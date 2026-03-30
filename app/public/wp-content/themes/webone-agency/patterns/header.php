<?php
/**
 * Title: Agency Header
 * Slug: webone-agency/header
 * Categories: webone-agency
 * Block Types: core/template-part/header
 * Description: Header with site title and navigation
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"base","className":"wa-header","layout":{"type":"constrained","contentSize":"1340px"}} -->
<div class="wp-block-group alignfull wa-header has-base-background-color has-background" style="padding-top:1.5rem;padding-right:var(--wp--preset--spacing--50);padding-bottom:1.5rem;padding-left:var(--wp--preset--spacing--50)">

    <!-- wp:group {"style":{"spacing":{"blockGap":"2rem"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
    <div class="wp-block-group">
    
        <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
        <div class="wp-block-group">
            <!-- Logo Icon -->
            <div class="wa-logo-icon" style="width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 17L12 22L22 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 12L12 17L22 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            
            <!-- wp:site-title {"level":0,"style":{"typography":{"fontWeight":"700"}}} /-->
        </div>
        <!-- /wp:group -->
        
        <!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"right","verticalAlignment":"center"}} -->
        <div class="wp-block-group">
            <!-- wp:navigation {"layout":{"type":"flex","justifyContent":"right"},"style":{"typography":{"fontWeight":"500"}}} -->
                <!-- wp:navigation-link {"label":"Services","url":"#services","className":"wa-nav-link"} /-->
                <!-- wp:navigation-link {"label":"Portfolio","url":"#portfolio","className":"wa-nav-link"} /-->
                <!-- wp:navigation-link {"label":"Team","url":"#team","className":"wa-nav-link"} /-->
                <!-- wp:navigation-link {"label":"Contact","url":"#contact","className":"wa-nav-link"} /-->
            <!-- /wp:navigation -->
            
            <!-- wp:buttons -->
            <div class="wp-block-buttons">
                <!-- wp:button {"style":{"border":{"radius":"100px"}},"fontSize":"small"} -->
                <div class="wp-block-button has-custom-font-size has-small-font-size"><a class="wp-block-button__link wp-element-button" href="#contact" style="border-radius:100px">Start Project</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:group -->
        
    </div>
    <!-- /wp:group -->
    
</div>
<!-- /wp:group -->
