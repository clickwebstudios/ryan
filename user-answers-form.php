<?php

/*
Plugin Name: Usert Answer Form
Description: Usert Answer Form
Version: 1.0.0
Author: ALex
Text Domain: user-answers-form
*/

define( 'PLUGIN_ANSWER_FORM_PATH', dirname(__FILE__));
define( 'PLUGIN_ANSWER_FORM_URI', str_replace(ABSPATH, '/', PLUGIN_ANSWER_FORM_PATH));

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
require 'vendor/autoload.php';
require 'admin/Pages/UserAnswerAdminPage.php';
require 'admin/Controllers/UserFormController.php';
require 'admin/Controllers/UserQuestionsController.php';
require 'admin/Controllers/UserOrganizationController.php';
require 'admin/Controllers/UserCoachController.php';
require 'admin/routes.php';
require 'form/Libs/OrganizationHelper.php';
require 'form/Libs/CoachHelper.php';

// Function to subscribe a user to Mailchimp
function subscribeToMailchimp($email, $firstName, $lastName) {
    // need test work
    return ;
  
    $apiKey = 'd4072b6b8d7a4258f86bf3347cfcfa20-us17';
    $listId = '80e3ba9130';

    $mailchimp = new \MailchimpMarketing\ApiClient();
    $mailchimp->setConfig([
        'apiKey' => $apiKey,
        'server' => 'us17',
    ]);

    $subscriber = $mailchimp->lists->addListMember($listId, [
        'email_address' => $email,
        'status' => 'subscribed',
        'merge_fields' => [
            'FNAME' => $firstName,
            'LNAME' => $lastName,
        ],
    ]);

    return $subscriber;
}

if (! function_exists('dd')) {
  function dd(...$data){
    echo '<pre>';
    print_r(...$data);
    echo '</pre>';
    exit();
  }
}

//dd(md5('TZoHBz5Z8f)zsw2bB$jMZ9Q!'));

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

if (! function_exists('set_email_html_content_type')) {
	function set_email_html_content_type() {
	  return 'text/html';
	}
}

function user_answers_form_menu() {
  add_menu_page(
    'Assessments',
    'Assessments',
    'manage_options',
    'user-forms',
    'my_admin_page_contents',
    'dashicons-schedule',
    3
  );
  add_submenu_page(
    'user-forms',
    'User Forms',
    'User Forms',
    'manage_options',
    'user-forms',
    'my_admin_page_contents',
    'dashicons-schedule',
    3
  );
  
  add_submenu_page(
    'user-forms',
    'User Questions',
    'User Questions',
    'manage_options',
    'user-questions',
    'my_admin_page_contents',
    'dashicons-admin-comments',
    4
  );
  
  add_submenu_page(
    'user-forms',
    'Organizations',
    'Organizations',
    'manage_options',
    'user-organizations',
    'my_admin_page_contents',
    'dashicons-admin-comments',
    5
  );

  add_submenu_page(
    'user-forms',
    'Coaches',
    'Coaches',
    'manage_options',
    'user-coaches',
    'my_admin_page_contents',
    'dashicons-admin-comments',
    5
  );
  
}

add_action( 'admin_menu', 'user_answers_form_menu' );

function my_admin_page_contents() {
  echo (new UserAnswerAdminPage)->generate();
}



function register_my_plugin_scripts() {
  wp_register_style( 'user-answers-form', plugins_url( 'user-answers-form/dist/admin/app.css?v='.time() ) );
  wp_register_script( 'user-answers-form', plugins_url( 'user-answers-form/dist/admin/app.js?v='.time() ) );
}

add_action( 'admin_enqueue_scripts', 'register_my_plugin_scripts' );



function load_my_plugin_scripts( $hook ) {
  
  if( 
    $hook == 'toplevel_page_user-questions' || 
    $hook == 'assessments_page_user-questions' || 
    $hook == 'toplevel_page_user-forms' || 
    $hook == 'assessments_page_user-forms' || 
    $hook == 'toplevel_page_user-organizations' ||
    $hook == 'assessments_page_user-organizations' ||
    $hook == 'assessments_page_user-coaches' 
  ) {
    wp_enqueue_style( 'user-answers-form' );
    wp_enqueue_script( 'user-answers-form' );
  }
}

add_action( 'admin_enqueue_scripts', 'load_my_plugin_scripts' );

add_shortcode('user-answers-form-site', 'getContentSite');

function getContentSite($attr, $content) {
  
  $str = '
    <div id="app"></div>
    <link rel="stylesheet" href="/wp-content/plugins/user-answers-form/dist/site/app.css?v=<?=time()?>">
    <script type="text/javascript" async="" src="/wp-content/plugins/user-answers-form/dist/site/app.js?v=<?=time()?>"></script>
  ';
  echo $str;
}

register_activation_hook( __FILE__, 'user_answer_form_activate' );

