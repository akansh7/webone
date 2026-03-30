<?php
/**
 * Title: Hero Agency Section
 * Slug: webone-agency/hero-agency
 * Categories: webone-agency
 * Description: A stunning hero section for software agency with animated elements
 */

// Get dynamic content from Theme Options
$badge = webone_agency_get_option('hero_badge', '🚀 Trusted by 80+ Companies Worldwide');
$title = webone_agency_get_option('hero_title', 'We Build <span class="wa-gradient-text">Digital Products</span> That Matter');
$subtitle = webone_agency_get_option('hero_subtitle', 'A team of passionate developers, designers, and strategists crafting exceptional software solutions that transform businesses and delight users.');
$btn1_text = webone_agency_get_option('hero_btn1_text', 'Explore Our Services');
$btn1_link = webone_agency_get_option('hero_btn1_link', '#services');
$btn2_text = webone_agency_get_option('hero_btn2_text', 'Start a Project');
$btn2_link = webone_agency_get_option('hero_btn2_link', '#contact');
$tech = webone_agency_get_option('hero_tech', 'Powered by: React • Node.js • AWS • Flutter • Python • PostgreSQL');
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"className":"wa-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull wa-hero" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">

    <!-- Floating Elements -->
    <div class="wa-floating-element wa-floating-element--1">
        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="60" height="60" rx="12" fill="url(#grad1)" fill-opacity="0.3"/>
            <defs><linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#6366f1"/><stop offset="100%" style="stop-color:#22d3ee"/></linearGradient></defs>
        </svg>
    </div>
    <div class="wa-floating-element wa-floating-element--2">
        <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="40" cy="40" r="40" fill="url(#grad2)" fill-opacity="0.2"/>
            <defs><linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#8b5cf6"/><stop offset="100%" style="stop-color:#f472b6"/></linearGradient></defs>
        </svg>
    </div>
    <div class="wa-floating-element wa-floating-element--3">
        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <polygon points="25,5 45,40 5,40" fill="url(#grad3)" fill-opacity="0.25"/>
            <defs><linearGradient id="grad3" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#22d3ee"/><stop offset="100%" style="stop-color:#6366f1"/></linearGradient></defs>
        </svg>
    </div>

    <!-- wp:group {"className":"wa-hero-content","layout":{"type":"constrained","contentSize":"900px"}} -->
    <div class="wp-block-group wa-hero-content">
        
        <!-- Badge -->
        <!-- wp:paragraph {"align":"center","className":"wa-hero-badge"} -->
        <p class="has-text-align-center wa-hero-badge"><?php echo esc_html($badge); ?></p>
        <!-- /wp:paragraph -->
        
        <!-- Hero Title -->
        <!-- wp:heading {"textAlign":"center","level":1,"className":"wa-hero-title"} -->
        <h1 class="wp-block-heading has-text-align-center wa-hero-title"><?php echo wp_kses_post($title); ?></h1>
        <!-- /wp:heading -->
        
        <!-- Subtitle -->
        <!-- wp:paragraph {"align":"center","className":"wa-hero-subtitle"} -->
        <p class="has-text-align-center wa-hero-subtitle"><?php echo esc_html($subtitle); ?></p>
        <!-- /wp:paragraph -->
        
        <!-- CTA Buttons -->
        <!-- wp:buttons {"className":"wa-hero-buttons","layout":{"type":"flex","justifyContent":"center"}} -->
        <div class="wp-block-buttons wa-hero-buttons">
            <!-- wp:button {"className":"wa-btn"} -->
            <div class="wp-block-button wa-btn"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url($btn1_link); ?>"><?php echo esc_html($btn1_text); ?></a></div>
            <!-- /wp:button -->
            
            <!-- wp:button {"className":"is-style-outline wa-btn-outline"} -->
            <div class="wp-block-button is-style-outline wa-btn-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url($btn2_link); ?>"><?php echo esc_html($btn2_text); ?></a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->
        
        <!-- Tech Logos -->
        <!-- wp:group {"style":{"spacing":{"margin":{"top":"4rem"}}},"className":"wa-hero-tech","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
        <div class="wp-block-group wa-hero-tech" style="margin-top:4rem">
            <!-- wp:paragraph {"style":{"typography":{"fontSize":"0.875rem"}},"textColor":"accent-4"} -->
            <p class="has-accent-4-color has-text-color" style="font-size:0.875rem"><?php echo esc_html($tech); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
        
    </div>
    <!-- /wp:group -->
    
</div>
<!-- /wp:group -->
