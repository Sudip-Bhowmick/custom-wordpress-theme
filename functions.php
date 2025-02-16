<?php
// theme color
function force_theme_color_meta_tag() {
    remove_action('wp_head', 'theme_slug_default_theme_color');
    echo '<meta name="theme-color" content="#3A0F69">';
}
add_action('wp_head', 'force_theme_color_meta_tag', 1);

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
    $nonce = base64_encode(random_bytes(16));

    header("X-Frame-Options: SAMEORIGIN");
    header("X-XSS-Protection: 1; mode=block");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: no-referrer-when-downgrade");

    if (is_admin()) {
        header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' 'unsafe-eval';");
    } else {
        header("Content-Security-Policy: default-src 'self'; style-src 'self'; script-src 'self' 'nonce-$nonce';");
    }

    header("Permissions-Policy: geolocation=(), camera=(), microphone=(), accelerometer=(), gyroscope=(), magnetometer=()");
}
// add_action('send_headers', 'add_security_headers');

// Remove WordPress version number from HTML head
remove_action('wp_head', 'wp_generator');
// header_remove("X-Powered-By");


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

// search
function search_bar() {
    ob_start(); ?>
<div class="search_box">
    <div class="search-container">
        <form id="searchform" action="<?php echo esc_url(home_url('/')); ?>" method="get">
            <div class="search">
                <input type="text" id="search" name="s" placeholder="Type to search..." autocomplete="off">
                <button class="search-btn"><img
                        src="<?php echo get_template_directory_uri() . '/img/search-icon.svg'; ?>"></button>
            </div>
            <div id="result" class="search-suggestions"></div>
        </form>
        <img src="<?php echo get_template_directory_uri() . '/img/close-icon.svg'; ?>" class="close_search"
            alt="Close search">
    </div>
</div>
<?php
    return ob_get_clean();
}
add_shortcode('customSearch', 'search_bar'); // shortcode [customSearch]

function enqueue_search_scripts() {
    wp_enqueue_script('custom-search', get_template_directory_uri() . '/js/custom-search.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-search', 'ajax_url', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_search_scripts');

function fetch_search_results() {
    $keyword = sanitize_text_field($_POST['keyword']);
    $results = [];

    // Query for posts, pages, and custom post types
    $args = [
        's' => $keyword,
        'posts_per_page' => 5,
        'post_type' => ['post', 'page', 'product'], // Add the desired post types
        'tax_query' => [
            [
                'taxonomy' => 'category', // Exclude 'news' category
                'field' => 'slug',
                'terms' => ['news'],
                'operator' => 'NOT IN',
            ],
        ],
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $results[] = [
                'type' => 'post', // Mark it as a post result
                'title' => get_the_title(),
                'url' => get_permalink(),
                'thumbnail' => $thumbnail,
            ];
        }
    }

    // Query for menu items
    $menu_name = 'dropdown-menu'; // Replace with your menu slug
    $menu_items = wp_get_nav_menu_items($menu_name);

    if ($menu_items) {
        foreach ($menu_items as $item) {
            if (stripos($item->title, $keyword) !== false) { // Check if menu title contains the keyword
                $results[] = [
                    'type' => 'menu', // Mark it as a menu result
                    'title' => $item->title,
                    'url' => $item->url,
                    'thumbnail' => '', // No thumbnail for menu items
                ];
            }
        }
    }

    // Output the results
    if (!empty($results)) {
        echo '<ul>';
        foreach ($results as $result) {
            echo '<li>';
            echo '<a target="_blank" href="' . esc_url($result['url']) . '">';
            if ($result['type'] === 'post' && !empty($result['thumbnail'])) {
                echo '<img src="' . esc_url($result['thumbnail']) . '" alt="' . esc_attr($result['title']) . '">';
            }
            echo '<span>' . esc_html($result['title']) . '</span>';
            echo '</a>';
            echo '</li>';
        }
        echo '</ul>';
        echo '<a href="' . esc_url(home_url('/?s=' . $keyword)) . '" class="view-all">View all</a>';
    } else {
        echo '<p>No results found.</p>';
    }

    wp_die(); // Ends the request
}

add_action('wp_ajax_fetch_search_results', 'fetch_search_results');
add_action('wp_ajax_nopriv_fetch_search_results', 'fetch_search_results');