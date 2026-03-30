<?php
/**
 * Title: Projects Showcase
 * Slug: webone-agency/projects-showcase
 * Categories: webone-agency
 * Description: Portfolio grid with featured projects (dynamically loaded)
 */

// Get section headers from Theme Options
$section_label = webone_agency_get_option('projects_label', 'Our Work');
$section_title = webone_agency_get_option('projects_title', 'Featured <span class="wa-gradient-text">Projects</span>');
$section_description = webone_agency_get_option('projects_description', 'A selection of our recent work showcasing innovation, design excellence, and technical expertise.');

// Get projects from database
$db_projects = webone_agency_get_projects();

// Default projects as fallback
$default_projects = array(
    array('title' => 'FinTrack Pro', 'category' => 'FinTech', 'description' => 'A comprehensive banking dashboard with real-time analytics, transaction monitoring, and AI-powered insights.', 'tags' => array('React', 'Node.js', 'AWS'), 'bg_color1' => '#1a1a2e', 'bg_color2' => '#16213e', 'icon_color' => '#6366f1'),
    array('title' => 'HealthSync', 'category' => 'Healthcare', 'description' => 'Healthcare management platform connecting patients, doctors, and pharmacies with secure data sharing.', 'tags' => array('React Native', 'Python', 'HIPAA'), 'bg_color1' => '#1a2e1a', 'bg_color2' => '#0d3d0d', 'icon_color' => '#10b981'),
    array('title' => 'EcoMarket', 'category' => 'E-Commerce', 'description' => 'Sustainable e-commerce marketplace featuring eco-friendly products with carbon footprint tracking.', 'tags' => array('Next.js', 'Stripe', 'PostgreSQL'), 'bg_color1' => '#2e1a2e', 'bg_color2' => '#3d1a3d', 'icon_color' => '#8b5cf6'),
    array('title' => 'TravelMate', 'category' => 'Travel', 'description' => 'AI-powered travel companion app with personalized itineraries, booking integration, and local recommendations.', 'tags' => array('React Native', 'AI/ML', 'GCP'), 'bg_color1' => '#1a2e3d', 'bg_color2' => '#0d3d4d', 'icon_color' => '#22d3ee'),
);

$projects = !empty($db_projects) ? $db_projects : $default_projects;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"accent-5","className":"wa-section wa-section-lighter","layout":{"type":"constrained","contentSize":"1340px"}} -->
<div id="portfolio" class="wp-block-group alignfull wa-section wa-section-lighter has-accent-5-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--50)">

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

    <!-- Projects Grid -->
    <!-- wp:group {"className":"wa-projects-grid","layout":{"type":"default"}} -->
    <div class="wp-block-group wa-projects-grid">
    
        <?php 
        foreach ($projects as $project) : 
            $initials = strtoupper(substr($project['title'], 0, 2));
        ?>
        <!-- wp:group {"className":"wa-project-card","layout":{"type":"default"}} -->
        <div class="wp-block-group wa-project-card">
            <div class="wa-project-image-wrapper" style="background: linear-gradient(135deg, <?php echo esc_attr($project['bg_color1']); ?> 0%, <?php echo esc_attr($project['bg_color2']); ?> 100%); height: 100%; display: flex; align-items: center; justify-content: center;">
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="20" y="30" width="80" height="60" rx="8" stroke="<?php echo esc_attr($project['icon_color']); ?>" stroke-width="2"/>
                    <text x="60" y="68" text-anchor="middle" fill="<?php echo esc_attr($project['icon_color']); ?>" font-size="20" font-weight="bold"><?php echo esc_html($initials); ?></text>
                </svg>
            </div>
            <div class="wa-project-overlay">
                <!-- wp:paragraph {"className":"wa-project-category"} -->
                <p class="wa-project-category"><?php echo esc_html($project['category']); ?></p>
                <!-- /wp:paragraph -->
                <!-- wp:heading {"level":3,"className":"wa-project-title"} -->
                <h3 class="wp-block-heading wa-project-title"><?php echo esc_html($project['title']); ?></h3>
                <!-- /wp:heading -->
                <!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9rem"}},"textColor":"accent-4"} -->
                <p class="has-accent-4-color has-text-color" style="font-size:0.9rem"><?php echo esc_html($project['description']); ?></p>
                <!-- /wp:paragraph -->
                <div class="wa-project-tags">
                    <?php foreach ($project['tags'] as $tag) : if (!empty($tag)) : ?>
                    <span class="wa-project-tag"><?php echo esc_html($tag); ?></span>
                    <?php endif; endforeach; ?>
                </div>
            </div>
        </div>
        <!-- /wp:group -->
        <?php 
        endforeach; 
        ?>
        
    </div>
    <!-- /wp:group -->
    
</div>
<!-- /wp:group -->
