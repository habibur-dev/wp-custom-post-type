<?php

/**
 * Plugin Name:       Test CPT
 * Plugin URI:        #
 * Description:       Simple custom post type for test purpose.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Habibur Rahman
 * Author URI:        https://habibur.dev/
 * Text Domain:       test-cpt
 */

 //enqueue css

 function test_cpt_css() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'style',  $plugin_url . "/css/test-cpt-style.css");
}
add_action( 'wp_enqueue_scripts', 'test_cpt_css' );

 // Register book Post Type
function book_post_type() {

	$labels = array(
		'name'                  => __( 'Books', 'Post Type General Name', 'test-cpt' ),
		'singular_name'         => __( 'Book', 'Post Type Singular Name', 'test-cpt' ),
		'menu_name'             => __( 'Books', 'test-cpt' ),
		'name_admin_bar'        => __( 'Book', 'test-cpt' ),
		'archives'              => __( 'Book Archives', 'test-cpt' ),
		'attributes'            => __( 'Book Attributes', 'test-cpt' ),
		'parent_item_colon'     => __( 'Parent Book:', 'test-cpt' ),
		'all_items'             => __( 'All Books', 'test-cpt' ),
		'add_new_item'          => __( 'Add New Book', 'test-cpt' ),
		'add_new'               => __( 'Add New', 'test-cpt' ),
		'new_item'              => __( 'New Book', 'test-cpt' ),
		'edit_item'             => __( 'Edit Book', 'test-cpt' ),
		'update_item'           => __( 'Update Book', 'test-cpt' ),
		'view_item'             => __( 'View Book', 'test-cpt' ),
		'view_items'            => __( 'View Books', 'test-cpt' ),
		'search_items'          => __( 'Search Book', 'test-cpt' ),
		'not_found'             => __( 'Not found', 'test-cpt' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'test-cpt' ),
		'featured_image'        => __( 'Featured Image', 'test-cpt' ),
		'set_featured_image'    => __( 'Set featured image', 'test-cpt' ),
		'remove_featured_image' => __( 'Remove featured image', 'test-cpt' ),
		'use_featured_image'    => __( 'Use as featured image', 'test-cpt' ),
		'insert_into_item'      => __( 'Insert into Book', 'test-cpt' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'test-cpt' ),
		'items_list'            => __( 'Books list', 'test-cpt' ),
		'items_list_navigation' => __( 'Books list navigation', 'test-cpt' ),
		'filter_items_list'     => __( 'Filter books list', 'test-cpt' ),
	);
	$args = array(
		'label'                 => __( 'Book', 'test-cpt' ),
		'description'           => __( 'All Books', 'test-cpt' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'taxonomies'            => array(  ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-book-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'book', $args );

}
add_action( 'init', 'book_post_type', 0 );


// book single page template load
add_filter( 'single_template', 'book_post_type_single_template' );
 
function book_post_type_single_template( $single_template ) {
    global $post;
 
    if ( 'book' === $post->post_type ) {
        $single_template = dirname( __FILE__ ) . '/single-book-page.php';
    }
 
    return $single_template;
}

// book archive page template load
add_filter( 'archive_template', 'book_post_type_archive_template' );
 
function book_post_type_archive_template( $archive_template ) {
     global $post;
 
     if ( is_post_type_archive ( 'book' ) ) {
          $archive_template = dirname( __FILE__ ) . '/book-archive-page.php';
     }
     return $archive_template;
}


//Book category taxonomy register

function book_category_taxonomy(){

	$labels = array(
		'name' 						=> __('Book Categories', 'test-cpt'),
		'singular_name' 			=> __('Book Category', 'test-cpt'),
		'menu_name' 				=> __('Book Category', 'test-cpt'),
		'all_items' 				=> __('All Book Categories', 'test-cpt'),
		'parent_item' 				=> __('All Book Categories', 'test-cpt'),
		'new_item_name' 			=> __('New Category Name', 'test-cpt'),
		'add_new_item' 				=> __('Add New Category', 'test-cpt'),
		'edit_item' 				=> __('Edit Category', 'test-cpt'),
		'update_item' 				=> __('Update Category', 'test-cpt'),
		'view_item' 				=> __('View Category', 'test-cpt'),
		'separate_item_with_commas' => __('Separate items with commas', 'test-cpt'),
		'add_or_remove_items' 		=> __('Add or rmeove items', 'test-cpt'),
		'popular_items' 			=> __('Popular Categories', 'test-cpt'),
		'search_items' 				=> __('Search Categories', 'test-cpt'),
	);
	$rewrite = array(
		'slug' 	=> 'book-category',
	);
	$args = array(
		'labels' 					=> $labels,
		'hierarchical' 				=> true,
		'public' 					=> true,
		'show_ui' 					=> true,
		'show_admin_column' 		=> true,
		'show_in_nav_menus' 		=> true,
		'show_tag_cloud' 			=> true,
		'rewrite' 					=> $rewrite,
	);

	register_taxonomy('book_category', array('book'), $args);

}

add_action('init', 'book_category_taxonomy');

// custom excerpt length
function book_excerpt_length($length) {
	global $post;
	
	if ($post->post_type == 'book'){
		return 20;
	}
}
add_filter('excerpt_length', 'book_excerpt_length');

//remove 3 dot from excert
function remove_excerpt_dots( $more ) {
	return '';
}
add_filter('excerpt_more', 'remove_excerpt_dots');
