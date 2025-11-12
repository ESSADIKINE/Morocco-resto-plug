<?php
/**
 * Single Restaurant Template - Updated Layout
 * 
 * @package LeBonResto
 */

get_header(); 

// Get restaurant data for SEO
$restaurant_id = get_the_ID();
$restaurant_name = get_the_title();
$cuisine_type = get_post_meta($restaurant_id, '_restaurant_cuisine_type', true);
$city = get_post_meta($restaurant_id, '_restaurant_city', true);
$description = get_post_meta($restaurant_id, '_restaurant_description', true);

// Use city from meta or default to Casablanca
$city = $city ?: 'Casablanca';
$cuisine_type = $cuisine_type ?: 'cuisine marocaine';

// Generate SEO meta description
$seo_description = "Restaurant d'exception à {$city}, Maroc. Cuisine authentique, ambiance chaleureuse et service impeccable. Découvrez nos spécialités culinaires avec visite virtuelle 360°, réservez votre table et vivez une expérience gastronomique unique au cœur de la capitale économique.";

// Add SEO meta tags to head
add_action('wp_head', function() use ($restaurant_name, $city, $cuisine_type, $seo_description) {
    echo '<!-- SEO Meta Descriptions -->' . "\n";
    echo '<meta name="description" content="' . esc_attr($seo_description) . '">' . "\n";
    echo '<meta name="keywords" content="restaurant ' . esc_attr($restaurant_name) . ', ' . esc_attr($cuisine_type) . ' ' . esc_attr($city) . ', gastronomie Maroc, réservation restaurant ' . esc_attr($city) . ', visite virtuelle restaurant, tour virtuel restaurant, visite 360 restaurant, tour 360 restaurant, visite immersive restaurant">' . "\n";
    echo '<meta name="robots" content="index, follow">' . "\n";
    echo '<meta name="author" content="' . get_bloginfo('name') . '">' . "\n";
    
    echo '<!-- Open Graph Meta Tags -->' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($restaurant_name) . ' - Restaurant à ' . esc_attr($city) . ', Maroc">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($seo_description) . '">' . "\n";
    echo '<meta property="og:type" content="restaurant">' . "\n";
    echo '<meta property="og:locale" content="fr_FR">' . "\n";
    echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '">' . "\n";
    echo '<meta property="og:url" content="' . get_permalink() . '">' . "\n";
    
    echo '<!-- Twitter Card Meta Tags -->' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($restaurant_name) . ' - Restaurant à ' . esc_attr($city) . ', Maroc">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($seo_description) . '">' . "\n";
    
    echo '<!-- Structured Data for Restaurants -->' . "\n";
    echo '<script type="application/ld+json">' . "\n";
    echo json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Restaurant',
        'name' => $restaurant_name,
        'description' => $seo_description,
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => $city,
            'addressCountry' => 'MA'
        ],
        'servesCuisine' => $cuisine_type,
        'url' => get_permalink()
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    echo "\n" . '</script>' . "\n";
}, 1);

// Enqueue Tailwind CSS with fallback
wp_enqueue_style(
    'tailwind-css',
    'https://cdn.tailwindcss.com',
    array(),
    '3.4.0'
);

// Enqueue FontAwesome CSS
wp_enqueue_style(
    'font-awesome',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
    array(),
    '6.0.0'
);

