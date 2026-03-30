<?php
/**
 * Title: Contact CTA
 * Slug: webone-agency/contact-cta
 * Categories: webone-agency
 * Description: Contact call-to-action section with gradient background (dynamically loaded)
 */

// Get CTA content from Theme Options
$heading = webone_agency_get_option('cta_heading', 'Ready to Build Something Amazing?');
$description = webone_agency_get_option('cta_description', "Let's discuss your project and see how we can help bring your ideas to life. Free consultation, no strings attached.");
$button_text = webone_agency_get_option('cta_button_text', 'Get in Touch →');
$email = webone_agency_get_option('company_email', 'hello@webone.agency');
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"base","className":"wa-section wa-section-dark","layout":{"type":"constrained","contentSize":"1000px"}} -->
<div id="contact" class="wp-block-group alignfull wa-section wa-section-dark has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--50)">

    <!-- wp:group {"className":"wa-cta","layout":{"type":"constrained","contentSize":"600px"}} -->
    <div class="wp-block-group wa-cta" data-reveal>
        <div class="wa-cta-content">
            <!-- wp:heading {"textAlign":"center","className":"wa-cta-title"} -->
            <h2 class="wp-block-heading has-text-align-center wa-cta-title"><?php echo esc_html($heading); ?></h2>
            <!-- /wp:heading -->
            
            <!-- wp:paragraph {"align":"center","className":"wa-cta-description"} -->
            <p class="has-text-align-center wa-cta-description"><?php echo esc_html($description); ?></p>
            <!-- /wp:paragraph -->
            
            <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
            <div class="wp-block-buttons">
                <!-- wp:button {"style":{"color":{"background":"#ffffff","text":"#6366f1"}},"className":"wa-btn"} -->
                <div class="wp-block-button wa-btn"><a class="wp-block-button__link has-text-color has-background wp-element-button" href="mailto:<?php echo esc_attr($email); ?>" style="color:#6366f1;background-color:#ffffff"><?php echo esc_html($button_text); ?></a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
            
            <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.875rem"},"spacing":{"margin":{"top":"1.5rem"}}}} -->
            <p class="has-text-align-center" style="margin-top:1.5rem;font-size:0.875rem">Or email us directly at <strong><?php echo esc_html($email); ?></strong></p>
            <!-- /wp:paragraph -->
        </div>
    </div>
    <!-- /wp:group -->
    
</div>
<!-- /wp:group -->
