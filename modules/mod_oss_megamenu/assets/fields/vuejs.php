<?php
/**
 * @license     GNU General Public License v2.0
 * @version 1.0.0
 * @author Alexander Green
 * @copyright (C) 2022- OSSKit.Net. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die;
?>
<script>
    class Icon {
      constructor(title) {
        this.title = title;
      }
    }
 
// import Menubar from '../components/menubar/main.vue';
// var dummy ='';
// Vue.component('joomla-toolbar-button', dummy);
var app = new Vue({
    el: '#app',
        data:{
            items:[
            <?php $this->get_items();   ?> 
            ],
            params:{
                menu: 1,
                changeM: false,
                default_class: "def_img",
                mod_1_icon_list: 0,
                mod_2_icon_list: 0,
                tmp: '',
                <?php
                $this->get_param('mid');
                $this->get_param('mobile');
                $this->get_param('type','omm-horizontal');
                $this->get_param('mode','');
                $this->get_param('float','omm-left');
                $this->get_param('dropType','ok-mm-tree');
                $this->get_param('groupBy','oms-default');
                $this->get_param('column',4);
                $this->get_param('dropEffect','omm-fade');
                $this->get_param('topDiv','');
                $this->get_param('topBg','');
                $this->get_param('topCol','');
                $this->get_param('topSubCol','');
                $this->get_param('dropBg','');
                $this->get_param('dropItemBg','');
                $this->get_param('dropCol','');
                $this->get_param('dropSubCol','');
                $this->get_param('imgClip','');
                $this->get_param('hover','omm-default-effect');
                $this->get_param('dropOpen','omm-hover');
                $this->get_param('dropOpenEffect','omm-fade');
                $this->get_param('shadow',' oss-depth-7');
                $this->get_param('dropStyle','omm-dst-boxed');
                $this->get_param('groupBg','');
                $this->get_param('groupCol','');                        
                $this->get_param('default','');
                $this->get_param('previewWidth',200);
                $this->get_param('size','');
                $this->get_param('topHeight','40');
                $this->get_param('subWidth','200');
                $this->get_param('preview_width',200);
                $this->get_param('preview_height',150);
                $this->get_param('tooltipPos','top');
                $this->get_param('extraColors','#9CD6DC');
                $this->get_param('search',false);
                $this->get_param('searchType','modal');
                $this->get_param('mod1',false);
                $this->get_param('mod_1_icon','fas fa-bars');
                $this->get_param('mod1Type','modal');
                $this->get_param('mod2',false);
                $this->get_param('mod2Type','modal');
                $this->get_param('mod_2_icon','fas fa-at');
                $this->get_param('edit_mode',true);
                $this->get_param('msg_edit',true);
                $this->get_param('msg_info',true);
                ?>
                },
                keyword: "",
                tab: 1,
                <?php include 'iconlist.php' ?>
        },
        methods: {

            defImg(i){
                let im = this.items[i].img,//item image
                    imd = this.params.default,//img default for all selected
                     w = 'width:' + this.params.subWidth +'px;',
                     calc = this.params.subWidth * (2 / 3),
                     h = 'height:' + calc + 'px;';
                if( im !=''){
                    return w + h + 'background-image: url(' + im + ')';
                }else{
                    //img default if empty
                    var d = '<?php echo JUri::root() ?>modules/mod_oss_megamenu/assets/images/default.jpg';
                    return w + h + 'background-image: url(' + d + ')';
                }
                     console.log("w", w);
                     console.log("calc", calc);
            },
            columnImg(i){
                let im = this.items[i].img,//item image
                    imd = this.params.default,//img default for all selected TODO
                    calc = this.params.subWidth - 4,
                    w = 'width:' + calc +'px;';
                    calc = this.params.subWidth * (2 / 3),
                    h = 'height:' + calc + 'px;';
                if( im !=''){
                    return w + h + 'background-image: url(' + im + ')';
                }else{
                    //img default for all preset
                    var d = '<?php echo JUri::root() ?>modules/mod_oss_megamenu/assets/images/default.jpg';
                    return w + h + 'background-image: url(' + d + ')';
                }
            }, 
            elImg(i){
                var im = this.items[i].img;
                if( im !=''){
                    return im;
                }else{
                    return '<?php echo JUri::root() ?>modules/mod_oss_megamenu/assets/images/default.jpg';
                }
            }, 
            liEnd(i){
                var e = this.items[i];
                if( e.clsP !=''){
                    return 'parent';
                }
                if(e.clsLastCh !=''){
                    return 'last child';
                }else{
                    return '</li>';
                }
            }, 
            switchTab(n){
                this.editElClose();
                this.tab = n;
            },                                                                                                       
            editElClose() {
            for(let i = 0; i < this.items.length; i++){ 
            this.items[i].edit = false;
            }
            },                                                                                         
            editEl(i) {
                var c = this.items[i].clsCh;
                //edit
                for(let i = 0; i < this.items.length; i++){ 
                    this.items[i].edit = false;
                }
              this.items[i].edit = !this.items[i].edit;
              //dropdown class TOFIX
              var d = this.items[i].drop;
              if (this.params.edit_mode && c!=='omm-child') {
                    for(let i = 0; i < this.items.length; i++){ 
                        this.items[i].drop = false;
                    }
                    if (d !=='ommi-active') {
                        this.items[i].drop = 'ommi-active';
                    } else {
                        this.items[i].drop = false;
                    }
              }   
            },
            //edit mode
            turnOfEditMode(){              
              if (this.params.edit_mode == false) {
                for(let i = 0; i < this.items.length; i++){ 
                    this.items[i].menuActive = false;
                    //for front add move sidebar
                }
              }
            },
            //switch modes edit/preview
            switchMode(){
                this.params.edit_mode=!this.params.edit_mode;
                this.megaR();
            },
            //preview Mode
            dropEffectClass(){              
              if (!this.params.edit_mode) {
                return this.params.dropOpen + ' ' + this.params.dropOpenEffect;
              }
            },
            strData(){
                var str = JSON.stringify(this.items);
                var prm = JSON.stringify(this.params);
                return '{ "items": ' + str + ',"params": ' + prm + '}';
            },
            size(){
                var s = this.params.size;
                if(s !=''){
                    return 'font-size:' + s + 'px';
                }
            },
            itemStyle(){
                var h = this.params.topHeight;
                if(h !=30){
                    return 'height:' + h + 'px';
                }
            },
            subS(i){
                let p ='', l ='', pr = this.params, e = this.items[i];
                if( e.icon !==''){
                    p = 'padding-left:18px;';
                }
                l = pr.topSubCol;
                if( e.clsCh =='omm-child'){
                    l = pr.dropSubCol;
                }
                l = 'color:' + l;
                return p + l;
            },
            dropS(i){//index seems not nessary
                let w ='', b ='', c ='', pr = this.params;
                if( pr.subWidth !=200){
                    w = 'width:' + pr.subWidth + 'px;';
                }
                if( pr.dropBg !==''){
                    b = 'background:' + pr.dropBg + ';';
                }
                if( pr.dropCol !==''){
                    c = 'color:' + pr.dropCol + ';';
                }
                return w + b + c; 
            },
            <?php //v11  ?>
            swittchGroup(){
                let p = this.params;
                if (p.dropType =='omm-columns-image') {
                    p.groupBy = 'oms-manual';
                }
            },



            linkS(i){
                let l ='', pr = this.params, e = this.items[i];              
                //  if marked header and mode manual
                if (this.items[i].clsCh) {
                    if (pr.dropType !== 'ok-mm-tree' && pr.groupBy == 'oms-manual') {
                        if(this.items[i].clsHeader){
                          return 'background:' + this.params.groupBg + ';color:' + this.params.groupCol + ';';
                         }else{
                           return 'background:' + this.params.dropItemBg + ';color:' + this.params.dropCol;
                         }
                    } else {
                         return 'background:' + this.params.dropItemBg + ';color:' + this.params.dropCol;
                    }                   
                 }else{
                    return 'color:' + this.params.topCol;
                 }
 
            },


            activeEl(i){
                //this.items[i].active = !this.items[i].active;//rm
            },
            extraS(){
                let pr = this.params, h = '';
                l = pr.topCol;
                if( pr.topHeight !=40){
                    h = 'height:' + pr.topHeight + 'px;';
                }
                return h + 'color:' + pr.extraColors;
            },
            str(i){
                var t = this.icons[i].ic;
                t = t.replace('fas fa-', '');
                return t;
            },
            badge(i){
                var t = this.items[i].badge;
                var p = window.location.pathname;
                return p;
            },
            imgId(i){
                return 'img-' + this.items[i].id;
            },
            imgInput(i){
                return 'input-' + this.items[i].id;
            },
            previewStyle(){
                return 'width:' + this.params.preview_width + 'px;height:' + this.params.preview_height + 'px';
            },
            previewStyleImg(){
                return 'display:block;width:' + this.params.preview_width + 'px;';
            },
            groupHeader(i) {//dev rm
                let h = this.items[i].clsHeader;
                if(h == true && this.params.groupBy == 'oms-manual'){
                return 'omm-group-header';
                 }
            },
            editItemMode(i) {//dev rm
                let h = this.items[i].clsHeader;
                if(h == true){
                return 'omm-group-header';
                 }
            },
            media(i) {//dev rm
                let ind = this.items[i].id;
                ind = '#input-' + ind;
                //jQuery('body').addMedia(ind);
            },
            megaR(){
                this.params.menu = 0;
                setTimeout(() => this.params.menu = 1, 500);
                jQuery('.omi-mega-note').fadeOut();
                setTimeout(() => {
                jQuery('#app').mega();
                }, 500);
            },

            megaNote(){
            jQuery('.omi-mega-note').fadeIn();
            },


            mediaLoad(i){
            // console.log("mediaLoad Click - index", i);
            var el = this.items[i];
            el.imgInput = true;
            // console.log("SHOW", el.imgInput);
            var managerSelectors = jQuery('.os-media, .os-image-select-buttons');
            jQuery('.os-media').fadeIn();


            jQuery('.os-img-cancel').click(function(event) {
            el.imgInput = false;
            jQuery('.os-media').fadeOut();
            });
            },
            mediaIn(i){
            var el = this.items[i];
            var managerSelectors = jQuery('.os-media, .os-image-select-buttons');
            var sel = jQuery('iframe').contents().find('.media-browser-item');

            var str = jQuery('iframe').contents().find('.selected .image-cropped').css('background-image');//TODO single iframe
            // console.log("str", str);
            str = str.replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
            el.img = str;
            //this.params.tmp = str;
            el.imgInput = false;
            jQuery('.os-media').fadeOut();
            this.megaR();
            },
            mediaCansel(i){
            this.items[i].imgInput = false;
            jQuery('.os-media').fadeOut();
            },
            mediaRemove(i){
            var el = this.items[i];
            this.items[i].img = '';
            },
            colorDelInd(i){
            var el = this.items[i];
            this.items[i].img = '';
            },
            colorDel(m){
            // console.log("model", m);
            var e = 'this.' + m
            // console.log("e", e);
            e == '';
            },





            log: function (evt) {
            // window.// console.log(evt);
            //     (function ($) {
            //       $(document).ready(function () {
            //         //$('#omi-reload').trigger('click').delay(500).trigger('click');
            //         //$('#app').mega();
            //         // console.log("jquery works");
            //       });
            //     })(jQuery);
            },




            
        },
      computed: {
        filteredList() {
          return this.icons.filter((icon) => {
            return icon.ic.toLowerCase().includes(this.keyword.toLowerCase());
          });
        }
      }
        })
</script>