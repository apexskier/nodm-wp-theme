<?php
/**
 * Add course content type
 */
function course_register() {
    $labels = array(
        'name' => _x('Courses', 'post type general name'),
        'singular_name' => _x('Course', 'post type singular name'),
        'add_new' => _x('Add New', 'course'),
        'add_new_item' => __('Add New Course'),
        'edit_item' => __('Edit Course'),
        'new_item' => __('New Course'),
        'view_item' => __('View Course'),
        'search_items' => __('Search Courses'),
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

    register_post_type( 'course' , $args );
}
add_action('init', __NAMESPACE__ . '\\course_register');

function course_type_admin_init() {
    add_meta_box("course_meta", "Course Details", "course_meta", "course", "normal", "low");
}
add_action("admin_init", "course_type_admin_init");

function course_color_script(){
    wp_enqueue_script('iris');
}
add_action('admin_enqueue_scripts', 'course_color_script');

function course_save_details() {
    global $post;
    update_post_meta($post->ID, "course_path", $_POST["course_path"]);
    update_post_meta($post->ID, "course_title", $_POST["course_title"]);
    update_post_meta($post->ID, "course_id", $_POST["course_id"]);
    update_post_meta($post->ID, "course_color", $_POST["course_color"]);
    update_post_meta($post->ID, "course_order", $_POST["course_order"]);
}
add_action('save_post', 'course_save_details');

function course_meta() {
    global $post;
    $custom = get_post_custom($post->ID);
    $course_path = $custom["course_path"][0];
    $course_title = $custom["course_title"][0];
    $course_id = $custom["course_id"][0];
    $course_color = $custom["course_color"][0];
    $course_order = $custom["course_order"][0];
    ?>
    <p>
        <input id="upload_image_button" type="button" value="GPS File" class="button" data-uploader_title="Select a GPS File" data-uploader_button_text="Select">
        <input id="course_path" type="text" name="course_path" value="<?php echo $course_path; ?>"> <span id="course_title_text"><?php echo $course_title; ?></span>
        <input id="course_title" type="hidden" name="course_title" value="<?php echo $course_title; ?>">
        <input id="course_id" type="hidden" name="course_id" value="<?php echo $course_id; ?>">
    </p>
    <p>
        <label for="course_color">Color</label><br />
        <input id="course_color" type="text" name="course_color" value="<?php echo $course_color; ?>" style="color: <?php echo $course_color; ?>; border-color: <?php echo $course_color; ?>;">
    </p>
    <p>
        <label for="course_order">Order</label><br />
        <input id="course_order" type="number" name="course_order" value="<?php echo $course_order; ?>" style="color: <?php echo $course_order; ?>; border-color: <?php echo $course_order; ?>;">
    </p>
    <script>
    (function () {
        jQuery(document).ready(function($) {
            // Uploading files
            var file_frame;
            var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
            var set_to_post_id = $('#course_id').val(); // Set this

            $('#upload_image_button').on('click', function(e) {
                e.preventDefault();

                // If the media frame already exists, reopen it.
                if (file_frame) {
                    // Set the post ID to what we want
                    file_frame.uploader.uploader.param('post_id', set_to_post_id);
                    // Open frame
                    file_frame.open();
                    return;
                } else {
                    // Set the wp.media post id so the uploader grabs the ID we want when initialised
                    wp.media.model.settings.post.id = set_to_post_id;
                }

                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: $(this).data('uploader_title'),
                    library: {
                        type: 'application',
                        selection: set_to_post_id
                    },
                    button: { text: $(this).data('uploader_button_text') },
                    multiple: false  // Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                file_frame.on('select', function() {
                    // We set multiple to false so only get one image from the uploader
                    attachment = file_frame.state().get('selection').first().toJSON();

                    // Do something with attachment.id and/or attachment.url here
                    $('#course_path').val(attachment.url);
                    $('#course_title').val(attachment.title);
                    $('#course_id').val(attachment.id);
                    set_to_post_id = attachment.id;
                    $('#course_title_text').text(attachment.title);
                    console.log(attachment);

                    // Restore the main post ID
                    wp.media.model.settings.post.id = wp_media_post_id;
                });

                // Finally, open the modal
                file_frame.open();
            });

            // Restore the main ID when the add media button is pressed
            $('a.add_media').on('click', function() {
                wp.media.model.settings.post.id = wp_media_post_id;
            });

            $('#course_color').iris({
                change: function (e, ui) {
                    var c = ui.color.toString();
                    $('#course_color').css({
                        'border-color': c,
                        'color': c
                    });
                }
            });
        });
    })()
    </script>
    <?php
}

