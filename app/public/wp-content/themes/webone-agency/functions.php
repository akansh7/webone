<?php
/**
 * WebOne Agency Theme Functions
 *
 * @package WebOne_Agency
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue parent and child theme styles
 */
function webone_agency_enqueue_styles() {
    // Enqueue parent theme styles
    wp_enqueue_style(
        'twentytwentyfive-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme('twentytwentyfive')->get('Version')
    );

    // Enqueue child theme styles
    wp_enqueue_style(
        'webone-agency-style',
        get_stylesheet_uri(),
        array('twentytwentyfive-style'),
        wp_get_theme()->get('Version')
    );

    // Enqueue custom animations script
    wp_enqueue_script(
        'webone-agency-animations',
        get_stylesheet_directory_uri() . '/assets/js/animations.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'webone_agency_enqueue_styles');

/**
 * Register block patterns
 */
function webone_agency_register_block_patterns() {
    // Register pattern category
    register_block_pattern_category(
        'webone-agency',
        array('label' => __('WebOne Agency', 'webone-agency'))
    );
}
add_action('init', 'webone_agency_register_block_patterns');

/**
 * Add theme support features
 */
function webone_agency_theme_support() {
    // Add support for editor styles
    add_theme_support('editor-styles');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for wide alignments
    add_theme_support('align-wide');
    
    // Add support for block styles
    add_theme_support('wp-block-styles');
}
add_action('after_setup_theme', 'webone_agency_theme_support');

/**
 * Add custom body classes
 */
function webone_agency_body_classes($classes) {
    $classes[] = 'webone-agency-theme';
    $classes[] = 'dark-mode';
    return $classes;
}
add_filter('body_class', 'webone_agency_body_classes');

/**
 * Modify excerpt length
 */
function webone_agency_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'webone_agency_excerpt_length');

/**
 * Custom excerpt more text
 */
function webone_agency_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'webone_agency_excerpt_more');

/**
 * Add custom favicon
 */
function webone_agency_favicon() {
    $favicon_url = get_stylesheet_directory_uri() . '/assets/favicon.png';
    echo '<link rel="icon" type="image/png" href="' . esc_url($favicon_url) . '" />';
    echo '<link rel="apple-touch-icon" href="' . esc_url($favicon_url) . '" />';
}
add_action('wp_head', 'webone_agency_favicon');
add_action('admin_head', 'webone_agency_favicon');

/**
 * Remove default WordPress favicon
 */
function webone_agency_remove_wp_favicon() {
    remove_action('wp_head', 'wp_site_icon', 99);
}
add_action('init', 'webone_agency_remove_wp_favicon');

/**
 * Contact Form AJAX Handler
 */
function webone_agency_handle_contact_form() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'webone_contact_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed.'));
    }

    // Sanitize form data
    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $subject = sanitize_text_field($_POST['subject'] ?? 'New Contact Form Submission');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
    }

    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
    }

    // Store message in database (works on local development too)
    $submissions = get_option('webone_contact_submissions', array());
    $submissions[] = array(
        'name' => $name,
        'email' => $email,
        'subject' => $subject,
        'message' => $message,
        'date' => current_time('mysql'),
    );
    update_option('webone_contact_submissions', $submissions);

    // Prepare email
    $to = get_option('admin_email');
    $email_subject = '[WebOne Agency] ' . $subject;
    $email_body = "You have received a new message from your website contact form.\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n\n";
    $email_body .= "Message:\n$message\n";
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <no-reply@' . parse_url(home_url(), PHP_URL_HOST) . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );

    // Try to send email (may fail on local development)
    $sent = wp_mail($to, $email_subject, $email_body, $headers);

    // Always return success since message is saved to database
    // In production, you should install WP Mail SMTP for reliable email delivery
    wp_send_json_success(array(
        'message' => 'Message received! We will get back to you soon.',
        'email_sent' => $sent
    ));
}
add_action('wp_ajax_webone_contact_form', 'webone_agency_handle_contact_form');
add_action('wp_ajax_nopriv_webone_contact_form', 'webone_agency_handle_contact_form');

/**
 * Localize script with AJAX URL and nonce
 */
