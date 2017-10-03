<?php
/*
'::' denotes coorespondence to database column

DATA:
0: Name :: name
1: Title :: position
2: Ext :: extension
3: Phone :: telephone
4: Place :: campus_location
5: Email :: email
6: Bio :: bio
7: Picture SRC :: img
8: Education, | Delimeter :: bio (prepended)
9: Dept, | Delimeter :: staff_category (separated by commas in db)
*/

define("COL_COUNT", 10);

try {
  $dbh = new PDO('mysql:host=localhost;dbname=bctest5_drupal', 'bctest5_sql', '.HNyt7KDF');
}
catch (PDOException $e) {
  die('Error: ' . $e->getMessage());
}

$row = 0;
if(($handle = fopen("dataclean.csv", "r")) !== FALSE) {
  while(($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
    $row++;
    if($row == 1) continue;

    if($data[7] == "https://www.bethelks.edu/images/blank.gif") {
      $img = "";
    }
    else {
      $img = basename($data[7]);
      file_put_contents('../sites/default/files/staff-pictures/' . $img, file_get_contents($data[7]));
    }

    $staffFields = array(
      ':name' => $data[0],
      ':img' => $img,
      ':position' => $data[1],
      ':extension' => str_replace('x', '', $data[2]),
      ':telephone' => preg_replace("/[^0-9]/", "", $data[3]),
      ':campus_location' => $data[4],
      ':email' => $data[5],
      ':bio' => $data[6]
    );

    $education = explode('|', $data[8]);
    $categories = explode('|', $data[9]);

    if(!empty($education)) {
      foreach($education as $key => $val) {
        $education[$key] = str_replace('Education: ', '', $val);
        $education[$key] = str_replace('Education:', '', $val);
      }
    }

    if(!empty($categories)) {
      foreach($categories as $key => $val) {
        $categories[$key] = str_replace(' ', '_', strtolower($val));
      }
    }

    $insertStaff = $dbh->prepare('INSERT INTO `bethelks_staff` VALUES(NULL, :name, :img, :position, :extension, :telephone, :campus_location, :email, :bio)');
    $insertStaff->execute($staffFields);

    $getLastID = $dbh->lastInsertId();

    if(!empty($education)) {
      foreach($education as $key => $val) {
        $insertEducation = $dbh->prepare("INSERT INTO `bethelks_staff_education` VALUES(NULL, :staff_id, :education)");
        $insertEducation->bindParam(':staff_id', $getLastID);
        $insertEducation->bindParam(':education', $val);
        $insertEducation->execute();
      }
    }

    if(!empty($categories)) {
      foreach($categories as $key => $val) {
        $insertCategory = $dbh->prepare("INSERT INTO `bethelks_staff_category` VALUES(NULL, :staff_id, :category)");
        $insertCategory->bindParam(':staff_id', $getLastID);
        $insertCategory->bindParam(':category', $val);
        $insertCategory->execute();
      }
    }
  }
  fclose($handle);
}
?>
