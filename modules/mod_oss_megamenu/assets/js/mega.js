(function($) {
  $(document).ready(function() {
    // alert(32);
    $('#app').mega();
  });
   //end ready
  // mega menu 
  $.fn.mega = function() {
   // alert(412);
      // for grouping
      $('.omm-child').each(function(index, el) {
        var c = $(this).prev('.omm-parent').find('.omm-sub');
        $(this).appendTo(c).show();
      });
      //image resize in column img mode
/*      $('.omm-columns-image').each(function(index, el) {
         var im = $('.omm-column-img',this);
         var w = $(im).width();
         var h3 = w * (2 / 3);
         $(im).height(h3);
      });*/
      //add active in click mode
/*      $('.omm-item').each(function(index, el) {
        $(this).click(function(event) {
          var p = $(this).parents('.omm-item');
          if($(p).not('.ommi-active')) {
            $('.omm-item').removeClass('ommi-active');
            $(this).toggleClass('ommi-active');
          } else {}
        });
      });*/

      //MULTI COLUMN
      $('.omm-columns, .omm-columns-image').each(function(index, el) {
        var eMain = $(this);
        // alert(42);
        var w = $(this).data('width'); //submenu width
        var d = $(this).data('columns'); //rm
        var columns = 1;
        //DEFAULT------------------------------
        if($(this).is('.oms-default')) {
          $(this).addClass('omm-column-flex');
          $('.omm-parent', this).each(function(index, el) {
            $(this).wrap('<div class="omm-column"></div>');
          });
          $('li', this).each(function(index, el) {
            var c = $(this).prev('.omm-column');
            $(this).appendTo(c);
          });
          // if single and not level 3
          $('li',this).each(function(index, el) {
            if (! $(this).closest(".omm-column").length ) {
              $(this).addClass('omm-single');
            }
          });
          $('.omm-single',this).wrapAll('<div class="omm-column"></div>');
          columns = $('.omm-column', this).length;
        }

        //MANUAL------------------------------
        if($(this).is('.oms-manual')) {
          $(this).addClass('omm-column-flex');
          //wrap to groups 
          $('.omm-group-header',this).each(function(index, el) {
            $(this).wrap('<div class="omm-column"></div>');
          });
          $('li', this).each(function(index, el) {
            var c = $(this).prev('.omm-column');
            $(this).appendTo(c);
          });
          columns = $('.omm-column', this).length;
        }
        //GROUPED BY
        //AUTO------------------------------
        if($(this).is('.oms-auto')) {
          columns = $(this).data('columns');
          $(this).css('column-count', columns);
        }
        //calculated for all typesexept -----------------------------
        columnWidth = w * columns;
        console.log("w", w);
        columnWidth = columnWidth + 20;
        console.log("columnWidth f2 ", columnWidth);
        cl_w = w - 4;
         //if single columm remove all calculated width - pure width
        if (columns == 1) {
          columnWidth = w;
          cl_w = w;
        }
        $(this).width(columnWidth);
        $('.omm-column', this).width(cl_w);
      });



      //MULTI COLUMN imsge preview
      $('.omm-columns-image').each(function(index, el) {
        $('.omm-column',this).each(function(index, el) {
          var ibox = $('.omm-column-img',this); 
          // $(ibox).css('border', '3px solid #000');
          var def = $(ibox).css('background-image'); 
          $('li',this).each(function(index, el) {
            var src  = $(this).data('img');
            $(this).hover(function() {
              if (src) {
                $(ibox).css('background-image', 'url(' + src + ')');
              }
            }, function() {
              $(ibox).css('background-image', 'url(' + def + ')');
            });
          });
        });
      });
      //MULTI COLUMN WITH PREVIW -------------------------------------------------------------------------------
      $('.omm-columns-preview').each(function(index, el) {
        var eMain = $(el);
        var e = $(el);
        // alert(42);
        var w = $(this).data('width'); //submenu width
        var d = $(this).data('columns'); //rm
        var columns = 1;
        //GROUPED BY
        //DEFAULT----------------------
        if($(this).is('.oms-default')) {
          $('.omm-parent', this).each(function(index, el) {
            $(this).wrap('<div class="omm-column"></div>');
          });
          $('li', this).each(function(index, el) {
            var c = $(this).prev('.omm-column');
            $(this).appendTo(c);
          });
          columns = $('.omm-column', this).length;
          $('.omm-column', this).wrapAll('<div class="omm-column-items"></div>');
          $('.omm-column-items', this).addClass('omm-column-flex');
        }
        //MANUAL-----------------------
        if($(this).is('.oms-manual')) {
          //wrap to groups 
          $('.omm-group-header',this).each(function(index, el) {
            $(this).wrap('<div class="omm-column"></div>');
          });
          $('li', this).each(function(index, el) {
            var c = $(this).prev('.omm-column');
            $(this).appendTo(c);
          });
          columns = $('.omm-column', this).length;
          $('.omm-column', this).wrapAll('<div class="omm-column-items"></div>');
          //$('.omm-column-items', this).addClass('omm-column-flex');
        }
        //AUTO--------------------------
        if($(this).is('.oms-auto')) {
          var items = $('li', this).length;
          columns = $(this).data('columns');
          $('li', this).wrapAll('<div class="omm-column-items"></div>');
          $('.omm-column-items', this).css('column-count', columns);
        }
        //calculated for all types -----------------------------
        columnWidth = w * columns + 10;
        cl_w = w - 4;
        //if single columm remove all calculated width - pure width
        if (columns == 1) {
          columnWidth = w;
          cl_w = w;
        }
        subWidth = columnWidth + w + 30;
        $(this).width(subWidth);
        $('.omm-column-items', this).width(columnWidth);
        $('.omm-column', this).width(cl_w);
        // console.log("d -----------------1");


      //image preview
        $(this).each(function(index, el) {
          var ibox = $('.omm-preview-box',this); 
          var def = $(ibox).css('background-image'); 
          $('li',this).each(function(index, el) {
            var src  = $(this).data('img');
            $(this).hover(function() {
              if (src) {
                $(ibox).css('background-image', 'url(' + src + ')');
              }
            }, function() {
              $(ibox).css('background-image', 'url(' + def + ')');
            });
          });
        });
      });
      //move sub if multicolumn too wide
      $('.omm-columns, .omm-columns-preview').each(function(index, el) {
          //move if overflow page
          var win = $(window).width();
          var p = $(this).parents('li');
          var w = $(this).width();
          var x = $(p).offset().left;
          var lp = x + w;//last point of submenu
          if (lp > win) { //if last p far than win
              var left = win - x - w - 40;// value if submenu goes wider than viewport
              $(this).css('left', left + 'px');
           } 
      }); 
    } // mega menu functions END
})(jQuery); //end jquery