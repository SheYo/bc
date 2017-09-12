<?php
define("MYSQL_USER", "bctest5");
define("MYSQL_PASS", ".HNyt7KDF");
define("MYSQL_DB", "bctest5_drupal");
define("DOMAIN", "https://www.bethelks.edu");
// define("MYSQL_USER", "root");
// define("MYSQL_PASS", "root");
// define("MYSQL_DB", "bethelks_db");
// define("DOMAIN", "/bethelks");

try {
  $dbh = new PDO('mysql:host=localhost;dbname=' . MYSQL_DB, MYSQL_USER, MYSQL_PASS);
}
catch(PDOException $e) {
  die("Error: " . $e->getMessage());
}

$fp = fopen("imgMigrateLog.txt", "w");

$postsWithImg = "SELECT `entity_id`, `body_value`
FROM `node__body`
WHERE (
  `body_value` LIKE '%<img%'
)";

$queryStruct = $dbh->prepare("UPDATE `node__body`
SET `body_value` = ?
WHERE `entity_id` = ?");

$postCount = 0;
foreach($dbh->query($postsWithImg) as $post) {
  $postCount += 1;

  $currentImgTagPos = strpos($post['body_value'], '<img');
  while($currentImgTagPos != false) {
    $currentImgSrcStart = strpos($post['body_value'], "src=\"", $currentImgTagPos) + strlen("src=\"");
    $currentImgSrcEnd = strpos($post['body_value'], "\"", $currentImgSrcStart + 1);
    $currentImgSrc = substr($post['body_value'], $currentImgSrcStart, ($currentImgSrcEnd - $currentImgSrcStart));

    $oldImgUrl = 'https://www.bethelks.edu' . $currentImgSrc;
    $newUrl = DOMAIN . '/sites/default/files/oldImg/' . basename($currentImgSrc);
    file_put_contents("../sites/default/files/oldImg/" . basename($currentImgSrc), $oldImgUrl);

    $post['body_value'] = str_replace($currentImgSrc, $newUrl, $post['body_value']);
    $queryStruct->execute(array($post['body_value'], $post['entity_id']));

    fwrite($fp, $post['entity_id'] . "," . $currentImgSrc . "," . $newUrl . "\n");

    $nextImgTagPos = strpos($post['body_value'], '<img', ($currentImgTagPos + 15));
    $currentImgTagPos = $nextImgTagPos;
  }
}

fclose($fp);

echo 'Done - (Node Count: ' . $postCount . ')';
?>
