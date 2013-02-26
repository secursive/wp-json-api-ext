<?php
/*
Controller name: JSON-API Extensions (Secursive)
Controller description: Extension controller for JSON API plugin from Secursive - https://github.com/secursive/wp-json-api-ext
*/

class JSON_API_Secursive_Controller {

    // Function for retrieving posts from multiple categories (comma separated input)
    public function get_categories_posts() {
    global $json_api, $post;
    extract($json_api->query->get(array('id', 'slug')));
    // Retrieving posts for (comma-separated) category id(s) or slug(s)
    if ($id) {
      $posts = $json_api->introspector->get_posts(array(
        'cat' => $id
      ));
    } else if ($slug) {
      $posts = $json_api->introspector->get_posts(array(
        'category_name' => $slug
      ));
    } else {
      $json_api->error("Include 'id' or 'slug' var in your request. Separate multiple categories with comma.");
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
    global $wp_query;
    return array(
      'count' => count($posts),
      'count_total' => (int) $wp_query->found_posts,
      'pages' => $wp_query->max_num_pages,
      'posts' => $posts
    );
  }
  
  protected function posts_object_result($posts, $object) {
    global $wp_query;
    // Convert something like "JSON_API_Category" into "category"
    $object_key = strtolower(substr(get_class($object), 9));
    return array(
      'count' => count($posts),
      'pages' => (int) $wp_query->max_num_pages,
      $object_key => $object,
      'posts' => $posts
    );
  }
  
}

?>
