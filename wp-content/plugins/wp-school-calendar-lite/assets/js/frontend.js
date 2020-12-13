jQuery(document).ready(function($) {
    "use strict";
    
    var load_content = function(school_year_id) {
        var data = { 
            action         : 'wpsc_get_content',
            nonce          : WPSC.nonce,
            school_year_id : school_year_id,
            categories     : $('.wpsc-categories').val()
        };
        
        $.magnificPopup.open({
            items: {
                src: '#wpsc-loading-panel',
                type: 'inline'
            },
            preloader: false,
            modal: true
        });
        
        $.post(WPSC.ajaxurl, data, function(res){
            if (res.success) {
                $('#wpsc-block-calendar').html(res.data.content);
            } else {
                console.log(res);
            }
            $.magnificPopup.close();
        }).fail(function(xhr, textStatus, e) {
            console.log(xhr.responseText);
        });
    };
    
    $(document).on('click', '.wpsc-school-year-menu', function(){
        load_content($(this).attr('data-year'));
        return false;
    });
    
    $(document).on('mouseover', '.wpsc-important-date-tooltip', function(){
        var t = $(this);
        
        if ($(this).is('.tooltipstered')) {
            // do nothing
        } else {
            $(this).tooltipster({
                contentCloning : true,
                contentAsHTML  : true,
                theme          : ['tooltipster-' + t.attr('data-theme'), 'tooltipster-school-calendar'],
                trigger        : t.attr('data-trigger'),
                interactive    : true,
                animation      : t.attr('data-animation'),
                minWidth       : 300,
                maxWidth       : 400,
                content        : '<div class="wpsc-tooltip-loading">' + WPSC.loading + '</div>',
                functionBefore: function(instance, helper) {
                    var $origin = $(helper.origin);
                    if ($origin.data('loaded') !== true) {
                        var data = { 
                            action          : 'wpsc_get_tooltip',
                            nonce           : WPSC.nonce,
                            important_dates : t.attr('data-important-dates')
                        };
        
                        $.post(WPSC.ajaxurl, data, function(res){
                            if (res.success) {
                                instance.content(res.data.tooltip);
                                $origin.data('loaded', true);
                            } else {
                                console.log(res);
                            }
                        }).fail(function(xhr, textStatus, e) {
                            console.log(xhr.responseText);
                        });
                    }
                }
            });
            
            $(this).mouseover();
        }
    });
    
    $(document).on('click', function(e) {
        var target = e.target;
        
        if ($(target).is('.wpsc-toggle-menu') || $(target).parents('.wpsc-toggle-menu-content').length) {
            // Do nothing
        } else {
            $('.wpsc-toggle-menu-content').hide();
        }
    });
    
    $(document).on('click', '.wpsc-toggle-menu', function(){
        var target = $(this).attr('data-target');
        $('.wpsc-toggle-menu-content').not(target).hide();
        $('#wpsc-block-calendar').find(target).toggle();
    });
    
    $(document).on('click', '.wpsc-subscribe-panel-navigation-button-copy', function(){
        var container = $(this).parents('.wpsc-subscribe-panel-container');
        var t = container.find('.wpsc-subscribe-panel-url');
        t.focus();
        t.select();
        document.execCommand('copy');
    });
    
    $(document).on('change', '.wpsc-filter-item', function(){
        var container = $(this).parents('.wpsc-filter-section');
        
        var i = 0;
        
        container.find('.wpsc-filter-item').each(function(){
            if ($(this).is(':checked')) {
                i++;
            }
        });
        
        container.find('.wpsc-filter-num').remove();
        
        if (i > 0) {
            container.find('.wpsc-apply-button').append('<span class="wpsc-filter-num">' + i + '</span>');
        }
    });
    
    $(document).on('click', '.wpsc-apply-button', function(){
        var container = $(this).parents('.wpsc-filter-section');
        var strCategories = [];
        
        container.find('.wpsc-filter-item').each(function(){
            if ($(this).is(':checked')) {
                strCategories.push($(this).val());
            }
        });
        
        $('#wpsc-block-calendar').find('.wpsc-categories').val(strCategories);
        $('.wpsc-filter-section__category-menus').hide();
        load_content($('.wpsc-school-year-id').val());
        
        return false;
    });
    
    $(document).on('click', '.wpsc-download-menu-button', function(){
        $(this).parents('.wpsc-download-menu-item').find('form').submit();
        return false;
    });
    
    $(document).on('click', '.wpsc-clear-filters', function(){
        $('#wpsc-block-calendar').find('.wpsc-categories').val('');
        $('#wpsc-block-calendar').find('.wpsc-filter-selected').hide();
        load_content($('.wpsc-school-year-id').val());
        
        return false;
    });
    
    $(document).on('click', '.wpsc-clear-filter-item', function(){
        var selected = $(this).attr('data-category');
        var strCategories = [];
        
        $('.wpsc-filter-section').find('.wpsc-filter-item').each(function(){
            if ($(this).is(':checked') && $(this).val() !== selected) {
                strCategories.push($(this).val());
            }
        });
        
        $('#wpsc-block-calendar').find('.wpsc-categories').val(strCategories);
        $(this).remove();
        load_content($('.wpsc-school-year-id').val());
        
        return false;
    });
});