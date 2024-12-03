<?php
// theme color
function force_theme_color_meta_tag() {
    remove_action('wp_head', 'theme_slug_default_theme_color');
    echo '<meta name="theme-color" content="#3A0F69">';
}
// Enqueue theme styles
function my_theme_scripts() {
	wp_enqueue_style('my-theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');

function my_custom_theme_setup() {
	add_theme_support('title-tag');
	// Add support for navigation menus
	register_nav_menus(array(
		'primary' => __('Primary Menu', 'my_custom_theme'),
		'footer'  => __('Footer Menu', 'my_custom_theme'),
	));
}
add_action('after_setup_theme', 'my_custom_theme_setup');

// featured images
function my_theme_setup(){
	add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'my_theme_setup');

// General security headers
function add_security_headers() {
    header("X-Frame-Options: SAMEORIGIN");
    header("X-XSS-Protection: 1; mode=block");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: no-referrer-when-downgrade");
    header("Content-Security-Policy: default-src 'self';");
    header("Permissions-Policy: geolocation=(), camera=(), microphone=(), accelerometer=(), gyroscope=(), magnetometer=()");
}
// add_action('send_headers', 'add_security_headers');


// global files
function enqueue_global_styles() {
	$random_version = rand(1, 9999);
	wp_enqueue_style('base-css', get_template_directory_uri() . '/css/base.css', array(), $random_version);
	wp_enqueue_style('slick-min-css', get_template_directory_uri() . '/css/slick.min.css');
	wp_enqueue_style('slick-theme-css', get_template_directory_uri() . '/css/slick-theme.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_global_styles');

function enqueue_global_scripts() {
	$random_version = rand(1, 9999);
	wp_enqueue_script('jquery-min-js', get_template_directory_uri() . '/js/jquery.min.js');
	wp_enqueue_script('lenis-js', get_template_directory_uri() . '/js/lenis.min.js', array(), $random_version);
	wp_enqueue_script('slick-min-js', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '', true);
	wp_enqueue_script('global-js', get_template_directory_uri() . '/js/global.js', array(), $random_version);
	// wp_enqueue_script('gsap-js', get_template_directory_uri() . '/js/gsap.min.js', array(), $random_version);
	// wp_enqueue_script('ScrollTrigger-js', get_template_directory_uri() . '/js/ScrollTrigger.min.js', array(), $random_version);
	// wp_enqueue_script('home-js', get_template_directory_uri() . '/js/home.js', array(), $random_version);
	// 	wp_enqueue_script('fancybox-min-js', get_template_directory_uri() . '/js/fancybox.min.js', array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'enqueue_global_scripts');

// css linking
function enqueue_page_styles() {
	// Generate a random number to prevent caching
	$random_version = rand(1, 9999);

	// Home
	if (is_home() || is_front_page()){
		wp_enqueue_style('home-page-css', get_template_directory_uri() . '/css/home.css', array(), $random_version);
	}

	// About Us
	//     if (is_page('about-us')) { 
	//         wp_enqueue_style('about-page-css', get_template_directory_uri() . '/css/about.css', array(), $random_version);
	//     }
}
add_action('wp_enqueue_scripts', 'enqueue_page_styles');