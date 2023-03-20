$(function() {
    var current_route = $('meta[name=route]').attr('content');
    
    var nav_links = $(".sidebar-menu a");
    var nav_link_item = $(".treeview-item > a");
    var loading_wrapper = $('.loading-wrapper');
    var pagination = $('.pagination');
    var select2 = $('.select2');
    var icheck_green = $('input[type="checkbox"].flat-red');
    var icheck_minimal = $('input[type="checkbox"].minimal');

    // Make link in navigation active
    nav_links.each(function(i, value) {
        var link = $(value);
        var link_names = link.data('name');
        

        if(typeof link_names != "undefined") {
            
            if(link_names.split('|').indexOf(current_route) > -1) {
                link.parent('li').addClass('active');
                link.parents('.treeview').addClass('menu-open');
                link.parents('.treeview-menu').css('display', 'block');
            }
        }
    });

    // nav_link_item.click(function(){
    //     $('.treeview-menu-item').slideToggle();
    // });

    // if ($('.treeview-menu-item > li').hasClass('active')) {
    //     $('.treeview-menu-item').css('display','block');
    // }

    // Make pagination small
    pagination.addClass('pagination-sm no-margin');

    // All select2
    select2.select2({ width: '100%' });

    // All icheck
    icheck_green.iCheck({
        checkboxClass: 'icheckbox_flat-green'
    });

    icheck_minimal.iCheck({
        checkboxClass: 'icheckbox_minimal-blue'
    });

    // For table select all
    $('.checkbox-all').on('ifChecked', function() {
        $('.checkbox-item').iCheck('check');
        $('.checkbox-all').iCheck('check');
    });

    $('.checkbox-all').on('ifUnchecked', function() {
        $('.checkbox-item').iCheck('uncheck');
        $('.checkbox-all').iCheck('uncheck');
    });

    $('.checkbox-item').on('ifToggled', function() {
        var count = $('.checkbox-item:checked').length;

        $('.lbl-selected-rows-count').html(count);

        if(count > 0) {
            $('.btn-delete-selected').removeClass('hide');
            $('.lbl-action').addClass('hide');
        } else {
            $('.btn-delete-selected').addClass('hide');
            $('.lbl-action').removeClass('hide');
        }
    });

    // Hide the loading icon
    loading_wrapper.fadeOut();


    // var height_content = $('.content-wrapper').height();

    // if (height_content <= 1000) {
    //     $('.content-wrapper').addClass("height-900");
    // }

    if ($(window).width() <= 1506) {
        $('.sidebar-mini').addClass("sidebar-collapse");
    }else{
        $('.sidebar-mini').removeClass("sidebar-collapse");
    }


    $('.task-name').click(function(){

        var active = $('.task-items').hasClass("active");

        

        if( active == false ){
            $(this).parent('.task-items').addClass("active");
        } else {
            $('.task-items').removeClass("active");
        }
    });

    
});

