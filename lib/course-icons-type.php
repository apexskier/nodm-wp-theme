<?php
/**
 * Add course icons content type
 */
function course_icons_register() {
    $labels = array(
        'name' => _x('Course Icons', 'post type general name'),
        'singular_name' => _x('Course Icons', 'post type singular name'),
        'add_new' => _x('Add New', 'course_icons'),
        'add_new_item' => __('Add New Course Icons'),
        'edit_item' => __('Edit Course Icons'),
        'new_item' => __('New Course Icons'),
        'view_item' => __('View Course Icons'),
        'search_items' => __('Search Course Iconss'),
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
        'capability_type' => 'page',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'revisions')
    );

    register_post_type( 'course_icons' , $args );
}
add_action('init', __NAMESPACE__ . '\\course_icons_register');

function course_icons_type_admin_init() {
    add_meta_box("course_icons_meta", "Course Icons Details", "course_icons_meta", "course_icons", "normal", "low");
}
add_action("admin_init", "course_icons_type_admin_init");

function course_icons_save_details() {
    global $post;
    update_post_meta($post->ID, "course_icons_path", $_POST["course_icons_path"]);
    update_post_meta($post->ID, "course_icons_title", $_POST["course_icons_title"]);
    update_post_meta($post->ID, "course_icons_id", $_POST["course_icons_id"]);
    update_post_meta($post->ID, "course_icons_icon", $_POST["course_icons_icon"]);
    update_post_meta($post->ID, "course_icons_icon_id", $_POST["course_icons_icon_id"]);
    update_post_meta($post->ID, "course_icons_icon_path", $_POST["course_icons_icon_path"]);
}
add_action('save_post', 'course_icons_save_details');

function course_icons_meta() {
    global $post;
    $custom = get_post_custom($post->ID);
    $course_icons_path = $custom["course_icons_path"][0];
    $course_icons_title = $custom["course_icons_title"][0];
    $course_icons_id = $custom["course_icons_id"][0];
    $course_icons_icon = $custom["course_icons_icon"][0];
    $course_icons_icon_path = $custom["course_icons_icon_path"][0];
    $course_icons_icon_id = $custom["course_icons_icon_id"][0];
    ?>
    <p>
        <input id="upload_geojson_button" type="button" value="GeoJSON File" class="button" data-uploader_title="Select a GeoJSON File" data-uploader_button_text="Select">
        <input id="course_icons_path" type="text" name="course_icons_path" value="<?php echo $course_icons_path; ?>"> <span id="course_icons_title_text"><?php echo $course_icons_title; ?></span>
        <input id="course_icons_title" type="hidden" name="course_icons_title" value="<?php echo $course_icons_title; ?>">
        <input id="course_icons_id" type="hidden" name="course_icons_id" value="<?php echo $course_icons_id; ?>">
    </p>
    <p>
        <input id="upload_icon_button" type="button" value="Icon File" class="button" data-uploader_title="Select an Icon File" data-uploader_button_text="Select">
        <input id="course_icons_icon_path" type="text" name="course_icons_icon_path" value="<?php echo $course_icons_icon_path; ?>">
        <input id="course_icons_icon_id" type="hidden" name="course_icons_icon_id" value="<?php echo $course_icons_icon_id; ?>">
    </p>
    <script>
    (function () {
        jQuery(document).ready(function($) {
            // Uploading files
            var file_frame_geojson;
            var file_frame_icon;
            var set_to_post_id = $('#course_icons_id').val(); // Set this

            $('#upload_geojson_button').on('click', function(e) {
                e.preventDefault();

                // If the media frame already exists, reopen it.
                if (file_frame_geojson) {
                    // Set the post ID to what we want
                    file_frame_geojson.uploader.uploader.param('post_id', set_to_post_id);
                    // Open frame
                    file_frame_geojson.open();
                    return;
                }

                // Create the media frame.
                file_frame_geojson = wp.media.frames.file_frame = wp.media({
                    title: $(this).data('uploader_title'),
                    library: {
                        selection: set_to_post_id
                    },
                    button: { text: $(this).data('uploader_button_text') },
                    multiple: false  // Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                file_frame_geojson.on('select', function() {
                    // We set multiple to false so only get one image from the uploader
                    attachment = file_frame_geojson.state().get('selection').first().toJSON();

                    // Do something with attachment.id and/or attachment.url here
                    $('#course_icons_path').val(attachment.url);
                    $('#course_icons_title').val(attachment.title);
                    $('#course_icons_id').val(attachment.id);
                    set_to_post_id = attachment.id;
                    $('#course_icons_title_text').text(attachment.title);
                });

                // Finally, open the modal
                file_frame_geojson.open();
            });

            $('#upload_icon_button').on('click', function(e) {
                e.preventDefault();

                // If the media frame already exists, reopen it.
                if (file_frame_icon) {
                    // Set the post ID to what we want
                    file_frame_icon.uploader.uploader.param('post_id', set_to_post_id);
                    // Open frame
                    file_frame_icon.open();
                    return;
                }

                // Create the media frame.
                file_frame_icon = wp.media.frames.file_frame = wp.media({
                    title: $(this).data('uploader_title'),
                    library: {
                        selection: set_to_post_id
                    },
                    button: { text: $(this).data('uploader_button_text') },
                    multiple: false  // Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                file_frame_icon.on('select', function() {
                    // We set multiple to false so only get one image from the uploader
                    attachment = file_frame_icon.state().get('selection').first().toJSON();

                    // Do something with attachment.id and/or attachment.url here
                    $('#course_icons_icon_path').val(attachment.url);
                    $('#course_icons_icon_id').val(attachment.id);
                    set_to_post_id = attachment.id;
                });

                // Finally, open the modal
                file_frame_icon.open();
            });
        });
    })()
    </script>
    <?php
}