function webone_agency_localize_scripts() {
    wp_localize_script('webone-agency-animations', 'weboneAjax', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('webone_contact_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'webone_agency_localize_scripts', 20);

/**
 * Register Custom Post Type: Reviews
 */
function webone_agency_register_review_post_type() {
    $labels = array(
        'name'                  => 'Reviews',
        'singular_name'         => 'Review',
        'menu_name'             => 'Reviews',
        'add_new'               => 'Add New Review',
        'add_new_item'          => 'Add New Review',
        'edit_item'             => 'Edit Review',
        'new_item'              => 'New Review',
        'view_item'             => 'View Review',
        'search_items'          => 'Search Reviews',
        'not_found'             => 'No reviews found',
        'not_found_in_trash'    => 'No reviews found in trash',
        'all_items'             => 'All Reviews',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-star-filled',
        'supports'           => array('title'),
        'show_in_rest'       => true,
    );

    register_post_type('webone_review', $args);
}
add_action('init', 'webone_agency_register_review_post_type');

/**
 * Add Meta Boxes for Review Fields
 */
function webone_agency_review_meta_boxes() {
    add_meta_box(
        'webone_review_details',
        'Review Details',
        'webone_agency_review_meta_box_callback',
        'webone_review',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'webone_agency_review_meta_boxes');

/**
 * Review Meta Box Callback
 */
function webone_agency_review_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('webone_review_meta_box', 'webone_review_meta_box_nonce');

    // Get existing values
    $client_name = get_post_meta($post->ID, '_webone_client_name', true);
    $client_position = get_post_meta($post->ID, '_webone_client_position', true);
    $company_name = get_post_meta($post->ID, '_webone_company_name', true);
    $review_text = get_post_meta($post->ID, '_webone_review_text', true);
    $star_rating = get_post_meta($post->ID, '_webone_star_rating', true) ?: '5';
    $avatar_initials = get_post_meta($post->ID, '_webone_avatar_initials', true);
    $avatar_color_1 = get_post_meta($post->ID, '_webone_avatar_color_1', true) ?: '#6366f1';
    $avatar_color_2 = get_post_meta($post->ID, '_webone_avatar_color_2', true) ?: '#8b5cf6';

    ?>
    <style>
        .webone-review-field { margin-bottom: 20px; }
        .webone-review-field label { display: block; font-weight: 600; margin-bottom: 5px; }
        .webone-review-field input[type="text"],
        .webone-review-field textarea,
        .webone-review-field select { width: 100%; max-width: 500px; }
        .webone-review-field textarea { height: 120px; }
        .webone-color-group { display: flex; gap: 20px; align-items: center; }
        .webone-color-group input[type="color"] { width: 60px; height: 40px; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; }
        .webone-avatar-preview { 
            width: 60px; height: 60px; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 1.25rem; color: white; font-weight: 600;
        }
    </style>

    <div class="webone-review-field">
        <label for="webone_client_name">Client Name *</label>
        <input type="text" id="webone_client_name" name="webone_client_name" value="<?php echo esc_attr($client_name); ?>" required>
    </div>

    <div class="webone-review-field">
        <label for="webone_client_position">Position/Role</label>
        <input type="text" id="webone_client_position" name="webone_client_position" value="<?php echo esc_attr($client_position); ?>" placeholder="e.g., CEO, Founder, CTO">
    </div>

    <div class="webone-review-field">
        <label for="webone_company_name">Company Name</label>
        <input type="text" id="webone_company_name" name="webone_company_name" value="<?php echo esc_attr($company_name); ?>" placeholder="e.g., TechCorp Industries">
    </div>

    <div class="webone-review-field">
        <label for="webone_review_text">Review Text *</label>
        <textarea id="webone_review_text" name="webone_review_text" required><?php echo esc_textarea($review_text); ?></textarea>
    </div>

    <div class="webone-review-field">
        <label for="webone_star_rating">Star Rating</label>
        <select id="webone_star_rating" name="webone_star_rating">
            <?php for ($i = 1; $i <= 5; $i++) : ?>
                <option value="<?php echo $i; ?>" <?php selected($star_rating, $i); ?>><?php echo str_repeat('★', $i); ?></option>
            <?php endfor; ?>
        </select>
    </div>

    <div class="webone-review-field">
        <label for="webone_avatar_initials">Avatar Initials (2 characters)</label>
        <input type="text" id="webone_avatar_initials" name="webone_avatar_initials" value="<?php echo esc_attr($avatar_initials); ?>" maxlength="2" placeholder="e.g., JD" style="width: 80px;">
    </div>

    <div class="webone-review-field">
        <label>Avatar Gradient Colors</label>
        <div class="webone-color-group">
            <div>
                <small>Color 1</small><br>
                <input type="color" id="webone_avatar_color_1" name="webone_avatar_color_1" value="<?php echo esc_attr($avatar_color_1); ?>">
            </div>
            <div>
                <small>Color 2</small><br>
                <input type="color" id="webone_avatar_color_2" name="webone_avatar_color_2" value="<?php echo esc_attr($avatar_color_2); ?>">
            </div>
            <div class="webone-avatar-preview" id="avatar_preview" style="background: linear-gradient(135deg, <?php echo esc_attr($avatar_color_1); ?> 0%, <?php echo esc_attr($avatar_color_2); ?> 100%);">
                <?php echo esc_html($avatar_initials ?: 'AB'); ?>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const initials = document.getElementById('webone_avatar_initials');
            const color1 = document.getElementById('webone_avatar_color_1');
            const color2 = document.getElementById('webone_avatar_color_2');
            const preview = document.getElementById('avatar_preview');

            function updatePreview() {
                preview.textContent = initials.value || 'AB';
                preview.style.background = `linear-gradient(135deg, ${color1.value} 0%, ${color2.value} 100%)`;
            }

            initials.addEventListener('input', updatePreview);
            color1.addEventListener('input', updatePreview);
            color2.addEventListener('input', updatePreview);
        })();
    </script>
    <?php
}

/**
 * Save Review Meta Box Data
 */
function webone_agency_save_review_meta($post_id) {
    // Verify nonce
    if (!isset($_POST['webone_review_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['webone_review_meta_box_nonce'], 'webone_review_meta_box')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save meta fields
    $fields = array(
        'webone_client_name' => '_webone_client_name',
        'webone_client_position' => '_webone_client_position',
        'webone_company_name' => '_webone_company_name',
        'webone_review_text' => '_webone_review_text',
        'webone_star_rating' => '_webone_star_rating',
        'webone_avatar_initials' => '_webone_avatar_initials',
        'webone_avatar_color_1' => '_webone_avatar_color_1',
        'webone_avatar_color_2' => '_webone_avatar_color_2',
    );

    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            $value = $field === 'webone_review_text' 
                ? sanitize_textarea_field($_POST[$field])
                : sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, $meta_key, $value);
        }
    }
}
add_action('save_post_webone_review', 'webone_agency_save_review_meta');

/**
 * Helper function to get all reviews
 */
function webone_agency_get_reviews() {
    $reviews = get_posts(array(
        'post_type'      => 'webone_review',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ));

    $formatted_reviews = array();

    foreach ($reviews as $review) {
        $formatted_reviews[] = array(
            'id'              => $review->ID,
            'client_name'     => get_post_meta($review->ID, '_webone_client_name', true),
            'client_position' => get_post_meta($review->ID, '_webone_client_position', true),
            'company_name'    => get_post_meta($review->ID, '_webone_company_name', true),
            'review_text'     => get_post_meta($review->ID, '_webone_review_text', true),
            'star_rating'     => get_post_meta($review->ID, '_webone_star_rating', true) ?: '5',
            'avatar_initials' => get_post_meta($review->ID, '_webone_avatar_initials', true),
            'avatar_color_1'  => get_post_meta($review->ID, '_webone_avatar_color_1', true) ?: '#6366f1',
            'avatar_color_2'  => get_post_meta($review->ID, '_webone_avatar_color_2', true) ?: '#8b5cf6',
        );
    }

    return $formatted_reviews;
}

// =========================================================================
// SERVICES CUSTOM POST TYPE
// =========================================================================

function webone_agency_register_service_post_type() {
    register_post_type('webone_service', array(
        'labels' => array(
            'name' => 'Services',
            'singular_name' => 'Service',
            'add_new' => 'Add New Service',
            'add_new_item' => 'Add New Service',
            'edit_item' => 'Edit Service',
            'all_items' => 'All Services',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 26,
        'menu_icon' => 'dashicons-hammer',
        'supports' => array('title'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'webone_agency_register_service_post_type');

function webone_agency_service_meta_boxes() {
    add_meta_box('webone_service_details', 'Service Details', 'webone_agency_service_meta_callback', 'webone_service', 'normal', 'high');
}
add_action('add_meta_boxes', 'webone_agency_service_meta_boxes');

function webone_agency_service_meta_callback($post) {
    wp_nonce_field('webone_service_meta', 'webone_service_nonce');
    $icon = get_post_meta($post->ID, '_webone_service_icon', true) ?: '💻';
    $desc = get_post_meta($post->ID, '_webone_service_description', true);
    ?>
    <p><label><strong>Icon (emoji)</strong><br>
    <input type="text" name="webone_service_icon" value="<?php echo esc_attr($icon); ?>" style="width:100px;font-size:1.5rem;"></label></p>
    <p><label><strong>Description</strong><br>
    <textarea name="webone_service_description" rows="3" style="width:100%;"><?php echo esc_textarea($desc); ?></textarea></label></p>
    <?php
}

function webone_agency_save_service_meta($post_id) {
    if (!isset($_POST['webone_service_nonce']) || !wp_verify_nonce($_POST['webone_service_nonce'], 'webone_service_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['webone_service_icon'])) update_post_meta($post_id, '_webone_service_icon', sanitize_text_field($_POST['webone_service_icon']));
    if (isset($_POST['webone_service_description'])) update_post_meta($post_id, '_webone_service_description', sanitize_textarea_field($_POST['webone_service_description']));
}
add_action('save_post_webone_service', 'webone_agency_save_service_meta');

function webone_agency_get_services() {
    $posts = get_posts(array('post_type' => 'webone_service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC', 'post_status' => 'publish'));
    $services = array();
    foreach ($posts as $p) {
        $services[] = array(
            'title' => $p->post_title,
            'icon' => get_post_meta($p->ID, '_webone_service_icon', true) ?: '💻',
            'description' => get_post_meta($p->ID, '_webone_service_description', true),
        );
    }
    return $services;
}

// =========================================================================
// PROJECTS CUSTOM POST TYPE
// =========================================================================

function webone_agency_register_project_post_type() {
    register_post_type('webone_project', array(
        'labels' => array(
            'name' => 'Projects',
            'singular_name' => 'Project',
            'add_new' => 'Add New Project',
            'add_new_item' => 'Add New Project',
            'edit_item' => 'Edit Project',
            'all_items' => 'All Projects',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 27,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'webone_agency_register_project_post_type');

function webone_agency_project_meta_boxes() {
    add_meta_box('webone_project_details', 'Project Details', 'webone_agency_project_meta_callback', 'webone_project', 'normal', 'high');
}
add_action('add_meta_boxes', 'webone_agency_project_meta_boxes');

function webone_agency_project_meta_callback($post) {
    wp_nonce_field('webone_project_meta', 'webone_project_nonce');
    $category = get_post_meta($post->ID, '_webone_project_category', true);
    $desc = get_post_meta($post->ID, '_webone_project_description', true);
    $tags = get_post_meta($post->ID, '_webone_project_tags', true);
    $bg_color1 = get_post_meta($post->ID, '_webone_project_bg_color1', true) ?: '#1a1a2e';
    $bg_color2 = get_post_meta($post->ID, '_webone_project_bg_color2', true) ?: '#16213e';
    $icon_color = get_post_meta($post->ID, '_webone_project_icon_color', true) ?: '#6366f1';
    ?>
    <p><label><strong>Category</strong><br>
    <input type="text" name="webone_project_category" value="<?php echo esc_attr($category); ?>" style="width:200px;" placeholder="e.g., FinTech, Healthcare"></label></p>
    <p><label><strong>Description</strong><br>
    <textarea name="webone_project_description" rows="2" style="width:100%;"><?php echo esc_textarea($desc); ?></textarea></label></p>
    <p><label><strong>Technologies (comma-separated)</strong><br>
    <input type="text" name="webone_project_tags" value="<?php echo esc_attr($tags); ?>" style="width:100%;" placeholder="React, Node.js, AWS"></label></p>
    <p><strong>Card Background Gradient</strong><br>
    <label>Color 1: <input type="color" name="webone_project_bg_color1" value="<?php echo esc_attr($bg_color1); ?>"></label>
    <label style="margin-left:20px;">Color 2: <input type="color" name="webone_project_bg_color2" value="<?php echo esc_attr($bg_color2); ?>"></label>
    <label style="margin-left:20px;">Icon Color: <input type="color" name="webone_project_icon_color" value="<?php echo esc_attr($icon_color); ?>"></label></p>
    <?php
}

function webone_agency_save_project_meta($post_id) {
    if (!isset($_POST['webone_project_nonce']) || !wp_verify_nonce($_POST['webone_project_nonce'], 'webone_project_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    $fields = array('category', 'description', 'tags', 'bg_color1', 'bg_color2', 'icon_color');
    foreach ($fields as $f) {
        if (isset($_POST['webone_project_' . $f])) {
            update_post_meta($post_id, '_webone_project_' . $f, sanitize_text_field($_POST['webone_project_' . $f]));
        }
    }
}
add_action('save_post_webone_project', 'webone_agency_save_project_meta');

function webone_agency_get_projects() {
    $posts = get_posts(array('post_type' => 'webone_project', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC', 'post_status' => 'publish'));
    $projects = array();
    foreach ($posts as $p) {
        $projects[] = array(
            'title' => $p->post_title,
            'category' => get_post_meta($p->ID, '_webone_project_category', true),
            'description' => get_post_meta($p->ID, '_webone_project_description', true),
            'tags' => array_map('trim', explode(',', get_post_meta($p->ID, '_webone_project_tags', true))),
            'bg_color1' => get_post_meta($p->ID, '_webone_project_bg_color1', true) ?: '#1a1a2e',
            'bg_color2' => get_post_meta($p->ID, '_webone_project_bg_color2', true) ?: '#16213e',
            'icon_color' => get_post_meta($p->ID, '_webone_project_icon_color', true) ?: '#6366f1',
        );
    }
    return $projects;
}

// =========================================================================
// TEAM MEMBERS CUSTOM POST TYPE
// =========================================================================

function webone_agency_register_team_post_type() {
    register_post_type('webone_team', array(
        'labels' => array(
            'name' => 'Team',
            'singular_name' => 'Team Member',
            'add_new' => 'Add Team Member',
            'add_new_item' => 'Add New Team Member',
            'edit_item' => 'Edit Team Member',
            'all_items' => 'All Team Members',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 28,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'webone_agency_register_team_post_type');

function webone_agency_team_meta_boxes() {
    add_meta_box('webone_team_details', 'Team Member Details', 'webone_agency_team_meta_callback', 'webone_team', 'normal', 'high');
}
add_action('add_meta_boxes', 'webone_agency_team_meta_boxes');

function webone_agency_team_meta_callback($post) {
    wp_nonce_field('webone_team_meta', 'webone_team_nonce');
    $role = get_post_meta($post->ID, '_webone_team_role', true);
    $bio = get_post_meta($post->ID, '_webone_team_bio', true);
    $initials = get_post_meta($post->ID, '_webone_team_initials', true);
    $color1 = get_post_meta($post->ID, '_webone_team_color1', true) ?: '#6366f1';
    $color2 = get_post_meta($post->ID, '_webone_team_color2', true) ?: '#8b5cf6';
    $linkedin = get_post_meta($post->ID, '_webone_team_linkedin', true);
    $github = get_post_meta($post->ID, '_webone_team_github', true);
    $twitter = get_post_meta($post->ID, '_webone_team_twitter', true);
    ?>
    <p><label><strong>Role/Position</strong><br>
    <input type="text" name="webone_team_role" value="<?php echo esc_attr($role); ?>" style="width:300px;" placeholder="e.g., Founder & Lead Developer"></label></p>
    <p><label><strong>Bio</strong><br>
    <textarea name="webone_team_bio" rows="3" style="width:100%;"><?php echo esc_textarea($bio); ?></textarea></label></p>
    <p><label><strong>Avatar Initials (2 characters)</strong><br>
    <input type="text" name="webone_team_initials" value="<?php echo esc_attr($initials); ?>" maxlength="2" style="width:60px;"></label></p>
    <p><strong>Avatar Gradient Colors</strong><br>
    <label>Color 1: <input type="color" name="webone_team_color1" value="<?php echo esc_attr($color1); ?>"></label>
    <label style="margin-left:20px;">Color 2: <input type="color" name="webone_team_color2" value="<?php echo esc_attr($color2); ?>"></label></p>
    <p><strong>Social Links</strong><br>
    <label>LinkedIn: <input type="url" name="webone_team_linkedin" value="<?php echo esc_url($linkedin); ?>" style="width:250px;"></label><br>
    <label>GitHub: <input type="url" name="webone_team_github" value="<?php echo esc_url($github); ?>" style="width:250px;"></label><br>
    <label>Twitter/X: <input type="url" name="webone_team_twitter" value="<?php echo esc_url($twitter); ?>" style="width:250px;"></label></p>
    <?php
}

function webone_agency_save_team_meta($post_id) {
    if (!isset($_POST['webone_team_nonce']) || !wp_verify_nonce($_POST['webone_team_nonce'], 'webone_team_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    $text_fields = array('role', 'bio', 'initials', 'color1', 'color2');
    foreach ($text_fields as $f) {
        if (isset($_POST['webone_team_' . $f])) {
            update_post_meta($post_id, '_webone_team_' . $f, sanitize_text_field($_POST['webone_team_' . $f]));
        }
    }
    $url_fields = array('linkedin', 'github', 'twitter');
    foreach ($url_fields as $f) {
        if (isset($_POST['webone_team_' . $f])) {
            update_post_meta($post_id, '_webone_team_' . $f, esc_url_raw($_POST['webone_team_' . $f]));
        }
    }
}
add_action('save_post_webone_team', 'webone_agency_save_team_meta');

function webone_agency_get_team() {
    $posts = get_posts(array('post_type' => 'webone_team', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC', 'post_status' => 'publish'));
    $team = array();
    foreach ($posts as $p) {
        $team[] = array(
            'name' => $p->post_title,
            'role' => get_post_meta($p->ID, '_webone_team_role', true),
            'bio' => get_post_meta($p->ID, '_webone_team_bio', true),
            'initials' => get_post_meta($p->ID, '_webone_team_initials', true),
            'color1' => get_post_meta($p->ID, '_webone_team_color1', true) ?: '#6366f1',
            'color2' => get_post_meta($p->ID, '_webone_team_color2', true) ?: '#8b5cf6',
            'linkedin' => get_post_meta($p->ID, '_webone_team_linkedin', true),
            'github' => get_post_meta($p->ID, '_webone_team_github', true),
            'twitter' => get_post_meta($p->ID, '_webone_team_twitter', true),
        );
    }
    return $team;
}

// =========================================================================
// THEME OPTIONS PAGE
// =========================================================================

function webone_agency_theme_options_menu() {
    add_theme_page('Theme Options', 'Theme Options', 'manage_options', 'webone-options', 'webone_agency_theme_options_page');
}
add_action('admin_menu', 'webone_agency_theme_options_menu');

function webone_agency_register_settings() {
    register_setting('webone_options', 'webone_options', 'webone_agency_sanitize_options');
}
add_action('admin_init', 'webone_agency_register_settings');

function webone_agency_sanitize_options($input) {
    return $input; // Basic sanitization, can be enhanced
}

function webone_agency_get_option($key, $default = '') {
    $options = get_option('webone_options', array());
    return isset($options[$key]) && $options[$key] !== '' ? $options[$key] : $default;
}

function webone_agency_theme_options_page() {
    if (!current_user_can('manage_options')) return;
    $options = get_option('webone_options', array());
    ?>
    <div class="wrap">
        <h1>WebOne Theme Options</h1>
        <form method="post" action="options.php">
            <?php settings_fields('webone_options'); ?>
            
            <style>
                .webone-options-section { background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; border-radius: 4px; }
                .webone-options-section h2 { margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #eee; }
                .webone-options-section h3 { margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee; }
                .webone-options-section label { display: block; margin: 15px 0 5px; font-weight: 600; }
                .webone-options-section input[type="text"], .webone-options-section input[type="email"], .webone-options-section input[type="url"], .webone-options-section textarea { width: 100%; max-width: 600px; }
                .webone-options-section textarea { height: 80px; }
                .webone-stat-row { display: flex; gap: 20px; margin-bottom: 10px; }
                .webone-stat-row input { width: 100px; }
                .webone-stat-row input:last-child { width: 200px; }
            </style>

            <!-- HERO SECTION -->
            <div class="webone-options-section">
                <h2>🚀 Hero Section</h2>
                <label>Badge Text</label>
                <input type="text" name="webone_options[hero_badge]" value="<?php echo esc_attr($options['hero_badge'] ?? '🚀 Trusted by 80+ Companies Worldwide'); ?>">
                
                <label>Title (use &lt;span class="wa-gradient-text"&gt; for gradient text)</label>
                <input type="text" name="webone_options[hero_title]" value="<?php echo esc_attr($options['hero_title'] ?? 'We Build <span class=\"wa-gradient-text\">Digital Products</span> That Matter'); ?>">
                
                <label>Subtitle</label>
                <textarea name="webone_options[hero_subtitle]"><?php echo esc_textarea($options['hero_subtitle'] ?? 'A team of passionate developers, designers, and strategists crafting exceptional software solutions that transform businesses and delight users.'); ?></textarea>
                
                <label>Primary Button Text</label>
                <input type="text" name="webone_options[hero_btn1_text]" value="<?php echo esc_attr($options['hero_btn1_text'] ?? 'Explore Our Services'); ?>">
                
                <label>Primary Button Link</label>
                <input type="text" name="webone_options[hero_btn1_link]" value="<?php echo esc_attr($options['hero_btn1_link'] ?? '#services'); ?>">
                
                <label>Secondary Button Text</label>
                <input type="text" name="webone_options[hero_btn2_text]" value="<?php echo esc_attr($options['hero_btn2_text'] ?? 'Start a Project'); ?>">
                
                <label>Secondary Button Link</label>
                <input type="text" name="webone_options[hero_btn2_link]" value="<?php echo esc_attr($options['hero_btn2_link'] ?? '#contact'); ?>">
                
                <label>Tech Stack Text</label>
                <input type="text" name="webone_options[hero_tech]" value="<?php echo esc_attr($options['hero_tech'] ?? 'Powered by: React • Node.js • AWS • Flutter • Python • PostgreSQL'); ?>">
            </div>

            <!-- SERVICES SECTION HEADER -->
            <div class="webone-options-section">
                <h2>🔨 Services Section</h2>
                <p><em>Individual services are managed at Admin → Services</em></p>
                
                <label>Section Label</label>
                <input type="text" name="webone_options[services_label]" value="<?php echo esc_attr($options['services_label'] ?? 'What We Do'); ?>">
                
                <label>Section Title (use &lt;span class="wa-gradient-text"&gt; for gradient)</label>
                <input type="text" name="webone_options[services_title]" value="<?php echo esc_attr($options['services_title'] ?? 'Services That <span class=\"wa-gradient-text\">Drive Growth</span>'); ?>">
                
                <label>Section Description</label>
                <textarea name="webone_options[services_description]"><?php echo esc_textarea($options['services_description'] ?? 'From concept to deployment, we deliver end-to-end solutions tailored to your unique business needs.'); ?></textarea>
            </div>

            <!-- PROJECTS SECTION HEADER -->
            <div class="webone-options-section">
                <h2>📁 Projects Section</h2>
                <p><em>Individual projects are managed at Admin → Projects</em></p>
                
                <label>Section Label</label>
                <input type="text" name="webone_options[projects_label]" value="<?php echo esc_attr($options['projects_label'] ?? 'Our Work'); ?>">
                
                <label>Section Title</label>
                <input type="text" name="webone_options[projects_title]" value="<?php echo esc_attr($options['projects_title'] ?? 'Featured <span class=\"wa-gradient-text\">Projects</span>'); ?>">
                
                <label>Section Description</label>
                <textarea name="webone_options[projects_description]"><?php echo esc_textarea($options['projects_description'] ?? 'A selection of our recent work showcasing innovation, design excellence, and technical expertise.'); ?></textarea>
            </div>

            <!-- TEAM SECTION HEADER -->
            <div class="webone-options-section">
                <h2>👥 Team Section</h2>
                <p><em>Individual team members are managed at Admin → Team</em></p>
                
                <label>Section Label</label>
                <input type="text" name="webone_options[team_label]" value="<?php echo esc_attr($options['team_label'] ?? 'Our Team'); ?>">
                
                <label>Section Title</label>
                <input type="text" name="webone_options[team_title]" value="<?php echo esc_attr($options['team_title'] ?? 'Meet the <span class=\"wa-gradient-text\">Experts</span>'); ?>">
                
                <label>Section Description</label>
                <textarea name="webone_options[team_description]"><?php echo esc_textarea($options['team_description'] ?? 'Talented individuals passionate about technology, design, and delivering exceptional results.'); ?></textarea>
            </div>

            <!-- TESTIMONIALS SECTION HEADER -->
            <div class="webone-options-section">
                <h2>⭐ Testimonials Section</h2>
                <p><em>Individual reviews are managed at Admin → Reviews</em></p>
                
                <label>Section Label</label>
                <input type="text" name="webone_options[testimonials_label]" value="<?php echo esc_attr($options['testimonials_label'] ?? 'Testimonials'); ?>">
                
                <label>Section Title</label>
                <input type="text" name="webone_options[testimonials_title]" value="<?php echo esc_attr($options['testimonials_title'] ?? 'What Our <span class=\"wa-gradient-text\">Clients Say</span>'); ?>">
                
                <label>Section Description</label>
                <textarea name="webone_options[testimonials_description]"><?php echo esc_textarea($options['testimonials_description'] ?? "Don't just take our word for it. Here's what our clients have to say about working with us."); ?></textarea>
            </div>

            <!-- STATS SECTION -->
            <div class="webone-options-section">
                <h2>📊 Stats Section</h2>
                <?php for ($i = 1; $i <= 4; $i++) : ?>
                <div class="webone-stat-row">
                    <input type="text" name="webone_options[stat<?php echo $i; ?>_number]" value="<?php echo esc_attr($options['stat' . $i . '_number'] ?? ''); ?>" placeholder="Number (e.g., 150)">
                    <input type="text" name="webone_options[stat<?php echo $i; ?>_suffix]" value="<?php echo esc_attr($options['stat' . $i . '_suffix'] ?? '+'); ?>" placeholder="Suffix" style="width:60px;">
                    <input type="text" name="webone_options[stat<?php echo $i; ?>_label]" value="<?php echo esc_attr($options['stat' . $i . '_label'] ?? ''); ?>" placeholder="Label (e.g., Projects Delivered)">
                </div>
                <?php endfor; ?>
            </div>

            <!-- CONTACT CTA SECTION -->
            <div class="webone-options-section">
                <h2>📞 Contact CTA Section</h2>
                <label>Heading</label>
                <input type="text" name="webone_options[cta_heading]" value="<?php echo esc_attr($options['cta_heading'] ?? 'Ready to Build Something Amazing?'); ?>">
                
                <label>Description</label>
                <textarea name="webone_options[cta_description]"><?php echo esc_textarea($options['cta_description'] ?? "Let's discuss your project and see how we can help bring your ideas to life. Free consultation, no strings attached."); ?></textarea>
                
                <label>Button Text</label>
                <input type="text" name="webone_options[cta_button_text]" value="<?php echo esc_attr($options['cta_button_text'] ?? 'Get in Touch →'); ?>">
            </div>

            <!-- SITE SETTINGS -->
            <div class="webone-options-section">
                <h2>⚙️ Site Settings / Footer</h2>
                <label>Company Name</label>
                <input type="text" name="webone_options[company_name]" value="<?php echo esc_attr($options['company_name'] ?? 'WebOne'); ?>">
                
                <label>Company Tagline</label>
                <textarea name="webone_options[company_tagline]"><?php echo esc_textarea($options['company_tagline'] ?? 'Crafting exceptional digital experiences since 2016. We turn complex ideas into elegant, scalable solutions.'); ?></textarea>
                
                <label>Email</label>
                <input type="email" name="webone_options[company_email]" value="<?php echo esc_attr($options['company_email'] ?? 'hello@webone.agency'); ?>">
                
                <label>Phone</label>
                <input type="text" name="webone_options[company_phone]" value="<?php echo esc_attr($options['company_phone'] ?? '+1 (555) 123-4567'); ?>">
                
                <label>Address</label>
                <input type="text" name="webone_options[company_address]" value="<?php echo esc_attr($options['company_address'] ?? 'San Francisco, CA'); ?>">
                
                <label>Copyright Text</label>
                <input type="text" name="webone_options[copyright_text]" value="<?php echo esc_attr($options['copyright_text'] ?? '© 2024 WebOne Agency. All rights reserved.'); ?>">
                
                <h3>Social Links</h3>
                <label>LinkedIn URL</label>
                <input type="url" name="webone_options[social_linkedin]" value="<?php echo esc_url($options['social_linkedin'] ?? ''); ?>">
                
                <label>GitHub URL</label>
                <input type="url" name="webone_options[social_github]" value="<?php echo esc_url($options['social_github'] ?? ''); ?>">
                
                <label>Twitter/X URL</label>
                <input type="url" name="webone_options[social_twitter]" value="<?php echo esc_url($options['social_twitter'] ?? ''); ?>">
                
                <label>Dribbble URL</label>
                <input type="url" name="webone_options[social_dribbble]" value="<?php echo esc_url($options['social_dribbble'] ?? ''); ?>">
            </div>

            <?php submit_button('Save All Settings'); ?>
        </form>
    </div>
    <?php
}

// =========================================================================
// POPULATE DATABASE WITH DEFAULT CONTENT
// =========================================================================

function webone_agency_populate_default_content() {
    // Only run once
    if (get_option('webone_agency_content_populated')) {
        return;
    }

    // === SERVICES ===
    $services = array(
        array('title' => 'Web Development', 'icon' => '💻', 'description' => 'Full-stack web applications built with React, Vue.js, Node.js, and modern frameworks. Scalable, secure, and performant.'),
        array('title' => 'Mobile Apps', 'icon' => '📱', 'description' => 'Native iOS, Android, and cross-platform apps with React Native. Beautiful interfaces with seamless user experiences.'),
        array('title' => 'UI/UX Design', 'icon' => '🎨', 'description' => 'User-centered design with Figma. Wireframes, prototypes, and design systems that convert visitors into customers.'),
        array('title' => 'Cloud Solutions', 'icon' => '☁️', 'description' => 'AWS, Azure, and GCP architecture. Serverless, microservices, and cloud-native solutions for enterprise scale.'),
        array('title' => 'DevOps', 'icon' => '⚙️', 'description' => 'CI/CD pipelines, Docker, Kubernetes, and infrastructure as code. Automate deployments and scale with confidence.'),
        array('title' => 'AI/ML Solutions', 'icon' => '🤖', 'description' => 'Machine learning models, AI integrations, and intelligent automation. Transform data into actionable insights.'),
    );

    foreach ($services as $index => $service) {
        $post_id = wp_insert_post(array(
            'post_title' => $service['title'],
            'post_type' => 'webone_service',
            'post_status' => 'publish',
            'menu_order' => $index,
        ));
        if ($post_id) {
            update_post_meta($post_id, '_webone_service_icon', $service['icon']);
            update_post_meta($post_id, '_webone_service_description', $service['description']);
        }
    }

    // === PROJECTS ===
    $projects = array(
        array('title' => 'FinTrack Pro', 'category' => 'FinTech', 'description' => 'A comprehensive banking dashboard with real-time analytics, transaction monitoring, and AI-powered insights.', 'tags' => 'React, Node.js, AWS', 'bg_color1' => '#1a1a2e', 'bg_color2' => '#16213e', 'icon_color' => '#6366f1'),
        array('title' => 'HealthSync', 'category' => 'Healthcare', 'description' => 'Healthcare management platform connecting patients, doctors, and pharmacies with secure data sharing.', 'tags' => 'React Native, Python, HIPAA', 'bg_color1' => '#1a2e1a', 'bg_color2' => '#0d3d0d', 'icon_color' => '#10b981'),
        array('title' => 'EcoMarket', 'category' => 'E-Commerce', 'description' => 'Sustainable e-commerce marketplace featuring eco-friendly products with carbon footprint tracking.', 'tags' => 'Next.js, Stripe, PostgreSQL', 'bg_color1' => '#2e1a2e', 'bg_color2' => '#3d1a3d', 'icon_color' => '#8b5cf6'),
        array('title' => 'TravelMate', 'category' => 'Travel', 'description' => 'AI-powered travel companion app with personalized itineraries, booking integration, and local recommendations.', 'tags' => 'React Native, AI/ML, GCP', 'bg_color1' => '#1a2e3d', 'bg_color2' => '#0d3d4d', 'icon_color' => '#22d3ee'),
    );

    foreach ($projects as $index => $project) {
        $post_id = wp_insert_post(array(
            'post_title' => $project['title'],
            'post_type' => 'webone_project',
            'post_status' => 'publish',
            'menu_order' => $index,
        ));
        if ($post_id) {
            update_post_meta($post_id, '_webone_project_category', $project['category']);
            update_post_meta($post_id, '_webone_project_description', $project['description']);
            update_post_meta($post_id, '_webone_project_tags', $project['tags']);
            update_post_meta($post_id, '_webone_project_bg_color1', $project['bg_color1']);
            update_post_meta($post_id, '_webone_project_bg_color2', $project['bg_color2']);
            update_post_meta($post_id, '_webone_project_icon_color', $project['icon_color']);
        }
    }

    // === TEAM MEMBERS ===
    $team = array(
        array('name' => 'Alex Chen', 'role' => 'Founder & Lead Developer', 'bio' => '10+ years building scalable applications. Former tech lead at major startups. Passionate about clean code and mentoring.', 'initials' => 'AC', 'color1' => '#6366f1', 'color2' => '#8b5cf6', 'linkedin' => '#', 'github' => '#', 'twitter' => '#'),
        array('name' => 'Sarah Mitchell', 'role' => 'UI/UX Design Lead', 'bio' => 'Award-winning designer with expertise in user research, prototyping, and design systems. Figma and motion design specialist.', 'initials' => 'SM', 'color1' => '#f472b6', 'color2' => '#8b5cf6', 'linkedin' => '#', 'github' => '', 'twitter' => '#'),
        array('name' => 'Marcus Johnson', 'role' => 'Full-Stack Developer', 'bio' => 'Cloud architecture expert specializing in AWS and Kubernetes. Open source contributor and performance optimization enthusiast.', 'initials' => 'MJ', 'color1' => '#22d3ee', 'color2' => '#6366f1', 'linkedin' => '#', 'github' => '#', 'twitter' => '#'),
        array('name' => 'Emma Williams', 'role' => 'Project Manager', 'bio' => 'PMP certified with agile expertise. Ensures seamless delivery from concept to launch while keeping teams motivated and clients happy.', 'initials' => 'EW', 'color1' => '#10b981', 'color2' => '#22d3ee', 'linkedin' => '#', 'github' => '', 'twitter' => '#'),
    );

    foreach ($team as $index => $member) {
        $post_id = wp_insert_post(array(
            'post_title' => $member['name'],
            'post_type' => 'webone_team',
            'post_status' => 'publish',
            'menu_order' => $index,
        ));
        if ($post_id) {
            update_post_meta($post_id, '_webone_team_role', $member['role']);
            update_post_meta($post_id, '_webone_team_bio', $member['bio']);
            update_post_meta($post_id, '_webone_team_initials', $member['initials']);
            update_post_meta($post_id, '_webone_team_color1', $member['color1']);
            update_post_meta($post_id, '_webone_team_color2', $member['color2']);
            update_post_meta($post_id, '_webone_team_linkedin', $member['linkedin']);
            update_post_meta($post_id, '_webone_team_github', $member['github']);
            update_post_meta($post_id, '_webone_team_twitter', $member['twitter']);
        }
    }

    // === REVIEWS ===
    $reviews = array(
        array('client_name' => 'James Davidson', 'client_position' => 'CEO', 'company_name' => 'TechCorp Industries', 'review_text' => 'The team delivered beyond our expectations. They transformed our outdated platform into a modern, scalable solution that has increased our efficiency by 40%. Highly recommend!', 'star_rating' => '5', 'avatar_initials' => 'JD', 'avatar_color_1' => '#6366f1', 'avatar_color_2' => '#8b5cf6'),
        array('client_name' => 'Lisa Park', 'client_position' => 'Founder', 'company_name' => 'StartupXYZ', 'review_text' => "Exceptional quality and attention to detail. They understood our vision from day one and translated it into a beautiful, functional product. The team's communication was outstanding throughout.", 'star_rating' => '5', 'avatar_initials' => 'LP', 'avatar_color_1' => '#f472b6', 'avatar_color_2' => '#8b5cf6'),
        array('client_name' => 'Michael Roberts', 'client_position' => 'CTO', 'company_name' => 'Enterprise Inc', 'review_text' => "Professional and innovative approach. They didn't just build what we asked for—they challenged our assumptions and delivered something even better. A true technology partner.", 'star_rating' => '5', 'avatar_initials' => 'MR', 'avatar_color_1' => '#22d3ee', 'avatar_color_2' => '#6366f1'),
    );

    foreach ($reviews as $index => $review) {
        $post_id = wp_insert_post(array(
            'post_title' => $review['client_name'] . ' - Review',
            'post_type' => 'webone_review',
            'post_status' => 'publish',
            'menu_order' => $index,
        ));
        if ($post_id) {
            update_post_meta($post_id, '_webone_client_name', $review['client_name']);
            update_post_meta($post_id, '_webone_client_position', $review['client_position']);
            update_post_meta($post_id, '_webone_company_name', $review['company_name']);
            update_post_meta($post_id, '_webone_review_text', $review['review_text']);
            update_post_meta($post_id, '_webone_star_rating', $review['star_rating']);
            update_post_meta($post_id, '_webone_avatar_initials', $review['avatar_initials']);
            update_post_meta($post_id, '_webone_avatar_color_1', $review['avatar_color_1']);
            update_post_meta($post_id, '_webone_avatar_color_2', $review['avatar_color_2']);
        }
    }

    // === THEME OPTIONS ===
    $default_options = array(
        // Hero
        'hero_badge' => '🚀 Trusted by 80+ Companies Worldwide',
        'hero_title' => 'We Build <span class="wa-gradient-text">Digital Products</span> That Matter',
        'hero_subtitle' => 'A team of passionate developers, designers, and strategists crafting exceptional software solutions that transform businesses and delight users.',
        'hero_btn1_text' => 'Explore Our Services',
        'hero_btn1_link' => '#services',
        'hero_btn2_text' => 'Start a Project',
        'hero_btn2_link' => '#contact',
        'hero_tech' => 'Powered by: React • Node.js • AWS • Flutter • Python • PostgreSQL',
        // Services Section
        'services_label' => 'What We Do',
        'services_title' => 'Services That <span class="wa-gradient-text">Drive Growth</span>',
        'services_description' => 'From concept to deployment, we deliver end-to-end solutions tailored to your unique business needs.',
        // Projects Section
        'projects_label' => 'Our Work',
        'projects_title' => 'Featured <span class="wa-gradient-text">Projects</span>',
        'projects_description' => 'A selection of our recent work showcasing innovation, design excellence, and technical expertise.',
        // Team Section
        'team_label' => 'Our Team',
        'team_title' => 'Meet the <span class="wa-gradient-text">Experts</span>',
        'team_description' => 'Talented individuals passionate about technology, design, and delivering exceptional results.',
        // Testimonials Section
        'testimonials_label' => 'Testimonials',
        'testimonials_title' => 'What Our <span class="wa-gradient-text">Clients Say</span>',
        'testimonials_description' => "Don't just take our word for it. Here's what our clients have to say about working with us.",
        // Stats
        'stat1_number' => '150',
        'stat1_suffix' => '+',
        'stat1_label' => 'Projects Delivered',
        'stat2_number' => '80',
        'stat2_suffix' => '+',
        'stat2_label' => 'Happy Clients',
        'stat3_number' => '25',
        'stat3_suffix' => '+',
        'stat3_label' => 'Team Members',
        'stat4_number' => '8',
        'stat4_suffix' => '+',
        'stat4_label' => 'Years Experience',
        // Contact CTA
        'cta_heading' => 'Ready to Build Something Amazing?',
        'cta_description' => "Let's discuss your project and see how we can help bring your ideas to life. Free consultation, no strings attached.",
        'cta_button_text' => 'Get in Touch →',
        // Site Settings
        'company_name' => 'WebOne',
        'company_tagline' => 'Crafting exceptional digital experiences since 2016. We turn complex ideas into elegant, scalable solutions.',
        'company_email' => 'hello@webone.agency',
        'company_phone' => '+1 (555) 123-4567',
        'company_address' => 'San Francisco, CA',
        'copyright_text' => '© 2024 WebOne Agency. All rights reserved.',
        'social_linkedin' => '#',
        'social_github' => '#',
        'social_twitter' => '#',
        'social_dribbble' => '#',
    );

    update_option('webone_options', $default_options);

    // Mark as populated
    update_option('webone_agency_content_populated', true);
}
add_action('after_setup_theme', 'webone_agency_populate_default_content', 20);

// Also run on admin init in case CPTs weren't registered yet
add_action('admin_init', 'webone_agency_populate_default_content', 20);