// Add inline backup styles if Tailwind fails to load
wp_add_inline_style('tailwind-css', '
/* Tailwind Backup Styles */
.bg-gray-50 { background-color: #f9fafb; }
.bg-gray-100 { background-color: #f3f4f6; }
.bg-white { background-color: #ffffff; }
.bg-yellow-400 { background-color: #cc2014; }
.bg-yellow-500 { background-color: #cc2014; }
.text-gray-700 { color: rgb(255, 0, 0); }
.text-gray-800 { color: ; }
.text-gray-600 { color: #4b5563; }
.text-yellow-600 { color: #cc2014; }
.border { border-width: 1px; }
.border-gray-200 { border-color: #e5e7eb; }
.border-gray-300 { border-color: #d1d5db; }
.rounded-lg { border-radius: 0.5rem; }
.shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
.shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
.p-4 { padding: 1rem; }
.p-6 { padding: 1.5rem; }
.px-4 { padding-left: 1rem; padding-right: 1rem; }
.py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
.py-4 { padding-top: 1rem; padding-bottom: 1rem; }
.mb-4 { margin-bottom: 1rem; }
.mb-6 { margin-bottom: 1.5rem; }
.w-full { width: 100%; }
.h-full { height: 100%; }
.h-screen { height: 100vh; }
.flex { display: flex; }
.grid { display: grid; }
.container { max-width: 1200px; margin: 0 auto; }
.sticky { position: sticky; }
.top-0 { top: 0; }
.z-50 { z-index: 50; }
.flex-1 { flex: 1 1 0%; }
.flex-col { flex-direction: column; }
.items-center { align-items: center; }
.justify-between { justify-content: space-between; }
.gap-4 { gap: 1rem; }
.space-y-3 > * + * { margin-top: 0.75rem; }
.font-semibold { font-weight: 600; }
.font-bold { font-weight: 700; }
.text-sm { font-size: 0.875rem; }
.text-lg { font-size: 1.125rem; }
.text-xl { font-size: 1.25rem; }
        .transition { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
        
        /* Remove underlines from icon links */
        a[href^="tel:"], a[href^="mailto:"] {
            text-decoration: none !important;
        }
        
        a[href^="tel:"]:hover, a[href^="mailto:"]:hover {
            text-decoration: none !important;
        }
        
.duration-200 { transition-duration: 200ms; }
.hover\\:bg-yellow-500:hover { background-color: #cc2014; }
.hover\\:bg-gray-300:hover { background-color: #d1d5db; }
.focus\\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
.focus\\:ring-2:focus { box-shadow: 0 0 0 2px #cc2014; }
.max-h-96 { max-height: 24rem; }
.h-96 { height: 24rem; }
.overflow-y-auto { overflow-y: auto; }
@media (min-width: 1024px) {
    .lg\\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .lg\\:flex-row { flex-direction: row; }
    .lg\\:w-48 { width: 12rem; }
    .lg\\:w-auto { width: auto; }
}
');

// Enqueue Leaflet CSS and JS
wp_enqueue_style(
    'leaflet-css',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
    array(),
    '1.9.4'
);

wp_enqueue_script(
    'leaflet-js',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
    array(),
    '1.9.4',
    true
);

// Enqueue single restaurant script (main script)
wp_enqueue_script(
    'lebonresto-single-js',
    LEBONRESTO_PLUGIN_URL . 'assets/js/single-restaurant.js',
    array('jquery', 'leaflet-js', 'wp-api'),
    LEBONRESTO_PLUGIN_VERSION . '.debug' . time(), // Force cache invalidation
    true
);

// Enqueue single restaurant CSS with higher priority
wp_enqueue_style(
    'lebonresto-single-css',
    LEBONRESTO_PLUGIN_URL . 'assets/css/single-restaurant.css',
    array('tailwind-css', 'font-awesome'),
    LEBONRESTO_PLUGIN_VERSION . '.debug' . time(), // Force cache invalidation
    'all'
);

// Enqueue all restaurants CSS for card styling
wp_enqueue_style(
    'lebonresto-all-restaurants-css',
    LEBONRESTO_PLUGIN_URL . 'assets/css/all-restaurants.css',
    array('tailwind-css', 'font-awesome'),
    LEBONRESTO_PLUGIN_VERSION . '.debug' . time(), // Force cache invalidation
    'all'
);

// Add preload links for CSS files
add_action('wp_head', function() {
    echo '<link rel="preload" href="' . LEBONRESTO_PLUGIN_URL . 'assets/css/single-restaurant.css" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
    echo '<link rel="preload" href="' . LEBONRESTO_PLUGIN_URL . 'assets/css/all-restaurants.css" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
    echo '<noscript><link rel="stylesheet" href="' . LEBONRESTO_PLUGIN_URL . 'assets/css/single-restaurant.css"></noscript>' . "\n";
    echo '<noscript><link rel="stylesheet" href="' . LEBONRESTO_PLUGIN_URL . 'assets/css/all-restaurants.css"></noscript>' . "\n";
}, 1);

// Add critical inline styles to head for immediate loading
add_action('wp_head', function() {
    echo '<style id="lebonresto-critical-css">
/* Critical CSS for immediate loading - prevents FOUC */
:root {
    --primary-color: #cc2014;
    --primary-dark: #9b1d17;
    --text-primary: #1a1a1a;
    --text-secondary: rgb(0, 0, 0);
    --secondary-dark: #0a4d40;
    --text-muted: #f6d2cf;
    --text-on-primary: #fffaf2;
    --border-color: rgb(255, 0, 0);
    --border-light: #f0f0f0;
    --bg-white: rgb(168, 243, 189);
    --bg-gray-50: #fafafa;
    --bg-gray-100: #f5f5f5;
    --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
    --button-shadow: 0 10px 26px rgba(15, 106, 88, 0.28);
    --button-shadow-hover: 0 12px 32px rgba(179, 52, 43, 0.32);
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --transition: all 0.2s ease;
    --success-color: #10b981;
    --error-color: #ef4444;
}

.lebonresto-single-layout {
    background: linear-gradient(135deg, var(--bg-gray-50) 0%, var(--bg-white) 100%) !important;
    min-height: 100vh !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif !important;
}

.two-column-layout {
    display: grid !important;
    grid-template-columns: 1fr !important;
    gap: 1.5rem !important;
}

@media (min-width: 1024px) {
    .two-column-layout {
        grid-template-columns: 1fr 1fr !important;
    }
}

/* Prevent layout shift */
.restaurant-card {
    background: white !important;
    border-radius: 12px !important;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
    overflow: hidden !important;
    transition: transform 0.2s ease !important;
}

.restaurant-card:hover {
    transform: translateY(-2px) !important;
}

.restaurant-name a {
    color: var(--text-primary) !important;
    text-decoration: none !important;
    font-weight: 600 !important;
}

.restaurant-name a:hover {
    color: #cc2014 !important;
}

/* Map container */
#restaurants-map {
    height: 60vh !important;
    min-height: 400px !important;
    border-radius: 12px !important;
    overflow: hidden !important;
}

/* Loading state */
.loading {
    opacity: 0.6 !important;
    pointer-events: none !important;
}

/* Fullscreen icons */
.map-fullscreen-icon,
.virtual-tour-fullscreen-icon {
    position: absolute !important;
    top: 20px !important;
    right: 20px !important;
    z-index: 1000 !important;
    background: rgba(255, 255, 255, 0.9) !important;
    border-radius: 50% !important;
    width: 40px !important;
    height: 40px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
}

.map-fullscreen-icon:hover,
.virtual-tour-fullscreen-icon:hover {
    background: #cc2014 !important;
    transform: scale(1.1) !important;
}

.map-fullscreen-icon i,
.virtual-tour-fullscreen-icon i {
    color: var(--primary-color) !important;
    font-size: 16px !important;
}

/* Shared Button System */
.button-base {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 0.5rem !important;
    padding: 12px 18px !important;
    border-radius: var(--radius-lg) !important;
    font-weight: 600 !important;
    font-size: 14px !important;
    text-decoration: none !important;
    border: none !important;
    cursor: pointer !important;
    transition: var(--transition) !important;
    box-shadow: var(--button-shadow) !important;
}

.button-base:focus {
    outline: 2px solid rgba(255, 255, 255, 0.32) !important;
    outline-offset: 2px !important;
}

.button-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
    color: var(--text-on-primary) !important;
}

.button-primary:hover {
    transform: translateY(-2px) !important;
    box-shadow: var(--button-shadow-hover) !important;
    color: var(--text-on-primary) !important;
}

.button-primary:active {
    transform: translateY(0) !important;
}

.button-secondary {
    background: linear-gradient(145deg, rgba(255, 247, 239, 0.95) 0%, rgba(243, 231, 211, 0.9) 100%) !important;
    color: var(--secondary-dark) !important;
    border: 2px solid rgba(15, 106, 88, 0.2) !important;
    box-shadow: var(--shadow-sm) !important;
}

.button-secondary:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 10px 20px rgba(15, 106, 88, 0.18) !important;
}

.button-secondary:focus {
    outline: 2px solid rgba(204, 32, 20, 0.18) !important;
    outline-offset: 2px !important;
}

.add-review-button {
    width: 100% !important;
}

.button-base svg {
    width: 18px !important;
    height: 18px !important;
    fill: currentColor !important;
}

.add-review-button svg {
    margin-right: 8px !important;
}

.add-review-button-container {
    margin-bottom: 1rem !important;
    text-align: center !important;
    padding: 0 1rem !important;
}

/* Shared filter control styling */
.filter-select {
    width: 100% !important;
    appearance: none !important;
    background: linear-gradient(145deg, rgba(255, 247, 239, 0.95) 0%, rgba(243, 231, 211, 0.9) 100%) !important;
    border: 2px solid rgba(15, 106, 88, 0.25) !important;
    border-radius: var(--radius-lg) !important;
    padding: 12px 16px !important;
    font-weight: 600 !important;
    font-size: 14px !important;
    color: var(--secondary-dark) !important;
    box-shadow: var(--shadow-sm) !important;
    transition: var(--transition) !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%230a4d40%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 14px center !important;
    background-size: 16px !important;
    padding-right: 44px !important;
}

.filter-select:focus {
    outline: none !important;
    border-color: var(--primary-color) !important;
    box-shadow: 0 0 0 4px rgba(204, 32, 20, 0.18), var(--shadow-md) !important;
}

.filter-select:hover {
    border-color: rgba(204, 32, 20, 0.6) !important;
    box-shadow: var(--shadow-md) !important;
}

.filter-select option {
    color: var(--text-primary) !important;
}
</style>';
}, 1);

// Add additional inline styles to ensure they're applied
wp_add_inline_style('lebonresto-single-css', '
/* Additional styles for complete styling */
:root {
    --primary-color: #cc2014;
    --primary-dark: #9b1d17;
    --text-primary: #1a1a1a;
    --text-secondary: rgb(0, 0, 0);
    --text-muted: #767676;
    --text-on-primary: #fffaf2;
    --border-color: rgb(255, 0, 0);
    --border-light: #f0f0f0;
    --bg-white: #b9ffc0;
    --bg-gray-50: #fafafa;
    --bg-gray-100: #f5f5f5;
    --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
    --button-shadow: 0 10px 26px rgba(15, 106, 88, 0.28);
    --button-shadow-hover: 0 12px 32px rgba(179, 52, 43, 0.32);
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --transition: all 0.2s ease;
    --success-color: #10b981;
    --error-color: #ef4444;
}

.lebonresto-single-layout {
    background: linear-gradient(135deg, var(--bg-gray-50) 0%, var(--bg-white) 100%) !important;
    min-height: 100vh !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif !important;
}

.two-column-layout {
    display: grid !important;
    grid-template-columns: 4fr 5fr !important;
    gap: 0 !important;
    max-height: 65vh;
}

@media (max-width: 1023px) {
    .two-column-layout {
        grid-template-columns: 1fr !important;
        flex-direction: column !important;
        gap: 16px !important;
        max-height: 65vh;
        height: 65vh;
        min-height: 65vh;
    }
}



/* Form container styling - match desktop filter form */
.mobile-filter-content .space-y-4 {
    background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%) !important;
    border-radius: 12px !important;
    padding: 20px !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
    border: 2px solid rgba(251, 191, 36, 0.1) !important;
}

/* IMPORTANT: Hide mobile filter button completely on desktop */
@media (min-width: 1024px) {
    .mobile-filter-toggle,
    .mobile-filter-toggle.lg\:hidden,
    div.mobile-filter-toggle {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }
}

/* Show mobile filter button only on mobile/tablet */
@media (max-width: 1023px) {
    .mobile-filter-toggle {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        position: fixed !important;
        bottom: 20px !important;
        right: 20px !important;
        z-index: 1000 !important;
        pointer-events: auto !important;
    }
    
    .mobile-filter-toggle button {
        min-width: 160px !important;
    }

    .mobile-filter-toggle .filter-icon {
        display: block !important;
        width: 20px !important;
        height: 20px !important;
        fill: currentColor !important;
        color: var(--text-on-primary) !important;
        flex-shrink: 0 !important;
    }

    .mobile-filter-toggle .filter-text {
        display: block !important;
        color: var(--text-on-primary) !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        letter-spacing: 0.5px !important;
    }
}

.filter-form {
    background: linear-gradient(135deg, var(--bg-white) 0%, var(--bg-white) 100%) !important;
    border-radius: var(--radius-lg) !important;
    box-shadow: var(--shadow-lg) !important;
    padding: 20px !important;
    border: 2px solid rgba(254, 220, 0, 0.1) !important;
}

.filter-form input,
.filter-form select {
    height: 48px !important;
    border: 2px solid var(--border-color) !important;
    border-radius: var(--radius-lg) !important;
    font-size: 16px !important;
    padding: 12px 16px !important;
    transition: var(--transition) !important;
    background-color: #b9ffc0 !important;
}

.filter-form input:focus,
.filter-form select:focus {
    border-color: var(--primary-color) !important;
    box-shadow: 0 0 0 3px rgba(254, 220, 0, 0.1) !important;
    outline: none !important;
}

.filter-form button {
    height: 48px !important;
    border-radius: var(--radius-lg) !important;
    font-size: 16px !important;
    font-weight: 600 !important;
    padding: 14px 24px !important;
    transition: var(--transition) !important;
    border: none !important;
    cursor: pointer !important;
}

#search-restaurants {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color) 100%) !important;
    color: var(--text-primary) !important;
    font-weight: 700 !important;
}

#search-restaurants:hover {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-dark) 100%) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(254, 220, 0, 0.4) !important;
}

#clear-filters {
    background: linear-gradient(135deg, var(--bg-gray-100) 0%, var(--border-color) 100%) !important;
    color: var(--text-secondary) !important;
    border: 2px solid var(--border-color) !important;
}

.restaurant-card {
    background: linear-gradient(135deg, var(--bg-white) 0%, var(--bg-white) 100%) !important;
    border-radius: var(--radius-lg) !important;
    box-shadow: var(--shadow-md) !important;
    margin-bottom: 16px !important;
    border: 2px solid var(--bg-white) !important;
    transition: all 0.4s ease !important;
}

.restaurant-card:hover {
    box-shadow: var(--shadow-lg) !important;
    transform: translateY(-4px) scale(1.02) !important;
    border-color: var(--primary-color) !important;
}

.loading-spinner {
    border: 4px solid var(--bg-white) !important;
    border-top: 4px solid var(--primary-color) !important;
    border-right: 4px solid var(--primary-color) !important;
    border-radius: 50% !important;
    width: 32px !important;
    height: 32px !important;
    animation: spin 1.2s ease-in-out infinite !important;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    :root {
        --text-primary: #ffffff;
        --text-secondary:rgb(0, 0, 0);
        --text-muted: #f6d2cf;
        --bg-white:rgb(255, 255, 255);
        --bg-gray-50: #111827;
        --bg-gray-100: rgb(182, 238, 207);
        --border-color: rgb(255, 0, 0);
        --border-light: #4b5563;
        --secondary-dark: #66b5a5;
    }
}

@media (max-width: 768px) {
    .filter-form {
        flex-direction: column !important;
        align-items: stretch !important;
        padding: 20px !important;
        gap: 12px !important;
    }
    
    .filter-form input,
    .filter-form select,
    .filter-form button {
        width: 100% !important;
        min-height: 52px !important;
        font-size: 16px !important;
    }
}
');

?>

<div class="lebonresto-single-layout single-restaurant-template bg-gray-50">
    <?php while (have_posts()) : the_post(); ?>
        
        <?php
        // Get restaurant meta data
        $current_restaurant_id = get_the_ID();
        $address = get_post_meta($current_restaurant_id, '_restaurant_address', true);
        $city = get_post_meta($current_restaurant_id, '_restaurant_city', true);
        $cuisine_type = get_post_meta($current_restaurant_id, '_restaurant_cuisine_type', true);
        $description = get_post_meta($current_restaurant_id, '_restaurant_description', true);
        $phone = get_post_meta($current_restaurant_id, '_restaurant_phone', true);
        $email = get_post_meta($current_restaurant_id, '_restaurant_email', true);
        $latitude = get_post_meta($current_restaurant_id, '_restaurant_latitude', true);
        $longitude = get_post_meta($current_restaurant_id, '_restaurant_longitude', true);
        $is_featured = get_post_meta($current_restaurant_id, '_restaurant_is_featured', true);
        $virtual_tour_url = get_post_meta($current_restaurant_id, '_restaurant_virtual_tour_url', true);
        // Get gallery images with fallback
        if (function_exists('lebonresto_get_gallery_images')) {
        $gallery_images = lebonresto_get_gallery_images($current_restaurant_id);
        } else {
            // Fallback: get gallery images manually
            $gallery_ids = get_post_meta($current_restaurant_id, '_restaurant_gallery', true);
            $gallery_images = array();
            
            if ($gallery_ids) {
                $image_ids = explode(',', $gallery_ids);
                foreach ($image_ids as $image_id) {
                    $image_id = intval($image_id);
                    if ($image_id) {
                        $image_url = wp_get_attachment_image_url($image_id, 'medium');
                        if ($image_url) {
                            $gallery_images[] = array(
                                'id' => $image_id,
                                'url' => $image_url,
                                'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true)
                            );
                        }
                    }
                }
            }
        }
        


        // Get cuisine types and cities for filters
        $cuisine_types = lebonresto_get_cuisine_types();
        $restaurant_cities = lebonresto_get_restaurant_cities();
        
        // Get Google API reviews for the current restaurant
        error_log('LEBONRESTO REVIEWS LOG: Starting review data fetching for restaurant ID: ' . $current_restaurant_id);
        
        $google_api_reviews = get_post_meta($current_restaurant_id, '_restaurant_google_api_reviews', true);
        error_log('LEBONRESTO REVIEWS LOG: Stored reviews from meta: ' . (is_array($google_api_reviews) ? count($google_api_reviews) . ' reviews found' : 'no reviews or not array'));
        
        if (!is_array($google_api_reviews)) {
            $google_api_reviews = array();
            error_log('LEBONRESTO REVIEWS LOG: Initialized empty reviews array');
        }
        
        // Try to get fresh Google Places data if needed
        $google_place_id = get_post_meta($current_restaurant_id, '_restaurant_google_place_id', true);
        $api_key = function_exists('lebonresto_get_google_maps_api_key') ? lebonresto_get_google_maps_api_key() : '';
        
        error_log('LEBONRESTO REVIEWS LOG: Google Place ID: ' . ($google_place_id ?: 'NOT SET'));
        error_log('LEBONRESTO REVIEWS LOG: API Key available: ' . (!empty($api_key) ? 'YES' : 'NO'));
        error_log('LEBONRESTO REVIEWS LOG: fetch function available: ' . (function_exists('lebonresto_fetch_google_places_data') ? 'YES' : 'NO'));
        
        if ($google_place_id && $api_key && function_exists('lebonresto_fetch_google_places_data')) {
            error_log('LEBONRESTO REVIEWS LOG: Attempting to fetch fresh Google Places data...');
            $places_data = lebonresto_fetch_google_places_data($google_place_id, $api_key);
            
            if ($places_data) {
                error_log('LEBONRESTO REVIEWS LOG: Google Places API returned data: ' . print_r(array_keys($places_data), true));
                
                if (isset($places_data['reviews']) && !empty($places_data['reviews'])) {
                    error_log('LEBONRESTO REVIEWS LOG: Found ' . count($places_data['reviews']) . ' reviews in API response');
                    
                    $fresh_api_reviews = array();
                    foreach ($places_data['reviews'] as $index => $review) {
                        error_log('LEBONRESTO REVIEWS LOG: Processing review ' . ($index + 1) . ': ' . print_r($review, true));
                        
                        // Ensure we have valid review data before adding
                        if (isset($review['author_name']) || isset($review['text']) || isset($review['rating'])) {
                            $processed_review = array(
                                'name' => isset($review['author_name']) ? $review['author_name'] : 'Utilisateur anonyme',
                                'author_name' => isset($review['author_name']) ? $review['author_name'] : 'Utilisateur anonyme',
                                'rating' => isset($review['rating']) ? intval($review['rating']) : 0,
                                'text' => isset($review['text']) ? $review['text'] : '',
                                'date' => isset($review['time']) ? date('Y-m-d', $review['time']) : date('Y-m-d'),
                                'time' => isset($review['time']) ? $review['time'] : time(),
                                'source' => 'google_api'
                            );
                            
                            $fresh_api_reviews[] = $processed_review;
                            error_log('LEBONRESTO REVIEWS LOG: Added processed review: ' . print_r($processed_review, true));
                        } else {
                            error_log('LEBONRESTO REVIEWS LOG: Skipped review ' . ($index + 1) . ' - invalid data');
                        }
                    }
                    
                    if (!empty($fresh_api_reviews)) {
                        $google_api_reviews = $fresh_api_reviews;
                        update_post_meta($current_restaurant_id, '_restaurant_google_api_reviews', $fresh_api_reviews);
                        error_log('LEBONRESTO REVIEWS LOG: Updated meta with ' . count($fresh_api_reviews) . ' fresh reviews');
                    } else {
                        error_log('LEBONRESTO REVIEWS LOG: No valid reviews to save after processing');
                    }
                } else {
                    error_log('LEBONRESTO REVIEWS LOG: No reviews found in API response or reviews array is empty');
                }
            } else {
                error_log('LEBONRESTO REVIEWS LOG: Google Places API returned no data or failed');
            }
        } else {
            error_log('LEBONRESTO REVIEWS LOG: Cannot fetch fresh data - missing requirements');
        }
        
        error_log('LEBONRESTO REVIEWS LOG: Final reviews count for display: ' . count($google_api_reviews));
        ?>

        <!-- Mobile Filter Toggle Button -->
        <div class="mobile-filter-toggle lg:hidden">
        <button type="button" id="mobile-filter-btn" class="mobile-filter-button button-base button-primary">
            <svg viewBox="0 0 24 24" width="20" height="20" class="filter-icon">
                <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"></path>
            </svg>
            <span class="filter-text">Filtres</span>
        </button>
        </div>

    <!-- Mobile Filter Overlay -->
    <div id="mobile-filter-overlay" class="mobile-filter-overlay fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden" style="display: none;">
        <div class="mobile-filter-panel bg-white h-full w-80 max-w-[85vw] transform -translate-x-full transition-transform duration-300">
            <!-- Filter Header with Close Button -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gradient-to-r from-yellow-400 to-yellow-500">
                <h3 class="text-lg font-semibold text-gray-800"><?php _e('Filtres', 'le-bon-resto'); ?></h3>
                <button type="button" id="close-mobile-filters" class="text-gray-600 hover:text-gray-800 p-2 rounded-full hover:bg-white hover:bg-opacity-20 transition-all">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <div class="p-4 overflow-y-auto">
                <!-- Mobile Filter Form -->
                <div class="space-y-4">
                    <!-- Restaurant Name Search -->
                    <div>
                        <input 
                            type="text" 
                            id="mobile-restaurant-name" 
                            placeholder="<?php _e('Nom du restaurant...', 'le-bon-resto'); ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                        />
                    </div>
                    
                    <!-- City Filter -->
                        <div>
                            <select
                                id="mobile-city"
                                class="filter-select"
                            >
                            <option value=""><?php _e('Toutes les villes', 'le-bon-resto'); ?></option>
                            <?php foreach ($restaurant_cities as $city_option): ?>
                                <option value="<?php echo esc_attr($city_option); ?>"><?php echo esc_html($city_option); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Cuisine Filter -->
                    <div>
                        <select
                            id="mobile-cuisine"
                            class="filter-select"
                        >
                            <option value=""><?php _e('Toutes les cuisines', 'le-bon-resto'); ?></option>
                            <option value="française"><?php _e('Française', 'le-bon-resto'); ?></option>
                            <option value="italienne"><?php _e('Italienne', 'le-bon-resto'); ?></option>
                            <option value="asiatique"><?php _e('Asiatique', 'le-bon-resto'); ?></option>
                            <option value="méditerranéenne"><?php _e('Méditerranéenne', 'le-bon-resto'); ?></option>
                            <option value="mexicaine"><?php _e('Mexicaine', 'le-bon-resto'); ?></option>
                            <option value="indienne"><?php _e('Indienne', 'le-bon-resto'); ?></option>
                        </select>
                    </div>
                    
                    <!-- Sort Filter -->
                    <div>
                        <select
                            id="mobile-sort"
                            class="filter-select"
                        >
                            <option value="featured"><?php _e('Recommandés en premier', 'le-bon-resto'); ?></option>
                            <option value="newest"><?php _e('Plus récents', 'le-bon-resto'); ?></option>
                            <option value="name"><?php _e('Nom A-Z', 'le-bon-resto'); ?></option>
                        </select>
                    </div>
                    
                    <!-- Featured Only Toggle -->
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="mobile-featured-only" 
                            class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500 focus:ring-2"
                        />
                        <span class="ml-2 text-sm text-gray-600">
                            <?php _e('Seulement les recommandés', 'le-bon-resto'); ?>
                        </span>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="space-y-3 pt-4">
                        <button
                            id="mobile-apply-filters"
                            class="button-base button-primary w-full"
                        >
                            <?php _e('Appliquer les filtres', 'le-bon-resto'); ?>
                        </button>
                        
                        <button
                            id="mobile-clear-all"
                            class="button-base button-secondary w-full"
                        >
                            <?php _e('Effacer tout', 'le-bon-resto'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Desktop Filter Header (Hidden on Mobile, Tablet, and iPad) -->
        <div class="filter-header1 w-full bg-gray-100 border-b border-gray-200 sticky top-0 z-50">
            <div class="filter-container container mx-auto px-4 py-4">
                <div class="filter-form bg-white rounded-lg shadow-md p-2">
                    <div class="flex flex-col lg:flex-row items-center gap-4">
                        <!-- Restaurant Name Search -->
                        <div class="flex-1">
                            <input 
                                type="text" 
                                id="restaurant-name-filter" 
                                placeholder="<?php _e('Rechercher des restaurants...', 'le-bon-resto'); ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                            />
                        </div>
                        
                        <!-- City Filter -->
                        <div class="w-full lg:w-48">
                            <select
                                id="city-filter"
                                class="filter-select"
                            >
                                <option value=""><?php _e('Toutes les villes', 'le-bon-resto'); ?></option>
                                <?php foreach ($restaurant_cities as $city_option): ?>
                                    <option value="<?php echo esc_attr($city_option); ?>"><?php echo esc_html($city_option); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Cuisine Filter -->
                        <div class="w-full lg:w-48">
                            <select
                                id="cuisine-filter"
                                class="filter-select"
                            >
                                <option value=""><?php _e('Toutes les cuisines', 'le-bon-resto'); ?></option>
                                <?php foreach ($cuisine_types as $cuisine): ?>
                                    <option value="<?php echo esc_attr($cuisine); ?>">
                                        <?php echo esc_html(ucfirst($cuisine)); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Featured Only Toggle -->
                        <div class="flex items-center">
                            <label class="flex items-center space-x-2">
                                <input 
                                    type="checkbox" 
                                    id="featured-only" 
                                    class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500 focus:ring-2"
                                />
                                <span class="text-sm text-yellow-600 whitespace-nowrap">
                                    <i class="fas fa-star mr-1" style="color: #cc2014;"></i>
                                    <?php _e('Recommandé', 'le-bon-resto'); ?>
                            </span>
                            </label>
                        </div>

                        <!-- Search Button -->
                        <button
                            id="search-restaurants"
                            class="button-base button-primary w-full lg:w-auto"
                        >
                            <i class="fas fa-search mr-2"></i><?php _e('Rechercher', 'le-bon-resto'); ?>
                        </button>
                        
                        <!-- Clear Button -->
                        <button
                            id="clear-filters"
                            class="button-base button-secondary w-full lg:w-auto"
                        >
                            <?php _e('Effacer', 'le-bon-resto'); ?>
                        </button>
                    </div>
                </div>
                        </div>
                </div>

        <!-- Mobile Tab Navigation (Hidden on Desktop) -->
        <div class="mobile-tab-navigation lg:hidden fixed bottom-0 left-0 right-0 z-100 bg-white border-t border-gray-200 shadow-lg">
            <div class="flex">
                <button 
                    id="mobile-tab-vr" 
                    class="mobile-tab-btn"
                    data-tab="vr"
                >
                    <i class="fas fa-vr-cardboard"></i>
                    <span class="tab-text"><?php _e('Visite virtuelle', 'le-bon-resto'); ?></span>
                </button>
                <button 
                    id="mobile-tab-map" 
                    class="mobile-tab-btn active"
                    data-tab="map"
                >
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="tab-text"><?php _e('Carte', 'le-bon-resto'); ?></span>
                </button>
                        </div>
                </div>

        <!-- Line 2: Two Column Layout (50% each) -->
        <div class="two-column-layout flex-1 grid grid-cols-1 lg:grid-cols-2">
            
            <!-- Left Column: Map + Gallery (50% width) -->
            <div class="left-column1 relative bg-white border-r border-gray-200 flex flex-col">
                <!-- Map Section -->
                <div id="restaurants-map" class="w-full flex-1 relative" style="height: 60vh; min-height: 400px;">
                <!-- Map Controls -->
                <div class="button-center">
                    <button 
                        id="center-current-restaurant"
                        class="px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-medium rounded text-sm transition duration-200"
                        style="background-color: #cc2014;"
                        title="<?php _e('Centrer sur le restaurant actuel', 'le-bon-resto'); ?>"
                    >
                        <i class="fas fa-crosshairs mr-1"></i><?php _e('Centrer', 'le-bon-resto'); ?>
                    </button>
                    </div>
                
                <!-- Fullscreen Icon for Map -->
                <div class="map-fullscreen-icon" onclick="openMapFullscreen()" title="<?php _e('Plein écran', 'le-bon-resto'); ?>" style="z-index: 1000;">
                    <i class="fas fa-expand"></i>
                    </div>
                
                <!-- Results Counter -->
                <div class="results-counter">
                    <span id="map-results-count" class="px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-medium rounded text-sm">
                        <?php _e('Chargement des restaurants...', 'le-bon-resto'); ?>
                    </span>
                </div>

                </div>
                
                            </div>
                            
            <!-- Right Column: All Sections Combined (50% width) -->
            <div class="right-column1 flex flex-col bg-white">
                
                <!-- Virtual Tour Section -->
                <div class="virtual-tour-section h-96 border-b border-gray-200 relative">
                    <!-- Fullscreen Icon for Virtual Tour -->
                    <div class="virtual-tour-fullscreen-icon" onclick="openVirtualTourFullscreen()" title="<?php _e('Plein écran', 'le-bon-resto'); ?>" style="z-index: 1000;">
                        <i class="fas fa-expand"></i>
                    </div>
                    
                    <?php if ($virtual_tour_url): ?>
                        <div class="h-full relative" style="width: -webkit-fill-available;">
                            <iframe 
                                src="<?php echo esc_url($virtual_tour_url); ?>"
                                class="w-full h-full border-none"
                                allowfullscreen
                                loading="lazy"
                            ></iframe>
                        </div>
                    <?php else: ?>
                        <div class="h-full flex items-center justify-center bg-gray-100">
                            <div class="text-center p-8">
                                <i class="fas fa-vr-cardboard text-5xl text-gray-400 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-600 mb-2"><?php _e('Visite virtuelle', 'le-bon-resto'); ?></h3>
                                <p class="text-gray-500 mb-4"><?php _e('Aucune visite virtuelle disponible pour ce restaurant', 'le-bon-resto'); ?></p>
                            </div>
            </div>
                    <?php endif; ?>
                </div>
                

                </div>
                
        <!-- Current Restaurant Info (Hidden, used by JS) -->
        <script type="application/json" id="current-restaurant-data">
        <?php
        $restaurant_data = array(
            'id' => intval($current_restaurant_id),
            'title' => get_the_title(),
            'address' => $address ?: '',
            'city' => $city ?: '',
            'cuisine_type' => $cuisine_type ?: '',
            'description' => $description ?: '',
            'phone' => $phone ?: '',
            'email' => $email ?: '',
            'latitude' => $latitude ?: '',
            'longitude' => $longitude ?: '',
            'is_featured' => ($is_featured === '1'),
            'virtual_tour_url' => $virtual_tour_url ?: '',
            'link' => get_permalink(),
            'gallery_images' => $gallery_images ?: array()
        );
        
        echo wp_json_encode($restaurant_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        ?>
        </script>
        
        <!-- All Restaurants Data (Hidden, used by JS for fullscreen map) -->
        <script type="application/json" id="all-restaurants-data">
        <?php
        // Get all restaurants for the fullscreen map
        $all_restaurants_query = new WP_Query(array(
            'post_type' => 'restaurant',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));
        
        $all_restaurants_data = array();
        if ($all_restaurants_query->have_posts()) {
            while ($all_restaurants_query->have_posts()) {
                $all_restaurants_query->the_post();
                $restaurant_id = get_the_ID();
                
                $all_restaurants_data[] = array(
                    'id' => intval($restaurant_id),
                    'title' => array('rendered' => get_the_title()),
                    'restaurant_meta' => array(
                        'latitude' => get_post_meta($restaurant_id, '_restaurant_latitude', true),
                        'longitude' => get_post_meta($restaurant_id, '_restaurant_longitude', true),
                        'google_rating' => get_post_meta($restaurant_id, '_restaurant_google_rating', true),
                        'local_rating' => get_post_meta($restaurant_id, '_restaurant_rating', true),
                        'google_review_count' => get_post_meta($restaurant_id, '_restaurant_google_review_count', true),
                        'local_review_count' => get_post_meta($restaurant_id, '_restaurant_review_count', true),
                        'cuisine_type' => get_post_meta($restaurant_id, '_restaurant_cuisine_type', true),
                        'price_range' => get_post_meta($restaurant_id, '_restaurant_price_range', true),
                        'address' => get_post_meta($restaurant_id, '_restaurant_address', true),
                        'phone' => get_post_meta($restaurant_id, '_restaurant_phone', true),
                        'google_place_id' => get_post_meta($restaurant_id, '_restaurant_google_place_id', true),
                        'slug' => get_post_field('post_name', $restaurant_id)
                    )
                );
            }
        }
        wp_reset_postdata();
        
        echo wp_json_encode($all_restaurants_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        ?>
        </script>
        


    <?php endwhile; ?>
</div>
<!-- Two Column Layout: Restaurant Cards + Reviews -->
<div class="flex flex-col lg:flex-row gap-4 lg:gap-0">
    
    <!-- Right Column: Google Reviews (30%) -->
    <div class="w-full lg:w-3/10 shadow-lg overflow-hidden order-2 lg:order-2">
        <!-- Add Review Button -->
        <?php if (!empty($google_place_id)): ?>
            <div class="add-review-button-container">
                <a href="https://search.google.com/local/writereview?placeid=<?php echo esc_attr($google_place_id); ?>"
                   target="_blank"
                   rel="noopener"
                   class="add-review-button button-base button-primary">
                    <svg viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.365 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.365-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Ajouter un avis
                </a>
            </div>
        <?php endif; ?>
        
        <div id="google-reviews-container">
            <?php 
            // Debug information (remove in production)
            error_log('LEBONRESTO REVIEWS LOG: DISPLAY SECTION - Starting display logic');
            error_log('LEBONRESTO REVIEWS LOG: DISPLAY SECTION - Reviews array: ' . print_r($google_api_reviews, true));
            
            if (WP_DEBUG) {
                echo '<!-- DEBUG: google_api_reviews count: ' . (is_array($google_api_reviews) ? count($google_api_reviews) : 'not array') . ' -->';
                echo '<!-- DEBUG: google_place_id: ' . esc_html($google_place_id) . ' -->';
                echo '<!-- DEBUG: api_key available: ' . (!empty($api_key) ? 'yes' : 'no') . ' -->';
                if (!empty($google_api_reviews)) {
                    echo '<!-- DEBUG: First review data: ' . esc_html(print_r($google_api_reviews[0], true)) . ' -->';
                }
            }
            
            if (!empty($google_api_reviews)) {
                error_log('LEBONRESTO REVIEWS LOG: DISPLAY SECTION - Will display real reviews');
            } else {
                error_log('LEBONRESTO REVIEWS LOG: DISPLAY SECTION - Will display fallback/test review');
            }
            ?>
            <?php if (!empty($google_api_reviews)): ?>
                <?php 
                $review_count = 0;
                foreach (array_slice($google_api_reviews, 0, 5) as $index => $review): 
                    error_log('LEBONRESTO REVIEWS LOG: DISPLAY SECTION - Processing review ' . ($index + 1) . ': ' . print_r($review, true));
                ?>
                    <?php 
                    // Validate review data and provide fallbacks
                    $review_name = isset($review['name']) ? $review['name'] : (isset($review['author_name']) ? $review['author_name'] : 'Utilisateur anonyme');
                    $review_rating = isset($review['rating']) ? intval($review['rating']) : 0;
                    $review_text = isset($review['text']) ? $review['text'] : '';
                    $review_date = isset($review['date']) ? $review['date'] : date('Y-m-d');
                    
                    error_log('LEBONRESTO REVIEWS LOG: DISPLAY SECTION - Review ' . ($index + 1) . ' processed data: name=' . $review_name . ', rating=' . $review_rating . ', text_length=' . strlen($review_text));
                    
                    // Skip reviews with invalid data
                    if (empty($review_name) && empty($review_text) && $review_rating === 0) {
                        error_log('LEBONRESTO REVIEWS LOG: DISPLAY SECTION - Skipping review ' . ($index + 1) . ' - invalid data');
                        continue;
                    }
                    
                    $review_count++;
                    error_log('LEBONRESTO REVIEWS LOG: DISPLAY SECTION - Will display review ' . ($index + 1) . ' (display count: ' . $review_count . ')');
                    
                    // Get first letter of author name for avatar
                    $author_initial = !empty($review_name) ? strtoupper(substr($review_name, 0, 1)) : 'A';
                    
                    // Rating badge text
                    $rating_text = $review_rating >= 4 ? 'Excellent' : ($review_rating >= 3 ? 'Bien' : 'Moyen');
                    
                    // Format date
                    $formatted_date = date('j M Y', strtotime($review_date));
                    ?>
                    <div class="review-item">
                        <div class="review-header">
                            <div class="review-author-section">
                                <div class="review-author-avatar"><?php echo esc_html($author_initial); ?></div>
                                <div class="review-author-info">
                                    <div class="review-author"><?php echo esc_html($review_name); ?></div>
                                    <div class="review-restaurant"><?php echo esc_html(get_the_title()); ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="review-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <svg class="w-3 h-3 <?php echo $i <= $review_rating ? 'text-yellow-400' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.365 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.365-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        
                        <div class="review-content">
                            <?php if (!empty($review_text)): ?>
                                <div class="review-text"><?php echo esc_html(wp_trim_words($review_text, 30)); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="review-footer">
                            <div class="review-date"><?php echo esc_html($formatted_date); ?></div>
                            <div class="review-badge"><?php echo esc_html($rating_text); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php error_log('LEBONRESTO REVIEWS LOG: DISPLAY SECTION - Completed real reviews display. Total displayed: ' . (isset($review_count) ? $review_count : 0)); ?>
            <?php else: ?>
                <?php
                error_log('LEBONRESTO REVIEWS LOG: DISPLAY SECTION - Showing test review (no real reviews available)');
                // Show a test review to verify the display is working (temporary for debugging)
                $test_review = array(
                    'name' => 'Test User',
                    'rating' => 5,
                    'text' => 'Ceci est un avis de test pour vérifier que l\'affichage fonctionne correctement.',
                    'date' => date('Y-m-d')
                );
                $review_name = $test_review['name'];
                $review_rating = $test_review['rating'];
                $review_text = $test_review['text'];
                $review_date = $test_review['date'];
                $author_initial = strtoupper(substr($review_name, 0, 1));
                $rating_text = $review_rating >= 4 ? 'Excellent' : ($review_rating >= 3 ? 'Bien' : 'Moyen');
                $formatted_date = date('j M Y', strtotime($review_date));
                ?>
                
                <!-- Test review for debugging -->
                <div class="review-item">
                    <div class="review-header">
                        <div class="review-author-section">
                            <div class="review-author-avatar"><?php echo esc_html($author_initial); ?></div>
                            <div class="review-author-info">
                                <div class="review-author"><?php echo esc_html($review_name); ?></div>
                                <div class="review-restaurant"><?php echo esc_html(get_the_title()); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="review-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <svg class="w-3 h-3 <?php echo $i <= $review_rating ? 'text-yellow-400' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.365 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.365-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        <?php endfor; ?>
                    </div>
                    
                    <div class="review-content">
                        <div class="review-text"><?php echo esc_html($review_text); ?></div>
                    </div>
                    
                    <div class="review-footer">
                        <div class="review-date"><?php echo esc_html($formatted_date); ?></div>
                        <div class="review-badge"><?php echo esc_html($rating_text); ?></div>
                    </div>
                </div>
                
                <div class="text-center py-4 mt-4 border-t border-gray-200">
                    <p class="text-gray-500 text-sm"><?php _e('Aucun avis réel disponible pour ce restaurant', 'le-bon-resto'); ?></p>
                    <?php if (empty($google_place_id)): ?>
                        <p class="text-xs text-gray-400 mt-2"><?php _e('Configurez un Google Place ID pour afficher les avis automatiquement', 'le-bon-resto'); ?></p>
                    <?php elseif (empty($api_key)): ?>
                        <p class="text-xs text-gray-400 mt-2"><?php _e('Configurez une clé API Google Maps pour récupérer les avis', 'le-bon-resto'); ?></p>
                    <?php else: ?>
                        <p class="text-xs text-gray-400 mt-2"><?php _e('Les avis seront récupérés automatiquement', 'le-bon-resto'); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Left Column: Restaurant Cards (70%) -->
    <div class="w-full lg:w-7/10 flex flex-col order-1 lg:order-1">
                                 <!-- Filter Section -->
                <div class="filter-section p-4 bg-gradient-to-r border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <select
                                id="sort-restaurants"
                                class="filter-select"
                            >
                        <option value="featured"><?php _e('Recommandés en premier', 'le-bon-resto'); ?></option>
                        <option value="newest"><?php _e('Plus récents', 'le-bon-resto'); ?></option>
                        <option value="name"><?php _e('Nom A-Z', 'le-bon-resto'); ?></option>
                            </select>
                        </div>
                        </div>
</div>

                <!-- Restaurant Cards Container -->
        <div id="restaurants-container" class="flex-1 overflow-y-auto">
                        <!-- Restaurant cards will be loaded here via JavaScript -->
                        <div class="text-center py-8">
                            <div class="loading-spinner mx-auto mb-3"></div>
                <p class="text-gray-500"><?php _e('Chargement des restaurants...', 'le-bon-resto'); ?></p>
                        </div>
                    </div>
                
                <!-- Pagination -->
                <div id="pagination-container" class="p-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                    <span id="pagination-info"><?php _e('Chargement...', 'le-bon-resto'); ?></span>
                        </div>
                        <div id="pagination-controls" class="flex items-center space-x-2">
                            <!-- Pagination buttons will be generated here by JavaScript -->
                        </div>
                    </div>
                </div>   
                    </div>
</div>



                
<script>
// Essential inline functions - main functionality moved to external JS
(function() {
    'use strict';
    
    // Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize mobile filters
        if (typeof initializeMobileFilterHandlers === 'function') {
            initializeMobileFilterHandlers();
    }
    
    // Initialize mobile tabs
    if (typeof initializeMobileTabs === 'function') {
        initializeMobileTabs();
    }
    
});
})();

// Mobile filter functionality
function initializeMobileFilterHandlers() {
    console.log('Initializing mobile filter handlers...');
    
    const mobileFilterBtn = document.getElementById('mobile-filter-btn');
    const mobileFilterOverlay = document.getElementById('mobile-filter-overlay');
    const mobileFilterPanel = document.querySelector('.mobile-filter-panel');
    
    console.log('Elements found:', {
        btn: !!mobileFilterBtn,
        overlay: !!mobileFilterOverlay,
        panel: !!mobileFilterPanel
    });
    
    // Check if elements exist
    if (!mobileFilterBtn || !mobileFilterOverlay || !mobileFilterPanel) {
        console.error('Mobile filter elements not found!');
        return;
    }
    
    // Open mobile filter panel
    function openMobileFilter() {
        console.log('Opening mobile filter');
                mobileFilterOverlay.classList.remove('hidden');
        mobileFilterOverlay.classList.add('show');
        mobileFilterPanel.classList.add('show');
                mobileFilterPanel.classList.remove('-translate-x-full');
                document.body.style.overflow = 'hidden';
    }
    
    // Close mobile filter panel
    function closeMobileFilter() {
        console.log('Closing mobile filter');
        mobileFilterPanel.classList.remove('show');
        mobileFilterPanel.classList.add('-translate-x-full');
        setTimeout(() => {
            mobileFilterOverlay.classList.add('hidden');
            mobileFilterOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }, 300);
    }
    
    // Mobile filter button click
    mobileFilterBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Mobile filter button clicked!');
        openMobileFilter();
    });
    
    // Close on overlay click
        mobileFilterOverlay.addEventListener('click', function(e) {
            if (e.target === mobileFilterOverlay) {
            console.log('Overlay clicked');
            closeMobileFilter();
        }
    });
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileFilterOverlay.classList.contains('show')) {
            console.log('Escape key pressed');
            closeMobileFilter();
        }
    });
    
    // Set up close button (it's added dynamically)
    setTimeout(() => {
        const closeMobileFilters = document.getElementById('close-mobile-filters');
        if (closeMobileFilters) {
            closeMobileFilters.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Close button clicked');
                closeMobileFilter();
            });
        }
    }, 100);
    
    // Sync mobile filters with desktop filters
    syncMobileFilters();
    
    // Mobile filter event listeners
    setupMobileFilterListeners();
}

// Sync mobile filters with desktop filters
function syncMobileFilters() {
    // Sync from desktop to mobile
    const desktopFilters = {
        name: 'restaurant-name-filter',
        city: 'city-filter',
        cuisine: 'cuisine-filter',
        featured: 'featured-only'
    };

    const mobileFilters = {
        name: 'mobile-restaurant-name-filter',
        city: 'mobile-city-filter',
        cuisine: 'mobile-cuisine-filter',
        featured: 'mobile-featured-only'
    };
    
    Object.keys(desktopFilters).forEach(key => {
        const desktopEl = document.getElementById(desktopFilters[key]);
        const mobileEl = document.getElementById(mobileFilters[key]);
        
        if (desktopEl && mobileEl) {
            // Sync desktop to mobile
            desktopEl.addEventListener('input', function() {
                if (mobileEl.type === 'checkbox') {
                    mobileEl.checked = this.checked;
                } else {
                    mobileEl.value = this.value;
                }
            });
            
            // Sync mobile to desktop
            mobileEl.addEventListener('input', function() {
                if (desktopEl.type === 'checkbox') {
                    desktopEl.checked = this.checked;
        } else {
                    desktopEl.value = this.value;
                }
            });
        }
    });
}

// Setup mobile filter event listeners
function setupMobileFilterListeners() {
    // Mobile search button
    const mobileSearchBtn = document.getElementById('mobile-search-restaurants');
    
    if (mobileSearchBtn) {
        mobileSearchBtn.addEventListener('click', function() {
            // Trigger desktop search
            const desktopSearchBtn = document.getElementById('search-restaurants');
            
            if (desktopSearchBtn) {
                desktopSearchBtn.click();
            }
            
            // Close mobile panel
            const mobileFilterPanel = document.querySelector('.mobile-filter-panel');
            const mobileFilterOverlay = document.getElementById('mobile-filter-overlay');
            
            if (mobileFilterPanel && mobileFilterOverlay) {
                mobileFilterPanel.classList.add('-translate-x-full');
                setTimeout(() => {
                    mobileFilterOverlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }, 300);
            }
        });
    }
    
    // Mobile clear button
    const mobileClearBtn = document.getElementById('mobile-clear-filters');
    
    if (mobileClearBtn) {
        mobileClearBtn.addEventListener('click', function() {
            // Clear mobile filters
            const mobileFilters = [
                'mobile-restaurant-name-filter',
                'mobile-city-filter',
                'mobile-cuisine-filter',
                'mobile-featured-only'
            ];
            
            mobileFilters.forEach(filterId => {
                const element = document.getElementById(filterId);
                if (element) {
                    if (element.type === 'checkbox') {
                        element.checked = false;
        } else {
                        element.value = '';
                    }
                }
            });
            
            // Trigger desktop clear
            const desktopClearBtn = document.getElementById('clear-filters');
            
            if (desktopClearBtn) {
                desktopClearBtn.click();
            }
        });
    }
}

// Handle tab click
function handleTabClick(e) {
    e.preventDefault();
    e.stopPropagation();
    
    // Only work on mobile devices
    if (window.innerWidth > 1023) {
        return;
    }
    
    // Add loading state
    this.classList.add('loading');
    
    // Remove loading state after animation
    setTimeout(() => {
        this.classList.remove('loading');
    }, 800);
    
    const tabType = this.getAttribute('data-tab');
    const vrContent = document.querySelector('.virtual-tour-section');
    const mapContent = document.querySelector('#restaurants-map');
    const leftColumn = document.querySelector('.left-column1');
    const rightColumn = document.querySelector('.right-column1');
    const tabButtons = document.querySelectorAll('.mobile-tab-btn');
    
    // Update button states
    tabButtons.forEach(btn => {
        btn.classList.remove('active', 'border-yellow-400', 'bg-yellow-50');
        btn.classList.add('border-transparent');
    });
    
    this.classList.add('active', 'border-yellow-400', 'bg-yellow-50');
    this.classList.remove('border-transparent');
    
    // Show/hide entire columns based on tab (mobile only)
    if (tabType === 'vr') {
        // Hide left column (map)
        if (leftColumn) {
            leftColumn.style.setProperty('display', 'none', 'important');
        }
        
        // Show right column (VR)
        if (rightColumn) {
            rightColumn.style.setProperty('display', 'flex', 'important');
            rightColumn.style.setProperty('visibility', 'visible', 'important');
            rightColumn.style.setProperty('opacity', '1', 'important');
            rightColumn.style.setProperty('width', '100%', 'important');
            rightColumn.style.setProperty('flex', '1', 'important');
        }
        
        // Also show the VR content specifically
        if (vrContent) {
            vrContent.style.setProperty('display', 'block', 'important');
            vrContent.style.setProperty('visibility', 'visible', 'important');
            vrContent.style.setProperty('opacity', '1', 'important');
            vrContent.style.setProperty('position', 'relative', 'important');
            vrContent.style.setProperty('z-index', '10', 'important');
        }
        
    } else if (tabType === 'map') {
        // Show left column (map)
        if (leftColumn) {
            leftColumn.style.setProperty('display', 'flex', 'important');
            leftColumn.style.setProperty('visibility', 'visible', 'important');
            leftColumn.style.setProperty('opacity', '1', 'important');
            leftColumn.style.setProperty('width', '100%', 'important');
            leftColumn.style.setProperty('flex', '1', 'important');
        }
        
        // Hide right column (VR)
        if (rightColumn) {
            rightColumn.style.setProperty('display', 'none', 'important');
        }
        
        // Also hide the VR content specifically
        if (vrContent) {
            vrContent.style.setProperty('display', 'none', 'important');
            vrContent.style.setProperty('visibility', 'hidden', 'important');
            vrContent.style.setProperty('opacity', '0', 'important');
        }
    }
}

// Initialize mobile tab system
function initializeMobileTabs() {
    // Wait a bit for DOM to be ready
    setTimeout(() => {
        const tabButtons = document.querySelectorAll('.mobile-tab-btn');
        const vrContent = document.querySelector('.virtual-tour-section');
        const mapContent = document.querySelector('#restaurants-map');
        const leftColumn = document.querySelector('.left-column1');
        const rightColumn = document.querySelector('.right-column1');
        
        if (tabButtons.length === 0) {
            return;
        }
    
        // Set default view to Map on mobile only
        if (window.innerWidth <= 1023) {
            
            // Show left column (map), hide right column (VR) on mobile
            if (leftColumn) {
                leftColumn.style.setProperty('display', 'flex', 'important');
                leftColumn.style.setProperty('visibility', 'visible', 'important');
                leftColumn.style.setProperty('opacity', '1', 'important');
                leftColumn.style.setProperty('width', '100%', 'important');
                leftColumn.style.setProperty('flex', '1', 'important');
            }
            if (rightColumn) {
                rightColumn.style.setProperty('display', 'none', 'important');
            }
            if (vrContent) {
                vrContent.style.setProperty('display', 'none', 'important');
                vrContent.style.setProperty('visibility', 'hidden', 'important');
                vrContent.style.setProperty('opacity', '0', 'important');
            }
        } else {
            // On desktop, ensure both columns are visible
            if (leftColumn) {
                leftColumn.style.setProperty('display', 'flex', 'important');
                leftColumn.style.setProperty('visibility', 'visible', 'important');
                leftColumn.style.setProperty('opacity', '1', 'important');
                leftColumn.style.setProperty('width', '100%', 'important');
                leftColumn.style.setProperty('flex', '1', 'important');
            }
            if (rightColumn) {
                rightColumn.style.setProperty('display', 'flex', 'important');
                rightColumn.style.setProperty('visibility', 'visible', 'important');
                rightColumn.style.setProperty('opacity', '1', 'important');
                rightColumn.style.setProperty('width', '100%', 'important');
                rightColumn.style.setProperty('flex', '1', 'important');
            }
            if (vrContent) {
                vrContent.style.setProperty('display', 'block', 'important');
                vrContent.style.setProperty('visibility', 'visible', 'important');
                vrContent.style.setProperty('opacity', '1', 'important');
            }
        }
            
            // Update tab button states - Map is default active
            const vrTab = document.getElementById('mobile-tab-vr');
            const mapTab = document.getElementById('mobile-tab-map');
            
            if (mapTab) {
                mapTab.classList.add('active');
                mapTab.classList.add('border-yellow-400', 'bg-yellow-50');
                mapTab.classList.remove('border-transparent');
            }
            
            if (vrTab) {
                vrTab.classList.remove('active');
                vrTab.classList.remove('border-yellow-400', 'bg-yellow-50');
                vrTab.classList.add('border-transparent');
            }
        
        // Add click event listeners to tab buttons
        
        // Test direct button access
        const vrButton = document.getElementById('mobile-tab-vr');
        const mapButton = document.getElementById('mobile-tab-map');
        
        tabButtons.forEach((button, index) => {
            console.log(`🔧 [MOBILE TABS] Button ${index}:`, button.id, button);
            
            // Test if button is clickable
            button.style.pointerEvents = 'auto';
            button.style.cursor = 'pointer';
            button.style.zIndex = '10000';
            button.style.position = 'relative';
            
            // Add multiple event listeners to ensure it works
            button.addEventListener('click', handleTabClick);
            button.addEventListener('touchstart', handleTabClick);
            button.addEventListener('touchend', handleTabClick);
        });
        
        // Also add direct event listeners as backup
        if (vrButton) {
            console.log('🔧 [MOBILE TABS] Adding direct event listener to VR button');
            vrButton.addEventListener('click', function(e) {
                console.log('🔧 [MOBILE TABS] Direct VR button clicked!');
                e.preventDefault();
                e.stopPropagation();
                handleTabClick.call(this, e);
            });
        }
        
        if (mapButton) {
            console.log('🔧 [MOBILE TABS] Adding direct event listener to Map button');
            mapButton.addEventListener('click', function(e) {
                console.log('🔧 [MOBILE TABS] Direct Map button clicked!');
                e.preventDefault();
                e.stopPropagation();
                handleTabClick.call(this, e);
            });
        }
        
        // Test if buttons are clickable by adding a simple test
        console.log('🔧 [MOBILE TABS] Testing button clickability...');
        if (vrButton) {
            vrButton.onclick = function() {
                console.log('🔧 [MOBILE TABS] VR button onclick triggered!');
            };
        }
        if (mapButton) {
            mapButton.onclick = function() {
                console.log('🔧 [MOBILE TABS] Map button onclick triggered!');
            };
        }
        
        console.log('🔧 [MOBILE TABS] Mobile tab system initialized!');
        
        // Test if buttons are clickable
        setTimeout(() => {
            console.log('🔧 [MOBILE TABS] Testing button clickability...');
            tabButtons.forEach((button, index) => {
                console.log(`🔧 [MOBILE TABS] Button ${index} (${button.id}):`, {
                    element: button,
                    classes: button.className,
                    style: button.style.cssText,
                    computedStyle: window.getComputedStyle(button)
                });
            });
        }, 1000);
    }, 500); // Wait 500ms for DOM to be ready
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize mobile tab system with a small delay to ensure DOM is ready
    setTimeout(() => {
        initializeMobileTabs();
    }, 100);
    
    // Apply essential styles
    const rightColumn = document.querySelector('.right-column1');
    const restaurantsContainer = document.querySelector('#restaurants-container');
    
    if (rightColumn) {
        // Check if mobile (screen width <= 1023px)
        if (window.innerWidth <= 1023) {
            // Mobile: Force disable all scrolling
            console.log('🔧 [MOBILE DEBUG] Applying mobile scroll disable...');
            rightColumn.style.overflowY = 'hidden';
            rightColumn.style.overflowX = 'hidden';
            rightColumn.style.maxHeight = 'none';
            rightColumn.style.height = 'auto';
            rightColumn.style.minHeight = 'auto';
            
            // Disable scroll in restaurants container on mobile
            if (restaurantsContainer) {
                console.log('🔧 [MOBILE DEBUG] Disabling restaurants container scroll...');
                restaurantsContainer.style.overflowY = 'visible';
                restaurantsContainer.style.overflowX = 'visible';
                restaurantsContainer.style.maxHeight = 'none';
                restaurantsContainer.style.height = 'auto';
                restaurantsContainer.style.minHeight = 'auto';
            }
            
            // Force all child elements to be visible
            const allChildren = rightColumn.querySelectorAll('*');
            allChildren.forEach(child => {
                child.style.overflow = 'visible';
                child.style.maxHeight = 'none';
            });
            
            console.log('🔧 [MOBILE DEBUG] Mobile scroll disable applied!');
        } else {
            // Enable scroll on desktop
        rightColumn.style.overflowY = 'auto';
        rightColumn.style.maxHeight = '100vh';
        rightColumn.style.scrollbarWidth = 'thin';
        rightColumn.style.scrollbarColor = '#cc2014 #f3f4f6';
            
            // Enable scroll in restaurants container on desktop
            if (restaurantsContainer) {
                restaurantsContainer.style.overflowY = 'auto';
                restaurantsContainer.style.maxHeight = '100%';
            }
        }
    }
    
    // Initialize mobile filter functionality
    console.log('🔧 [MOBILE DEBUG] Calling initializeMobileFilters...');
    
    // Debug: Check if elements exist
    console.log('🔧 [MOBILE DEBUG] Checking elements:', {
        button: document.getElementById('mobile-filter-btn'),
        overlay: document.getElementById('mobile-filter-overlay'),
        panel: document.querySelector('.mobile-filter-panel'),
        toggle: document.querySelector('.mobile-filter-toggle')
    });
    
    initializeMobileFilters();
    
    /**
     * Initialize mobile filters
     */
    function initializeMobileFilters() {
        const mobileFilterBtn = document.getElementById('mobile-filter-btn');
        const mobileFilterOverlay = document.getElementById('mobile-filter-overlay');
        const closeMobileFilters = document.getElementById('close-mobile-filters');
        const mobileFilterPanel = document.querySelector('.mobile-filter-panel');
        
        console.log('Initializing mobile filters...', {
            btn: !!mobileFilterBtn,
            overlay: !!mobileFilterOverlay,
            panel: !!mobileFilterPanel,
            closeBtn: !!closeMobileFilters
        });
        
        // Open mobile filters
        if (mobileFilterBtn) {
            console.log('Adding click event listener to mobile filter button');
            
            // Test if button is visible and clickable
            console.log('Button styles:', {
                display: window.getComputedStyle(mobileFilterBtn).display,
                visibility: window.getComputedStyle(mobileFilterBtn).visibility,
                opacity: window.getComputedStyle(mobileFilterBtn).opacity,
                pointerEvents: window.getComputedStyle(mobileFilterBtn).pointerEvents
            });
            
            mobileFilterBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Mobile filter button clicked!');
                showMobileFilters();
            });
            
            // Also add a test click handler
            mobileFilterBtn.addEventListener('mousedown', function() {
                console.log('Button mousedown detected');
            });
            
        } else {
            console.error('Mobile filter button not found!');
        }

        // Close on overlay click
        if (mobileFilterOverlay) {
            mobileFilterOverlay.addEventListener('click', function(e) {
                if (e.target === mobileFilterOverlay) {
                    hideMobileFilters();
                }
            });
        }
        
        // Close button handler
        if (closeMobileFilters) {
            closeMobileFilters.addEventListener('click', function(e) {
                e.preventDefault();
                hideMobileFilters();
            });
        }
        
        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileFilterOverlay && mobileFilterOverlay.classList.contains('show')) {
                hideMobileFilters();
            }
        });
    }
    
    /**
     * Show mobile filters
     */
    function showMobileFilters() {
        console.log('=== SHOWING MOBILE FILTERS ===');
        const mobileFilterOverlay = document.getElementById('mobile-filter-overlay');
        const mobileFilterPanel = document.querySelector('.mobile-filter-panel');
        const mobileFilterToggle = document.querySelector('.mobile-filter-toggle');
        
        console.log('Mobile filter elements found:', {
            overlay: !!mobileFilterOverlay,
            panel: !!mobileFilterPanel,
            toggle: !!mobileFilterToggle
        });
        
        if (mobileFilterOverlay && mobileFilterPanel) {
            // Hide the filter button
            if (mobileFilterToggle) {
                mobileFilterToggle.classList.add('filter-open');
                console.log('Filter button hidden');
            }
            
            // Show overlay with proper styling
            mobileFilterOverlay.style.display = 'block';
            mobileFilterOverlay.style.visibility = 'visible';
            mobileFilterOverlay.style.opacity = '1';
            mobileFilterOverlay.classList.add('show');
            mobileFilterOverlay.classList.remove('hidden');
            
            // Show panel with animation
            mobileFilterPanel.style.transform = 'translateX(0)';
            mobileFilterPanel.style.opacity = '1';
            mobileFilterPanel.style.visibility = 'visible';
            mobileFilterPanel.classList.add('show');
            mobileFilterPanel.classList.remove('-translate-x-full');
            
            console.log('Mobile filters shown successfully');
        } else {
            console.error('Mobile filter elements not found:', {
                overlay: !!mobileFilterOverlay,
                panel: !!mobileFilterPanel
            });
        }
    }
    
    /**
     * Hide mobile filters
     */
    function hideMobileFilters() {
        console.log('=== HIDING MOBILE FILTERS ===');
        const mobileFilterOverlay = document.getElementById('mobile-filter-overlay');
        const mobileFilterPanel = document.querySelector('.mobile-filter-panel');
        const mobileFilterToggle = document.querySelector('.mobile-filter-toggle');
        
        if (mobileFilterPanel && mobileFilterOverlay) {
            console.log('Starting hide animation...');
            
            // Start panel slide-out animation
            mobileFilterPanel.style.transform = 'translateX(-100%)';
            mobileFilterPanel.classList.remove('show');
            mobileFilterPanel.classList.add('-translate-x-full');
            
            setTimeout(() => {
                // Hide overlay
                mobileFilterOverlay.style.display = 'none';
                mobileFilterOverlay.style.opacity = '0';
                mobileFilterOverlay.style.visibility = 'hidden';
                mobileFilterOverlay.classList.add('hidden');
                mobileFilterOverlay.classList.remove('show');
                
                // Show the filter button again
                if (mobileFilterToggle) {
                    mobileFilterToggle.classList.remove('filter-open');
                    console.log('Filter button shown again');
                }
                
                console.log('Mobile filters hidden successfully');
            }, 300);
        }
    }
    
    // Handle window resize to update scroll behavior and tab visibility
    window.addEventListener('resize', function() {
        const rightColumn = document.querySelector('.right-column1');
        const restaurantsContainer = document.querySelector('#restaurants-container');
        const vrContent = document.querySelector('.virtual-tour-section');
        const mapContent = document.querySelector('#restaurants-map');
        
        if (rightColumn) {
            if (window.innerWidth <= 1023) {
                // Mobile: Let CSS handle the styling, just ensure no conflicting styles
                rightColumn.style.overflowY = 'hidden';
                rightColumn.style.overflowX = 'hidden';
                rightColumn.style.maxHeight = 'none';
                
                // Disable scroll in restaurants container on mobile
                if (restaurantsContainer) {
                    restaurantsContainer.style.overflowY = 'visible';
                    restaurantsContainer.style.overflowX = 'visible';
                    restaurantsContainer.style.maxHeight = 'none';
                }
                
                // Ensure mobile tab behavior - Map is default
                if (leftColumn) {
                    leftColumn.style.setProperty('display', 'flex', 'important');
                    leftColumn.style.setProperty('width', '100%', 'important');
                }
                if (rightColumn) {
                    rightColumn.style.setProperty('display', 'none', 'important');
                }
            } else {
                // Enable scroll on desktop
                rightColumn.style.overflowY = 'auto';
                rightColumn.style.maxHeight = '100vh';
                rightColumn.style.scrollbarWidth = 'thin';
                rightColumn.style.scrollbarColor = '#cc2014 #f3f4f6';
                
                // Enable scroll in restaurants container on desktop
                if (restaurantsContainer) {
                    restaurantsContainer.style.overflowY = 'auto';
                    restaurantsContainer.style.maxHeight = '100%';
                }
                
                // Ensure both columns are visible on desktop
                if (leftColumn) {
                    leftColumn.style.setProperty('display', 'flex', 'important');
                    leftColumn.style.setProperty('width', '50%', 'important');
                }
                if (rightColumn) {
                    rightColumn.style.setProperty('display', 'flex', 'important');
                    rightColumn.style.setProperty('width', '50%', 'important');
                }
            }
        }
    });
    
});

