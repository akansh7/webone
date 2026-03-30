<?php
/**
 * Title: Testimonials Section
 * Slug: webone-agency/testimonials-section
 * Categories: webone-agency
 * Description: Client testimonials with ratings (dynamically loaded from admin)
 */

// Get section headers from Theme Options
$section_label = webone_agency_get_option('testimonials_label', 'Testimonials');
$section_title = webone_agency_get_option('testimonials_title', 'What Our <span class="wa-gradient-text">Clients Say</span>');
$section_description = webone_agency_get_option('testimonials_description', "Don't just take our word for it. Here's what our clients have to say about working with us.");

// Get reviews from database
$db_reviews = webone_agency_get_reviews();

// Default reviews as fallback
$default_reviews = array(
    array(
        'client_name'     => 'James Davidson',
        'client_position' => 'CEO',
        'company_name'    => 'TechCorp Industries',
        'review_text'     => 'The team delivered beyond our expectations. They transformed our outdated platform into a modern, scalable solution that has increased our efficiency by 40%. Highly recommend!',
        'star_rating'     => '5',
        'avatar_initials' => 'JD',
        'avatar_color_1'  => '#6366f1',
        'avatar_color_2'  => '#8b5cf6',
    ),
    array(
        'client_name'     => 'Lisa Park',
        'client_position' => 'Founder',
        'company_name'    => 'StartupXYZ',
        'review_text'     => 'Exceptional quality and attention to detail. They understood our vision from day one and translated it into a beautiful, functional product. The team\'s communication was outstanding throughout.',
        'star_rating'     => '5',
        'avatar_initials' => 'LP',
        'avatar_color_1'  => '#f472b6',
        'avatar_color_2'  => '#8b5cf6',
    ),
    array(
        'client_name'     => 'Michael Roberts',
        'client_position' => 'CTO',
        'company_name'    => 'Enterprise Inc',
        'review_text'     => 'Professional and innovative approach. They didn\'t just build what we asked for—they challenged our assumptions and delivered something even better. A true technology partner.',
        'star_rating'     => '5',
        'avatar_initials' => 'MR',
        'avatar_color_1'  => '#22d3ee',
        'avatar_color_2'  => '#6366f1',
    ),
);

// Use database reviews if available, otherwise fallback to defaults
$reviews = !empty($db_reviews) ? $db_reviews : $default_reviews;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"accent-5","className":"wa-section wa-section-lighter","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group alignfull wa-section wa-section-lighter has-accent-5-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--50)">

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

    <!-- Testimonials Grid -->
    <!-- wp:group {"className":"wa-testimonials-grid","layout":{"type":"default"}} -->
    <div class="wp-block-group wa-testimonials-grid">
    
        <?php 
        foreach ($reviews as $review) : 
            $stars = str_repeat('★', (int)$review['star_rating']);
            $position_company = trim($review['client_position'] . ', ' . $review['company_name'], ', ');
        ?>
        <!-- wp:group {"className":"wa-testimonial-card","layout":{"type":"default"}} -->
        <div class="wp-block-group wa-testimonial-card">
            <div class="wa-testimonial-stars"><?php echo esc_html($stars); ?></div>
            <!-- wp:paragraph {"className":"wa-testimonial-text"} -->
            <p class="wa-testimonial-text">"<?php echo esc_html($review['review_text']); ?>"</p>
            <!-- /wp:paragraph -->
            <div class="wa-testimonial-author">
                <div class="wa-testimonial-avatar">
                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, <?php echo esc_attr($review['avatar_color_1']); ?> 0%, <?php echo esc_attr($review['avatar_color_2']); ?> 100%); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: white; border-radius: 50%;"><?php echo esc_html($review['avatar_initials']); ?></div>
                </div>
                <div>
                    <!-- wp:paragraph {"className":"wa-testimonial-name"} -->
                    <p class="wa-testimonial-name"><?php echo esc_html($review['client_name']); ?></p>
                    <!-- /wp:paragraph -->
                    <!-- wp:paragraph {"className":"wa-testimonial-company"} -->
                    <p class="wa-testimonial-company"><?php echo esc_html($position_company); ?></p>
                    <!-- /wp:paragraph -->
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
