<?php

global $woothemes_sensei;
remove_action( 'sensei_before_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ), 10 );
remove_action( 'sensei_after_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ), 10 );
remove_all_actions('sensei_course_archive_header');
remove_all_actions('sensei_lesson_archive_header');
remove_all_actions('sensei_message_archive_header');
remove_all_actions('sensei_message_single_title');
remove_all_actions('sensei_quiz_single_title');
add_theme_support( 'sensei' );

remove_action( 'sensei_single_course_content_inside_before' ,array('Sensei_Course', 'the_title' ) );
remove_action( 'sensei_single_quiz_content_inside_before' ,array('Sensei_Quiz', 'the_title' ), 20 );
remove_action( 'sensei_single_lesson_content_inside_before' , array('Sensei_Lesson', 'the_title' ), 15 );
remove_action('sensei_archive_before_course_loop', array( 'Sensei_Course', 'archive_header' ), 10 );


add_action('sensei_before_main_content', 'kleo_sensei_wrapper_start', 10);
function kleo_sensei_wrapper_start() {
    kleo_switch_layout( sq_option( 'global_sidebar' ) );
    get_template_part('page-parts/general-title-section');
    get_template_part('page-parts/general-before-wrap');
}

add_action('sensei_after_main_content', 'kleo_sensei_wrapper_end', 10);
function kleo_sensei_wrapper_end() {
    get_template_part('page-parts/general-after-wrap');
}


add_filter('kleo_title_args', 'kleo_sensei_title', 10, 1);
function kleo_sensei_title($args){
    $title = false;
    global $post, $wp_query, $woothemes_sensei;
    if ( is_tax( 'course-category' ) ) {
        $taxonomy_obj = $wp_query->get_queried_object();
        $taxonomy_short_name = $taxonomy_obj->taxonomy;
        $taxonomy_raw_obj = get_taxonomy( $taxonomy_short_name );
        $title = sprintf( __( '%1$s Archives: %2$s', 'woothemes-sensei' ), $taxonomy_raw_obj->labels->name, $taxonomy_obj->name );
    }
    if( is_singular( 'sensei_message' ) ) {
        $content_post_id = get_post_meta( $post->ID, '_post', true );
        if( $content_post_id ) {
            $title = sprintf( __( 'Re: %1$s', 'woothemes-sensei' ), '<a href="' . get_permalink( $content_post_id ) . '">' . get_the_title( $content_post_id ) . '</a>' );
        }
    }
    if( is_singular('course') ){
        //remove_all_actions('sensei_course_image');
        remove_all_actions('sensei_course_single_title');
    }
    if( is_singular('lesson') ){
       // remove_all_actions('sensei_lesson_image');
        remove_all_actions('sensei_lesson_single_title');
    }
    if( isset( $wp_query->query_vars['learner_profile'] ) ) {
        $user = get_user_by( 'login', $wp_query->query_vars['learner_profile'] );
        if( strlen( $user->first_name ) > 0 ) {
            $name = $user->first_name;
        } else {
            $name = $user->display_name;
        }
        $name = apply_filters( 'sensei_learner_profile_courses_heading_name', $name );
        $title = apply_filters( 'sensei_learner_profile_courses_heading', sprintf( __( 'Courses %s is taking', 'woothemes-sensei' ), $name ) );
    }
    if($title){
        $breadcrumb_data = kleo_breadcrumb(array(
            'show_title' => false,
            'show_browse' => false,
            'separator' => ' ',
            'show_home'  => esc_html__( 'Home', 'kleo' ),
            'echo'       => false
        ));
        $breadcrumb_data = str_replace('</div>', '<span class="sep"> </span> <span class="active">'.$title.'</span> </div>', $breadcrumb_data);
        $args['output'] = str_replace('{breadcrumb_data}', $breadcrumb_data , $args['output']);
        $args['title'] = $title;
    }
    return $args;
}


add_action( 'wp_enqueue_scripts', 'kleo_sensei_css', 999 );
function kleo_sensei_css(){
    wp_register_style( 'kleo-sensei', trailingslashit( get_template_directory_uri() ) . 'lib/plugin-sensei/kleo-sensei.css', array(), SVQ_THEME_VERSION, 'all' );
    wp_enqueue_style( 'kleo-sensei' );
}