// Also initialize on window load as backup
window.addEventListener('load', function() {
    console.log('🔧 [MOBILE TABS] Window loaded, re-initializing mobile tabs...');
    setTimeout(() => {
        initializeMobileTabs();
    }, 200);
});

// Syntax validation check
if (typeof window !== 'undefined') {
    console.log('✅ Single restaurant JavaScript loaded successfully');
}
</script>

<?php
// Localize script data
wp_localize_script(
    'lebonresto-single-js',
    'lebonrestoSingle',
    array(
        'apiUrl' => home_url('/wp-json/lebonresto/v1/restaurants'),
        'cuisineTypesUrl' => home_url('/wp-json/lebonresto/v1/cuisine-types'),
        'citiesUrl' => home_url('/wp-json/lebonresto/v1/cities'),
        'homeUrl' => home_url('/'),
        'nonce' => wp_create_nonce('wp_rest'),
        'currentRestaurantId' => $current_restaurant_id,
        'cities' => $restaurant_cities,
        'mapCenter' => array(
            'lat' => !empty($latitude) ? floatval($latitude) : 48.8566,
            'lng' => !empty($longitude) ? floatval($longitude) : 2.3522
        ),
        'strings' => array(
            'featuredBadge' => __('Featured', 'le-bon-resto'),
            'viewDetails' => __('View Details', 'le-bon-resto'),
            'noRestaurants' => __('No restaurants found', 'le-bon-resto'),
            'loadingError' => __('Error loading restaurants', 'le-bon-resto'),
            'phoneTitle' => __('Call restaurant', 'le-bon-resto'),
            'emailTitle' => __('Email restaurant', 'le-bon-resto'),
            'loadingRestaurants' => __('Loading restaurants...', 'le-bon-resto'),
            'restaurantsFound' => __('%s restaurants found', 'le-bon-resto'),
            'centerOnCurrent' => __('Centrer sur le restaurant actuel', 'le-bon-resto'),
            'googleReviews' => __('Avis Google', 'le-bon-resto'),
            'loadingReviews' => __('Chargement des avis...', 'le-bon-resto'),
            'noReviews' => __('Aucun avis disponible', 'le-bon-resto'),
            'reviewsFrom' => __('Avis de %s', 'le-bon-resto'),
        )
    )
);

