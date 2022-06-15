<?php 
/*
fix1653731540-entidades-cpt-inc.php
*/
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', 'fix1653731632' );
function fix1653731632() {
    $labels = array(
            "name" => "Entidades",
            "singular_name" => "Entidade",
    );

    $args = array(
            "label" => "Entidades",
            "labels" => $labels,
            "description" => "",
            "public" => true,
            // "public" => false,
            "publicly_queryable" => true,
            "show_ui" => true,
            "delete_with_user" => false,
            "show_in_rest" => false,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            // "has_archive" => false,
            "has_archive" => true,
            // "show_in_menu" => false,
            "show_in_menu" => true,
            // "show_in_nav_menus" => false,
            "show_in_nav_menus" => true,
            // "exclude_from_search" => true,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "rewrite" => array( "slug" => "entidades", "with_front" => true ),
            "query_var" => true,
            // "supports" => array( "title", "editor","thumbnail" ),
            // "supports" => array( "title", "editor" ),
            "supports" => array( "title" ),
    );
    register_post_type( "entidades", $args );
}



###############################
##    tg_include_custom_post_types_in_search_results
##############################
// add_action( 'pre_get_posts', 'fix1653990122' );
function fix1653990122( $query ) {
    if ( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
        $query->set( 'post_type', array( 'post', 'movies', 'products', 'portfolio' ) );
    }
}


###############################
##    template_chooser
## https://wordpress.stackexchange.com/questions/89886/how-to-create-a-custom-search-for-custom-post-type
##############################
// add_filter('template_include', 'fix1653990152');    
function fix1653990152($template){ 
    global $wp_query;
    $post_type = get_query_var('post_type');
    if( $wp_query->is_search && $post_type == 'products' ) {
        return locate_template('archive-search.php');  //  redirect to archive-search.php
    }
    return $template;
}
