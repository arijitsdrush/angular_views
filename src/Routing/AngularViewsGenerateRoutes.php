<?php
/**
 * @file
 * Contains \Drupal\example\Routing\ExampleRoutes.
 */

namespace Drupal\angular_views\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


class AngularViewsGenerateRoutes{
	
	 /**
   * {@inheritdoc}
   */
  public function routes() {
	  
	  
	 $db_results = db_select('angular_views','av')
	 ->fields('av')
	 ->execute()
	->fetchAll(); 
	 
	
	$routes = array();
	foreach($db_results as $results){
		
			
		// Declares a single route under the name 'example.content'.
		// Returns an array of Route objects. 
		$routes['angular_views_user_'.$results->aid.'_ui'] = new Route(
		  // Path to attach this route to:
		  $results->url,
		  // Route defaults:
		  array(
			'_controller' => '\Drupal\angular_views\Controller\AngularViewsController::index',
		  ),
		  // Route requirements:
		  array(
			'_permission'  => 'access angular ui page',
		  )
		);
		
	}
	
	
	return $routes;
	  
  }
	
	
}