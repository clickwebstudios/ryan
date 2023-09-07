<?php

// forms
add_action( 'wp_ajax_admin_get_user_forms', 'UserFormController::grid' );
add_action( 'wp_ajax_get_user_form', 'UserFormController::show' );
add_action( 'wp_ajax_nopriv_get_user_form', 'UserFormController::show' );

// questions
add_action( 'wp_ajax_admin_get_user_questions', 'UserQuestionsController::grid' );
add_action( 'wp_ajax_admin_get_question', 'UserQuestionsController::show' );
add_action( 'wp_ajax_admin_update_question', 'UserQuestionsController::update' );

// organization
add_action( 'wp_ajax_admin_user_organizations_index', 'UserOrganizationController::index' );
add_action( 'wp_ajax_admin_user_organizations_show', 'UserOrganizationController::show' );
add_action( 'wp_ajax_admin_user_organizations_update', 'UserOrganizationController::update' );
add_action( 'wp_ajax_admin_user_organizations_store', 'UserOrganizationController::store' );
add_action( 'wp_ajax_admin_user_organizations_destroy', 'UserOrganizationController::destroy' );


// coach
add_action( 'wp_ajax_admin_user_coach_index', 'UserCoachController::index' );
add_action( 'wp_ajax_admin_user_coach_show', 'UserCoachController::show' );
add_action( 'wp_ajax_admin_user_coach_update', 'UserCoachController::update' );
add_action( 'wp_ajax_admin_user_coach_store', 'UserCoachController::store' );
add_action( 'wp_ajax_admin_user_coach_destroy', 'UserCoachController::destroy' );