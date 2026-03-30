<?php
/**
 * Title: Stats Counter
 * Slug: webone-agency/stats-counter
 * Categories: webone-agency
 * Description: Animated statistics counter section (dynamically loaded)
 */

// Get stats from Theme Options
$stats = array(
    array(
        'number' => webone_agency_get_option('stat1_number', '150'),
        'suffix' => webone_agency_get_option('stat1_suffix', '+'),
        'label' => webone_agency_get_option('stat1_label', 'Projects Delivered'),
    ),
    array(
        'number' => webone_agency_get_option('stat2_number', '80'),
        'suffix' => webone_agency_get_option('stat2_suffix', '+'),
        'label' => webone_agency_get_option('stat2_label', 'Happy Clients'),
    ),
    array(
        'number' => webone_agency_get_option('stat3_number', '25'),
        'suffix' => webone_agency_get_option('stat3_suffix', '+'),
        'label' => webone_agency_get_option('stat3_label', 'Team Members'),
    ),
    array(
        'number' => webone_agency_get_option('stat4_number', '8'),
        'suffix' => webone_agency_get_option('stat4_suffix', '+'),
        'label' => webone_agency_get_option('stat4_label', 'Years Experience'),
    ),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"base","className":"wa-section wa-section-dark","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group alignfull wa-section wa-section-dark has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--50)">

    <!-- Stats Grid -->
    <!-- wp:group {"className":"wa-stats-grid","layout":{"type":"default"}} -->
    <div class="wp-block-group wa-stats-grid" data-reveal>
    
        <?php foreach ($stats as $stat) : if (!empty($stat['number'])) : ?>
        <!-- wp:group {"className":"wa-stat-item","layout":{"type":"default"}} -->
        <div class="wp-block-group wa-stat-item">
            <!-- wp:paragraph {"className":"wa-stat-number"} -->
            <p class="wa-stat-number" data-counter="<?php echo esc_attr($stat['number']); ?>" data-counter-suffix="<?php echo esc_attr($stat['suffix']); ?>">0<?php echo esc_html($stat['suffix']); ?></p>
            <!-- /wp:paragraph -->
            <!-- wp:paragraph {"className":"wa-stat-label"} -->
            <p class="wa-stat-label"><?php echo esc_html($stat['label']); ?></p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->
        <?php endif; endforeach; ?>
        
    </div>
    <!-- /wp:group -->
    
</div>
<!-- /wp:group -->
