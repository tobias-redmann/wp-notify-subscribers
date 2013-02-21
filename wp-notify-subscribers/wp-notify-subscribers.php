<?php
/*
Plugin Name: WP Notify Subscribers
Plugin URI: https://github.com/tobias-redmann/wp-notify-subscribers
Description: A brief description of the Plugin.
Version: 0.1
Author: Tobias Redmann
Author URI: http://www.tricd.de
*/


/**
 * Get the mail subject
 * 
 * @param WP_Post $post
 * @param WP_User $subscriber
 * @return string
 */
function wpns_get_mail_subject($post, $subscriber) {
  
  return 'Neue Bilder in Avas Blog';
  
  
}


/**
 * 
 * @param WP_Post $post
 * @param WP_User $subscriber
 * @return String
 */
function wpns_get_mail_text($post, $subscriber) {
  
  $url = get_permalink($post->ID);
  
  $user_name = $subscriber->display_name;
  
  $text = "Hallo $user_name,
  
in Avas Blog gibt es neue Photos. Gleich anschauen unter:
  
$url
    
Viele Grüße,
Miriam, Tobias und Ava
";
  
  return $text;
  
}

/**
 * Send the mail to a specific subscriber
 * 
 * @param WP_Post $post
 * @param WP_User $subscriber
 */
function wpns_send_mail($post, $subscriber) {
  
  $headers = 'From: Avas Blog <blog@avathea.de>' . "\r\n";
  
  // FIXME: Just for test purposes
  //if ($subscriber->ID == 1 || $subscriber->ID == 2) {
  
    wp_mail(
      $subscriber->user_email, 
      wpns_get_mail_subject($post, $subscriber),
      wpns_get_mail_text($post, $subscriber),
      $headers
    );
  
  //}
  
}


/**
 * Get all blog subscribers
 * 
 * @return Array
 */
function wpns_get_subscribers() {
  
  #return get_users(array('role' => 'subscriber'));
  return get_users();
  
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