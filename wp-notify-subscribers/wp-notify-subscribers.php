<?php
/*
Plugin Name: WP Notify Subscribers
Plugin URI: https://github.com/tobias-redmann/wp-notify-subscribers
Description: A brief description of the Plugin.
Version: 0.1
Author: Tobias Redmann
Author URI: http://www.tricd.de
*/



function wpns_get_mail_subject($post, $subscriber) {
  
  return 'Test subject';
  
  
}

function wpns_get_mail_text($post, $subscriber) {
  
  return 'Test Body';
  
  
}


function wpns_send_mail($post, $subscriber) {
  
  $headers = 'From: Avas Blog <blog@avathea.de>' . "\r\n";
  
  
  wp_mail(
    $subscriber['email'], 
    wpns_get_mail_subject($post, $subscriber),
    wpns_get_mail_text($post, $subscriber),
    $headers
  );
  
}


/**
 * Get all blog subscribers
 * 
 * @return Array
 */
function wpns_get_subscribers() {
  
  return array(array('name' => 'Tobias', 'email' => 'tobias.redmann@gmail.com'));
  
}


/**
 * Notify all subscribers when Post is published
 * 
 * @param int $post_id WordPress Post Id
 */
function wp_notify_subscribers($post_id) {
  
  // FIXME: It is possible, that the filter also excecutes when already was public
  
  $subscribers = wpns_get_subscribers();
  
  $post = get_post($post_id);
  
  foreach($subscribers as $subscriber) {
  
    wpns_send_mail($post, $subscriber);
  
  }
  
  
  
  
}


add_filter('publish_post', 'wp_notify_subscribers');


?>