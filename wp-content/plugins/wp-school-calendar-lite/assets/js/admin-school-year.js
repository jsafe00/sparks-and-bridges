jQuery(document).ready(function($) {
    "use strict";
    
    var startDate = $('#start-datepicker').datepicker({
        dateFormat: "d MM yy",
        altField  : "#start-datepicker-alt",
        altFormat : "yy-mm-dd",
        showOn    : "button",
        buttonText: WPSC_Admin.datepickerButton
    }).on('change', function(){
        endDate.datepicker("setDate", setDate(this));
        endDate.datepicker("option", "minDate", getMinDate(this));
        endDate.datepicker("option", "maxDate", getMaxDate(this));
    });

    var endDate = $('#end-datepicker').datepicker({
        dateFormat: "d MM yy",
        altField  : "#end-datepicker-alt",
        altFormat : "yy-mm-dd",
        showOn    : "button",
        buttonText: WPSC_Admin.datepickerButton
    });
    
    function getMinDate(element) {
        var date;
        
        try {
            date = $.datepicker.parseDate("d MM yy", element.value);
        } catch( error ) {
            date = null;
        }
 
        return date;
    }
    
    function getMaxDate(element) {
        var date, year, month, day;
        
        try {
            date = $.datepicker.parseDate("d MM yy", element.value);
            
            year = date.getFullYear() + 1;
            month = date.getMonth() + 2;
            
            day = new Date(year, month + 1, 0).getDate();
            date = new Date(year, month, day);
        } catch( error ) {
            date = null;
        }
 
        return date;
    }
    
    function setDate(element) {
        var date, year, month, day;
        
        try {
            date = $.datepicker.parseDate("d MM yy", element.value);

            year = date.getFullYear();
            month = date.getMonth();
            
            if (month > 0) {
                year = year + 1;
                month = month - 1;
            } else {
                month = month + 11;
            }
            
            day = new Date(year, month + 1, 0).getDate();
            date = new Date(year, month, day);
        } catch( error ) {
            date = null;
        }
 
        return date;
    }
    
    try {
        var strStartDate = $('#start-datepicker-alt').val();
        var strEndDate   = $('#end-datepicker-alt').val();
    
        var arrDate = strStartDate.split('-');
        var minDate = new Date(parseInt(arrDate[0]), parseInt(arrDate[1]) - 1, parseInt(arrDate[2]));
        
        var year = parseInt(arrDate[0]) + 1;
        var month = parseInt(arrDate[1]) + 1;

        var day = new Date(year, month + 1, 0).getDate();
        var maxDate = new Date(year, month, day);
        
        $('#start-datepicker').datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", strStartDate));
        
        if (strEndDate !== '') {
            $('#end-datepicker').datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", strEndDate));
        }
        
        $("#end-datepicker").datepicker("option", "minDate", minDate);
        $("#end-datepicker").datepicker("option", "maxDate", maxDate);
    } catch(e) {}
    
    $('#the-list.wpsc-list-table').on('click', '.delete', function(){
        if (confirm(WPSC_Admin.warnDelete)) {
            return true;
        }
        
        return false;
    });
});