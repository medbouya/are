(function($) {
  $(document).ready(function() {
      // alert('ssss');
    $('body').prepend('<div class="omm-dammy"></div>');//adds emty bar fot it will not be emty on other tabs

    $('#app').addMedia();//adds media manager

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
        console.log("d", d);
        $('.os-tabs li, .os-tabs-content li').removeClass('os-active');
        $(this).addClass('os-active');
        $(d).addClass('os-active');
      });    
    });
    //tabs switcher--------------------------------------------------------
    $('.omm-cont').click(function(event) {
      $('.omi-tab li').removeClass('os-active');
    });
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
    //icon filter
/*    $(".oi-icon-filter").keyup(function() {
      // Retrieve the input field text and reset the count to zero
      var filter = $(this).val(),
        count = 0;
      alert("filter", filter);
      // Loop through the comment list
      $(".oi-icon-list label").each(function() {
        // If the list item does not contain the text phrase fade it out
        if($(this).text().search(new RegExp(filter, "i")) < 0) {
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
    });*/
    // open by click to edit ---------------------------
    $('.omm-item').each(function(index, el) {
      $(this).click(function(event) {
        var p = $(this).parents('.omm-item');
        if ($(p).not('.ommi-active')) {
          $('.omm-item').removeClass('ommi-active');
          $(this).toggleClass('ommi-active');
        }else{
        }        
      });
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
      $(this).append(' <span class="om-pro-note">Pro</span>');
      $(this).prepend('<div class="oss-tooltip-right">This Function has Pro Options. It works in backend as a DEMO, frontend will display default(free) options ONLY</div>');
      $(this).click(function(event) {
        $('.oss-tooltip-right', this).toggle(500);
      });
    });
  // re initializing media manager function after DOM changed
  $('.omm-link').each(function(index, el) {
    $(this).click(function(event) {
      $('#app').addMedia();
    });
  });
    //re initializing mega menu when condition(DOM) changed
    $('.osi-trigger').change(function(event) {
      //temp manual relod
      $('.omi-mega-note').slideDown().delay(5000).slideUp(500);
    });
    // $('#app').iconFilter();
    $('.omi-but-save').click(function(event) {
      $('.button-apply').trigger('click');
    });
    $('.omi-mega-note .fa-times').click(function(event) {
      $('.omi-mega-note').remove();
    });
  }); //end ready



  // icon filter
/*  $.fn.iconFilter = function(){
    console.log("filter ON");
    $('.oi-icon-filter').keyup(function(event) {
      var filter = $(this).val();
      console.log("filter", filter);
        var count = 0;
        $('.oi-icon-list label').each(function(index, el) {
              if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(el).fadeOut(500);
              } else {
              $(el).fadeIn(500);
            }
         });
      });*/
/*    var input = document.querySelector('.oi-icon-filter');
    var items = document.querySelector('.oi-icon-list').getElementsByTagName('label');

    input.addEventListener('keyup', function(ev) {
      var text = ev.target.value;
      var pat = new RegExp(text, 'i');
      for (var i=0; i < items.length; i++) {
        var item = items[i];
        if (pat.test(item.innerText)) {
          item.classList.remove("oss-hidden");
        }
        else {console.log(item);
          item.classList.add("oss-hidden");
        }
      }
    });
  }*/
  



  // function to add images using media manager in iframe
  $.fn.addMedia = function() {
    $('.os-media-manager').each(function(index, el) {
      var e = $(this);
      var managerSelectors = $('.os-image-modal-bg, .os-media, .os-image-select-buttons',e);
      // var managerSelectors = $('.os-image-modal-bg, #os-media, .os-image-select-buttons');//TODO single iframe
      $('.os-media-manager-select',e).click(function(event) {
        // func add value from iframe -------------
        function getVal(){
          // var inp = $('#' + id);
          var inp = $('.os-img-selected',e);
           $('.os-img-select').click(function(event) { 
             var str = $('iframe',e).contents().find('.selected .image-cropped').css('background-image');//TODO single iframe
             if (typeof str === 'undefined') {     
               str = '';
               alert('Not Selected')
             } else {              
                str = str.replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
                $(inp).val(str)[0].dispatchEvent(new Event('input'));
                $('.os-image-modal-bg').fadeOut(300);
                $(managerSelectors).fadeOut(300);
             }
           }); 
        }// func add value from iframe END -------------
        if ($('iframe',e).length) {
          $('.os-image-modal-bg').fadeIn();
          $(managerSelectors).fadeIn();
          getVal();
        } else {
          $('.os-image-modal-bg').fadeIn();
          var iframe = document.createElement('iframe');
          iframe.onload = function() { 
            $(managerSelectors).fadeIn();
            getVal();
          }
          iframe.src = 'index.php?option=com_media&view=media&tmpl=component&mediatype&path=local-images:/'; 
          document.querySelector('.os-media',e).appendChild(iframe);//TODO single iframe
        }
        //close media manager
         $('.os-image-modal-bg, .os-img-cancel').click(function(event) {
              $('.os-image-modal-bg').fadeOut(300);
              $(managerSelectors).fadeOut(300);
         });
      });
    });
  }//end func addMedia







