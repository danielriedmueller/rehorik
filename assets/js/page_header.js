jQuery(document).ready(function($) {
    // Add your custom meta field functionality here
    var metaImageFrame;

    // Function to handle the media uploader
    function openMetaImageUploader(event) {
        event.preventDefault();

        // If the media frame already exists, reopen it
        if (metaImageFrame) {
            metaImageFrame.open();
            return;
        }

        // Create a new media frame
        metaImageFrame = wp.media({
            title: 'Select Meta Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false // Set to true if you want to allow multiple image selection
        });

        // When an image is selected, run a callback
        metaImageFrame.on('select', function() {
            var attachment = metaImageFrame.state().get('selection').first().toJSON();
            $('#meta-image-preview').attr('src', attachment.url);
            $('#meta-image-url').val(attachment.url);
        });

        // Open the media frame
        metaImageFrame.open();
    }

    // Attach the event listener to the button or element that triggers the media uploader
    $('#open-meta-image-uploader').on('click', openMetaImageUploader);
});