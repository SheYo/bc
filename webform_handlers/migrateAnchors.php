<?php
define("MYSQL_USER", "bctest5");
define("MYSQL_PASS", ".HNyt7KDF");
define("MYSQL_DB", "bctest5_drupal");
define("DOMAIN", "https://www.bethelks.edu");
// define("MYSQL_USER", "root");
// define("MYSQL_PASS", "root");
// define("MYSQL_DB", "bethelks_db");
// define("DOMAIN", "/bethelks");

function sluggify($url) {
  $url = strtolower($url);
  $url = strip_tags($url);
  $url = stripslashes($url);
  $url = html_entity_decode($url);

  $url = str_replace('\'', '', $url);

  $match = '/[^a-z0-9]+/';
  $replace = '-';
  $url = preg_replace($match, $replace, $url);

  $url = trim($url, '-');

  return $url;
}

try {
  $dbh = new PDO('mysql:host=localhost;dbname=' . MYSQL_DB, MYSQL_USER, MYSQL_PASS);
}
catch(PDOException $e) {
  die("Error: " . $e->getMessage());
}

$fp = fopen("migrateLogFile.txt", "w"); //URLs that weren't dealt with
$fpFileLog = fopen("fileMigrateLog.txt", "w"); //File URLs
$fpNewsLog = fopen("newsMigrateLog.txt", "w"); //News URLs
$fpMapLog = fopen("mapMigrateLog.txt", "w"); //Map URLs
$fpPageLog = fopen("pageMigrateLog.txt", "w"); //Page URLs

$postsWithLinks = "SELECT `entity_id`, `body_value`
FROM `node__body`
WHERE (
  `body_value` LIKE '%<a href=\"/%'
  OR `body_value` LIKE '%<a href=\"../%'
)";

