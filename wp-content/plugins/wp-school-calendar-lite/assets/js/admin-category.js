jQuery(document).ready(function($) {
    "use strict";
    
    $('.color-picker').wpColorPicker();
    
    $('#the-list.wpsc-list-table').on('click', '.delete', function(){
        if (confirm(WPSC_Admin.warnDelete)) {
            return true;
        }
        
        return false;
    });
});