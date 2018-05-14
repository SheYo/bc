<?php
namespace Drupal\bethelks_staff\Controller;

use Drupal\Core\Url;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class StaffController extends ControllerBase {

  // User - list
  public function listStaffPaginated(Request $request) {
    $connection = \Drupal::service('database');
    $total =  $connection->query('SELECT count(*) as number FROM `bethelks_staff`')->fetchAssoc()['number'];

    if ($total > 0) {
      //return new JsonResponse( $request);
      if ($request->get('page')!= null) {
        if ($request->get('page')!='view') $page = $request->get('page');
        else $page = 0;
      }
      else {
        $page = 0;
      }

      $list_size = 9;

      $response['total'] = $total;
      $maxPage = (int)(round($total /$list_size)) -1;
      $response['maxPage'] = $maxPage;
      $response['list_size'] = $list_size;

      if ($page > $maxPage) $page = $maxPage;

      // Pagination button
      if ($page != 0) {
        $response['prev'] = $page - 1;
      }
      else {
        $response['prev'] = null;
      }

      $off = $page* $list_size;

      if (($total - ($list_size * ($page+1))) > 0) $response['next'] = $page+1;
      else $response['next'] = null;

      $response['offset'] = $off;
      $staffArray = array();
      $data = array();
      $retval = $connection->query('SELECT * FROM bethelks_staff ORDER BY name LIMIT '.$list_size.' OFFSET '.$off.';')->fetchAllAssoc('sid');

      foreach ($retval as &$dt) {
        if ($dt->img != "") {
          if(strpos($dt->img, ".jpg") != false) { //imported users from old site
            $path = 'sites/default/files/staff-pictures/' . $dt->img;
          }
          else {
            $file = \Drupal\file\Entity\File::load($dt->img);
            $path = $file->getFileUri();
          }
        }
        else {
          $path = null;
        }

        array_push($data, array('name'=>$dt->name, 'sid'=>$dt->sid, 'img'=>$dt->img, 'path'=>$path, 'staff_catagory'=>$dt->staff_category, 'position'=>$dt->position, 'email'=>$dt->email, 'telephone'=>$dt->telephone));
      }

      $response['data'] = $data;//$retval->fetchAllAssoc('sid');
      //return new JsonResponse($response);
    }
    else {
      $response = null;
    }

    $categories = $connection->query('SELECT DISTINCT `category` FROM `bethelks_staff_category`')->fetchAllAssoc('category');

    $clean = array();
    foreach($categories as $key => $value) {
      $temp = array('safe' => $key, 'clean' => str_replace("_", " ", $key));
      array_push($clean, $temp);
    }

    $response['categories'] = $clean;

    return array(
      '#theme' => 'user_list_template',
      '#staff' => $response
    );
  }

  public function listStaffByDepartment(Request $request) {
    $connection = \Drupal::service('database');
    $response = array();
    $response['department'] = $request->get('department');
    $response['total'] = $connection->query('SELECT count(*) as number FROM `bethelks_staff_category` WHERE `category` = :department', array(':department' => $request->get('department')))->fetchAssoc()['number'];

    if($response['total'] > 0) {
      $retval = $connection->query('SELECT * FROM `bethelks_staff` INNER JOIN `bethelks_staff_category` ON `bethelks_staff`.`sid` = `bethelks_staff_category`.`staff_id` AND `bethelks_staff_category`.`category` = ?', array($response['department']))->fetchAllAssoc('sid');

      $data = array();
      foreach ($retval as &$dt) {
        if ($dt->img != "") {
          if(strpos($dt->img, ".jpg") != false) { //imported users from old site
            $path = 'sites/default/files/staff-pictures/' . $dt->img;
          }
          else {
            $file = \Drupal\file\Entity\File::load($dt->img);
            $path = $file->getFileUri();
          }
        }
        else {
          $path = null;
        }

        array_push($data, array('name'=>$dt->name, 'sid'=>$dt->sid, 'img'=>$dt->img, 'path'=>$path, 'staff_catagory'=>$dt->staff_category, 'position'=>$dt->position, 'email'=>$dt->email, 'telephone'=>$dt->telephone));
      }

      $response['data'] = $data;
    }

    $categories = $connection->query('SELECT DISTINCT `category` FROM `bethelks_staff_category`')->fetchAllAssoc('category');

    $clean = array();
    foreach($categories as $key => $value) {
      $temp = array('safe' => $key, 'clean' => str_replace("_", " ", $key));
      array_push($clean, $temp);
    }

    $response['categories'] = $clean;

    return array(
      '#theme' => 'user_list_department_template',
      '#staff' => $response
    );
  }

  // Admin - list
  public function listStaff() {
    $connection = \Drupal::service('database');

    $staffArray = array();
    $getStaff = $connection->query('SELECT * FROM `bethelks_staff`');
    while($row = $getStaff->fetchAssoc()) {
      $getStaffCategory = $connection->query('SELECT `category` FROM `bethelks_staff_category` WHERE `staff_id` = :sid LIMIT 1', array(':sid' => $row["sid"]))->fetchAssoc();
      $row["category"] = str_replace("_", " ", $getStaffCategory["category"]);
      array_push($staffArray, $row);
    }

    return array(
      '#theme' => 'admin_list_template',
      '#staff' => $staffArray
    );
  }

  // Admin - delete
  public function deleteStaff($sid) {
    $connection = \Drupal::service('database');
    $getStaff = $connection->query('SELECT * FROM `bethelks_staff` WHERE sid = :sid LIMIT 1', array(':sid' => $sid))->fetchAssoc();

    if(empty($getStaff)) {
      return $this->redirect("bethelks_staff.adminList");
    }
    else {
      return array(
        '#theme' => 'delete_staff_template',
        '#staff' => $getStaff
      );
    }
  }

  public function confirmDeleteStaff(Request $request) {
    if ($request->get('sid')!= null) $sid = $request->get('sid');
    else return $this->redirect("bethelks_staff.adminList");

    $connection = \Drupal::service('database');
    $deleteStaff = $connection->delete('bethelks_staff')->condition('sid', $sid, '=')->execute();
    $deleteStaffCategories = $connection->delete('bethelks_staff_category')->condition('staff_id', $sid, '=')->execute();
    $delteStaffEducation = $connection->delete('bethelks_staff_education')->condition('staff_id', $sid, '=')->execute();

    return $this->redirect("bethelks_staff.adminList");
  }

  public function viewStaff($sid) {
    if($sid == null) {
      return $this->redirect("bethelks_staff.faculty");
    }

    $connection = \Drupal::service('database');
    $staff_array = $connection->query('SELECT * FROM `bethelks_staff` WHERE sid = :sid LIMIT 1', array(':sid' => $sid))->fetchAssoc();

    $staffMemberEducation = $connection->query('SELECT * FROM `bethelks_staff_education` WHERE `staff_id` = :sid', array(':sid' => $sid))->fetchAll();
    $staffMemberCategories = $connection->query('SELECT * FROM `bethelks_staff_category` WHERE `staff_id` = :sid', array(':sid' => $sid))->fetchAll();

    $categoryArray = array('categories' => array());
    foreach($staffMemberCategories as $staff_category) {
      array_push($categoryArray['categories'], $staff_category->category);
    }

    $educationArray = array('education' => array());
    foreach($staffMemberEducation as $staff_education) {
      array_push($educationArray['education'], $staff_education->education);
    }

    $staff_array = array_merge($staff_array, $categoryArray, $educationArray);

    if(!empty($staff_array)) {
      if ($staff_array['img'] != "") {
        if(strpos($staff_array['img'], '.jpg') != false) {
          $path = 'sites/default/files/staff-pictures/' . $staff_array['img'];
          $staff_array["imguri"] = $path;
        }
        else {
          $file = \Drupal\file\Entity\File::load($staff_array['img']);
          $path = $file->getFileUri();
          $staff_array["imguri"] = $path;
        }
      }
      else {
        $staff_array["imguri"] = null;
      }
      return array(
        '#theme' => 'view_staff_template',
        '#staff' => $staff_array
      );
    }
    else {
      return array(
        '#theme' => 'view_staff_template',
        '#staff' => null
      );
    }
  }

  public function viewStaffTitle($sid) {
    $connection = \Drupal::service('database');
    $getStaffName = $connection->query('SELECT `name` FROM `bethelks_staff` WHERE `sid` = :sid LIMIT 1', array(':sid' => $sid))->fetchAssoc();

    if(!empty($getStaffName["name"])) return $getStaffName["name"];
    else return "Error";
  }

  public function staffByDepartmentTitle($department) {
    return ucwords(str_replace("_", " ", $department));
  }

  public function editStaffTitle($sid) {
    $connection = \Drupal::service('database');
    $getStaffName = $connection->query('SELECT `name` FROM `bethelks_staff` WHERE `sid` = :sid LIMIT 1', array(':sid' => $sid))->fetchAssoc();
    return 'Edit '. $getStaffName["name"];
  }

  public function deleteStaffTitle($sid) {
    $connection = \Drupal::service('database');
    $getStaffName = $connection->query('SELECT `name` FROM `bethelks_staff` WHERE `sid` = :sid LIMIT 1', array(':sid' => $sid))->fetchAssoc();
    return 'Delete '. $getStaffName["name"];
  }
}
?>
