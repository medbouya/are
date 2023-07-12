(function ($) {
    $(document).ready(function () {
/*        $('#omi-media').load('index.php?option=com_media&view=media&tmpl=component&mediatype', function() {
        

        }); */ 
        $('body').ossAdmin();

    });//end ready
    $.fn.ossAdmin = function (){
        $('.ok-mm-mega-preview .omm-preview').remove();
        $('.ok-mm-mega-preview li li .omm-preview-admin').remove();

    }

})(jQuery);//end jquery