// Google Reviews are now loaded directly via PHP for the current restaurant
// No additional JavaScript loading needed for reviews display
?>

<!-- DEBUG MARKER: Line reference for JavaScript error debugging -->

<style>







/* Mobile Content Visibility */
@media (max-width: 1023px) {
    /* Default: Show Map, Hide VR on mobile */
    .virtual-tour-section {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        transition: all 0.3s ease !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 1 !important;
    }
    
    #restaurants-map {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        transition: all 0.3s ease !important;
        position: relative !important;
        z-index: 2 !important;
        max-height: 65vh;
    }
    
    /* Make sure both containers are in the same area on mobile */
    .left-column1 {
        position: relative !important;
    }
    
    .right-column1 {
        position: relative !important;
    }
    
    /* Allow JavaScript to override these styles */
    .virtual-tour-section[style*="display: block"] {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    .virtual-tour-section[style*="display: none"] {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
    }
    
    #restaurants-map[style*="display: block"] {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        max-height: 65vh;
    }
    
    #restaurants-map[style*="display: none"] {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        max-height: 65vh;
    }

    
    /* Ensure cards section is always visible on mobile */
    .mobile-cards-section {
        position: relative !important;
        z-index: 1 !important;
        background: white !important;
        border-top: 2px solid #e5e7eb !important;
        margin-top: 0 !important;
    }
}

