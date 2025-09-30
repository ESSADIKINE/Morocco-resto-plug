<?php
/**
 * Plugin Name: Le Bon Resto
 * Description: A WordPress plugin for managing restaurants with map integration using OpenStreetMap and Leaflet.js
 * Version: 1.4.0
 * Author: Your Name
 * Text Domain: le-bon-resto
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('LEBONRESTO_PLUGIN_URL', plugin_dir_url(__FILE__));
define('LEBONRESTO_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('LEBONRESTO_PLUGIN_VERSION', '1.4.0');

/**
 * Main plugin class
 */
class LeBonResto {
    
    /**
     * Initialize the plugin
     */
    public function __construct() {
        add_action('init', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    /**
     * Initialize plugin functionality
     */
    public function init() {
        // Load plugin files
        $this->load_includes();
        
        // Load text domain for translations
        load_plugin_textdomain('le-bon-resto', false, dirname(plugin_basename(__FILE__)) . '/languages');
        
        // Force register post type immediately if not already done
        if (!post_type_exists('restaurant')) {
            if (function_exists('lebonresto_register_restaurant_cpt')) {
                lebonresto_register_restaurant_cpt();
            }
        }
        
        // Add rewrite rules for details pages - high priority
        add_action('init', array($this, 'add_rewrite_rules'), 5);
        add_filter('query_vars', array($this, 'add_query_vars'));
        add_action('template_redirect', array($this, 'handle_details_redirect'));
        
        // Ensure all restaurants page is publicly accessible
        add_action('template_redirect', array($this, 'ensure_public_access'), 1);
        
        // Prevent WordPress from redirecting /all to other URLs
        add_filter('redirect_canonical', array($this, 'prevent_all_redirect'), 10, 2);
        
        // Force add rewrite rules on every init
        add_action('init', array($this, 'force_add_rewrite_rules'), 30);
        
        // Add admin notice for rewrite rules
        add_action('admin_notices', array($this, 'rewrite_rules_notice'));
        
        // Add admin action to flush rewrite rules
        add_action('admin_action_lebonresto_flush_rewrite_rules', array($this, 'flush_rewrite_rules_action'));
        
        // Add debug function for testing
        add_action('wp_ajax_lebonresto_test_routing', array($this, 'test_routing'));
        
        // Add function to flush rewrite rules and test URLs
        add_action('wp_ajax_lebonresto_flush_and_test', array($this, 'flush_and_test_urls'));
        
        // Add test function for all restaurants page access
        add_action('wp_ajax_lebonresto_test_all_restaurants_access', array($this, 'test_all_restaurants_access'));
        add_action('wp_ajax_nopriv_lebonresto_test_all_restaurants_access', array($this, 'test_all_restaurants_access'));
        
        // Auto-flush rewrite rules on activation
        add_action('init', array($this, 'maybe_flush_rewrite_rules'), 999);
        
        // Ensure all restaurants page is accessible to all users
        add_filter('user_has_cap', array($this, 'allow_all_restaurants_access'), 10, 4);
        
        // Override any permission checks for all restaurants page
        add_action('wp', array($this, 'override_permissions_for_all_restaurants'), 1);
    }
    
    /**
     * Load required files
     */
    private function load_includes() {
        require_once LEBONRESTO_PLUGIN_PATH . 'includes/cpt.php';
        require_once LEBONRESTO_PLUGIN_PATH . 'includes/scripts.php';
        require_once LEBONRESTO_PLUGIN_PATH . 'includes/shortcodes.php';
        require_once LEBONRESTO_PLUGIN_PATH . 'includes/api.php';
        require_once LEBONRESTO_PLUGIN_PATH . 'includes/templates.php';
        require_once LEBONRESTO_PLUGIN_PATH . 'includes/email-handler.php';
        require_once LEBONRESTO_PLUGIN_PATH . 'includes/seo-meta.php';
        require_once LEBONRESTO_PLUGIN_PATH . 'includes/seo-advanced.php';
        require_once LEBONRESTO_PLUGIN_PATH . 'includes/html-optimization.php';
        require_once LEBONRESTO_PLUGIN_PATH . 'includes/seo-hooks.php';
        require_once LEBONRESTO_PLUGIN_PATH . 'includes/performance-optimization.php';
        
        // Load admin interface if in admin
        if (is_admin()) {
            require_once LEBONRESTO_PLUGIN_PATH . 'includes/admin.php';
        }
    }
    
    /**
     * Add rewrite rules for details pages and all restaurants page
     */
    public function add_rewrite_rules() {
        // Single restaurant page rule (uses single-restaurant.php)
        add_rewrite_rule(
            '^restaurant/([^/]+)/?$',
            'index.php?restaurant_single=$matches[1]',
            'top'
        );
        
        // Details page rule (uses restaurant-detail.php)
        add_rewrite_rule(
            '^details/([^/]+)/?$',
            'index.php?restaurant_slug=$matches[1]',
            'top'
        );
        
        // All restaurants page rule - high priority to override any page redirects
        add_rewrite_rule(
            '^all/?$',
            'index.php?all_restaurants=1',
            'top'
        );
        
        // Prevent redirect from /all to other URLs
        add_rewrite_rule(
            '^all$',
            'index.php?all_restaurants=1',
            'top'
        );
    }
    
    /**
     * Force add rewrite rules (backup method)
     */
    public function force_add_rewrite_rules() {
        global $wp_rewrite;
        
        // Add the single restaurant rule directly to the rewrite rules array
        $wp_rewrite->add_rule(
            '^restaurant/([^/]+)/?$',
            'index.php?restaurant_single=$matches[1]',
            'top'
        );
        
        // Add the details rule directly to the rewrite rules array
        $wp_rewrite->add_rule(
            '^details/([^/]+)/?$',
            'index.php?restaurant_slug=$matches[1]',
            'top'
        );
        
        // Add the all restaurants rule directly to the rewrite rules array
        $wp_rewrite->add_rule(
            '^all/?$',
            'index.php?all_restaurants=1',
            'top'
        );
        
        // Also add without trailing slash to prevent redirects
        $wp_rewrite->add_rule(
            '^all$',
            'index.php?all_restaurants=1',
            'top'
        );
    }
    
    /**
     * Add custom query vars
     */
    public function add_query_vars($vars) {
        $vars[] = 'restaurant_single';
        $vars[] = 'restaurant_slug';
        $vars[] = 'all_restaurants';
        return $vars;
    }
    
    /**
     * Ensure all restaurants page is publicly accessible
     */
    public function ensure_public_access() {
        $all_restaurants = get_query_var('all_restaurants');
        
        if ($all_restaurants) {
            // Force public access - remove any permission restrictions
            remove_action('template_redirect', 'wp_redirect_admin_locations', 1000);
            
            // Set proper headers
            status_header(200);
            
            // Ensure no 403 errors
            if (function_exists('wp_die_handler')) {
                remove_action('wp_die_handler', 'wp_die_handler');
            }
        }
    }
    
    /**
     * Allow all users to access the all restaurants page
     */
    public function allow_all_restaurants_access($allcaps, $caps, $args, $user) {
        // Check if we're on the all restaurants page
        if (get_query_var('all_restaurants')) {
            // Grant read capability to all users for this page
            $allcaps['read'] = true;
        }
        
        return $allcaps;
    }
    
    /**
     * Override permissions for all restaurants page
     */
    public function override_permissions_for_all_restaurants() {
        if (get_query_var('all_restaurants')) {
            // Force WordPress to treat this as a public page
            global $wp_query;
            
            // Remove any admin restrictions
            remove_action('template_redirect', 'wp_redirect_admin_locations', 1000);
            
            // Set proper query flags
            $wp_query->is_404 = false;
            $wp_query->is_single = false;
            $wp_query->is_page = true;
            $wp_query->is_singular = true;
            
            // Ensure proper status
            status_header(200);
            
            // Remove any capability checks that might cause 403
            add_filter('user_has_cap', array($this, 'force_read_capability'), 10, 4);
        }
    }
    
    /**
     * Force read capability for all users on all restaurants page
     */
    public function force_read_capability($allcaps, $caps, $args, $user) {
        if (get_query_var('all_restaurants')) {
            $allcaps['read'] = true;
        }
        return $allcaps;
    }
    
    /**
     * Maybe flush rewrite rules if needed
     */
    public function maybe_flush_rewrite_rules() {
        // Check if rewrite rules need to be flushed
        $rules = get_option('rewrite_rules');
        if (!isset($rules['^all/?$']) || !isset($rules['^all$'])) {
            flush_rewrite_rules();
        }
    }
    
    /**
     * Test all restaurants page access
     */
    public function test_all_restaurants_access() {
        // Test if the all restaurants page is accessible
        $test_url = home_url('/all');
        
        // Simulate the query var
        set_query_var('all_restaurants', '1');
        
        // Check capabilities
        $can_read = current_user_can('read');
        $is_logged_in = is_user_logged_in();
        
        $response = array(
            'success' => true,
            'url' => $test_url,
            'can_read' => $can_read,
            'is_logged_in' => $is_logged_in,
            'user_id' => get_current_user_id(),
            'query_var' => get_query_var('all_restaurants'),
            'message' => 'All restaurants page access test completed'
        );
        
        wp_send_json_success($response);
    }
    
    /**
     * Handle details page redirect and all restaurants page
     */
    public function handle_details_redirect() {
        $restaurant_single = get_query_var('restaurant_single');
        $restaurant_slug = get_query_var('restaurant_slug');
        $all_restaurants = get_query_var('all_restaurants');
        
        // Handle all restaurants page
        if ($all_restaurants) {
            // Ensure this is accessible to all users (public access)
            if (!current_user_can('read')) {
                // Allow access to all users, including non-logged in users
                // This ensures the page is publicly accessible
            }
            
            // Set up the query for all restaurants page
            global $wp_query;
            $wp_query->is_single = false;
            $wp_query->is_singular = false;
            $wp_query->is_page = true;
            $wp_query->is_home = false;
            $wp_query->is_archive = false;
            $wp_query->is_search = false;
            $wp_query->is_404 = false;
            
            // Set proper headers to prevent 403 errors
            status_header(200);
            
            // Load the all restaurants template
            $template_path = LEBONRESTO_PLUGIN_PATH . 'templates/all-restaurants.php';
            if (file_exists($template_path)) {
                include $template_path;
                exit;
            }
        }
        
        // Handle single restaurant page (/restaurant/{slug})
        if ($restaurant_single) {
            $restaurant = $this->find_restaurant_by_slug($restaurant_single);
            
            if (!empty($restaurant)) {
                // Set up the post data
                global $post, $wp_query;
                $post = $restaurant[0];
                setup_postdata($post);
                
                // Set up the query to make have_posts() work
                $wp_query->is_single = true;
                $wp_query->is_singular = true;
                $wp_query->is_page = false;
                $wp_query->is_home = false;
                $wp_query->is_archive = false;
                $wp_query->is_search = false;
                $wp_query->is_404 = false;
                $wp_query->posts = array($post);
                $wp_query->post_count = 1;
                $wp_query->current_post = -1;
                $wp_query->in_the_loop = false;
                
                // Load the single restaurant template
                $template_path = LEBONRESTO_PLUGIN_PATH . 'templates/single-restaurant.php';
                if (file_exists($template_path)) {
                    include $template_path;
                    exit;
                }
            } else {
                // Restaurant not found, show 404
                global $wp_query;
                $wp_query->set_404();
                status_header(404);
                get_template_part('404');
                exit;
            }
        }
        
        // Handle details page (/details/{slug})
        if ($restaurant_slug) {
            $restaurant = $this->find_restaurant_by_slug($restaurant_slug);
            
            if (!empty($restaurant)) {
                // Set up the post data
                global $post, $wp_query;
                $post = $restaurant[0];
                setup_postdata($post);
                
                // Set up the query to make have_posts() work
                $wp_query->is_single = true;
                $wp_query->is_singular = true;
                $wp_query->is_page = false;
                $wp_query->is_home = false;
                $wp_query->is_archive = false;
                $wp_query->is_search = false;
                $wp_query->is_404 = false;
                $wp_query->posts = array($post);
                $wp_query->post_count = 1;
                $wp_query->current_post = -1;
                $wp_query->in_the_loop = false;
                
                // Load the restaurant detail template
                $template_path = LEBONRESTO_PLUGIN_PATH . 'templates/restaurant-detail.php';
                if (file_exists($template_path)) {
                    include $template_path;
                    exit;
                }
            } else {
                // Restaurant not found, show 404
                global $wp_query;
                $wp_query->set_404();
                status_header(404);
                get_template_part('404');
                exit;
            }
        }
    }
    
    /**
     * Helper method to find restaurant by slug
     */
    private function find_restaurant_by_slug($restaurant_slug) {
        // First try exact slug match
        $restaurant = get_posts(array(
            'post_type' => 'restaurant',
            'name' => $restaurant_slug,
            'posts_per_page' => 1,
            'post_status' => 'publish'
        ));
        
        // If no exact match, try to find by title similarity
        if (empty($restaurant)) {
            $restaurants = get_posts(array(
                'post_type' => 'restaurant',
                'posts_per_page' => -1,
                'post_status' => 'publish'
            ));
            
            foreach ($restaurants as $rest) {
                $title_slug = sanitize_title($rest->post_title);
                if ($title_slug === $restaurant_slug) {
                    $restaurant = array($rest);
                    break;
                }
            }
        }
        
        return $restaurant;
    }
    
    /**
     * Admin notice for rewrite rules
     */
    public function rewrite_rules_notice() {
        if (current_user_can('manage_options') && get_transient('lebonresto_rewrite_notice')) {
            echo '<div class="notice notice-info is-dismissible">';
            echo '<p><strong>Le Bon Resto:</strong> ' . __('Rewrite rules have been updated. Details pages should now work correctly.', 'le-bon-resto') . '</p>';
            echo '</div>';
            delete_transient('lebonresto_rewrite_notice');
        }
    }
    
    /**
     * Flush rewrite rules action
     */
    public function flush_rewrite_rules_action() {
        if (current_user_can('manage_options')) {
            // Force add rewrite rules first
            $this->add_rewrite_rules();
            $this->force_add_rewrite_rules();
            
            // Then flush
            flush_rewrite_rules();
            set_transient('lebonresto_rewrite_notice', true, 30);
            wp_redirect(admin_url('edit.php?post_type=restaurant&rewrite_flushed=1'));
            exit;
        }
    }
    
    /**
     * Test routing function
     */
    public function test_routing() {
        if (current_user_can('manage_options')) {
            $restaurants = get_posts(array(
                'post_type' => 'restaurant',
                'posts_per_page' => 5,
                'post_status' => 'publish'
            ));
            
            $results = array();
            foreach ($restaurants as $restaurant) {
                $slug = sanitize_title($restaurant->post_title);
                $results[] = array(
                    'id' => $restaurant->ID,
                    'title' => $restaurant->post_title,
                    'slug' => $slug,
                    'single_url' => home_url('/restaurant/' . $slug . '/'),
                    'details_url' => home_url('/details/' . $slug . '/')
                );
            }
            
            wp_send_json_success($results);
        }
    }
    
    /**
     * Flush rewrite rules and test URLs
     */
    public function flush_and_test_urls() {
        if (current_user_can('manage_options')) {
            // Flush rewrite rules
            flush_rewrite_rules();
            
            // Get restaurants for testing
            $restaurants = get_posts(array(
                'post_type' => 'restaurant',
                'posts_per_page' => 3,
                'post_status' => 'publish'
            ));
            
            $results = array(
                'rewrite_rules_flushed' => true,
                'restaurants_found' => count($restaurants),
                'test_urls' => array()
            );
            
            foreach ($restaurants as $restaurant) {
                $slug = sanitize_title($restaurant->post_title);
                $results['test_urls'][] = array(
                    'id' => $restaurant->ID,
                    'title' => $restaurant->post_title,
                    'slug' => $slug,
                    'single_url' => home_url('/restaurant/' . $slug . '/'),
                    'details_url' => home_url('/details/' . $slug . '/'),
                    'status' => 'published'
                );
            }
            
            wp_send_json_success($results);
        }
    }
    
    
    /**
     * Prevent WordPress from redirecting /all to other URLs
     */
    public function prevent_all_redirect($redirect_url, $requested_url) {
        // If the requested URL is /all, don't redirect it
        if (strpos($requested_url, '/all') !== false) {
            return false;
        }
        return $redirect_url;
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        // Make sure CPT is registered before flushing
        $this->load_includes();
        
        // Register the post type immediately
        if (function_exists('lebonresto_register_restaurant_cpt')) {
            lebonresto_register_restaurant_cpt();
        }
        
        // Create the all restaurants page if it doesn't exist
        if (function_exists('lebonresto_create_all_restaurants_page_now')) {
            lebonresto_create_all_restaurants_page_now();
        }
        
        // Flush rewrite rules to ensure custom post type URLs work
        flush_rewrite_rules();
        
        // Set a flag to show activation success
        set_transient('lebonresto_activation_notice', true, 30);
        set_transient('lebonresto_rewrite_notice', true, 30);
        
        // Trigger custom activation hook
        do_action('lebonresto_plugin_activated');
    }
    
    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Flush rewrite rules on deactivation
        flush_rewrite_rules();
    }
}

// Initialize the plugin
new LeBonResto();
