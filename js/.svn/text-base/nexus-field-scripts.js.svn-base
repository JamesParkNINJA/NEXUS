jQuery(document).ready(function($){
    $('.nexusColorPick').wpColorPicker();
    
    $('.nexusUploadBTN').click(function(e) {
        e.preventDefault();
        var imageURL = $(this).attr('data-url'),
            imageSRC = $(this).attr('data-src');
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            //console.log(image_url);
            $('#'+imageSRC).attr('src',image_url);
            $('#'+imageURL).val(image_url);
        });
    });
});