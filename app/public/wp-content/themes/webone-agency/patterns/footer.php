<?php
/**
 * Title: Agency Footer
 * Slug: webone-agency/footer
 * Categories: webone-agency
 * Block Types: core/template-part/footer
 * Description: Footer with links and social icons (dynamically loaded)
 */

// Get site settings from Theme Options
$company_name = webone_agency_get_option('company_name', 'WebOne');
$tagline = webone_agency_get_option('company_tagline', 'Crafting exceptional digital experiences since 2016. We turn complex ideas into elegant, scalable solutions.');
$email = webone_agency_get_option('company_email', 'hello@webone.agency');
$phone = webone_agency_get_option('company_phone', '+1 (555) 123-4567');
$address = webone_agency_get_option('company_address', 'San Francisco, CA');
$copyright = webone_agency_get_option('copyright_text', '© 2024 WebOne Agency. All rights reserved.');
$social_linkedin = webone_agency_get_option('social_linkedin', '#');
$social_github = webone_agency_get_option('social_github', '#');
$social_twitter = webone_agency_get_option('social_twitter', '#');
$social_dribbble = webone_agency_get_option('social_dribbble', '#');
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"accent-5","className":"wa-footer","layout":{"type":"constrained","contentSize":"1340px"}} -->
<div class="wp-block-group alignfull wa-footer has-accent-5-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">

    <!-- Footer Grid -->
    <!-- wp:columns {"className":"wa-footer-grid"} -->
    <div class="wp-block-columns wa-footer-grid">
    
        <!-- Brand Column -->
        <!-- wp:column {"width":"40%","className":"wa-footer-brand"} -->
        <div class="wp-block-column wa-footer-brand" style="flex-basis:40%">
            <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
            <div class="wp-block-group">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <!-- wp:heading {"level":3,"className":"wa-footer-logo"} -->
                <h3 class="wp-block-heading wa-footer-logo"><?php echo esc_html($company_name); ?></h3>
                <!-- /wp:heading -->
            </div>
            <!-- /wp:group -->
            
            <!-- wp:paragraph {"className":"wa-footer-description","style":{"spacing":{"margin":{"top":"1rem"}}}} -->
            <p class="wa-footer-description" style="margin-top:1rem"><?php echo esc_html($tagline); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
        
        <!-- Services Column -->
        <!-- wp:column {"width":"20%"} -->
        <div class="wp-block-column" style="flex-basis:20%">
            <!-- wp:heading {"level":4,"className":"wa-footer-title"} -->
            <h4 class="wp-block-heading wa-footer-title">Services</h4>
            <!-- /wp:heading -->
            
            <!-- wp:list {"className":"wa-footer-links"} -->
            <ul class="wa-footer-links">
                <li><a href="#services">Web Development</a></li>
                <li><a href="#services">Mobile Apps</a></li>
                <li><a href="#services">UI/UX Design</a></li>
                <li><a href="#services">Cloud Solutions</a></li>
            </ul>
            <!-- /wp:list -->
        </div>
        <!-- /wp:column -->
        
        <!-- Company Column -->
        <!-- wp:column {"width":"20%"} -->
        <div class="wp-block-column" style="flex-basis:20%">
            <!-- wp:heading {"level":4,"className":"wa-footer-title"} -->
            <h4 class="wp-block-heading wa-footer-title">Company</h4>
            <!-- /wp:heading -->
            
            <!-- wp:list {"className":"wa-footer-links"} -->
            <ul class="wa-footer-links">
                <li><a href="#team">About Us</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <!-- /wp:list -->
        </div>
        <!-- /wp:column -->
        
        <!-- Contact Column -->
        <!-- wp:column {"width":"20%"} -->
        <div class="wp-block-column" style="flex-basis:20%">
            <!-- wp:heading {"level":4,"className":"wa-footer-title"} -->
            <h4 class="wp-block-heading wa-footer-title">Contact</h4>
            <!-- /wp:heading -->
            
            <!-- wp:list {"className":"wa-footer-links"} -->
            <ul class="wa-footer-links">
                <li><?php echo esc_html($email); ?></li>
                <li><?php echo esc_html($phone); ?></li>
                <li><?php echo esc_html($address); ?></li>
            </ul>
            <!-- /wp:list -->
        </div>
        <!-- /wp:column -->
        
    </div>
    <!-- /wp:columns -->
    
    <!-- Footer Bottom -->
    <!-- wp:group {"className":"wa-footer-bottom","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
    <div class="wp-block-group wa-footer-bottom">
        <!-- wp:paragraph {"className":"wa-footer-copyright"} -->
        <p class="wa-footer-copyright"><?php echo esc_html($copyright); ?></p>
        <!-- /wp:paragraph -->
        
        <div class="wa-footer-social">
            <?php if (!empty($social_linkedin)) : ?>
            <a href="<?php echo esc_url($social_linkedin); ?>" aria-label="LinkedIn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
            </a>
            <?php endif; ?>
            <?php if (!empty($social_github)) : ?>
            <a href="<?php echo esc_url($social_github); ?>" aria-label="GitHub">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
            </a>
            <?php endif; ?>
            <?php if (!empty($social_twitter)) : ?>
            <a href="<?php echo esc_url($social_twitter); ?>" aria-label="Twitter">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            <?php endif; ?>
            <?php if (!empty($social_dribbble)) : ?>
            <a href="<?php echo esc_url($social_dribbble); ?>" aria-label="Dribbble">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.628 0-12 5.373-12 12s5.372 12 12 12 12-5.373 12-12-5.372-12-12-12zm9.885 11.441c-2.575-.422-4.943-.445-7.103-.073-.244-.563-.497-1.125-.767-1.68 2.31-1 4.165-2.358 5.548-4.082 1.35 1.594 2.197 3.619 2.322 5.835zm-3.842-7.282c-1.205 1.554-2.868 2.783-4.986 3.68-1.016-1.861-2.178-3.676-3.488-5.438.779-.197 1.591-.314 2.431-.314 2.275 0 4.368.779 6.043 2.072zm-10.516-.993c1.331 1.742 2.511 3.538 3.537 5.381-2.43.715-5.331 1.082-8.684 1.105.692-2.835 2.601-5.193 5.147-6.486zm-5.44 8.834l.013-.256c3.849-.005 7.169-.448 9.95-1.322.233.475.456.952.67 1.432-3.38 1.057-6.165 3.222-8.337 6.48-1.432-1.719-2.296-3.927-2.296-6.334zm3.829 7.81c1.969-3.088 4.482-5.098 7.598-6.027.928 2.42 1.609 4.91 2.043 7.46-3.349 1.291-6.953.666-9.641-1.433zm11.586.43c-.438-2.353-1.08-4.653-1.92-6.897 1.876-.265 3.94-.196 6.199.196-.437 2.786-2.028 5.192-4.279 6.701z"/></svg>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <!-- /wp:group -->
    
</div>
<!-- /wp:group -->
