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
        if ($request->get('page')!='view')
          $page = $request->get('page');
        else
          $page = 0;
      } else
        $page = 0;

      $list_size =2;


      $response['total'] = $total;
      $maxPage = (int)(round($total /$list_size)) -1;
      $response['maxPage'] = $maxPage;
      $response['list_size'] = $list_size;

      if ($page > $maxPage)
        $page = $maxPage;

      // Pagination button
      if ($page != 0) {
        $response['prev'] = $page-1;
      }else {
        $response['prev'] = null;
      }
      $off = $page* $list_size;
      if (($total - ($list_size * ($page+1))) > 0 )
        $response['next'] = $page+1;
      else
        $response['next'] = null;
      $response['offset'] = $off;
      $staffArray = array();
      $data = array();
      $retval = $connection->query('SELECT * FROM bethelks_staff LIMIT '.$list_size.' OFFSET '.$off.';')->fetchAllAssoc('sid');

      foreach ($retval as &$dt) {
        if ($dt->img != "") {
          $file = \Drupal\file\Entity\File::load($dt->img);
          $path = $file->getFileUri();
        } else
          $path = null;

        array_push($data, array('name'=>$dt->name, 'sid'=>$dt->sid, 'img'=>$dt->img, 'path'=>$path, 'staff_catagory'=>$dt->staff_category, 'position'=>$dt->position, 'email'=>$dt->email, 'telephone'=>$dt->telephone));
      }
      $response['data'] = $data;//$retval->fetchAllAssoc('sid');
      //return new JsonResponse($response);
    } else
      $response = null;
    return array(
      '#theme' => 'user_list_template',
      '#staff' => $response
    );
  }

  // Admin - list
  public function listStaff() {
    $connection = \Drupal::service('database');

    $staffArray = array();
    $getStaff = $connection->query('SELECT * FROM `bethelks_staff`');
    while($row = $getStaff->fetchAssoc()) {
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
    if ($request->get('sid')!= null)
      $sid = $request->get('sid');
    else
      $sid = 1;
    $connection = \Drupal::service('database');
    $deleteStaff = $connection->delete('bethelks_staff')->condition('sid', $sid, '=')->execute();
    return $this->redirect("bethelks_staff.adminList");
  }

  public function viewStaff($sid) {
    $connection = \Drupal::service('database');
    $staff_array = $connection->query('SELECT * FROM `bethelks_staff` WHERE sid = :sid LIMIT 1', array(':sid' => $sid))->fetchAssoc();

    if(!empty($staff_array)) {
      if ($staff_array['img'] != "") {
        $file = \Drupal\file\Entity\File::load($staff_array['img']);
        $path = $file->getFileUri();
        $staff_array["imguri"] = $path;
      } else
        $staff_array["imguri"] = null;
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

  public function viewStaffFull() {
    return new\Symfony\Component\HttpFoundation\RedirectResponse('/faculty/0');
   // return $this->redirect("/faculty/0");
 /*   $connection = \Drupal::service('database');

    $staffArray = array();
    $getStaff = $connection->query('SELECT * FROM `bethelks_staff`');
    while($row = $getStaff->fetchAssoc()) {
      array_push($staffArray, $row);
    }

    return array(
      '#theme' => 'view_staff_full_template',
      '#staff' => $staffArray
    );*/
  }

  public function viewStaffTitle($sid) {
    $connection = \Drupal::service('database');
    $getStaffName = $connection->query('SELECT `name` FROM `bethelks_staff` WHERE `sid` = :sid LIMIT 1', array(':sid' => $sid))->fetchAssoc();
    return $getStaffName["name"];
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
