<?php
define( 'PLUGIN_FORM_PATH', dirname(__FILE__));

require 'Controllers/StorageController.php';
require 'Controllers/FormController.php';
require 'Controllers/MailchimpController.php';
require 'Repositories/UserAnswerRepository.php';
require 'Libs/PdfGenerator.php';
require 'Libs/PdfGeneratorV2.php';
require 'Libs/CsvGenerator.php';
require 'Libs/EmailSender.php';
require 'Libs/AnswerHelper.php';
require 'routes.php';

if (! function_exists('dd')) {
  function dd(...$data){
    echo '<pre>';
    print_r(...$data);
    echo '</pre>';
    exit();
  }
}

if (! function_exists('object_to_array')) {
  function object_to_array($obj) {
    if (is_object($obj))
      $obj = (array) $obj;
    if (is_array($obj)) {
      $new = array();
      foreach ($obj as $key => $val) {
        $new[$key] = object_to_array($val);
      }
    } else
      $new = $obj;
    return $new;
  }
}

function eej($string){
  return htmlentities(json_encode($string));
}

function ee($string){
  return htmlentities($string);
}

if(!empty($_GET['resultPrint'])){
  $token = (string) $_GET['resultPrint'];
  (new PdfGeneratorV2)->generateAndStreamPdf($token);
}

if(!empty($_GET['resultExportCSV'])){
  $token = (string) $_GET['resultExportCSV'];
  (new CsvGenerator)->generateCsvExportOrganization($token);
}


if(!empty($_GET['resultExportCoachCSV'])){
  $token = (string) $_GET['resultExportCoachCSV'];
  (new CsvGenerator)->generateCsvExportCoach($token);
}

if(!empty($_GET['testemail'])){
  MailchimpController::subscribe('testemail@gmail.com', 'testfirstname', 'testlastname');
}

function test_send_email(){
  $dataTest = [
      "first_name" => 'first_name',
      "last_name" => 'last_name',
      "email" => 'withindestruction2@gmail.com',
      "answers" => [],
      "a_organization_id" => 6,
      "a_coach_id" => 2,
      "date_created" => date('Y-m-d H:i:s'),
      "token" => 'test token',
  ];
  
  (new EmailSender)->sendEmail('withindestruction2@gmail.com', $dataTest, true, 13);
  
  exit('email was send');
}

if(!empty($_GET['testattachement'])){
  add_action( 'wp_loaded', 'test_send_email' );
}


/*
function my_admin_menu() {
  add_menu_page(
    'User Answers',
    'Sample page',
    'manage_options',
    'sample-page',
    'my_admin_page_contents',
    'dashicons-schedule',
    3
  );
}

add_action( 'admin_menu', 'my_admin_menu' );


function my_admin_page_contents() {
  ?>
    <h1>
      1111111
    </h1>
  <?php
}
*/