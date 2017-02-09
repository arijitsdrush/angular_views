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
  public function buildForm(array $form, FormStateInterface $form_state) {
	
	$current_protocol = explode('/',$_SERVER['SERVER_PROTOCOL']);
	
	// Select Protocol To communicate with.
    $form['protocol'] = [
      '#type' => 'select',
      '#title' => $this->t('Select Backend Service protocol'),
      '#options' => [
        'http' => $this->t('HTTP://'),
        'https' => $this->t('HTTPS://'),
      ],
      '#empty_option' => $this->t('- Select -'),
      '#description' => $this->t('Select Backend Service protocol on which angular will get request '),
	  '#required' => TRUE,
    ];
	
	// Textfield.
    $form['page_url'] = [
      '#type' => 'textfield',
      '#title' => t('Frontend display URL'),
      '#size' => 60,
      '#maxlength' => 128,
      '#description' => $this->t('Enter URL where you want to display Angular Data Table'),
	  '#required' => TRUE,
    ];
	
	// Enter Views URL.
    $form['backend_url'] = [
      '#type' => 'textfield',
      '#title' => t('Backend JSON URL'),
      '#size' => 60,
      '#maxlength' => 128,
      '#description' => $this->t('Enter views URL from where JSON will be supplied '),
	  '#required' => TRUE,
    ];
	
	//
/*	
    // CheckBoxes.
    $form['tests_taken'] = [
      '#type' => 'checkboxes',
      '#options' => ['SAT' => t('SAT'), 'ACT' => t('ACT')],
      '#title' => $this->t('What standardized tests did you take?'),
      '#description' => 'Checkboxes, #type = checkboxes',
    ];

    // Color.
    $form['color'] = [
      '#type' => 'color',
      '#title' => $this->t('Color'),
      '#default_value' => '#ffffff',
      '#description' => 'Color, #type = color',
    ];

    // Date.
    $form['expiration'] = [
      '#type' => 'date',
      '#title' => $this->t('Content expiration'),
      '#default_value' => ['year' => 2020, 'month' => 2, 'day' => 15],
      '#description' => 'Date, #type = date',
    ];

    // Email.
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => 'Email, #type = email',
    ];

    // Number.
    $form['quantity'] = [
      '#type' => 'number',
      '#title' => t('Quantity'),
      '#description' => $this->t('Number, #type = number'),
    ];

    // Password.
    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#description' => 'Password, #type = password',
    ];

    // Password Confirm.
    $form['password_confirm'] = [
      '#type' => 'password_confirm',
      '#title' => $this->t('New Password'),
      '#description' => $this->t('PasswordConfirm, #type = password_confirm'),
    ];

    // Range.
    $form['size'] = [
      '#type' => 'range',
      '#title' => t('Size'),
      '#min' => 10,
      '#max' => 100,
      '#description' => $this->t('Range, #type = range'),
    ];

    // Radios.
    $form['settings']['active'] = [
      '#type' => 'radios',
      '#title' => t('Poll status'),
      '#options' => [0 => $this->t('Closed'), 1 => $this->t('Active')],
      '#description' => $this->t('Radios, #type = radios'),
    ];

    // Search.
    $form['search'] = [
      '#type' => 'search',
      '#title' => $this->t('Search'),
      '#description' => $this->t('Search, #type = search'),
    ];

    // Select.
    $form['favorite'] = [
      '#type' => 'select',
      '#title' => $this->t('Favorite color'),
      '#options' => [
        'red' => $this->t('Red'),
        'blue' => $this->t('Blue'),
        'green' => $this->t('Green'),
      ],
      '#empty_option' => $this->t('-select-'),
      '#description' => $this->t('Select, #type = select'),
    ];

    // Tel.
    $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone'),
      '#description' => $this->t('Tel, #type = tel'),
    ];

    // TableSelect.
    $options = [
      1 => ['first_name' => 'Indy', 'last_name' => 'Jones'],
      2 => ['first_name' => 'Darth', 'last_name' => 'Vader'],
      3 => ['first_name' => 'Super', 'last_name' => 'Man'],
    ];

    $header = [
      'first_name' => t('First Name'),
      'last_name' => t('Last Name'),
    ];

    $form['table'] = [
      '#type' => 'tableselect',
      '#title' => $this->t('Users'),
      '#header' => $header,
      '#options' => $options,
      '#empty' => t('No users found'),
    ];

    // Textarea.
    $form['text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Text'),
      '#description' => $this->t('Textarea, #type = textarea'),
    ];

    // Textfield.
    $form['subject'] = [
      '#type' => 'textfield',
      '#title' => t('Subject'),
      '#size' => 60,
      '#maxlength' => 128,
      '#description' => $this->t('Textfield, #type = textfield'),
    ];

    // Weight.
    $form['weight'] = [
      '#type' => 'weight',
      '#title' => t('Weight'),
      '#delta' => 10,
      '#description' => $this->t('Weight, #type = weight'),
    ];*/

    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#description' => $this->t('Submit, #type = submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'angular_views_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Find out what was submitted.
	
	db_insert('angular_views')->fields(
	  array(
		'url' => $form_state->getValue('page_url'),
		'protocol' => $form_state->getValue('protocol'),
		'service_backend' => $form_state->getValue('backend_url'),
	  )
	)->execute();
	
  }

}
