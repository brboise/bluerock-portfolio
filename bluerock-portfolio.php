<?php

/*
Plugin Name: Bluerock Property Portfolio
Plugin URI: http://bluerockre.com
Description: Custom Post register for Property Portfolio
Author: Robby Milo
Version: 0.1
Author URI: http://rmilo.com
*/


// include 'slider.php';



// Begin Custom Post Type (CPT)
if ( ! function_exists('bluerock_portfolio2') ) {

// Register Custom Post Type
function bluerock_portfolio2() {

	$labels = array(
		'name'                => 'Portfolio',
		'singular_name'       => 'Property',
		'menu_name'           => 'Portfolio',
		'name_admin_bar'      => 'Property',
		'parent_item_colon'   => 'Parent Property:',
		'all_items'           => 'All Properties',
		'add_new_item'        => 'Add New Property',
		'add_new'             => 'Add New Property',
		'new_item'            => 'New Property',
		'edit_item'           => 'Edit Property',
		'update_item'         => 'Update Property',
		'view_item'           => 'View Property',
		'search_items'        => 'Search Property',
		'not_found'           => 'Not found',
		'not_found_in_trash'  => 'Not found in Trash',
	);
    $rewrite = array(
		'with_front'          => false,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => 'portfolio',
		'description'         => 'Custom Post register for Property Portfolio',
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', ),
		'taxonomies'          => array( 'property' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
        'rewrite'             => true,
		'capability_type'     => 'page',
        'query_var'           => true,
	);
	register_post_type( 'portfolio', $args );

}

// Hook into the 'init' action
add_action( 'init', 'bluerock_portfolio2', 0 );

}

if ( ! function_exists( 'bluerock_property_category' ) ) {

// Register Custom Taxonomy
function bluerock_property_category() {

	$labels = array(
		'name'                       => _x( 'Types', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Property Types', 'text_domain' ),
		'all_items'                  => __( 'All Property Types', 'text_domain' ),
		'parent_item'                => __( 'Parent Property Type', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Property Type:', 'text_domain' ),
		'new_item_name'              => __( 'New Property Type', 'text_domain' ),
		'add_new_item'               => __( 'Add Property Type', 'text_domain' ),
		'edit_item'                  => __( 'Edit Property Type', 'text_domain' ),
		'update_item'                => __( 'Update Property Type', 'text_domain' ),
		'view_item'                  => __( 'View Property Type', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Property Types', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Property Types', 'text_domain' ),
		'search_items'               => __( 'Search Property Types', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
    	$rewrite2 = array(
		'slug'                => 'property',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,  
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
        'query_var'                  => false,
        'rewrite'                    => $rewrite2,
	);
	register_taxonomy( 'type', array( 'portfolio' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'bluerock_property_category', 0 );

}

// Add Portfolio Thumb
add_image_size( 'brg-portfolio-thumby', 294, 196, true );
add_image_size( 'portfolio-header', 968, 450, true );

// Add the Meta Boxes
function bluerock_add_custom_meta_box() {
    add_meta_box(
        'custom_meta_box', // $id
        'Property Information', // $title 
        'bluerock_show_custom_meta_box', // $callback
        'portfolio', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'bluerock_add_custom_meta_box');

// Move Meta Boxes above Editor
add_action('edit_form_after_title', function() {
    global $post, $wp_meta_boxes;
    do_meta_boxes(get_current_screen(), 'advanced', $post);
    unset($wp_meta_boxes[get_post_type($post)]['advanced']);
});

// Meta Boxes
$prefix = 'bluerock_';
$bluerock_custom_meta_fields = array(
    array(
        'label'=> 'Location',
        'id'    => $prefix.'location',
        'type'  => 'text',
        'desc'  => 'Houston, TX'
    ),
    array(
        'label'=> 'Street Address',
        'id'    => $prefix.'address1',
        'type'  => 'text',
        'desc'  => '123 ABC'
    ),
    array(
        'label'=> 'City',
        'id'    => $prefix.'address2',
        'type'  => 'text',
    ),
    array(
        'label'=> 'State',
        'id'    => $prefix.'address3',
        'type'  => 'text',
    ),
    array(
        'label'=> 'Zip',
        'id'    => $prefix.'address4',
        'type'  => 'text',
    ),   
    array(
        'label'=> 'Square Feet',
        'id'    => $prefix.'squarefeet',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Units',
        'id'    => $prefix.'units',
        'type'  => 'text'
    ),

    array(
        'label'=> 'Year Built',
        'id'    => $prefix.'yearbuilt',
        'type'  => 'text'
    ),
        array(
        'label'=> 'Website',
        'id'    => $prefix.'url',
        'type'  => 'url',
    ),    
    array(
        'label'=> 'Partner',
        'id'    => $prefix.'partner',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Manager',
        'id'    => $prefix.'manager2',
        'type'  => 'text'
    ),    
    array(
        'label'=> 'Description',
        'id'    => $prefix.'description',
        'type'  => 'textarea'
    ),
    array(
        'label'=> 'Highlights',
        'id'    => $prefix.'highlights',
        'type'  => 'textarea'
    ),
    array(
        'label'=> 'Highlights 2',
        'id'    => $prefix.'highlights2',
        'type'  => 'textarea'
    ),
        array(
        'label'=> 'Sold',
        'id'    => $prefix.'highlights3',
        'type'  => 'checkbox'
    ),

);

// Callback
function bluerock_show_custom_meta_box() {
global $bluerock_custom_meta_fields, $post;
    
// Nonce for verification
get_the_ID();    
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
        
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($bluerock_custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
// text
case 'text':
    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.sanitize_text_field( $meta ).'" size="30" /><br /><span class="description">'.$field['desc'].'</span>';
break;
// url
case 'url':
    echo '<input type="url" name="'.$field['id'].'" id="'.$field['id'].'" value="'.esc_url_raw( $meta ).'" size="30" /><br /><span class="description">'.$field['desc'].'</span>';
break;      
// email
case 'email':
    echo '<input type="email" name="'.$field['id'].'" id="'.$field['id'].'" value="'.sanitize_email( $meta ).'" size="30" /><br /><span class="description">'.$field['desc'].'</span>';
break;                    
// textarea
case 'textarea':
    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.esc_textarea( $meta ).'</textarea>
        <br /><span class="description">'.$field['desc'].'</span>';
break;
                    
// checkbox
case 'checkbox':
    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
        <label for="'.$field['id'].'">'.$field['desc'].'</label>';
break;
                    
                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}
// Save the Meta Box Input
// Again - are we sanitizing/escing properly?
function bluerock_save_custom_meta($post_id) {
    global $bluerock_custom_meta_fields;
     
    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } 
            elseif (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
     
    // loop through fields, sanitize and save the data
    foreach ($bluerock_custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = sanitize_text_field( $_POST[$field['id']] );
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'bluerock_save_custom_meta');

// Register Portfolio Sidebar
function bluerock_portfolio_sidebar() {
    register_sidebar( array(
        'name' => __( 'Portfolio Sidebar', 'Bluerockre' ),
        'id' => 'portfolio-sidebar',
        'description' => __( 'Widgets in this area will be shown on all portfolio posts.', 'Bluerockre' ),
        'before_widget' => '<aside id="sidebar" class="sidebar-container sidebar-primary" role="complementary"><div id="sidebar-inner" class="clear"><div class="sidebar-box widget_nav_menu clr">',
	'after_widget'  => '</div></div></aside>',
	'before_title'  => '<h5 class="widget-title">',
	'after_title'   => '</h5>',
    ) );
}

add_action( 'widgets_init', 'bluerock_portfolio_sidebar' );

?>