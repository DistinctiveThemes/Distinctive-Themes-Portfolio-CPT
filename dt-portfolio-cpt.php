<?php

/*
Plugin Name: Distinctive Themes Portfolio CPT
Plugin URI: http://www.distinctivethemes.com
Description: Portable Post Type from Distinctive Themes
Author: Danny Jones (Distinctive Themes)
Version: 1.0.0
Author URI: http://www.distinctivethemes.com
*/

add_action( 'init', 'register_cpt_dt_portfolio_cpt' );

function register_cpt_dt_portfolio_cpt() {

    $labels = array( 
        'name' => _x( 'Portfolio Projects', 'dt_portfolio_cpt' ),
        'singular_name' => _x( 'Project', 'dt_portfolio_cpt' ),
        'add_new' => _x( 'Add New', 'dt_portfolio_cpt' ),
        'add_new_item' => _x( 'Add New Project', 'dt_portfolio_cpt' ),
        'edit_item' => _x( 'Edit Project', 'dt_portfolio_cpt' ),
        'new_item' => _x( 'New Project', 'dt_portfolio_cpt' ),
        'view_item' => _x( 'View Project', 'dt_portfolio_cpt' ),
        'search_items' => _x( 'Search Portfolio Projects', 'dt_portfolio_cpt' ),
        'not_found' => _x( 'No portfolio projects found', 'dt_portfolio_cpt' ),
        'not_found_in_trash' => _x( 'No portfolio projects found in Trash', 'dt_portfolio_cpt' ),
        'parent_item_colon' => _x( 'Parent Project:', 'dt_portfolio_cpt' ),
        'menu_name' => _x( 'Portfolio', 'dt_portfolio_cpt' ),
    );

    $slug = get_option('dt_portfolio_slug');
    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,        
        'supports' => array( 'title', 'editor', 'thumbnail', 'post-formats' ),
        'taxonomies' => array( 'Filters' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-format-gallery',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,        
        'rewrite' =>  array( 'slug' => $slug ),
        'capability_type' => 'post'
    );

    register_post_type( 'dt_portfolio_cpt', $args );
}

add_action( 'init', 'register_taxonomy_dt_portfolio_cpt_categories' );

function register_taxonomy_dt_portfolio_cpt_categories() {

    $labels = array( 
        'name' => _x( 'Project Categories', 'distinctpress' ),
        'singular_name' => _x( 'Project Category', 'distinctpress' ),
        'search_items' => _x( 'Search Project Categories', 'distinctpress' ),
        'popular_items' => _x( 'Popular Project Categories', 'distinctpress' ),
        'all_items' => _x( 'All Project Categories', 'distinctpress' ),
        'parent_item' => _x( 'Parent Project Category', 'distinctpress' ),
        'parent_item_colon' => _x( 'Parent Project Category:', 'distinctpress' ),
        'edit_item' => _x( 'Edit Project Category', 'distinctpress' ),
        'update_item' => _x( 'Update Project Category', 'distinctpress' ),
        'add_new_item' => _x( 'Add New Project Category', 'distinctpress' ),
        'new_item_name' => _x( 'New Project Category', 'distinctpress' ),
        'separate_items_with_commas' => _x( 'Separate project categories with commas', 'distinctpress' ),
        'add_or_remove_items' => _x( 'Add or remove project categories', 'distinctpress' ),
        'choose_from_most_used' => _x( 'Choose from the most used project categories', 'distinctpress' ),
        'menu_name' => _x( 'Project Categories', 'distinctpress' ),
    );   

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,
        'query_var' => true
    );

    register_taxonomy( 'dt_portfolio_cpt_categories', array('dt_portfolio_cpt'), $args );
}

/* Admin */
add_action('admin_menu', 'dt_portfolio_plugin_settings');

function dt_portfolio_plugin_settings() {
    add_submenu_page('edit.php?post_type=dt_portfolio_cpt', 'settings', 'Settings', 'manage_options', 'portfolio_settings', 'dt_portfolio_display_settings' );
}

function dt_portfolio_display_settings() {
    $interval = (get_option('dt_portfolio_slug') != '') ? get_option('dt_portfolio_slug') : 'portfolio';

    $html = '</pre>
                <div class="wrap">
                    <form action="options.php" method="post" name="options">
                        <h2>Portfolio Settings</h2>
                        ' . wp_nonce_field('update-options') . '
                        <p class="intro">When you make any changes in this plugin, be sure to visit Your Permalink Settings & click the SAVE CHANGES button to refresh & re-write your permalinks, otherwise your changes will not take effect properly.
                        </p>
                        <p class="intro"><strong>Enter the URL slug you want to use for this post type. DO-NOT: use numbers, spaces, capital letters or special characters.</strong></p>
                        <table class="form-table" width="100%" cellpadding="10">
                            <tbody>
                                <tr>
                                    <td scope="row" align="left">
                                    <label class="inline-me"><strong>Portfolio Slug</strong></label>
                                    <input class="inline-me" type="text" name="dt_portfolio_slug" value="' . $interval . '" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="action" value="update" />
                        <input type="hidden" name="page_options" value="dt_portfolio_slug" />
                        <input type="submit" name="Submit" value="Update" />
                    </form>
                </div>
            <pre>
            <style type="text/css">
            .wrap { max-width: 800px; }
            .form-table td { padding: 10px 0; }
            .inline-me { display: inline-block; }
            </style>';
    echo $html;
}

?>