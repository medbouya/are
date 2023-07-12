(function($) {
  $(document).ready(function() {
    // alert(43);
    //mobile view
    if($(window).width() < 640) {
      $('.omm-drop').removeClass('osmm-tree-ver').addClass('osmm-accordion');
      $('.omm-sub').removeClass('omm-columns omm-columns-image omm-columns-preview  oms-default oms-auto oms-manual');
    }
    console.log("R ---1");
    //mega initialize
    $('body').mega();
    //remove icons on ul level 3
    $('.omm-mod-menu li li .fa-caret-down').remove(); //Removes arrow in sub
    //add active in click mode
    $('.omm-item').each(function(index, el) {
      $(this).click(function(event) {
        var p = $(this).parents('.omm-item');
        if($(p).not('.ommi-active')) {
          $('.omm-item').removeClass('ommi-active');
          $(this).toggleClass('ommi-active');
        } else {}
      });
    });




    //mobile open
    // alert(420);
    $('.omm-dir').each(function(index, el) {
      var e = $(this);
      $('.omm-mobile-but', this).click(function(event) {
        $('.omm-mobile-offcanvas', el).animate({
          left: 0
        }, 300); //offcanvas
        $('.omm-mobile-slider', el).slideToggle(500); //slider
      });
      //close click outside
      $(document).on('click', function(e) {
        var el = '.omm-mobile-but';
        if(jQuery(e.target).closest(el).length) return;
        $('.omm-mobile-offcanvas').animate({
          left: '-100%'
        }, 300); //offcanvas
        $('.omm-mobile-slider', el).slideToggle(500); //slider//TODO
      });
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
    // click ouside TO CLOSE OPENED IN CLICK MODE
    $(document).on('click',function (e) {
         var el = '.omm-item';
         if ($(e.target).closest(el).length) return;
           $('li').removeClass('ommi-active');
    });
  }); //end ready
  // mega menu 
  $.fn.mega = function() {
      // for grouping
      function buildTree() {
        $('.omm-custon-tree .omm-child').each(function(index, el) {
          var c = $(this).prev('.omm-parent').find('.omm-sub');
          $(this).appendTo(c).show();
        });
      }
      //MULTI COLUMN
      $('.omm-columns').each(function(index, el) {
        $('.omm-sub', this).removeClass('omm-columns');
        $('.omm-sub .omm-sub', this).removeClass('omm-parent');
        var eMain = $(this);
        // alert(42);
        var wP = '';
        var columnWidth = '';
        var w = $(this).data('width'); //submenu width
        var d = $(this).data('columns'); //rm
        var columns = '';



        //GROUPED BY
        //DEFAULT------------------------------
        if($(this).is('.oms-default')) {
          $(this).addClass('omm-column-flex');
          //columns = $('.omm-sub-parent', this).length;
          $('.omm-sub-parent', this).width(w);
          // if single and not level 3
          $('.omm-sub-parent',this).wrap('<div class="omm-column"></div>');
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
          buildTree();
          //wrap to groups 
          $('.omm-group-header', this).each(function(index, el) {
            $(this).wrap('<div class="omm-column"></div>');
          });
          $('li', this).each(function(index, el) {
            var c = $(this).prev('.omm-column');
            $(this).appendTo(c);
          });
          columns = $('.omm-column', this).length;
          $('.omm-column, li', this).width(w);
        }
        //AUTO------------------------------
        if($(this).is('.oms-auto')) {
          buildTree();
          columns = $(this).data('columns');
          $(this).css('column-count', columns);
        }
        //calculated for all typesexept -----------------------------
        columnWidth = w * columns + 20;
        //if single columm remove all calculated width - pure width
        cl_w = w - 4;
        if (columns == 1) {
          columnWidth = w;
          cl_w = w;
        }
        $(this).width(columnWidth);
        $('.omm-column', this).width(cl_w);
      });
      //MULTI COLUMN imsge preview
      $('.omm-columns-image').each(function(index, el) {
        var eMain = $(this);
        // alert(42);
        var wP = '';
        var columnWidth = '';
        var w = $(this).data('width'); //submenu width
        var d = $(this).data('columns'); //rm
        var columns = '';
        buildTree();
        //MANUAL------------------------------
        // if($(this).is('.oms-manual')) {
          // buildTree();
          // 
        $('.omm-child').each(function(index, el) {
          var c = $(this).prev('.omm-parent').find('.omm-sub');
          $(this).appendTo(c).show();
        });
        //wrap to groups 
        $('.omm-group-header', this).each(function(index, el) {
          $(this).wrap('<div class="omm-column"></div>');
        });
        $('li', this).each(function(index, el) {
          var c = $(this).prev('.omm-column');
          $(this).appendTo(c);
        });
        columns = $('.omm-column', this).length;
        $('.omm-column, li', this).width(w);
        var calc = w * (2 / 3);
        $('.omm-column-img',this).height(calc);
        //calculated for all typesexept -----------------------------
        columnWidth = w * columns + 20;
        cl_w = w - 4;
        if (columns == 1) {
          columnWidth = w;
          cl_w = w;
        }
        $(this).width(columnWidth);
        $('.omm-column', this).width(cl_w);

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
      });
      //MULTI COLUMN WITH PREVIW -------------------------------------------------------------------------------
      $('.omm-columns-preview').each(function(index, el) {
        var wP = '';
        var columnWidth = '';
        var eMain = $(this);
        var prevBox = $('.omm-preview-box',this);
        // alert(42);
        var w = $(this).data('width'); //submenu width
        var d = $(this).data('columns'); //rm
        var columns = 1;
        //GROUPED BY
        //DEFAULT----------------------
        if($(this).is('.oms-default')) {
          columns = $('.omm-sub-parent', this).length;
          $('.omm-sub-parent', this).wrapAll('<div class="omm-column-items"></div>');
          $('.omm-sub-parent', this).width(w);
        }
        //MANUAL-----------------------
        if($(this).is('.oms-manual')) {
          buildTree();
          //wrap to groups 
          $('.omm-group-header', this).each(function(index, el) {
            $(this).wrap('<div class="omm-column"></div>');
          });
          $('li', this).each(function(index, el) {
            var c = $(this).prev('.omm-column');
            $(this).appendTo(c);
          });
          columns = $('.omm-column', this).length;
          $('.omm-column', this).wrapAll('<div class="omm-column-items"></div>');
           $('.omm-column, li', this).width(w);
        }
        //AUTO--------------------------
        if($(this).is('.oms-auto')) {
          buildTree();
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
        console.log("d -----------------1");





        //fix to do it in php, not eork there now
        var h = w * (2 / 3);
        $('.omm-preview-box',this).width(w);
        $('.omm-preview-box',this).height(h);
        //img preview
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
        var lp = x + w; //last point of submenu
        if(lp > win) { //if last p far than win
          var left = win - x - w - 40; // value if submenu goes wider than viewport
          $(this).css('left', left + 'px');
        }
      });
      //right correcting
      $('.omm-vertical-right .omm-columns, .omm-vertical-right .omm-columns-preview').each(function(index, el) {
        var w = $(this).width();
        var w = w + 10;
        $(this).css('left', '-' + w + 'px');
      });
    } // mega menu functions END
})(jQuery); //end jquery