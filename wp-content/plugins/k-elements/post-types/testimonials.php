<?php
/*
 * Testimonials creation class
 * @author SeventhQueen
 *
 */


class Testimonials_Post_Type extends Kleo_Post_types {

	public function __construct() {
		$this->labels                 = array();
		$this->labels['testimonials'] = array(
			'singular' => esc_html__( 'Testimonial', 'kleo' ),
			'plural'   => esc_html__( 'Testimonials', 'kleo' ),
			'menu'     => esc_html__( 'Testimonials', 'kleo' )
		);

		add_action( 'init', array( $this, 'setup_post_type' ), 7 );
	}


	/**
	 * Setup Testimonials post type
	 * @since  1.0
	 * @return void
	 */
	public function setup_post_type() {

		$args = array(
			'labels'             => $this->get_labels( 'testimonials', $this->labels['testimonials']['singular'], $this->labels['testimonials']['plural'], $this->labels['testimonials']['menu'] ),
			'public'             => true,
			'publicly_queryable' => sq_option( 'testimonial_publicly_queryable', 1 ) ? true : false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-format-quote',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => esc_attr( apply_filters( 'kleo_testimonials_slug', 'testimonials' ) ) ),
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 20, // Below "Pages"
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'kleo-testimonials', $args );

		$tag_args = array(
			"label"             => esc_html_x( 'Testimonial Tags', 'tag label', 'kleo' ),
			"singular_label"    => esc_html_x( 'Testimonial Tag', 'tag singular label', 'kleo' ),
			'public'            => true,
			'hierarchical'      => false,
			'show_ui'           => true,
			'show_in_nav_menus' => false,
			'args'              => array( 'orderby' => 'term_order' ),
			'query_var'         => true
		);

		register_taxonomy( 'testimonials-tag', 'kleo-testimonials', $tag_args );
	} // End setup_testimonials_post_type()

}

$kleo_testimonials = new Testimonials_Post_Type();
if( class_exists( 'SVQ_FW' ) ) {
	SVQ_FW::set_module( 'testimonials', $kleo_testimonials );
}
