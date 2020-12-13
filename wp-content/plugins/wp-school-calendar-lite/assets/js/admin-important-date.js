jQuery(document).ready(function($) {
    "use strict";
    
    $('.color-picker').wpColorPicker();
    
    var startDate = $('#start-datepicker').datepicker({
        dateFormat: "d MM yy",
        altField  : "#start-datepicker-alt",
        altFormat : "yy-mm-dd",
        showOn    : "button",
        buttonText: WPSC_Admin.datepickerButton
    }).on('change', function(){
        endDate.datepicker("option", "minDate", getDate(this));
    });

    var endDate = $('#end-datepicker').datepicker({
        dateFormat: "d MM yy",
        altField  : "#end-datepicker-alt",
        altFormat : "yy-mm-dd",
        showOn    : "button",
        buttonText: WPSC_Admin.datepickerButton
    });
    
    function getDate(element) {
        var date;
        
        try {
            date = $.datepicker.parseDate("d MM yy", element.value);
        } catch( error ) {
            date = null;
        }
 
        return date;
    }
    
    try {
        var strStartDate = $('#start-datepicker-alt').val();
        var strEndDate   = $('#end-datepicker-alt').val();
    
        var arrDate = strStartDate.split('-');
        var date     = new Date(parseInt(arrDate[0]), parseInt(arrDate[1]) - 1, parseInt(arrDate[2]));
        
        $('#start-datepicker').datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", strStartDate));
        
        if (strEndDate !== '') {
            $('#end-datepicker').datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", strEndDate));
        }
        
        $("#end-datepicker").datepicker("option", "minDate", date);
    } catch(e) {}
});