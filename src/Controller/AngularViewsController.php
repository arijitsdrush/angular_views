<?php

namespace Drupal\angular_views\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Controller routines for page example routes.
 */
class AngularViewsController extends ControllerBase {

  /**
   * Constructs a page with descriptive content.
   *
   * Our router maps this method to the path 'examples/page-example'.
   */
  public function index() {
   
	return array(
      '#theme' => 'angular_table',
      '#test_var' => $this->t('Test Value'),
    );
  }
  
  
  public function adminindex() {
   
	return array(
      '#theme' => 'angular_table',
      '#test_var' => $this->t('Test Value'),
    );
  }

}
