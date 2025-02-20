<?php
/**
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

/**
 * Kleo Child Theme Functions
 * Add custom code below
*/ 



function create_spotlight_ads_cpt() {
    $labels = array(
        'name'                  => _x( 'Spotlight Ads', 'Post Type General Name', 'nacaid' ),
        'singular_name'         => _x( 'Spotlight Ad', 'Post Type Singular Name', 'nacaid' ),
        'menu_name'             => __( 'Spotlight Ads', 'nacaid' ),
        'name_admin_bar'        => __( 'Spotlight Ad', 'nacaid' ),
        'archives'              => __( 'Spotlight Ad Archives', 'nacaid' ),
        'attributes'            => __( 'Spotlight Ad Attributes', 'nacaid' ),
        'parent_item_colon'     => __( 'Parent Spotlight Ad:', 'nacaid' ),
        'all_items'             => __( 'All Spotlight Ads', 'nacaid' ),
        'add_new_item'          => __( 'Add New Spotlight Ad', 'nacaid' ),
        'add_new'               => __( 'Add New', 'nacaid' ),
        'new_item'              => __( 'New Spotlight Ad', 'nacaid' ),
        'edit_item'             => __( 'Edit Spotlight Ad', 'nacaid' ),
        'update_item'           => __( 'Update Spotlight Ad', 'nacaid' ),
        'view_item'             => __( 'View Spotlight Ad', 'nacaid' ),
        'view_items'            => __( 'View Spotlight Ads', 'nacaid' ),
        'search_items'          => __( 'Search Spotlight Ad', 'nacaid' ),
        'not_found'             => __( 'Not found', 'nacaid' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'nacaid' ),
        'featured_image'        => __( 'Featured Image', 'nacaid' ),
        'set_featured_image'    => __( 'Set featured image', 'nacaid' ),
        'remove_featured_image' => __( 'Remove featured image', 'nacaid' ),
        'use_featured_image'    => __( 'Use as featured image', 'nacaid' ),
        'insert_into_item'      => __( 'Insert into Spotlight Ad', 'nacaid' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Spotlight Ad', 'nacaid' ),
        'items_list'            => __( 'Spotlight Ads list', 'nacaid' ),
        'items_list_navigation' => __( 'Spotlight Ads list navigation', 'nacaid' ),
        'filter_items_list'     => __( 'Filter Spotlight Ads list', 'nacaid' ),
    );
    $args = array(
        'label'                 => __( 'Spotlight Ad', 'nacaid' ),
        'description'           => __( 'Custom post type for spotlight ads', 'nacaid' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-megaphone', // You can change the icon here
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'rewrite'               => array( 'slug' => 'spotlight-ads' ),
    );
    register_post_type( 'spotlight_ads', $args );
}
add_action( 'init', 'create_spotlight_ads_cpt', 0 );

// Member count
function get_all_users_count() {
    $user_count = count_users(); 
    return $user_count['total_users']; 
}

function display_all_users_count() {
    $total_users = get_all_users_count(); 
    return '<span>' . esc_html($total_users) . '</span>'; 
}
add_shortcode('total_user_count', 'display_all_users_count');


//Group count