$queryStruct = $dbh->prepare("UPDATE `node__body`
SET `body_value` = ?
WHERE `entity_id` = ?");

$postCount = 0;
foreach($dbh->query($postsWithLinks) as $post) {
  $postCount += 1;

  $currentAnchorPos = strpos($post['body_value'], '<a href="/');
  while($currentAnchorPos != false){
    $startOfUrl = $currentAnchorPos + strlen('<a href="');
    $urlLength = strpos($post['body_value'], '"', $startOfUrl) - $startOfUrl;
    $url = substr($post['body_value'], $startOfUrl, $urlLength);

    if($url != "/" || strpos($url, '/#') != 0) {
      if(strpos($url, 'campus-map/#!') != false) {
        $newUrl = DOMAIN . '/campus-map/#!' . substr($url, strpos($url, 'campus-map/#!') + strlen('campus-map/#!'));
        $post['body_value'] = str_replace($url, $newUrl, $post['body_value']);

        fwrite($fpMapLog, $post['entity_id'] . "," . $url . "," . $newUrl . "\n");

        $queryStruct->execute(array($post['body_value'], $post['entity_id']));
      }
      else if(strpos($url, 'news/post/') != false) {
        $oldNewsInfo = $dbh->prepare('SELECT `nid`, `title`
        FROM `old_new_page`
        WHERE `oid` = ?
        LIMIT 1');

        $oid = preg_replace("/[^0-9]/", "", $url);
        $oldNewsInfo->bindParam(1, $oid, PDO::PARAM_INT);
        $oldNewsInfo->execute();
        $oldNewsInfo = $oldNewsInfo->fetch();

        $newUrl = DOMAIN . '/article/' . sluggify($oldNewsInfo['title']);
        $post['body_value'] = str_replace($url, $newUrl, $post['body_value']);

        fwrite($fpNewsLog, $post['entity_id'] . "," . $url . "," . $newUrl . "\n");

        $queryStruct->execute(array($post['body_value'], $post['entity_id']));
      }
      else if(strpos($url, '_userfiles/1/') != false) {
        $newUrl = DOMAIN . "/sites/default/files/old/" . basename($url);
        file_put_contents("../sites/default/files/old/" . basename($url), fopen("https://www.bethelks.edu" . $url, 'r'));
        $post['body_value'] = str_replace($url, $newUrl, $post['body_value']);

        fwrite($fpFileLog, $post['entity_id'] . "," . $url . "," . $newUrl . "\n");

        $queryStruct->execute(array($post['body_value'], $post['entity_id']));
      }
      else {
        $parseRelativeURL = array_filter(explode("/", $url));
        $findInternalURL = $dbh->prepare('SELECT `nid`, `title`
        FROM `old_new_page`
        WHERE `url` = ?
        LIMIT 1');
        $findInternalURL->bindParam(1, end($parseRelativeURL));
        $findInternalURL->execute();
        $findInternalURL = $findInternalURL->fetch();

        if(!empty($findInternalURL)) {
          $newUrl = DOMAIN . '/page/' . sluggify($findInternalURL['title']);
          $post['body_value'] = str_replace($url, $newUrl, $post['body_value']);
          $queryStruct->execute(array($post['body_value'], $post['entity_id']));
          fwrite($fpPageLog, $post['entity_id'] . "," . $url . "," . $newUrl . "\n");
        }
        else {
          fwrite($fp, $post['entity_id'] . "," . $url . ",\n");
        }
      }
    }

    $nextAnchorPos = strpos($post['body_value'], '<a href="/', ($currentAnchorPos + 10));
    $currentAnchorPos = $nextAnchorPos;
  }

  $currentAnchorPos = strpos($post['body_value'], '<a href="../');
  while($currentAnchorPos != false) {
    $startOfUrl = $currentAnchorPos + strlen('<a href="');
    $urlLength = strpos($post['body_value'], '"', $startOfUrl) - $startOfUrl;
    $url = substr($post['body_value'], $startOfUrl, $urlLength);
    $urlWithoutDots = str_replace("..", "", $url);

    if($url != "../" || strpos($url, '../#') != 0) {
      if(strpos($url, 'campus-map/#!') != false) {
        $newUrl = DOMAIN . '/campus-map/#!' . substr($url, strpos($url, 'campus-map/#!') + strlen('campus-map/#!'));
        $post['body_value'] = str_replace($url, $newUrl, $post['body_value']);

        fwrite($fpMapLog, $post['entity_id'] . "," . $url . "," . $newUrl . "\n");

        $queryStruct->execute(array($post['body_value'], $post['entity_id']));
      }
      else if(strpos($url, 'news/post/') != false) {
        $oldNewsInfo = $dbh->prepare('SELECT `nid`, `title`
        FROM `old_new_page`
        WHERE `oid` = ?
        LIMIT 1');

        $oid = preg_replace("/[^0-9]/", "", $url);
        $oldNewsInfo->bindParam(1, $oid, PDO::PARAM_INT);
        $oldNewsInfo->execute();
        $oldNewsInfo = $oldNewsInfo->fetch();

        $newUrl = DOMAIN . '/article/' . sluggify($oldNewsInfo['title']);
        $post['body_value'] = str_replace($url, $newUrl, $post['body_value']);

        fwrite($fpNewsLog, $post['entity_id'] . "," . $url . "," . $newUrl . "\n");

        $queryStruct->execute(array($post['body_value'], $post['entity_id']));
      }
      else if(strpos($url, '_userfiles/1/') != false) {
        $newUrl = DOMAIN . "/sites/default/files/old/" . basename($url);
        file_put_contents("../sites/default/files/old/" . basename($url), fopen("https://www.bethelks.edu" . $urlWithoutDots, 'r'));
        $post['body_value'] = str_replace($url, $newUrl, $post['body_value']);

        write($fpFileLog, $post['entity_id'] . "," . $url . "," . $newUrl . "\n");

        $queryStruct->execute(array($post['body_value'], $post['entity_id']));
      }
      else {
        $parseRelativeURL = array_filter(explode("/", $url));
        $findInternalURL = $dbh->prepare('SELECT `nid`, `title`
        FROM `old_new_page`
        WHERE `url` = ?
        LIMIT 1');
        $findInternalURL->bindParam(1, end($parseRelativeURL));
        $findInternalURL->execute();
        $findInternalURL = $findInternalURL->fetch();

        if(!empty($findInternalURL)) {
          $newUrl = DOMAIN . '/page/' . sluggify($findInternalURL['title']);
          $post['body_value'] = str_replace($url, $newUrl, $post['body_value']);
          $queryStruct->execute(array($post['body_value'], $post['entity_id']));
          fwrite($fpPageLog, $post['entity_id'] . "," . $url . "," . $newUrl . "\n");
        }
        else {
          fwrite($fp, $post['entity_id'] . "," . $url . ",\n");
        }
      }
    }

    $nextAnchorPos = strpos($post['body_value'], '<a href="../', ($currentAnchorPos + 10));
    $currentAnchorPos = $nextAnchorPos;
  }
}

fclose($fp);
fclose($fpFileLog);
fclose($fpNewsLog);
fclose($fpMapLog);
fclose($fpPageLog);

echo 'Done - (Node Count: ' . $postCount . ')';
?>
