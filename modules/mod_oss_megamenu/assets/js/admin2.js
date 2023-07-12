(function ($) {
    $(document).ready(function () {
        // alert('oss mm script loaded');
        $('body').prepend('<div class="omm-dammy"></div>');
        //pass menu from field app to field osshidden
        $('.omm-hidden-selected-out').change(function(event) {
            var str = $(this).val();
            $('.omm-hidden-selected-in').val(str);
        });
        //save   
        $('.omi-dang, .omi-conf').click(function(event) {//TODO not work
            // alert('Clicked Triger');
            $('.button-apply').trigger('click');
        });
        //tabs switcher
        $('.omi-tab .opt').click(function(event) {
            $('.omi-tab li, .omi-tab-content li').removeClass('omi-active');
            $('.omi-tab .opt, .omi-tab-content .opt').addClass('omi-active');
        });
        $('.omi-tab .style').click(function(event) {
            $('.omi-tab li, .omi-tab-content li').removeClass('omi-active');
            $('.omi-tab .style, .omi-tab-content .style').addClass('omi-active');
        });
        $('.omi-tab .help').click(function(event) {
            $('.omi-tab li, .omi-tab-content li').removeClass('omi-active');
            $('.omi-tab .help, .omi-tab-content .help').addClass('omi-active');
        });
        //submenu appends to parent 
        $('.omm-mod-menu li').each(function(index, el) {
            var pr = $('input',el).val();//parent value
            if(pr > 1){
                $(this).appendTo('#' + pr);
            }
        });
        // open edit form
        $('.omm-link').each(function(index, el) {
            var d = $(this).data('omm');
            $(this).click(function(event) {
                $('.omm-edit').hide();
                $('.cl' + d).show();
            });
        });
        //open icon dropdown??? on vue
        $('.omm-icon-group').each(function(index, el) {
            $('.omm-icon-select',this).click(function(event) {
               $('.oi-icon-list-wrap, .oi-icon-list-wrap-heading',el).slideDown();
            });
            $('.oi-icon-list-wrap label').click(function(event) {
                $('.oi-icon-list-wrap, .oi-icon-list-wrap-heading').slideUp();
            });
        });
        $('.omm-close').click(function(event) {
            $('.omm-edit').hide();
        });
        //tooltips
        $('label').each(function(index, el) {
            if ($(this).attr('data-osstt')) {
                var t = $(this).data('osstt');
                $(this).css('cursor', 'pointer');
                $(this).append(' <i class="omi-tt fas fa-question-circle"></i>');
                $(this).prepend('<div class="oss-tooltip-right">' + t + '</div>');
                $(this).click(function(event) {
                    $('.oss-tooltip-right',this).toggle(500);
                });
            }
        });
        //icon filter
        $(".oi-icon-filter").keyup(function(){
            // Retrieve the input field text and reset the count to zero
            var filter = $(this).val(), count = 0;
            alert("filter", filter);
            // Loop through the comment list
            $(".oi-icon-list label").each(function(){
                // If the list item does not contain the text phrase fade it out
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).fadeOut();
                // Show the list item if the phrase matches and increase the count by 1   
                } else {
                    $(this).show();
                    count++;
                }
            });
            //click to open sub
            $('.omm-item').click(function(event) {
                 $(this).addClass('ommi-show');
            });
  // Update the count
        var numberItems = count;
        $(".oki_filter-count").text(count + " matching results");
    });
/* 
//TODO FOR PREVIEW WITHOUT SAVE   
   ossMenuDropdown();
        $('.osi-change-type').change(function(event) {
            alert('changed');
           ossMenuDropdown();
        });*/
    });//end ready
    function ossMenuDropdown(){
      //TODO FOR PREVIEW WITHOUT SAVE
    }
})(jQuery);//end jquery
