<?php

// Add admin field for cat video
add_action('product_cat_edit_form_fields', 'wh_taxonomy_edit_meta_field', 10, 1);
add_action('edited_product_cat', 'wh_save_taxonomy_custom_meta', 10, 1);

//Product Cat Edit page
function wh_taxonomy_edit_meta_field($term) {

    //getting term ID
    $term_id = $term->term_id;

    // retrieve the existing value(s) for this meta field.
    $reh_cat_video = get_term_meta($term_id, 'reh_cat_video', true);

    $noVideoText = 'kein Video';
    if (!empty($reh_cat_video)) {
        $exploded = explode('/', wp_get_attachment_url($reh_cat_video));
        $reh_cat_video_name = end($exploded);
    } else {
        $reh_cat_video_name = $noVideoText;
    }

    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="reh_cat_video">Video</label></th>
        <td>
            <div id="reh_cat_video_name"><?= $reh_cat_video_name ?></div>
            <input type="hidden" id="reh_cat_video" name="reh_cat_video" value="<?= $reh_cat_video ?>">
            <button type="button" class="upload_video_button button">Video hochladen</button>
            <button type="button" class="remove_video_button button">Video entfernen</button>
            <script type="text/javascript">

                // Only show the "remove video" button when needed
                if ( '0' === jQuery( '#reh_cat_video' ).val() ) {
                    jQuery( '.remove_video_button' ).hide();
                }

                // Uploading files
                var file_frame;

                jQuery( document ).on( 'click', '.upload_video_button', function( event ) {

                    event.preventDefault();

                    // If the media frame already exists, reopen it.
                    if ( file_frame ) {
                        file_frame.open();
                        return;
                    }

                    // Create the media frame.
                    file_frame = wp.media.frames.downloadable_file = wp.media({
                        title: 'Video auswählen',
                        button: {
                            text: 'Video verwenden'
                        },
                        multiple: false
                    });

                    // When an video is selected, run a callback.
                    file_frame.on( 'select', function() {
                        var attachment = file_frame.state().get( 'selection' ).first().toJSON();
                        jQuery( '#reh_cat_video' ).val( attachment.id );
                        jQuery( '#reh_cat_video_name' ).text(attachment.filename);
                        jQuery( '.remove_video_button' ).show();
                    });

                    // Finally, open the modal.
                    file_frame.open();
                });

                jQuery( document ).on( 'click', '.remove_video_button', function() {
                    jQuery( '#reh_cat_video_name' ).text('<?= $noVideoText ?>');
                    jQuery( '#reh_cat_video' ).val( '' );
                    jQuery( '.remove_video_button' ).hide();
                    return false;
                });

            </script>

        </td>
    </tr>
    <?php
}

// Save extra taxonomy fields callback function.
function wh_save_taxonomy_custom_meta($term_id) {
    $reh_cat_video = filter_input(INPUT_POST, 'reh_cat_video');
    update_term_meta($term_id, 'reh_cat_video', $reh_cat_video);
}