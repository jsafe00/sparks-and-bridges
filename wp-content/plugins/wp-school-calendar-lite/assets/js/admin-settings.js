jQuery(document).ready(function($) {
    "use strict";
    
    $('.wpsc-select').select2({
        minimumResultsForSearch: Infinity,
        width: "25em"
    });
    
    $('.wpsc-uploader .upload-btn').on('click', function(){
        var media_uploader = null;
        var $el = $( this );
        
        media_uploader = wp.media({
            title: $el.data('choose'),
            library : { type : 'image' },
            multiple: false
        });
        
        media_uploader.on("close", function(){
            try {
                var json = media_uploader.state().get("selection").first().toJSON();
                $el.parents('.wpsc-uploader').find('input').val(json.id);
                $el.parents('.wpsc-uploader').find('.image-preview').html('<img src="' + json.sizes.thumbnail.url + '">');
            } catch(e) {}
        });
        
        media_uploader.open();
    
        return false;
    });
    
    $('.wpsc-uploader .remove-btn').on('click', function(){
        var $el = $( this );
        $el.parents('.wpsc-uploader').find('input').val('');
        $el.parents('.wpsc-uploader').find('.image-preview').html('');
        return false;
    });
    
    $(document).on('click', '.wpsc-settings-nav-tab', function(){
        if ($(this).hasClass('wpsc-settings-nav-tab-upgrade-modal')) {
            $.magnificPopup.open({
                items: {
                    src  : '#wpsc-upgrade-panel',
                    type : 'inline'
                },
                preloader : false,
                modal     : false
            });
        } else {
            var target = $(this).attr('href');
            $('.wpsc-settings-nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            $('.wpsc-settings-page').hide();
            $('#wpsc-settings-' + target.substring(1)).show();
        }
        
        return false;
    });
});