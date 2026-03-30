<?php
/**
 * Title: Team Section
 * Slug: webone-agency/team-section
 * Categories: webone-agency
 * Description: Team members grid with photos and bios (dynamically loaded)
 */

// Get section headers from Theme Options
$section_label = webone_agency_get_option('team_label', 'Our Team');
$section_title = webone_agency_get_option('team_title', 'Meet the <span class="wa-gradient-text">Experts</span>');
$section_description = webone_agency_get_option('team_description', 'Talented individuals passionate about technology, design, and delivering exceptional results.');

// Get team from database
$db_team = webone_agency_get_team();

// Default team as fallback
$default_team = array(
    array('name' => 'Alex Chen', 'role' => 'Founder & Lead Developer', 'bio' => '10+ years building scalable applications. Former tech lead at major startups. Passionate about clean code and mentoring.', 'initials' => 'AC', 'color1' => '#6366f1', 'color2' => '#8b5cf6', 'linkedin' => '#', 'github' => '#', 'twitter' => '#'),
    array('name' => 'Sarah Mitchell', 'role' => 'UI/UX Design Lead', 'bio' => 'Award-winning designer with expertise in user research, prototyping, and design systems. Figma and motion design specialist.', 'initials' => 'SM', 'color1' => '#f472b6', 'color2' => '#8b5cf6', 'linkedin' => '#', 'github' => '', 'twitter' => '#'),
    array('name' => 'Marcus Johnson', 'role' => 'Full-Stack Developer', 'bio' => 'Cloud architecture expert specializing in AWS and Kubernetes. Open source contributor and performance optimization enthusiast.', 'initials' => 'MJ', 'color1' => '#22d3ee', 'color2' => '#6366f1', 'linkedin' => '#', 'github' => '#', 'twitter' => '#'),
    array('name' => 'Emma Williams', 'role' => 'Project Manager', 'bio' => 'PMP certified with agile expertise. Ensures seamless delivery from concept to launch while keeping teams motivated and clients happy.', 'initials' => 'EW', 'color1' => '#10b981', 'color2' => '#22d3ee', 'linkedin' => '#', 'github' => '', 'twitter' => '#'),
);

$team = !empty($db_team) ? $db_team : $default_team;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"base","className":"wa-section wa-section-dark","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div id="team" class="wp-block-group alignfull wa-section wa-section-dark has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--50)">

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

    <!-- Team Grid -->
    <!-- wp:group {"className":"wa-team-grid","layout":{"type":"default"}} -->
    <div class="wp-block-group wa-team-grid">
    
        <?php 
        foreach ($team as $member) : 
        ?>
        <!-- wp:group {"className":"wa-team-card","layout":{"type":"default"}} -->
        <div class="wp-block-group wa-team-card">
            <div class="wa-team-avatar">
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, <?php echo esc_attr($member['color1']); ?> 0%, <?php echo esc_attr($member['color2']); ?> 100%); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white;"><?php echo esc_html($member['initials']); ?></div>
            </div>
            <!-- wp:heading {"level":3,"className":"wa-team-name"} -->
            <h3 class="wp-block-heading wa-team-name"><?php echo esc_html($member['name']); ?></h3>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"className":"wa-team-role"} -->
            <p class="wa-team-role"><?php echo esc_html($member['role']); ?></p>
            <!-- /wp:paragraph -->
            <!-- wp:paragraph {"className":"wa-team-bio"} -->
            <p class="wa-team-bio"><?php echo esc_html($member['bio']); ?></p>
            <!-- /wp:paragraph -->
            <div class="wa-team-social">
                <?php if (!empty($member['linkedin'])) : ?>
                <a href="<?php echo esc_url($member['linkedin']); ?>" aria-label="LinkedIn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                </a>
                <?php endif; ?>
                <?php if (!empty($member['github'])) : ?>
                <a href="<?php echo esc_url($member['github']); ?>" aria-label="GitHub">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                </a>
                <?php endif; ?>
                <?php if (!empty($member['twitter'])) : ?>
                <a href="<?php echo esc_url($member['twitter']); ?>" aria-label="Twitter">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <?php endif; ?>
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
