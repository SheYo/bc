<?php

namespace Drupal\bethelks_facilities;

class BethelksFacilityModel {

  private $connection;

  public function __construct() {
    $this->$connection = \Drupal::service('database');
  }

  static function GetList() {
    $connection = \Drupal::service('database');
    $retval = $connection->query('SELECT * FROM bethelks_facilities;');
    return $retval->fetchAllAssoc('id');
  }

//  private static function 
  static function GetView($id) {
    $connection = \Drupal::service('database');
  	return $connection->query('SELECT * FROM bethelks_facilities WHERE id=:id; ', array(':id' => $id))->fetchAssoc();
  }

  static function GetImage($refid) {
    if ($refid != ''){
      $file = \Drupal\file\Entity\File::load($refid);
      $path = $file->getFileUri();
      return $path;
    } else
      return null;
  }

  static function InsertEdit($id, $mapid, $title, $description, $image) {
    $connection = \Drupal::service('database');
    if ($id == 0) {
      // Insert if 0
      $connection->query('INSERT INTO `bethelks_facilities` (`mapid`,`title`,`description`,`image`) 
       VALUES (:mapid, :title, :description, :image);', 
       array(':mapid'=> $mapid, ':title'=>$title, ':description'=>$description, ':image'=>$image));
       // get Newly created id
       $id = $connection->query('SELECT LAST_INSERT_ID() as id')->fetchAssoc()['id'];
    } else {
      // Update if not 0
      $connection->query(
      'UPDATE `bethelks_facilities` 
       SET `mapid` = :mapid, `title` = :title, `description` = :description, `image` = :image 
       WHERE `id` = :id;', array(':id' => $id, ':mapid'=> $mapid, ':title'=>$title, ':description'=>$description, ':image'=>$image));
    }
    //return $id;
  	return BethelksFacilityModel::Getview($id);
  }

  static function Delete($id) {
    $connection = \Drupal::service('database');
    $connection->query('DELETE FROM `bethelks_facilities` WHERE id=:id;',  array(':id' => $id));
    return BethelksFacilityModel::Getlist();
  }
}