<?php
/*
Controller name: JSON-API Extensions (Secursive)
Controller description: Extension controller for JSON API plugin from Secursive - https://github.com/secursive/wp-json-api-ext
*/

class JSON_API_Secursive_Controller {

    // Function for retrieving posts from multiple categories (comma separated input)
    public function get_categories_posts() {
    global $json_api;
    extract($json_api->query->get(array('id', 'slug')));
    // Retrieving posts for (comma-separated) category id(s) or slug(s)
    if ($id) {
	  return $this->get_categories_posts_internal('id', $id);
    } else if ($slug) {
	  return $this->get_categories_posts_internal('slug', $slug);
    } else {
      $json_api->error("Include 'id' or 'slug' var in your request. Separate multiple categories with comma.");
    }
  }

  // Function for retrieving n posts from groups of categories (input n)
  public function get_home() {
    global $json_api;
	
	// Names (slugs) of categories (comma separated)
	$group1_categories_slugs = 'category-a,category-b';
	$group2_categories_slugs = 'category-c';
	$group3_categories_slugs = 'category-d';

    extract($json_api->query->get(array('n')));
	// return n posts - defaulting to 3 posts per group
	if (!$n || !is_numeric($n)) {
	  $n = 3;
	}
	$n = intval($n);
    // Retrieving n posts for (comma-separated) category slug(s)
	$group1_result = $this->get_categories_posts_internal('slug', $group1_categories_slugs, $n);
	$group2_result = $this->get_categories_posts_internal('slug', $group2_categories_slugs, $n);
	$group3_result = $this->get_categories_posts_internal('slug', $group3_categories_slugs, $n);
	return array(
      'group1' => $group1_result,
      'group2' => $group2_result,
      'group3' => $group3_result
    );
  }
  
  // Function for sending email
  public function send_email() {
    global $json_api;
	
	// Configuration Parameters:
	$to_name = 'Receiver';
	$to_email = 'test@example.com';
	$subject = 'JSON API Send Email';
	$from_name = 'Admin';
	$from_email = get_option('admin_email');;

	// Processing inputs
    extract($json_api->query->get(array('firstname', 'lastname', 'email', 'phone')));
    if (!$firstname || !$lastname || !$email || !$phone) {
      $json_api->error("Include 'firstname', 'lastname', 'email', 'phone' vars in your request.");
    }
	$message = "First Name: $firstname\n";
	$message .= "Last Name: $lastname\n";
	$message .= "Email: $email\n";
	$message .= "Phone: $phone\n";
	
	// Sending email
	$headers[] = "From: $from_name <$from_email>";
	wp_mail($to_email, $subject, $message, $headers);
	return array();
  }

  // Internal Function for retrieving posts from multiple categories (comma separated input)
  // $input-type = 'id' or 'slug'
  // $categories = comma separated ids or slugs
  // $output_limit = option input for number of results (n+1 results are returned. By default (-1: all posts are returned))
  protected function get_categories_posts_internal($input_type, $categories, $output_limit=-1) {
    global $json_api;
	wp_reset_query();
    if ($input_type == 'id') {
      $posts = $json_api->introspector->get_posts(array(
        'cat' => $categories,
		'posts_per_page' => $output_limit
      ));
    } else if ($input_type == 'slug') {
      $posts = $json_api->introspector->get_posts(array(
        'category_name' => $categories,
		'posts_per_page' => $output_limit
      ));
    } else {
      return $this->posts_result(array());
    }

    // Retrieving meta data (including MagicFields) for each post
	foreach ($posts as $post) {
	  $meta = get_post_meta($post->id);
	  if (empty($meta)) {
	    $meta = array();
	  }
    // Embedding meta data into output post objects
	  foreach ($meta as $meta_key => $meta_val) {
        // Excluding meta keys starting with underscore (internal keys)
	    if (substr($meta_key,0,1) != "_") {
	      $post->$meta_key = $meta_val;
		}
	  }
    }
    // Returning result posts
    return $this->posts_result($posts);
  }

  protected function posts_result($posts) {
    return array(
      'count' => count($posts),
      'posts' => $posts
    );
  }

}

?>