// mega menu functions as single function for re initializing when condition changed  TODO
 $.fn.mega = function() {
    // for grouping
    $('.omm-child').each(function(index, el) {
           var c = $(this).prev('.omm-parent').find('.omm-sub');
           $(this).appendTo(c).show();
           
      });
    

      //MULTI COLUMN
      $('.omm-columns').each(function(index, el) {
        var eMain = $(this);
        // alert(42);
        var w = $(this).data('width'); //submenu width
        var d = $(this).data('columns');//rm
        var columns = 1;

         //GROUPED BY
         
         //AUTO----------------------------------------------------------------------------------
         if ($(this).is('.oms-auto')) {
          console.log("grouped AUTO");
          columns = $(this).data('columns');
          console.log("olumns", columns);
         }






         //MANUAL----------------------------------------------------------------------------------
         if ($(this).is('.oms-manual')) {
          console.log("grouped MANUAL");
          //wrap to groups 
          $('.omm-group-header').each(function(index, el) {
            $(this).wrap('<div class="omm-column"></div>');
          });
           $('li',this).each(function(index, el) {
             var c = $(this).prev('.omm-column');
             $(this).appendTo(c);
           });
          columns = $('.omm-column',this).length;
         }





         //DEFAULT----------------------------------------------------------------------------------
         if ($(this).is('.oms-default')) {
          console.log("grouped DEFAULT");
          $('.omm-parent',this).each(function(index, el) {
            $(this).wrap('<div class="omm-column"></div>');
          });
           $('li',this).each(function(index, el) {
             var c = $(this).prev('.omm-column');
             $(this).appendTo(c);
           });
           columns = $('.omm-column',this).length;
         }
         //calculated for all types -----------------------------
         console.log("columns", columns);
         columnWidth = w * columns;
         console.log("w", w);
         console.log("columnWidth", columnWidth);
         $(this).width(columnWidth);
         $(this).css('column-count', columns);
      });








      //MULTI COLUMN WITH PREVIW -----------------------------------------------------------
      $('.omm-columns-preview').each(function(index, el) {
        var eMain = $(this);
        // alert(42);
        var w = $(this).data('width'); //submenu width
        var d = $(this).data('columns');//rm
        var columns = 1;

         //GROUPED BY
         



         //AUTO----------------------------------------------------------------------------------
         if ($(this).is('.oms-auto')) {
          console.log("grouped AUTO");
          var items = $('li',this).length;
          // columns = items / d;//floating nomber
          // columns = Math.ceil(columns); //whole nomber to bigger 
          columns = $(this).data('columns');
          console.log("olumns", columns);
          $('li',this).wrapAll('<div class="omm-column-items"></div>');
         }






         //MANUAL----------------------------------------------------------------------------------
         if ($(this).is('.oms-manual')) {
          console.log("grouped MANUAL");
          //wrap to groups 
          $('.omm-group-header').each(function(index, el) {
            $(this).wrap('<div class="omm-column"></div>');
          });
           $('li',this).each(function(index, el) {
             var c = $(this).prev('.omm-column');
             $(this).appendTo(c);
           });
          columns = $('.omm-column',this).length;
          $('.omm-column',this).wrapAll('<div class="omm-column-items"></div>');
         }





         //DEFAULT----------------------------------------------------------------------------------
         if ($(this).is('.oms-default')) {
          console.log("grouped DEFAULT");
          $('.omm-parent',this).each(function(index, el) {
            $(this).wrap('<div class="omm-column"></div>');
          });
           $('li',this).each(function(index, el) {
             var c = $(this).prev('.omm-column');
             $(this).appendTo(c);
           });
           columns = $('.omm-column',this).length;
           $('.omm-column',this).wrapAll('<div class="omm-column-items"></div>');
         }
         //calculated for all types -----------------------------
         console.log("columns", columns);
         columnWidth = w * columns;
         console.log("w", w);
         console.log("columnWidth", columnWidth);
         subWidth = columnWidth + w;
         $(this).width(subWidth);
         $('.omm-column-items', this).width(columnWidth);
         $('.omm-column-items', this).css('column-count', columns);

          console.log("subWidth", subWidth);
        //img preview
        $('li',this).each(function(index, el) {
          var d = $(this).data('omm-id');
          $('img',this).appendTo('.omm-preview-box',eMain);
            if ($('#img-' + d).length) {
              $(this).hover(function() {
                $('.omm-preview-box img',eMain).hide();
                $('#img-' + d).show();
              }, function() {
                $('#img-' + d).hide();
                $('.omm-preview-box .omm-preview-default',eMain).show();
              });   
            }
        });
      });
    } //END
  // mega menu functions END
})(jQuery); //end jquery

// var trig = document.getElementsByClassName('osi-trigger');

/*document.getElementsByClassName('osi-trigger').addEventListener('change',function(){
   console.log("changed!!!!"); 
});*/

// document.getElementById("osi-trigger").onchange = function() { console.log("Changed!"); }