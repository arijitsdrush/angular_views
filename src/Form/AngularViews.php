<?php

namespace Drupal\angular_views\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Implements InputDemo form controller.
 *
 * This example demonstrates the different input elements that are used to
 * collect data in a form.
 */
class AngularViews extends FormBase {

	/**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'angular_views_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
	
	$current_protocol = explode('/',$_SERVER['SERVER_PROTOCOL']);
	
	$form['form_container'] = array(
	'#type' => 'fieldset',
	'#title' => $this->t('Set Angular views page'),
	'#weight' => -1,
	);
	
	// Select Protocol To communicate with.
    $form['form_container']['protocol'] = [
      '#type' => 'select',
      '#title' => $this->t('Select Backend Service protocol'),
      '#options' => [
        'http' => $this->t('HTTP://'),
        'https' => $this->t('HTTPS://'),
      ],
      '#empty_option' => $this->t('- Select -'),
      '#description' => $this->t('Select Backend Service protocol on which angular will get request '),
	  '#required' => ($form_state->getValue('protocol')!= NULL ? $form_state->getValue('protocol'):$_SERVER['HTTP_HOST']),
	  '#default_value' => 'http'
    ];
	
	// Textfield.
    $form['form_container']['page_url'] = [
      '#type' => 'textfield',
      '#title' => t('Dispaly URL alias'),
      '#size' => 60,
      '#maxlength' => 128,
      '#description' => $this->t('Specify a path by which this UI can be accessed. For example, type "/angular-view" if you want to display it at URL: '.$GLOBALS['base_url'].'/angular-view'),
	  '#required' => TRUE,
    ];
	
	// Enter JSON backend URL.
    $form['form_container']['backend_url'] = [
      '#type' => 'textfield',
      '#title' => t('Backend JSON URL alias'),
      '#size' => 60,
      '#maxlength' => 128,
      '#description' => $this->t('Specify a path by which JSON data can be accessed. For example, type "/json-service" if your JSON data is showed at URL: '.$GLOBALS['base_url'].'/json-service'),
	  '#required' => TRUE,
    ];


    // Add a submit button that handles the submission of the form.
    $form['form_container']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#description' => $this->t('Submit, #type = submit'),
    ];
	
	 $header = [
      array('data' => $this->t('URL'), 'field' => 'url', 'sort' => 'asc'),
      array('data' => $this->t('Service Backend'),'field' => 'service_backend'),
	  array('data' => $this->t('Edit')),
	  array('data' => $this->t('Delete')),
    ];
	
	$edit_l = \Drupal::l(t('Edit'), Url::fromUri('internal:/config/user-interface/angular-views-management/edit'));
	$del_l = \Drupal::l(t('Delete'), Url::fromUri('internal:/config/user-interface/angular-views-management/delete'));
	
    $query = \Drupal::database()->select('angular_views','av');
    $query->fields('av', array('url'));
	$query->fields('av', array('service_backend'));
	// The actual action of sorting the rows is here.
    $table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')
                        ->orderByHeader($header);
	 // Limit the rows to 10 for each page.
    $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')
                        ->limit(10);
    $result = $pager->execute();
	
	// Populate the rows.
    $rows = array();
    foreach($result as $row) {
      $rows[] = ['data' => [
        'url' => $GLOBALS['base_url'].$row->url,
        'service_backend' => $row->service_backend,
		'edit' => $edit_l,
		'del' => $del_l,
      ]];
    }

	
	// Generate the table.
    $build['config_table'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];
 
    // Finally add the pager.
    $build['pager'] = [
      '#type' => 'pager'
    ];
	
	
	
	$form['table'] = [
	'#markup' => drupal_render($build),
	'#weight' => 0,
	];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
  
	if($form_state->getValue('page_url')!= NULL && substr($form_state->getValue('page_url'),0,1)!="/"){
		$form_state->setErrorByName('page_url', t('Dispaly URL alias needs to start with a slash.'));
	}elseif($form_state->getValue('backend_url')!= NULL && substr($form_state->getValue('backend_url'),0,1)!="/"){
		$form_state->setErrorByName('backend_url', t('Backend JSON URL alias needs to start with a slash.'));
	}
  
 }
  
  

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Find out what was submitted.
	
	db_insert('angular_views')->fields(
	  array(
		'protocol' => $form_state->getValue('protocol'),
		'url' => $form_state->getValue('page_url'),
		'service_backend' => $form_state->getValue('backend_url'),
	  )
	)->execute();
	drupal_flush_all_caches();
	drupal_set_message(t('Angular display created successfully.'), 'status');
  }

}