/* Desktop: Show both VR and Map */
@media (min-width: 1024px) {
    .mobile-tab-navigation {
        display: none !important;
    }
    
    .virtual-tour-section {
        display: block !important;
    }
    
    #restaurants-map {
        display: block !important;
        max-height: 65vh;
    }
    
    /* Reset any mobile overrides on desktop */
    .virtual-tour-section[style*="display: none"] {
        display: block !important;
    }
    
    #restaurants-map[style*="display: none"] {
        display: block !important;
        max-height: 65vh;
    }

.mobile-filter-toggle button {
    width: auto !important;
    height: auto !important;
    padding: 12px 18px !important;
    border-radius: var(--radius-lg) !important;
    font-size: 14px !important;
    font-weight: 600 !important;
}

.mobile-filter-toggle button:hover {
    transform: translateY(-2px) !important;
}

/* Custom Filter Icon - Visible */
.filter-icon {
    display: block !important;
    width: 20px !important;
    height: 20px !important;
    fill: currentColor !important;
    color: var(--text-on-primary) !important;
    flex-shrink: 0 !important;
}

.filter-line {
    display: none;
}

.mobile-filter-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 40;
    display: none;
}

/* Mobile Filter Panel - Essential Styles Only */
.mobile-filter-panel {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

.mobile-filter-panel .space-y-4 > div {
    margin-bottom: 20px !important;
}

.mobile-filter-panel input,
.mobile-filter-panel select {
    background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%) !important;
    border: 2px solid #e5e7eb !important;
    border-radius: 12px !important;
    padding: 14px 16px !important;
    font-size: 15px !important;
    font-weight: 500 !important;
    color: var(--secondary-dark) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
}

