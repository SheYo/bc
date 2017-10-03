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

$row = 0;
if(($handle = fopen("dataclean.csv", "r")) !== FALSE) {
  while(($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
    $row++;
    if($row == 1) continue;

    for ($i = 0; $i < COL_COUNT; $i++) {
      echo $i .  ": " . $data[$i] . "<br>\n";
    }
    echo "<br>\n";
    echo "<br>\n";
  }
  fclose($handle);
}
?>
