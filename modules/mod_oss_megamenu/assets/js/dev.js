(function ($) {
    $(document).ready(function () {
      $('#app').addMedia();
      // $('#omi-reload').trigger('click').delay(500).trigger('click');

    });//end ready


  $.fn.addMedia = function() {
    $('.os-media-manager').each(function(index, el) {
      var e = $(this);
      var managerSelectors = $('.os-image-modal-bg, #os-media, .os-image-select-buttons');
      $('.os-media-manager-select',e).click(function(event) {
        var id = Math.random().toString(16).slice(2);
        // alert("id", id);
        console.log("id", id);
        function getVal(){
          var inp = $('#' + id);
           $('.os-img-select').click(function(event) { 
             var str = $('#os-media iframe').contents().find('.selected .image-cropped').css('background-image');
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
        }
        $('.os-img-selected').attr('id', id);
        if ($('#os-media iframe').length) {
          console.log("HAS IFRAME");
          $('.os-image-modal-bg').fadeIn();
          $(managerSelectors).fadeIn();
          getVal();
        } else {
          console.log("NO iframe");
          $('.os-image-modal-bg').fadeIn();
          var iframe = document.createElement('iframe');
          iframe.onload = function() { 
            $(managerSelectors).fadeIn();
            getVal();
          }
          iframe.src = 'index.php?option=com_media&view=media&tmpl=component&mediatype&path=local-images:/'; 
          document.getElementById('os-media').appendChild(iframe);
        }
        //close media manager
         $('.os-image-modal-bg, .os-img-cancel').click(function(event) {
              $('.os-image-modal-bg').fadeOut(300);
              $(managerSelectors).fadeOut(300);
         });
      });
    });
  }//end func addMedia





})(jQuery);//end jquery


/*var v = document.getElementsByClassName('field-media-input').value;
console.log('value - ',v);
document.addEventListener(v, function (event) {
  alert('value - ',v);

  console.log('value - ',v);

}, false);*/