.mobile-filter-panel input:focus,
.mobile-filter-panel select:focus {
    outline: none !important;
    border-color: #cc2014 !important;
    box-shadow: 0 0 0 4px rgba(254, 220, 0, 0.15), 0 4px 12px rgba(254, 220, 0, 0.1) !important;
    background: #ffffff !important;
    transform: translateY(-1px) !important;
}

.mobile-filter-panel input::placeholder {
    color: #f6d2cf !important;
    font-weight: 400 !important;
}

.mobile-filter-panel select {
    cursor: pointer !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%236b7280%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E") !important;
    background-position: right 12px center !important;
    background-repeat: no-repeat !important;
    background-size: 16px !important;
    padding-right: 40px !important;
}

.mobile-filter-panel input:hover,
.mobile-filter-panel select:hover {
    border-color: #fbbf24 !important;
    box-shadow: 0 2px 8px rgba(254, 220, 0, 0.1) !important;
}

.mobile-filter-panel input[type="checkbox"] {
    width: 20px !important;
    height: 20px !important;
    accent-color: #cc2014 !important;
    margin-right: 12px !important;
    cursor: pointer !important;
}

.mobile-filter-panel .flex.items-center {
    padding: 12px 0 !important;
}

.mobile-filter-panel .flex.items-center span {
    font-size: 15px !important;
    font-weight: 500 !important;
    color: rgb(255, 0, 0) !important;
}

.mobile-filter-panel button {
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    font-size: 14px !important;
    padding: 16px 20px !important;
}

.mobile-filter-panel .button-primary {
    color: var(--text-on-primary) !important;
}

.mobile-filter-panel .button-primary:hover {
    box-shadow: var(--button-shadow-hover) !important;
}

.mobile-filter-panel .button-secondary {
    color: var(--secondary-dark) !important;
}

.mobile-filter-panel .button-secondary:hover {
    box-shadow: 0 10px 20px rgba(15, 106, 88, 0.18) !important;
}

.mobile-filter-panel .flex.items-center.justify-between {
    background: linear-gradient(135deg, #cc2014 0%, #f59e0b 100%) !important;
    padding: 20px !important;
    border-bottom: 2px solid rgba(0, 0, 0, 0.1) !important;
    position: sticky !important;
    top: 0 !important;
    z-index: 10 !important;
    display: flex;
    gap: 170px;
}

.mobile-filter-panel h3 {
    color: var(--text-on-primary) !important;
    font-size: 18px !important;
    font-weight: 700 !important;
    margin: 0 !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) !important;
}

#close-mobile-filters {
    width: 44px !important;
    height: 44px !important;
    border-radius: 50% !important;
    background: rgba(255, 255, 255, 0.2) !important;
    border: 2px solid rgba(255, 255, 255, 0.3) !important;
    color: var(--text-on-primary) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    backdrop-filter: blur(10px) !important;
}

#close-mobile-filters:hover {
    background: rgba(255, 255, 255, 0.3) !important;
    border-color: rgba(255, 255, 255, 0.5) !important;
    transform: scale(1.1) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
}

#close-mobile-filters:active {
    transform: scale(0.95) !important;
}

#close-mobile-filters svg {
    width: 24px !important;
    height: 24px !important;
    stroke: currentColor !important;
    stroke-width: 2.5 !important;
    fill: none !important;
}

.mobile-filter-panel .p-4 {
    padding: 24px !important;
    background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%) !important;
}

.mobile-filter-panel .space-y-4 > div {
    animation: slideInUp 0.3s ease-out !important;
    animation-fill-mode: both !important;
}

.mobile-filter-panel .space-y-4 > div:nth-child(1) { animation-delay: 0.1s !important; }
.mobile-filter-panel .space-y-4 > div:nth-child(2) { animation-delay: 0.15s !important; }
.mobile-filter-panel .space-y-4 > div:nth-child(3) { animation-delay: 0.2s !important; }
.mobile-filter-panel .space-y-4 > div:nth-child(4) { animation-delay: 0.25s !important; }
.mobile-filter-panel .space-y-4 > div:nth-child(5) { animation-delay: 0.3s !important; }
.mobile-filter-panel .space-y-4 > div:nth-child(6) { animation-delay: 0.35s !important; }

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mobile-filter-panel::-webkit-scrollbar {
    width: 6px !important;
}

.mobile-filter-panel::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05) !important;
    border-radius: 3px !important;
}

.mobile-filter-panel::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #cc2014 0%, #f59e0b 100%) !important;
    border-radius: 3px !important;
}

.mobile-filter-panel::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #f59e0b 0%, #cc2014 100%) !important;
}

.mobile-filter-panel .space-y-4 > div {
    margin-bottom: 20px !important;
}

.mobile-filter-panel input,
.mobile-filter-panel select {
    background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%) !important;
    border: 2px solid #e5e7eb !important;
    border-radius: 12px !important;
    padding: 14px 16px !important;
    font-size: 15px !important;
    font-weight: 500 !important;
    color: var(--secondary-dark) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
}

.mobile-filter-panel input:focus,
.mobile-filter-panel select:focus {
    outline: none !important;
    border-color: #cc2014 !important;
    box-shadow: 0 0 0 4px rgba(254, 220, 0, 0.15), 0 4px 12px rgba(254, 220, 0, 0.1) !important;
    background: #ffffff !important;
    transform: translateY(-1px) !important;
}

.mobile-filter-panel input::placeholder {
    color: #f6d2cf !important;
    font-weight: 400 !important;
}

.mobile-filter-panel select {
    cursor: pointer !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%236b7280%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E") !important;
    background-position: right 12px center !important;
    background-repeat: no-repeat !important;
    background-size: 16px !important;
    padding-right: 40px !important;
}

.mobile-filter-panel input:hover,
.mobile-filter-panel select:hover {
    border-color: #fbbf24 !important;
    box-shadow: 0 2px 8px rgba(254, 220, 0, 0.1) !important;
}

/* Checkbox styling */
.mobile-filter-panel input[type="checkbox"] {
    width: 20px !important;
    height: 20px !important;
    accent-color: #cc2014 !important;
    margin-right: 12px !important;
    cursor: pointer !important;
}

.mobile-filter-panel .flex.items-center {
    padding: 12px 0 !important;
}

.mobile-filter-panel .flex.items-center span {
    font-size: 15px !important;
    font-weight: 500 !important;
    color: rgb(255, 0, 0) !important;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .gap-4 {
        gap: 0.75rem;
    }
    
    .text-4xl {
        font-size: 2rem;
    }
    
    .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .h-96 {
        height: 300px !important;
    }
    
    .max-h-96 {
        max-height: 300px !important;
    }
    
    /* Hide desktop filter header on mobile */
    .filter-header1 {
        display: none !important;
    }
    
    /* Adjust layout for mobile */
    .two-column-layout {
        margin-top: 0 !important;
        max-height: 65vh;
    }
    
    /* Mobile map height - 40vh */
    #restaurants-map {
        height: 50vh !important;
        min-height: 50vh !important;
        max-height: 65vh;
    }
    
    /* Mobile virtual tour height - 40vh */
    .virtual-tour-section {
        height: 50vh !important;
        min-height: 50vh !important;
    }
    
    /* Disable scroll in right column on mobile - AGGRESSIVE APPROACH */
    .right-column1 {
        display: flex !important;
        flex-direction: column !important;
        background-color: #ffffff !important;
        overflow: hidden !important;
        overflow-x: hidden !important;
        overflow-y: hidden !important;
        position: relative !important;
        max-height: none !important;
        height: auto !important;
        min-height: auto !important;
    }
    
    /* Force all child elements to not scroll */
    .right-column1 * {
        overflow: visible !important;
        max-height: none !important;
    }
    
    /* Specifically target restaurants container */
    .right-column1 #restaurants-container {
        overflow: visible !important;
        overflow-y: visible !important;
        overflow-x: visible !important;
        max-height: none !important;
        height: auto !important;
        min-height: auto !important;
    }
    
    /* Disable scroll in restaurants list on mobile */
    #restaurants-list {
        overflow: hidden !important;
    }
    
    /* Disable scroll in restaurants container on mobile */
    #restaurants-container {
        overflow: visible !important;
        overflow-y: visible !important;
        max-height: none !important;
    }
}



/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .restaurant-card,
    .current-restaurant-marker div {
        animation: none !important;
        transition: none !important;
    }
    
    .restaurant-card:hover {
        transform: none !important;
    }
}

/* Map Popup Styles */
.leaflet-popup-content-wrapper {
    border-radius: 12px !important;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15) !important;
    border: 2px solid #f3f4f6 !important;
    transition: all 0.3s ease !important;
}

.restaurant-popup-content {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
    min-width: 200px !important;
    max-width: 280px !important;
    transition: all 0.3s ease !important;
}

/* Mobile popup styles */
@media (max-width: 768px) {
    .leaflet-popup-content-wrapper {
        border-radius: 8px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
        border: 1px solid #e5e7eb !important;
    }
    
    .restaurant-popup-content {
        min-width: 180px !important;
        max-width: 220px !important;
        font-size: 12px !important;
    }
    
    .popup-image {
        width: 60px !important;
        height: 60px !important;
    }
    
    .popup-placeholder {
        width: 60px !important;
        height: 60px !important;
    }
}

/* Popup hover effects */
.restaurant-popup-content:hover {
    transform: scale(1.02) !important;
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2) !important;
}

.leaflet-popup-content-wrapper:hover {
    border-color: #cc2014 !important;
    box-shadow: 0 12px 32px rgba(251, 191, 36, 0.3) !important;
}

.restaurant-popup-content .flex {
    display: flex !important;
    gap: 12px !important;
}

.restaurant-popup-content .flex-1 {
    flex: 1 !important;
    min-width: 0 !important;
}

.restaurant-popup-content .flex-shrink-0 {
    flex-shrink: 0 !important;
}

.restaurant-popup-content img {
    border-radius: 8px !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
}

.restaurant-popup-content h3 {
    font-size: 16px !important;
    font-weight: 600 !important;
    margin: 0 !important;
    line-height: 1.3 !important;
}

.restaurant-popup-content p {
    margin: 0 0 4px 0 !important;
    font-size: 13px !important;
    line-height: 1.4 !important;
}

.restaurant-popup-content .space-x-1 > * + * {
    margin-left: 4px !important;
}

.restaurant-popup-content .space-x-1 {
    display: flex !important;
}

/* Current restaurant popup highlight */
.current-popup .leaflet-popup-content-wrapper {
    border-color: #cc2014 !important;
    box-shadow: 0 8px 24px rgba(251, 191, 36, 0.3) !important;
}

/* Marker animations */
.current-restaurant-marker div {
    animation: current-pulse 2s infinite;
}

@keyframes current-pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Restaurant Cards Layout - Redesigned to match all restaurants page */
#restaurants-list {
    display: grid !important;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)) !important;
    gap: 16px !important;
    padding: 16px !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    max-height: 60vh !important;
}

/* Single restaurant page card overrides */
.restaurant-card {
    background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%) !important;
    border-radius: 16px !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
    border: 2px solid #ffffff !important;
    transition: all 0.4s ease !important;
    overflow: hidden !important;
    height: auto !important;
    width: 100% !important;
    min-width: auto !important;
    max-width: none !important;
}

.restaurant-card:hover {
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-4px) scale(1.02) !important;
    border-color: #fbbf24 !important;
}

.restaurant-card.current-restaurant {
    border-color: #fbbf24 !important;
    box-shadow: 0 8px 25px rgba(251, 191, 36, 0.3) !important;
}

/* Card layout for single restaurant page */
.restaurant-card .card-layout {
    flex-direction: column !important;
    height: 100% !important;
}

.restaurant-card .card-image {
    width: 100% !important;
    height: 140px !important;
    position: relative !important;
    border-radius: 12px 12px 0 0 !important;
    overflow: hidden !important;
    background: #f3f4f6 !important;
}

.restaurant-card .restaurant-image {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 0.3s ease !important;
}

.restaurant-card .card-content {
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 8px !important;
    padding: 16px !important;
    justify-content: space-between !important;
}

.restaurant-card .card-actions {
    display: flex !important;
    gap: 8px !important;
    align-items: center !important;
    margin-top: auto !important;
}

/* Mobile responsive overrides for single restaurant cards */
@media (max-width: 768px) {
    #restaurants-list {
        grid-template-columns: 1fr !important;
        gap: 12px !important;
        padding: 12px !important;
        max-height: 50vh !important;
    }
    
    .restaurant-card {
        min-height: 220px !important;
    }
    
    .restaurant-card .card-image {
        height: 120px !important;
        border-radius: 12px 12px 0 0 !important;
    }
}

/* Current restaurant highlighting */
.restaurant-card.current-restaurant .restaurant-name a {
    color: #fbbf24 !important;
    font-weight: 700 !important;
}

.restaurant-card .text-xs {
    font-size: 12px !important;
}

.restaurant-card .px-1 {
    padding-left: 4px !important;
    padding-right: 4px !important;
}

.restaurant-card .py-0\.5 {
    padding-top: 2px !important;
    padding-bottom: 2px !important;
}

.restaurant-card .px-2 {
    padding-left: 8px !important;
    padding-right: 8px !important;
}

.restaurant-card .py-1 {
    padding-top: 4px !important;
    padding-bottom: 4px !important;
}

.restaurant-card .rounded-full {
    border-radius: 9999px !important;
}

.restaurant-card .bg-yellow-100 {
    background-color: #cc2014 !important;
}

.restaurant-card .text-yellow-800 {
    color: #cc2014 !important;
}

.restaurant-card .bg-red-100 {
    background-color: #fee2e2 !important;
}

.restaurant-card .text-red-800 {
    color: #991b1b !important;
}

.restaurant-card .bg-gray-200 {
    background-color: rgb(255, 255, 255) !important;
}

.restaurant-card .text-gray-600 {
    color: #4b5563 !important;
}

.restaurant-card .bg-yellow-400 {
    background-color: #cc2014 !important;
}

.restaurant-card .text-gray-800 {
    color: var(--text-primary) !important;
}

.restaurant-card .text-green-600 {
    color: #059669 !important;
}

/* Two Column Layout Styles */
.w-7\/10 {
    width: 70% !important;
}

