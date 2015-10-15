<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add Property Shortcode
add_shortcode( 'property', 'bluerock_property_display' );

function bluerock_property_display( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'type' => '',
		), $atts )
	);
    
    ob_start();
    
    $property_query = new WP_Query(
        array(
            'post_type'      => 'property',
            'order'          => 'ASC',
            'orderby'        => 'title',
            'posts_per_page' => -1,
            'type'           => $type,
        )
    );

	// Code
if( $property_query->have_posts() ) {  ?>

<?php while ($property_query->have_posts()) : $property_query->the_post(); ?>

<a href="<?php echo get_permalink(); ?>"><h2><?php echo get_the_title(); ?></h2></a>
<?php endwhile; ?>
<?php } 
    wp_reset_query();//reset the global variable related to post loop
    $dirvar = ob_get_clean();
    return $dirvar;
}




?>


                                     