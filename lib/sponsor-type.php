<?php
/**
 * Add sponsor content type
 */
function sponsor_register() {
    $labels = array(
        'name' => _x('Sponsors', 'post type general name'),
        'singular_name' => _x('Sponsor', 'post type singular name'),
        'add_new' => _x('Add New', 'sponsor'),
        'add_new_item' => __('Add New Sponsor'),
        'edit_item' => __('Edit Sponsor'),
        'new_item' => __('New Sponsor'),
        'view_item' => __('View Sponsor'),
        'search_items' => __('Search Sponsors'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'query_var' => true,
        // 'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','thumbnail')
    );

    register_post_type( 'sponsor' , $args );
}
add_action('init', __NAMESPACE__ . '\\sponsor_register');

function admin_init() {
    add_meta_box("sponsor_meta", "Sponsor Details", "sponsor_meta", "sponsor", "normal", "low");
}
add_action("admin_init", "admin_init");

function sponsor_meta() {
    global $post;
    $custom = get_post_custom($post->ID);
    $sponsor_url = $custom["sponsor_url"][0];
    $sponsor_level = $custom["sponsor_level"][0];
    ?>
    <p>
        <label for="sponsor_url">Website URL</label><br />
        <input type="text" name="sponsor_url" value="<?php echo $sponsor_url; ?>" placeholder="https://example.com" />
    </p>
    <p>
        <label for="sponsor_level">Level</label><br />
        <input type="number" name="sponsor_level" value="<?php echo $sponsor_level; ?>" min="1" max="5" step="1" />
    </p>
    <?php
}

function save_details() {
    global $post;
    update_post_meta($post->ID, "sponsor_url", $_POST["sponsor_url"]);
    update_post_meta($post->ID, "sponsor_level", $_POST["sponsor_level"]);
}
add_action('save_post', 'save_details');

function sponsor_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type='checkbox' />",
        "title" => "Name",
        "url" => "Website URL",
        "level" => "Level",
    );

    return $columns;
}
function sponsor_custom_columns($column) {
    global $post;

    switch ($column) {
        case "url":
            $custom = get_post_custom();
            echo $custom["sponsor_url"][0];
            break;
        case "level":
            $custom = get_post_custom();
            echo $custom["sponsor_level"][0];
            break;
    }
}
add_action("manage_posts_custom_column",  "sponsor_custom_columns");
add_filter("manage_edit-sponsor_columns", "sponsor_edit_columns");