function user_answer_form_activate(){
	global $wpdb;
  /*
   $sql = "DROP TABLE IF EXISTS a_organizations";
   $wpdb->query($sql);
  */
  $sql1 = "CREATE TABLE IF NOT EXISTS `a_organizations` (
	`id` INT(100) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(500) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
	`slug` VARCHAR(500) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
	`email` VARCHAR(500) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
	`date_created` DATETIME NULL DEFAULT NULL,
	`token` VARCHAR(500) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `token` (`token`) USING BTREE,
	INDEX `slug` (`slug`) USING BTREE
	)
	COLLATE='latin1_swedish_ci'
	ENGINE=InnoDB
	AUTO_INCREMENT=6
	;";
  
  dbDelta($sql1);
  
  // coach
  dbDelta("CREATE TABLE IF NOT EXISTS `a_coaches` (
      `id` INT(100) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(500) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
      `slug` VARCHAR(500) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
      `email` VARCHAR(500) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
      `date_created` DATETIME NULL DEFAULT NULL,
      `token` VARCHAR(500) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
      PRIMARY KEY (`id`) USING BTREE,
      UNIQUE INDEX `token` (`token`) USING BTREE,
      INDEX `slug` (`slug`) USING BTREE
    )
    COLLATE='latin1_swedish_ci'
    ENGINE=InnoDB");
  
  /*
   $sql = "DROP TABLE IF EXISTS a_user_answers";
   $wpdb->query($sql);
  */

  $sql1 = "CREATE TABLE IF NOT EXISTS `a_user_answers` (
		`id` BIGINT(200) UNSIGNED NOT NULL AUTO_INCREMENT,
		`first_name` VARCHAR(500) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
		`last_name` VARCHAR(500) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
		`email` VARCHAR(500) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
		`answers` JSON NULL DEFAULT NULL,
		`date_created` DATETIME NULL DEFAULT NULL,
		`token` VARCHAR(400) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
		`a_organization_id` INT(100) UNSIGNED NULL DEFAULT NULL,
		PRIMARY KEY (`id`) USING BTREE,
		UNIQUE INDEX `token` (`token`) USING BTREE,
		INDEX `FK_a_user_answers_a_organizations` (`a_organization_id`) USING BTREE,
	CONSTRAINT `FK_a_user_answers_a_organizations` FOREIGN KEY (`a_organization_id`) REFERENCES `a_organizations` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
	)
	COLLATE='latin1_swedish_ci'
	ENGINE=InnoDB
	AUTO_INCREMENT=8
	;";
  
  dbDelta($sql1);
  
  // alter table user answer
  try{
    dbDelta("ALTER TABLE `a_user_answers`
      ADD COLUMN `a_coach_id` INT(100) UNSIGNED NULL DEFAULT NULL AFTER `a_organization_id`,
      ADD INDEX `a_coach_id` (`a_coach_id`),
      ADD CONSTRAINT `FK_a_user_answers_a_coaches` FOREIGN KEY (`a_coach_id`) REFERENCES `a_coaches` (`id`) ON UPDATE CASCADE ON DELETE SET NULL"
    );
  } catch(\Exception $e){
    
  }
  
  $sql1 = "CREATE TABLE IF NOT EXISTS `a_answers` (
      `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(200) NOT NULL,
      `order` int(10) unsigned DEFAULT '0',
      `score` int(10) unsigned DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

  $sql2 = "DELETE FROM `a_answers`";
  
  $sql3 = "INSERT INTO `a_answers` (`id`, `name`, `order`, `score`) VALUES
      (1, 'Perfect Fit', 1, 1),
      (2, 'Good Fit', 2, 2),
      (3, 'Somewhat Fit', 3, 3),
      (4, 'Equal Fit', 4, 4),
      (5, 'Somewhat Fit', 5, 5),
      (6, 'Good Fit', 6, 6),
      (7, 'Perfect Fit', 7, 7)";

  dbDelta($sql1);
  dbDelta($sql2);
  dbDelta($sql3);
    
  $sql1 = "CREATE TABLE IF NOT EXISTS `a_questions` (
    `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
    `q_left` varchar(500) DEFAULT NULL,
    `q_right` varchar(500) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1";

	
  $sql2 = "DELETE FROM `a_questions`";
  
  $sql3 = "INSERT INTO `a_questions` (`id`, `q_left`, `q_right`) VALUES
    (1, '<p>1I am too concerned about my goals and zzz</p><p> objectives to give much attention to the</p><p> goals and objectives of my key coworkers aaaa</p>', '<p>I do not let my goals and objectives get in</p><p> the way of the goals and objectives of my</p><p> key coworkers bbb</p>'),
    (2, '2I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (3, '3I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (4, '4I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (5, '5I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (6, '6I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (7, '7I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (8, '8I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (9, '9I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (10, '10I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (11, '11I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (12, '12I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (13, '13I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (14, '14I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (15, '15I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (16, '16I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (17, '17I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (18, '18I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (19, '19I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers'),
    (20, '20I am too concerned about my goals and<br> objectives to give much attention to the<br> goals and objectives of my key coworkers', 'I do not let my goals and objectives get in<br> the way of the goals and objectives of my<br> key coworkers');
  ";
  
  dbDelta($sql1);
  dbDelta($sql2);
  dbDelta($sql3);
  
}

require PLUGIN_ANSWER_FORM_PATH . '/form/functions-form.php';