.w-3\/10 {
    width: 30% !important;
}

/* Google Reviews Section */
#google-reviews-container {
    max-height: 60vh !important;
    overflow-y: auto !important;
    padding: 4px !important;
}

.review-item {
    background: linear-gradient(135deg, var(--bg-white) 0%, var(--bg-gray-50) 100%) !important;
    border: 2px solid var(--bg-white) !important;
    border-radius: var(--radius-lg) !important;
    padding: 16px !important;
    margin-bottom: 16px !important;
    transition: all 0.4s ease !important;
    box-shadow: var(--shadow-md) !important;
    position: relative !important;
    overflow: hidden !important;
    cursor: pointer !important;
}

.review-item:hover {
    box-shadow: var(--shadow-lg) !important;
    transform: translateY(-4px) scale(1.02) !important;
    border-color: var(--primary-color) !important;
}

.review-item::before {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    height: 3px !important;
    background: linear-gradient(90deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
    opacity: 0 !important;
    transition: opacity 0.3s ease !important;
}

.review-item:hover::before {
    opacity: 1 !important;
}

.review-header {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    margin-bottom: 12px !important;
}

.review-author-section {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
}

.review-author-avatar {
    width: 32px !important;
    height: 32px !important;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: var(--text-primary) !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    box-shadow: 0 2px 8px rgba(254, 220, 0, 0.3) !important;
}

.review-author-info {
    flex: 1 !important;
}

.review-author {
    font-weight: 600 !important;
    color: var(--text-primary) !important;
    font-size: 14px !important;
    margin-bottom: 2px !important;
    line-height: 1.2 !important;
}

.review-restaurant {
    color: var(--primary-color) !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}

.review-rating {
    display: flex !important;
    align-items: center !important;
    gap: 2px !important;
    margin-bottom: 12px !important;
}

.review-rating svg {
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1)) !important;
}

.review-content {
    margin-bottom: 12px !important;
}

.review-text {
    color: var(--text-secondary) !important;
    font-size: 13px !important;
    line-height: 1.6 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 4 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    text-align: justify !important;
}

.review-footer {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding-top: 8px !important;
    border-top: 1px solid var(--border-light) !important;
}

.review-date {
    color: var(--text-muted) !important;
    font-size: 11px !important;
    font-weight: 500 !important;
}

.review-badge {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
    color: var(--text-primary) !important;
    font-size: 9px !important;
    font-weight: 700 !important;
    padding: 2px 6px !important;
    border-radius: 12px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    box-shadow: 0 1px 3px rgba(254, 220, 0, 0.3) !important;
}

/* Reviews container header */
.reviews-header {
    background: linear-gradient(135deg, var(--bg-white) 0%, var(--bg-gray-50) 100%) !important;
    border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important;
    padding: 20px !important;
    border-bottom: 2px solid var(--border-light) !important;
    position: sticky !important;
    top: 0 !important;
    z-index: 10 !important;
    backdrop-filter: blur(10px) !important;
}

.reviews-title {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    margin-bottom: 4px !important;
}

.reviews-title svg {
    filter: drop-shadow(0 2px 4px rgba(254, 220, 0, 0.3)) !important;
}

.reviews-subtitle {
    color: var(--text-muted) !important;
    font-size: 12px !important;
    font-weight: 500 !important;
}

/* Custom scrollbar for reviews */
#google-reviews-container::-webkit-scrollbar {
    width: 6px;
}

#google-reviews-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#google-reviews-container::-webkit-scrollbar-thumb {
    background: #cc2014;
    border-radius: 3px;
}

#google-reviews-container::-webkit-scrollbar-thumb:hover {
    background: #e6c200;
}

/* Two Column Layout Container */
.mobile-cards-section {
    height: calc(100vh - 200px) !important;
    overflow: hidden !important;
}

.mobile-cards-section > .flex {
    height: 100% !important;
}

/* Left Column (Restaurant Cards) */
.w-7\/10 {
    height: 100% !important;
    display: flex !important;
    flex-direction: column !important;
}

/* Right Column (Reviews) */
.w-3\/10 {
    height: 100% !important;
    max-height: 100% !important;
}

/* Ensure restaurants container takes remaining space */
#restaurants-container {
    flex: 1 !important;
    overflow-y: auto !important;
    min-height: 0 !important;
}

/* Mobile Responsive Fixes */
@media (max-width: 768px) {
    /* Stack columns vertically on mobile */
    .mobile-cards-section .flex {
        flex-direction: column !important;
    }
    
    .w-7\/10, .w-3\/10 {
        width: 100% !important;
        height: auto !important;
    }
    
    /* Hide reviews section on mobile to save space */
    .w-3\/10 {
        display: none !important;
    }
    
    .mobile-cards-section {
        height: auto !important;
    }
    
    #restaurants-list {
        padding: 8px !important;
        gap: 10px !important;
        flex-direction: column !important;
        overflow-x: hidden !important;
        overflow-y: auto !important;
    }
    
    .restaurant-card {
        height: 350px !important;
        min-height: 350px !important;
        min-width: 95% !important;
        width: 95% !important;
        padding: 12px !important;
        flex-direction: column !important;
        align-items: stretch !important;
    }
    
    .restaurant-card img {
        width: 100% !important;
        height: 180px !important;
        margin-bottom: 12px !important;
    }
    
    .restaurant-card .flex-1 {
        padding-left: 0 !important;
        padding-top: 16px !important;
    }
    
    .restaurant-card h4 {
        font-size: 18px !important;
        margin-bottom: 8px !important;
    }
    
    .restaurant-card p {
        font-size: 13px !important;
        margin-bottom: 6px !important;
    }
    
    .restaurant-card .description {
        font-size: 12px !important;
        margin-top: 8px !important;
        -webkit-line-clamp: 2 !important;
    }
    
    .restaurant-card .space-y-2 > * + * {
        margin-top: 6px !important;
    }
    
    .restaurant-card .bg-gray-50 {
        padding: 0px 10px !important;
    }
    
    .restaurant-card .fas {
        font-size: 12px !important;
    }
}

@media (max-width: 480px) {
    .restaurant-card {
        height: 350px !important;
        min-height: 350px !important;
        min-width: 95% !important;
        padding: 10px !important;
        width: 95% !important;
        flex-direction: column !important;
    }
    
    .restaurant-card img {
        width: 100% !important;
        height: 150px !important;
        margin-bottom: 10px !important;
    }
    
    .restaurant-card .flex-1 {
        padding-left: 0 !important;
        padding-top: 12px !important;
    }
    
    .restaurant-card h4 {
        font-size: 16px !important;
        margin-bottom: 6px !important;
    }
    
    .restaurant-card p {
        font-size: 11px !important;
        margin-bottom: 4px !important;
    }
    
    .restaurant-card .description {
        font-size: 11px !important;
        margin-top: 6px !important;
        -webkit-line-clamp: 2 !important;
    }
    
    .restaurant-card .bg-gray-50 {
        padding: 0px 8px !important;
    }
}

</style>

<script>
// Debug and ensure fullscreen functions are available
console.log('Single restaurant template loaded');

// Load current restaurant data
const currentRestaurantDataElement = document.getElementById('current-restaurant-data');
if (currentRestaurantDataElement) {
    try {
        window.currentRestaurantData = JSON.parse(currentRestaurantDataElement.textContent);
        console.log('Current restaurant data loaded:', window.currentRestaurantData);
    } catch (e) {
        console.error('Error parsing current restaurant data:', e);
    }
}

// Load all restaurants data for fullscreen map
const allRestaurantsDataElement = document.getElementById('all-restaurants-data');
if (allRestaurantsDataElement) {
    try {
        window.allRestaurants = JSON.parse(allRestaurantsDataElement.textContent);
        console.log('All restaurants data loaded:', window.allRestaurants.length, 'restaurants');
    } catch (e) {
        console.error('Error parsing all restaurants data:', e);
    }
} else {
    console.warn('All restaurants data element not found');
}

// Ensure functions are available globally
window.openMapFullscreen = function() {
    console.log('openMapFullscreen called');
    const modal = document.getElementById('fullscreen-map-modal');
    if (modal) {
        console.log('Map modal found, showing...');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Initialize fullscreen map after modal is shown
        setTimeout(() => {
            console.log('About to initialize fullscreen map...');
            console.log('window.allRestaurants available:', !!window.allRestaurants);
            console.log('window.allRestaurants length:', window.allRestaurants ? window.allRestaurants.length : 'undefined');
            
            if (typeof initializeFullscreenMap === 'function') {
                initializeFullscreenMap();
            } else {
                console.log('initializeFullscreenMap function not found, using existing map logic');
                // Use the existing map initialization logic
                initializeFullscreenMapWithExistingLogic();
            }
        }, 500);
    } else {
        console.error('Map modal not found');
    }
};

window.openVirtualTourFullscreen = function() {
    console.log('openVirtualTourFullscreen called');
    const modal = document.getElementById('fullscreen-virtual-tour-modal');
    if (modal) {
        console.log('Virtual tour modal found, showing...');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    } else {
        console.error('Virtual tour modal not found');
    }
};

