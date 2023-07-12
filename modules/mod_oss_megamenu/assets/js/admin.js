(function($) {
  $(document).ready(function() {
     // alert('ssss');
    $('body').prepend('<div class="omm-dammy"></div>');//adds emty bar fot it will not be emty on other tabs
    $('.info-labels').next('div').remove();


    //dev vinilla
    var menu = document.getElementById("menu-selected");
    if (menu.value == '' ) {
      var obj = document.getElementById("jform_params_menutype");
      var menuSelected = obj.value;
      $('#menu-selected').val(menuSelected)[0].dispatchEvent(new Event('input'));
    }
    document.getElementById("jform_params_menutype").addEventListener('change', function() {
      $("#confirm-change-menu").fadeIn();
       document.getElementById("confirm-change-menu").display = 'block';
      $('#confirm-change-menu .omm-but-success').click(function(event) {
       $("#confirm-change-menu-reload").fadeIn();
       var str = $('#jform_params_menutype').val();
      $('#menu-selected').val(str)[0].dispatchEvent(new Event('input'));
      setTimeout(function() { 
          $('.button-apply')[0].dispatchEvent(new Event('click'));
      }, 1000);
      });
    });
    $('#confirm-change-menu, #confirm-change-menu .omm-but-cancel, #confirm-change-menu-reload').click(function(event) {
      var str = $('#menu-selected').val();
      $('#jform_params_menutype').val(str);
      $('#confirm-change-menu, #confirm-change-menu-reload').fadeOut();
    });
    //old keep for now rm ------------------
    $('.omm-hidden-selected-out').change(function(event) {
      var str = $(this).val();
      $('.omm-hidden-selected-in').val(str);
    });
    //save rm 
    $('.omi-dang, .omi-conf').click(function(event) { //TODO not work
      // alert('Clicked Triger');
      $('.button-apply').trigger('click'); 
    });
    //tabs FOS! -------------------------
    $('.os-tabs li').each(function(index, el) {
      $(this).click(function(event) {
        var d = $(this).data('tab-index');
        // console.log("d", d);
        $('.os-tabs li, .os-tabs-content li').removeClass('os-active');
        $(this).addClass('os-active');
        $(d).addClass('os-active');
      });    
    });
    //tabs switcher--------------------------------------------------------
/*    $('.omm-cont').click(function(event) {
      var s = $(this).parents('.omm-sub');
      var d = $(this).parents('.omm-item').data('omm-id');
      // console.log("d", d);

      $('.omm-preview-box img', s).hide();
      $('#img-' + d).show();
    });*/
    // console.log("R ------------967");
    //tooltips
    $('label').each(function(index, el) {
      if($(this).attr('data-osstt')) {
        var t = $(this).data('osstt');
        $(this).css('cursor', 'pointer');
        $(this).append(' <i class="omi-tt fas fa-question-circle"></i>');
        $(this).prepend('<div class="oss-tooltip-right">' + t + '</div>');
        $(this).click(function(event) {
          $('.oss-tooltip-right', this).toggle(500);
        });
      }
    });

    //-----------------
    $('.osi-side-toggle').click(function(event) {
      $('#general .col-lg-3').toggle(500);
      $('#general .col-lg-9').toggleClass('col-lg-9-wide');

    });
    //pro highlite
    $('label:contains("pro")').each(function(index, el) {
      // $(this).addClass('onmm-admin-pro-note');//for free
      $(this).prepend('<div class="oss-tooltip-right">Available in Pro Version. This work in backend as a demo, but will not be rendered in frontend</div>');
      $(this).click(function(event) {
        $('.oss-tooltip-right', this).toggle(500);
      });
    });
    $('option:contains("pro")').each(function(index, el) {
      // $(this).addClass('onmm-option-pro');//for free
      $(this).click(function(event) {
        $('.oss-tooltip-right', this).toggle(500);
      });
    });
    //pro note - added after pro highlite  to avoid execute function above
    $('.om-pro-test').each(function(index, el) {
      // alert(42);
      $(this).append(' <span class="om-pro-note">Premium</span>');
      $(this).prepend('<div class="oss-tooltip-right">This is Premium Option. It works in backend as a DEMO, frontend will display default(free) options ONLY</div>');
      $(this).click(function(event) {
        $('.oss-tooltip-right', this).toggle(500);
      });
    });


    $('.omi-mega-note .fa-times').click(function(event) {
      $('.omi-mega-note').remove();
    });
    //EXTRA NEW(FOS) --------------------------------------
    $('.os-modal-click').each(function(index, el) {
      var id = $(this).data('os-modal');
      $(this).click(function(event) {
        $('.os-modal-bg').fadeIn(500);
        $(id).fadeIn(500);
      });
    });
    $('.os-modal-bg, .os-modal-close').click(function(event) {
      $('.os-modal-content, .os-modal-bg').fadeOut(500);
    });
    //remove active
    $('.omm-item').click(function(event) {
      // console.log("check click ");
      $('.omi-tab li').removeClass('os-active');
    });
    // console.log("RC ------------ 1 ");
  /*  $('.omm-item').each(function(index, el) {
      $(this).click(function(event) {
        var p = $(this).parents('.omm-item');
        if($(p).not('.ommi-active')) {
          $('.omm-item').removeClass('ommi-active');
          $(this).toggleClass('ommi-active');
        } else {}
      });
    });*/




  }); //end ready---------------






})(jQuery); //end jquery
