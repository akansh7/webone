<?php
/**
 * Title: Services Grid
 * Slug: webone-agency/services-grid
 * Categories: webone-agency
 * Description: A grid of services with icons and hover effects (dynamically loaded)
 */

// Get section headers from Theme Options
$section_label = webone_agency_get_option('services_label', 'What We Do');
$section_title = webone_agency_get_option('services_title', 'Services That <span class="wa-gradient-text">Drive Growth</span>');
$section_description = webone_agency_get_option('services_description', 'From concept to deployment, we deliver end-to-end solutions tailored to your unique business needs.');

// Get services from database
$db_services = webone_agency_get_services();

// Default services as fallback
$default_services = array(
    array('title' => 'Web Development', 'icon' => '💻', 'description' => 'Full-stack web applications built with React, Vue.js, Node.js, and modern frameworks. Scalable, secure, and performant.'),
    array('title' => 'Mobile Apps', 'icon' => '📱', 'description' => 'Native iOS, Android, and cross-platform apps with React Native. Beautiful interfaces with seamless user experiences.'),
    array('title' => 'UI/UX Design', 'icon' => '🎨', 'description' => 'User-centered design with Figma. Wireframes, prototypes, and design systems that convert visitors into customers.'),
    array('title' => 'Cloud Solutions', 'icon' => '☁️', 'description' => 'AWS, Azure, and GCP architecture. Serverless, microservices, and cloud-native solutions for enterprise scale.'),
    array('title' => 'DevOps', 'icon' => '⚙️', 'description' => 'CI/CD pipelines, Docker, Kubernetes, and infrastructure as code. Automate deployments and scale with confidence.'),
    array('title' => 'AI/ML Solutions', 'icon' => '🤖', 'description' => 'Machine learning models, AI integrations, and intelligent automation. Transform data into actionable insights.'),
);

$services = !empty($db_services) ? $db_services : $default_services;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"accent-5","className":"wa-section wa-section-lighter","layout":{"type":"constrained","contentSize":"1340px"}} -->
<div id="services" class="wp-block-group alignfull wa-section wa-section-lighter has-accent-5-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--50)">

    <!-- Section Header -->
    <!-- wp:group {"className":"wa-section-header","layout":{"type":"constrained","contentSize":"700px"}} -->
    <div class="wp-block-group wa-section-header" data-reveal>
        <!-- wp:paragraph {"align":"center","className":"wa-section-label"} -->
        <p class="has-text-align-center wa-section-label"><?php echo esc_html($section_label); ?></p>
        <!-- /wp:paragraph -->
        
        <!-- wp:heading {"textAlign":"center","className":"wa-section-title"} -->
        <h2 class="wp-block-heading has-text-align-center wa-section-title"><?php echo wp_kses_post($section_title); ?></h2>
        <!-- /wp:heading -->
        
        <!-- wp:paragraph {"align":"center","className":"wa-section-description"} -->
        <p class="has-text-align-center wa-section-description"><?php echo esc_html($section_description); ?></p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- Services Grid -->
    <!-- wp:group {"className":"wa-services-grid","layout":{"type":"default"}} -->
    <div class="wp-block-group wa-services-grid">
    
        <?php 
        foreach ($services as $service) : 
        ?>
        <!-- wp:group {"className":"wa-service-card","layout":{"type":"default"}} -->
        <div class="wp-block-group wa-service-card">
            <div class="wa-service-icon"><?php echo esc_html($service['icon']); ?></div>
            <!-- wp:heading {"level":3,"className":"wa-service-title"} -->
            <h3 class="wp-block-heading wa-service-title"><?php echo esc_html($service['title']); ?></h3>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"className":"wa-service-description"} -->
            <p class="wa-service-description"><?php echo esc_html($service['description']); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
        <?php 
        endforeach; 
        ?>
        
    </div>
    <!-- /wp:group -->
    
</div>
<!-- /wp:group -->
