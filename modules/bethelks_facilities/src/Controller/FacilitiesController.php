<?php

namespace Drupal\bethelks_facilities\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\bethelks_facilities\BethelksFacilityModel;

class FacilitiesController extends ControllerBase {

  // User - list
  public function getList() {
    $response['data'] = BethelksFacilityModel::GetList();

    return new JsonResponse($response);
  }
  // User - view
  public function getView(Request $request) {
    $response['data'] = BethelksFacilityModel::Getview($request->get('id'));
    $response['imguri'] = BethelksFacilityModel::GetImage($response['data']['image']);
    return new JsonResponse($response);
  }

  // Admin - list
  public function getListAdmin() {
    $dta =  BethelksFacilityModel::GetList();
    $response['title'] = 'Admin Facility';
    $response['link'] = '/admin/content/facility';
    $response['data'] = $dta;

    return array(
      '#theme' => 'facility_list_admin_template',
      '#items' => $response
    );
  }



  // Admin - view
  public function getViewAdmin(Request $request) {
    $response['title'] = 'About';
    $response['data'] = BethelksFacilityModel::Getview($request->get('id'));
    $response['imguri'] = BethelksFacilityModel::GetImage($response['data']['image']);
    return array(
      '#theme' => 'facility_item_admin_template',
      '#items' => $response
    );
  }

  // Admin - delete
  public function setDelete(Request $request) {
    BethelksFacilityModel::Delete($request->get('id'));
    return $this->redirect("facility_list_admin.Controller");
  }
}
