<?php

// Add slider script to head
function bluerockre_slider_scripts() {
    if ( is_singular('portfolio')) {
    
    wp_enqueue_script( 'slider', content_url() . '/plugins/bluerock-portfolio/slider/js/lightslider.js', false, 1.0, false );
    wp_enqueue_style( 'slider', content_url() . '/plugins/bluerock-portfolio/slider/css/lightslider.css' );
}
}
add_action( 'wp_enqueue_scripts', 'bluerockre_slider_scripts', 100 );

// Print script to head
function bluerock_slider_head() {
        if ( is_singular('portfolio')) {
    echo '<script>
  jQuery(document).ready(function($) {
    $("#gallery-1").lightSlider({
        item:1,
        loop:true,
        thumbItem:9,
        slideMargin:0,
        gallery:false,
        enableDrag: true,
        enableTouch: true,
        mode:\'slide\',
        keyPress:true,
        adaptiveHeight:false,
        currentPagerPosition:\'middle\',
        })
    }); 
</script>';
}
}
 
// Add hook for front-end <head></head>
add_action('wp_head', 'bluerock_slider_head');

function my_post_layout_class( $class ) {

    // Make the front-page have a full-width layout
    if ( is_page_template( 'single-portfolio.php') ) {
        $class = 'content-right-sidebar'; // You can use full-width, full-screen, left-sidebar or right-sidebar
    }

    // Return correct class
    return $class;

}
add_filter( 'wpex_post_layout_class', 'my_post_layout_class', 100 );