window.closeMapFullscreen = function() {
    console.log('closeMapFullscreen called');
    const modal = document.getElementById('fullscreen-map-modal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
};

window.closeVirtualTourFullscreen = function() {
    console.log('closeVirtualTourFullscreen called');
    const modal = document.getElementById('fullscreen-virtual-tour-modal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
};

// Initialize fullscreen map using the same implementation as all-restaurants popup
window.initializeFullscreenMapWithExistingLogic = function() {
    console.log('initializeFullscreenMapWithExistingLogic called');
    
    const mapContainer = document.getElementById('fullscreen-map');
    if (!mapContainer || !window.L) {
        console.error('Map container not found or Leaflet not loaded');
        return;
    }

    console.log('Map container found, Leaflet loaded');

    // Clear existing map
    if (window.fullscreenMapInstance) {
        window.fullscreenMapInstance.remove();
    }

    // Default center (Casablanca)
    let centerLat = 33.5731;
    let centerLng = -7.5898;
    let zoom = 12;

    // Use current restaurant location if available
    if (window.currentRestaurantData && window.currentRestaurantData.restaurant_meta) {
        const lat = parseFloat(window.currentRestaurantData.restaurant_meta.latitude);
        const lng = parseFloat(window.currentRestaurantData.restaurant_meta.longitude);
        if (lat && lng) {
            centerLat = lat;
            centerLng = lng;
            zoom = 14;
            console.log('Using current restaurant location:', centerLat, centerLng);
        }
    }

    console.log('Initializing map with center:', centerLat, centerLng, 'zoom:', zoom);

    // Initialize map
    window.fullscreenMapInstance = L.map('fullscreen-map').setView([centerLat, centerLng], zoom);

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(window.fullscreenMapInstance);

    console.log('Map initialized, adding markers...');

    // Add markers for all restaurants using the same logic as all-restaurants popup
    addRestaurantMarkersToFullscreenMap();
};

// Add restaurant markers to fullscreen map (same as all-restaurants popup)
function addRestaurantMarkersToFullscreenMap() {
    if (!window.fullscreenMapInstance) {
        console.error('Fullscreen map instance not found');
        return;
    }

    // Get restaurants data from the existing data
    let restaurants = window.allRestaurants || [];
    
    // Fallback: try to get data from the existing map markers
    if (restaurants.length === 0 && window.map && window.markersLayer) {
        console.log('Trying to get restaurants from existing map markers...');
        const existingMarkers = window.markersLayer.getLayers();
        console.log('Existing markers found:', existingMarkers.length);
        // For now, we'll use the current restaurant data as a fallback
        if (window.currentRestaurantData) {
            restaurants = [window.currentRestaurantData];
            console.log('Using current restaurant data as fallback');
        }
    }
    
    console.log('Restaurants data for fullscreen map:', restaurants);

    if (restaurants.length === 0) {
        console.warn('No restaurants data available for fullscreen map');
        return;
    }

    window.fullscreenMarkers = [];

    // Add markers for all restaurants
    restaurants.forEach(restaurant => {
        const meta = restaurant.restaurant_meta || {};
        const lat = parseFloat(meta.latitude);
        const lng = parseFloat(meta.longitude);
        
        if (!isNaN(lat) && !isNaN(lng)) {
            console.log(`Creating marker for restaurant: ${restaurant.title?.rendered} at [${lat}, ${lng}]`);
            
            const rating = parseFloat(meta.google_rating || meta.local_rating || 0);
            const reviewCount = parseInt(meta.google_review_count || meta.local_review_count || 0);
            const isCurrent = restaurant.id === window.currentRestaurantData?.id;

            console.log(`Restaurant: ${restaurant.title?.rendered || 'Unknown'}, Rating: ${rating}, ReviewCount: ${reviewCount}`);

            // Generate stars function (same as all-restaurants)
            const generateStars = (rating) => {
                const numRating = parseFloat(rating) || 0;
                return Array.from({ length: 5 }, (_, i) => {
                    const starColor = i < Math.floor(numRating) ? '#fbbf24' : '#d1d5db';
                    return `<span style="color: ${starColor}; font-size: 0.7rem;">★</span>`;
                }).join('');
            };
            
            // Extract clean title from HTML
            const getCleanTitle = (title) => {
                if (typeof title === 'string') {
                    // Remove HTML tags and get clean text
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = title;
                    const cleanText = tempDiv.textContent || tempDiv.innerText || 'Restaurant';
                    console.log('Original title:', title, 'Clean title:', cleanText);
                    return cleanText;
                }
                return title?.rendered || 'Restaurant';
            };

            const cleanTitle = getCleanTitle(restaurant.title);

            // Create custom icon with name and rating below (same as all-restaurants popup)
            const iconHtml = `
                <div class="marker-with-label">
                    <div class="marker-icon ${isCurrent ? 'current' : 'regular'}">
                        <div class="marker-content">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 713.343 713.343" style="enable-background:new 0 0 512 512" xml:space="preserve" class="marker-svg">
                                <g>
                                    <path fill="#ff5252" d="M656.467 289.796c1.226 76.016-30.317 152.811-89.168 211.774L356.672 702.197 156.044 501.569C97.193 442.607 65.65 365.811 66.876 289.796c1.226-70.108 30.651-139.548 84.932-193.717 56.499-56.622 130.742-84.932 204.863-84.932s148.353 28.311 204.863 84.932c54.282 54.169 83.707 123.608 84.933 193.717zm-66.876 11.146c0-123.163-99.757-222.92-222.92-222.92s-222.92 99.757-222.92 222.92 99.757 222.92 222.92 222.92 222.92-99.757 222.92-222.92z" opacity="1" data-original="#ff5252" class=""></path>
                                    <path fill="#323232" d="M490.312 234.066c1.783 88.834-33.438 89.168-33.438 89.168V178.336s32.658 15.381 33.438 55.73zM378.965 312.088c0-21.289-33.438-47.259-33.438-78.022s14.936-55.73 33.438-55.73 33.438 24.967 33.438 55.73-33.438 56.065-33.438 78.022z" opacity="1" data-original="#323232" class=""></path>
                                    <path fill="#ffd438" d="M378.965 312.088c0-21.958 33.438-47.259 33.438-78.022s-14.936-55.73-33.438-55.73-33.438 24.967-33.438 55.73 33.438 56.733 33.438 78.022zm77.91 11.146s35.221-.334 33.438-89.168c-.78-40.348-33.438-55.73-33.438-55.73zM356.672 78.022c123.163 0 222.92 99.757 222.92 222.92s-99.757 222.92-222.92 222.92-222.92-99.757-222.92-222.92 99.757-222.92 222.92-222.92z" opacity="1" data-original="#ffd438" class=""></path>
                                    <path fill="#323232" d="M356.672 713.343a11.145 11.145 0 0 1-7.881-3.265L148.163 509.451c-60.028-60.142-93.715-140.266-92.431-219.835 1.301-74.434 32.626-145.965 88.204-201.427C200.675 31.326 276.232 0 356.672 0 437.1 0 512.657 31.325 569.423 88.205c55.563 55.448 86.886 126.977 88.188 201.397 1.283 79.585-32.404 159.709-92.424 219.842l-.007.008-200.627 200.627a11.145 11.145 0 0 1-7.881 3.265zm0-691.051c-74.476 0-144.429 29-196.973 81.659-51.478 51.372-80.479 117.436-81.678 186.039-1.187 73.561 30.127 147.814 85.912 203.705l192.739 192.739L549.41 493.696c55.784-55.891 87.098-130.144 85.912-203.72-1.199-68.588-30.201-134.653-81.662-186.008-52.57-52.675-122.522-81.676-196.988-81.676zm200.627 479.277h.014z" opacity="1" data-original="#323232" class=""></path>
                                    <path fill="#323232" d="M356.672 535.007c-129.065 0-234.066-105.001-234.066-234.066S227.608 66.876 356.672 66.876s234.065 105.001 234.065 234.066-105.001 234.065-234.065 234.065zm0-445.839c-116.772 0-211.774 95.001-211.774 211.774s95.001 211.774 211.774 211.774 211.773-95.001 211.773-211.774S473.444 89.168 356.672 89.168z" opacity="1" data-original="#323232" class=""></path>
                                    <path fill="#323232" d="M267.504 423.548c-6.156 0-11.146-4.991-11.146-11.146V278.65c0-6.156 4.99-11.146 11.146-11.146s11.146 4.99 11.146 11.146v133.752c0 6.155-4.99 11.146-11.146 11.146z" opacity="1" data-original="#323232" class=""></path>
                                    <path fill="#323232" d="M267.504 289.796c-11.89 0-23.08-4.653-31.511-13.073-8.43-8.429-13.073-19.62-13.073-31.511v-55.73c0-6.156 4.99-11.146 11.146-11.146s11.146 4.99 11.146 11.146v55.73c0 5.936 2.324 11.528 6.543 15.748 4.221 4.221 9.814 6.544 15.749 6.544 12.292 0 22.292-10 22.292-22.292v-55.73c0-6.156 4.99-11.146 11.146-11.146s11.146 4.99 11.146 11.146v55.73c0 24.584-20 44.584-44.584 44.584z" opacity="1" data-original="#323232" class=""></path>
                                    <path fill="#323232" d="M267.504 289.796c-6.156 0-11.146-4.99-11.146-11.146v-89.168c0-6.156 4.99-11.146 11.146-11.146s11.146 4.99 11.146 11.146v89.168c0 6.156-4.99 11.146-11.146 11.146zM378.963 423.548c-6.155 0-11.146-4.991-11.146-11.146V289.796c0-6.156 4.991-11.146 11.146-11.146s11.146 4.99 11.146 11.146v122.606c0 6.155-4.99 11.146-11.146 11.146z" opacity="1" data-original="#323232" class=""></path>
                                    <path fill="#323232" d="M378.963 323.234c-6.155 0-11.146-4.99-11.146-11.146 0-6.37-6.421-16.27-12.629-25.845-9.753-15.04-20.808-32.086-20.808-52.177 0-37.501 19.583-66.876 44.583-66.876 25.001 0 44.584 29.375 44.584 66.876 0 19.988-10.961 36.801-20.632 51.636-6.585 10.102-12.806 19.653-12.806 26.386 0 6.156-4.99 11.146-11.146 11.146zm0-133.752c-10.523 0-22.291 19.067-22.291 44.584 0 13.496 8.753 26.994 17.219 40.048 1.701 2.622 3.381 5.213 4.98 7.788 1.716-2.769 3.532-5.556 5.37-8.374 8.365-12.831 17.014-26.099 17.014-39.462 0-25.518-11.769-44.584-22.292-44.584zM456.874 334.38a11.146 11.146 0 0 1-11.146-11.146V178.336a11.144 11.144 0 0 1 15.896-10.083c1.588.748 38.929 18.867 39.833 65.598.867 43.225-6.591 73.282-22.167 89.326-10.251 10.559-20.383 11.185-22.31 11.203h-.106zm11.146-132.397v99.251c6.193-10.788 11.87-31.038 11.149-66.944-.28-14.439-5.417-24.988-11.149-32.307z" opacity="1" data-original="#323232" class=""></path>
                                    <path fill="#323232" d="M456.874 423.548c-6.155 0-11.146-4.991-11.146-11.146v-89.168c0-6.156 4.991-11.146 11.146-11.146s11.146 4.99 11.146 11.146v89.168c0 6.155-4.991 11.146-11.146 11.146z" opacity="1" data-original="#323232" class=""></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="marker-label">
                        <div class="marker-name">${cleanTitle}</div>
                        ${rating > 0 ? `
                            <div class="marker-rating">
                                <div class="marker-stars">${generateStars(rating)}</div>
                                <span class="marker-rating-text">${rating.toFixed(1)}</span>
                                ${reviewCount > 0 ? `<span class="marker-review-count">(${reviewCount})</span>` : ''}
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
            
            const customIcon = L.divIcon({
                html: iconHtml,
                className: 'custom-marker-with-label',
                iconSize: [120, 80],
                iconAnchor: [60, 40]
            });

            const popupContent = createRestaurantPopupContent(restaurant);
            console.log('Popup content created:', popupContent);

            const marker = L.marker([lat, lng], { icon: customIcon })
                .addTo(window.fullscreenMapInstance)
                .bindPopup(popupContent);

            console.log(`Marker created and added for: ${cleanTitle}`);
            window.fullscreenMarkers.push(marker);

            // Open popup for current restaurant
            if (isCurrent) {
                marker.openPopup();
                console.log(`Opened popup for current restaurant: ${cleanTitle}`);
            }
        }
    });

    // Fit map to show all markers
    console.log(`Total markers created: ${window.fullscreenMarkers.length}`);
    if (window.fullscreenMarkers.length > 0) {
        const group = new L.featureGroup(window.fullscreenMarkers);
        window.fullscreenMapInstance.fitBounds(group.getBounds().pad(0.1));
        console.log('Map bounds fitted to show all markers');
    } else {
        console.warn('No markers were created for the fullscreen map');
    }
}

// Escape HTML function
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Create restaurant popup content using the same format as the main map
function createRestaurantPopupContent(restaurant) {
    console.log('Creating popup for restaurant:', restaurant);
    
    // Get restaurant data from the restaurant object
    const restaurantMeta = restaurant.restaurant_meta || {};
    const rating = parseFloat(restaurantMeta.google_rating || restaurantMeta.local_rating || 0);
    const reviewCount = parseInt(restaurantMeta.google_review_count || restaurantMeta.local_review_count || 0);
    const cuisine = restaurantMeta.cuisine_type || restaurantMeta.cuisine || '';
    const priceRange = restaurantMeta.price_range || '';
    const address = restaurantMeta.address || '';
    const phone = restaurantMeta.phone || '';
    const slug = restaurantMeta.slug || '';
    
    // Clean the title
    const getCleanTitle = (title) => {
        if (typeof title === 'string') {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = title;
            return tempDiv.textContent || tempDiv.innerText || 'Restaurant';
        }
        return title?.rendered || 'Restaurant';
    };
    
    const title = getCleanTitle(restaurant.title);
    
    console.log('Popup data:', { title, rating, reviewCount, cuisine, priceRange, address, phone });
    console.log('Original restaurant title:', restaurant.title);
    console.log('Cleaned title:', title);

    // Generate rating stars
    const ratingStars = Array.from({ length: 5 }, (_, i) => {
        const starColor = i < Math.floor(rating) ? '#fbbf24' : '#d1d5db';
        return `<span style="color: ${starColor};">★</span>`;
    }).join('');

    return `
        <div class="restaurant-popup-content" style="min-width: 280px; max-width: 320px;">
            <div style="margin-bottom: 1rem;">
                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; font-weight: 700; color: ; line-height: 1.3;">
                    ${title}
                </h3>
                
                ${rating > 0 ? `
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <div style="display: flex; gap: 1px;">
                            ${ratingStars}
                        </div>
                        <span style="font-weight: 600; color: ; font-size: 0.9rem;">${rating.toFixed(1)}</span>
                        <span style="color: #6b7280; font-size: 0.8rem;">(${reviewCount} avis)</span>
                    </div>
                ` : ''}
            </div>
            
            <div style="margin-bottom: 1rem;">
                ${cuisine ? `
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                        <svg viewBox="0 0 24 24" width="14" height="14" style="color: #6b7280;">
                            <path fill="currentColor" d="M14.051 6.549v.003l1.134 1.14 3.241-3.25.003-.002 1.134 1.136-3.243 3.252 1.134 1.14a1 1 0 0 0 .09-.008c.293-.05.573-.324.72-.474l.005-.006 2.596-2.603L22 8.016l-2.597 2.604a3.73 3.73 0 0 1-1.982 1.015 4.3 4.3 0 0 1-3.162-.657l-.023-.016-.026-.018-1.366 1.407 8.509 8.512L20.219 22l-.002-.002-6.654-6.663-2.597 2.76-7.3-7.315C1.967 8.948 1.531 6.274 2.524 4.198c.241-.504.566-.973.978-1.386l8.154 8.416 1.418-1.423-.039-.045c-.858-1.002-1.048-2.368-.62-3.595a4.15 4.15 0 0 1 .983-1.561L16 2l1.135 1.138-2.598 2.602-.047.045c-.16.151-.394.374-.433.678zM3.809 5.523c-.362 1.319-.037 2.905 1.06 4.103L10.93 15.7l1.408-1.496zM2.205 20.697 3.34 21.84l4.543-4.552-1.135-1.143z"></path>
                        </svg>
                        <span style="font-size: 0.85rem; color: rgb(255, 0, 0);">${cuisine}</span>
                    </div>
                ` : ''}
                
                ${priceRange ? `
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                        <svg viewBox="0 0 24 24" width="14" height="14" style="color: #6b7280;">
                            <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.65-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.65 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"></path>
                        </svg>
                        <span style="font-size: 0.85rem; color: rgb(255, 0, 0);">${priceRange}</span>
                    </div>
                ` : ''}
                
                ${address ? `
                    <a href="${restaurantMeta.google_maps_link || `https://www.google.com/maps?q=${restaurantMeta.latitude || ''},${restaurantMeta.longitude || ''}`}" target="_blank" rel="noopener" style="display: flex; align-items: flex-start; gap: 0.5rem; margin-bottom: 0.25rem; text-decoration: none;">
                        <svg viewBox="0 0 24 24" width="14" height="14" style="color: #6b7280; margin-top: 0.1rem;">
                            <path fill="currentColor" d="M4.25 9.799c0-4.247 3.488-7.707 7.75-7.707s7.75 3.46 7.75 7.707c0 2.28-1.138 4.477-2.471 6.323-1.31 1.813-2.883 3.388-3.977 4.483l-.083.083-.002.002-1.225 1.218-1.213-1.243-.03-.03-.012-.013c-1.1-1.092-2.705-2.687-4.035-4.53-1.324-1.838-2.452-4.024-2.452-6.293"></path>
                        </svg>
                        <span style="font-size: 0.85rem; color: #2563eb; line-height: 1.3;">${address}</span>
                    </a>
                ` : ''}
                
                ${phone ? `
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                        <svg viewBox="0 0 24 24" width="14" height="14" style="color: #6b7280;">
                            <path fill="currentColor" d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"></path>
                        </svg>
                        <a href="tel:${phone}" style="font-size: 0.85rem; color: #3b82f6; text-decoration: none;">${phone}</a>
                    </div>
                ` : ''}
            </div>
            
            ${slug ? `
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                    <a href="${window.location.origin}/restaurant/${slug}/" class="popup-link" style="display: inline-block; width: 100%; text-align: center; background-color: #cc2014; color: ; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 600; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f59e0b'" onmouseout="this.style.backgroundColor='#cc2014'">
                        Plus d'informations
                    </a>
                </div>
            ` : ''}
        </div>
    `;
}

// Test if icons are clickable
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking fullscreen icons...');
    
    const mapIcon = document.querySelector('.map-fullscreen-icon');
    const vtIcon = document.querySelector('.virtual-tour-fullscreen-icon');
    
    console.log('Map icon found:', !!mapIcon);
    console.log('Virtual tour icon found:', !!vtIcon);
    
    if (mapIcon) {
        console.log('Map icon styles:', window.getComputedStyle(mapIcon));
    }
    if (vtIcon) {
        console.log('Virtual tour icon styles:', window.getComputedStyle(vtIcon));
    }
});
</script>

<!-- Fullscreen Map Modal -->
<div id="fullscreen-map-modal" class="fullscreen-modal" style="display: none;">
    <div class="fullscreen-modal-content">
        <div class="fullscreen-modal-header">
            <h3><?php _e('Carte des restaurants', 'le-bon-resto'); ?></h3>
            <div class="fullscreen-close-icon" onclick="closeMapFullscreen()" title="<?php _e('Fermer', 'le-bon-resto'); ?>">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="fullscreen-modal-body">
            <div id="fullscreen-map" style="width: 100%; height: 100%;"></div>
        </div>
    </div>
</div>

<!-- Fullscreen Virtual Tour Modal -->
<div id="fullscreen-virtual-tour-modal" class="fullscreen-modal" style="display: none;">
    <div class="fullscreen-modal-content">
        <div class="fullscreen-modal-header">
            <h3><?php _e('Visite virtuelle', 'le-bon-resto'); ?></h3>
            <div class="fullscreen-close-icon" onclick="closeVirtualTourFullscreen()" title="<?php _e('Fermer', 'le-bon-resto'); ?>">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="fullscreen-modal-body">
            <?php if ($virtual_tour_url): ?>
                <iframe 
                    src="<?php echo esc_url($virtual_tour_url); ?>"
                    class="w-full h-full border-none"
                    allowfullscreen
                    loading="lazy"
                ></iframe>
            <?php else: ?>
                <div class="h-full flex items-center justify-center bg-gray-100">
                    <div class="text-center p-8">
                        <i class="fas fa-vr-cardboard text-5xl text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2"><?php _e('Visite virtuelle non disponible', 'le-bon-resto'); ?></h3>
                        <p class="text-gray-500"><?php _e('Aucune visite virtuelle configurée pour ce restaurant.', 'le-bon-resto'); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>