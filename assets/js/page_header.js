jQuery(document).ready(function($) {
    // Add your custom meta field functionality here
    var metaImageFrame;

    // Function to handle the media uploader
    function openMetaImageUploader(event) {
        event.preventDefault();
        const size = $(this).data('size');

        // Create a new media frame
        metaImageFrame = wp.media({
            title: 'Bild auswählen',
            button: {
                text: 'Bild auswählen'
            },
            multiple: false // Set to true if you want to allow multiple image selection
        });

        // When an image is selected, run a callback
        metaImageFrame.on('select', function() {
            var attachment = metaImageFrame.state().get('selection').first().toJSON();
            $('#meta-page-header-image-preview-' + size).attr('src', attachment.url).show();
            $('#meta-page-header-image-' + size).val(attachment.url);
            $('#meta-page-header-image-remove-' + size).show();
        });

        // Open the media frame
        metaImageFrame.open();
    }

    function removeMetaImage(event) {
        event.preventDefault();
        const size = $(this).data('size');
        $('#meta-page-header-image-preview-' + size).attr('src', '').hide();
        $('#meta-page-header-image-' + size).val('');
        $(this).hide();
    }

    // Attach the event listener to the button or element that triggers the media uploader
    $('.open-meta-image-uploader').on('click', openMetaImageUploader);
    $('.remove-meta-image').on('click', removeMetaImage);
});