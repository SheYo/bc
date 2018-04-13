<?php
namespace Drupal\bethelks_staff\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;

class bethelksStaffBreadcrumbBuilder implements BreadcrumbBuilderInterface {
  // public function applies(RouteMatchInterface $attributes) {
  //   $parameters = $attributes->getParameters()->all();
  //
  //   if(isset($parameters['singleStaff']) && $parameters['singleStaff'] == true) {
  //     return true;
  //   }
  //   else {
  //     return false;
  //   }
  // }
  //
  // public function build(RouteMatchInterface $route_match) {
  //   $breadcrumb = new Breadcrumb();
  //
  //   $breadcrumb->addLink(Link::createFromRoute('Home', '<front>'));
  //   $breadcrumb->addLink(Link::createFromRoute('Employee', 'bethelks_staff.faculty'));
  //
  //   return $breadcrumb;
  // }
}
?>
