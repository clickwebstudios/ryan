<?php

add_action( 'wp_ajax_get_storage', 'StorageController::getStorage' );
add_action( 'wp_ajax_nopriv_get_storage', 'StorageController::getStorage' );

add_action( 'wp_ajax_store_form', 'FormController::store' );
add_action( 'wp_ajax_nopriv_store_form', 'FormController::store' );

// USER SUBSCRIBE
add_action( 'wp_ajax_subscribe_user', 'MailchimpController::actionSubscribe' );
add_action( 'wp_ajax_nopriv_subscribe_user', 'MailchimpController::actionSubscribe' );
