<?php
/**
* @license    GNU General Public License v2.0
* @version 1.0.0
* @author Alexander Green
* @copyright (C) 2022- OSSKit.Net. All rights reserved.
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/
defined('_JEXEC') or die; 
?>
<aside class="oss-menu-form">
  <div class="omi-logo"><a href="http://osskit.net" target="_blank"><i class="fas fa-cogs"></i> OSS MegaMenu</a></div>
  <div class="os-tabs os-tabs-left-fixed">
    <ul class="omi-tab"> 
      <li class="os-active" data-tab-index="#omi-config" data-tooltip="Main Option" data-flow="right" @click="switchTab(1)"><i class="fas fa-cogs"></i></li>
      <li class="style" data-tab-index="#omi-style" data-tooltip="Menu Style" data-flow="right" @click="switchTab(2)"><i class="fas fa-palette"></i></li>
      <li class="sub" data-tab-index="#omi-sub" data-tooltip="Dropdown" data-flow="right" @click="switchTab(3)"><i class="far fa-window-maximize"></i></li>
      <li class="extra" data-tab-index="#omi-extra" data-tooltip="Extra Icons" data-flow="right" @click="switchTab(4)"><i class="fas fa-plus-square"></i></li>
      <li class="osi-side-toggle" data-tooltip="<?php echo JText::_('MOD_OSS_TOGGLE_S') ?>" data-flow="right"><i class="fas fa-arrows-alt-h"></i></li>
    </ul>
  </div>
  <ul class="os-tabs-content">
    <li v-if="tab==1" id="omi-config" class="os-active">
      <h3><?php echo JText::_('MOD_OSS_H_M') ?></h3>
      <label><?php echo JText::_('MOD_OSS_OR') ?></label>
      <select v-model="params.type">
        <option value="omm-horizontal">Horizontal</option>
        <option value="omm-vertical-left">Vertical Left</option>
        <option value="omm-vertical-right">Vertical Right</option>
      </select>
      <template v-if="params.type=='omm-horizontal'">
      <label><?php echo JText::_('MOD_OSS_FL') ?></label>
      <select v-model="params.float">
        <option value="omm-left">Left</option>
        <option value="omm-center">Center</option>
        <option value="omm-right">Right</option>
      </select>
      </template>
      <div>
        <label><?php echo JText::_('MOD_OSS_DROPTYPE') ?></label>
        <select v-model="params.dropOpen">
          <option value="omm-hover">Hover</option>
          <option class="omi-premium" value="omm-click">Click(demo - Premium)</option>
        </select>
        <!-- <p class="small-note"><?php echo JText::_('MOD_OSS_NDROP_CLICK') ?></p> -->
        <p v-if="params.dropOpen=='omm-click'" class="small-note"><?php echo JText::_('MOD_OSS_DROPTYPE_N') ?></p>
        <label class="om-pro-tes"><?php echo JText::_('MOD_OSS_DEFFECT') ?></label>
        <select v-model="params.dropOpenEffect" class="om-preview-display">
          <option value="omm-fade">Default</option>
          <option class="omi-premium" value="omm-scale">scale(demo - Premium)</option>
          <option class="omi-premium" value="omm-flip-in">flip-in(demo - Premium)</option>
          <option class="omi-premium" value="omm-slide-fwd">slide-fwd(demo - Premium)</option>
          <option class="omi-premium" value="omm-slide-top-fwd">slide-top-fwd(demo - Premium)</option>
          <option class="omi-premium" value="omm-elliptic">elliptic(demo - Premium)</option>
          <option class="omi-premium" value="omm-bounce">bounce(demo - Premium)</option>
          <option class="omi-premium" value="omm-swing">swing(demo - Premium)</option>
          <option class="omi-premium" value="omm-fade-in-top">fade-in-top(demo - Premium)</option>
          <option class="omi-premium" value="omm-fade-in-bottom">fade-in-bottom(demo - Premium)</option>
          <option class="omi-premium" value="omm-puff-in-hor">puff-in-hor(demo - Premium)</option>
          <option class="omi-premium" value="omm-puff-in-ver">puff-in-ver(demo - Premium)</option>
          <option class="omi-premium" value="omm-tracking">tracking(demo - Premium)</option>
          <option class="omi-premium" value="omm-tracking-top">hovertracking-top (demo - Premium)</option>
          <option class="omi-premium" value="omm-focus-in">focus(demo - Premium)</option>
        </select>
      </div>
      <label><?php echo JText::_('MOD_OSS_HEFFECT') ?></label>
      <select v-model="params.hover">
        <option value="omm-default-effect">Simple Hover</option>
        <option class="omi-premium" value="effect-1">effect-1(demo - Premium)</option>
        <option class="omi-premium" value="effect-2">effect-2(demo - Premium)</option>
        <option class="omi-premium" value="effect-3">effect-3(demo - Premium)</option>
        <!--       TODO  <option class="omi-premium" value="effect-4">effect-4(demo - Premium)</option>
        <option class="omi-premium" value="effect-5">effect-5(demo - Premium)</option>
        <option class="omi-premium" value="effect-6">effect-6(demo - Premium)</option>
        <option class="omi-premium" value="effect-7">effect-7(demo - Premium)</option>
        <option class="omi-premium" value="effect-8">effect-8(demo - Premium)</option>
        <option class="omi-premium" value="effect-9">effect-9(demo - Premium)</option>
        <option class="omi-premium" value="effect-10">effect-10(demo - Premium)</option> -->
      </select>
      <!-- <label><?php echo JText::_('MOD_OSS_SUBTYPE') ?></label> -->
      <label>Mega Dropdown</label>
      <select class="osi-trigger" v-model="params.dropType" @change="megaR(); megaNote(); swittchGroup()">
        <option value="ok-mm-tree">Default</option>
        <option class="omi-premium" value="omm-columns">Mega(demo - Premium)</option>
        <option class="omi-premium" value="omm-columns-image">Mega Preview - Columns(demo - Premium)</option>
        <option class="omi-premium" value="omm-columns-preview">Mega Preview - Panel(demo - Premium)</option>
      </select>


<!-- TODO
      <template v-if="params.dropType=='omm-columns-preview'">
      <label for="st-preview-width">Preview Width- {{params.previewWidth}}.px</label>
      <input id="st-preview-width" type="range" min="150" max="400" step="10" v-model="params.previewWidth">
      </template> -->




      <div v-if="params.dropType=='ok-mm-tree'" class="omi-info-note-side"><?php echo JText::_('MOD_OSS_N_TYPE_TREE') ?></div>
      <div v-if="params.dropType=='omm-columns'" class="omi-info-note-side"><?php echo JText::_('MOD_OSS_N_TYPE_MEGA') ?></div>
      <div v-if="params.dropType=='omm-columns-image'" class="omi-info-note-side"><?php echo JText::_('MOD_OSS_N_TYPE_COLUMN') ?></div>
      <div v-if="params.dropType=='omm-columns-preview'" class="omi-info-note-side"><?php echo JText::_('MOD_OSS_N_TYPE_PREVIEW') ?></div>




      <template v-if="params.dropType!=='ok-mm-tree'">
      <label><?php echo JText::_('MOD_OSS_GROUP_TYPE') ?> <i data-os-modal="#group-help" class="os-modal-click fas fa-question-circle"></i></label>
      <select class="osi-trigger" v-model="params.groupBy" @change="megaR(); megaNote()">
      <template v-if="params.dropType!=='omm-columns-image'">
        <option value="oms-default">Default</option>
        <option class="omi-premium" value="oms-auto">Auto</option>
      </template>
        <option class="omi-premium" value="oms-manual">Manual</option>
      </select>
      <div v-if="params.groupBy=='oms-default'" class="omi-info-note-side"><?php echo JText::_('MOD_OSS_N_ORDER_DEF') ?></div>
      <div v-if="params.groupBy=='oms-auto'" class="omi-info-note-side"><?php echo JText::_('MOD_OSS_N_ORDER_AUTO') ?></div>
      <div v-if="params.groupBy=='oms-manual'" class="omi-info-note-side"><?php echo JText::_('MOD_OSS_N_ORDER_MANUAL') ?></div>
      </template>



      <div class="omi-mega-note omi-reload" @click="megaR()"><i class="fas fa-sync"></i> <?php echo JText::_('MOD_OSS_REBUILD_N') ?></div>
      <?php $this->showReloadNote() ?>
      <template v-if="params.dropType=='omm-columns-preview' || params.dropType=='omm-columns-preview'">
      <label><?php echo JText::_('MOD_OSS_IMG') ?> Default</label>
      
      <?php //$this->media('params.default') ?>
      <!-- <input class="os-img-selected" type="text" v-model="params.default">
      <div class="omi-select-img" @click="media()">Select Image</div> -->
      </template>
      <br><br>
    </li>
    <li v-if="tab==2" id="omi-style">
      <h3><?php echo JText::_('MOD_OSS_H_TS') ?></h3>
      <label><?php echo JText::_('MOD_OSS_THEIGHT') ?>- {{params.topHeight}}px</label>
      <input class="os-img-selected" type="range" min="15" max="100" step="1" v-model="params.topHeight">
      <label data-osstt="<?php echo JText::_('MOD_OSS_NSIZE') ?>">Font Size - {{params.size}}px</label>
      <input class="os-img-selected" type="range" min="10" max="30" step="1" v-model="params.size">
      <label><?php echo JText::_('MOD_OSS_TCOL') ?></label>
      
      <div class="osi-colorpicker" :style="{background: params.topCol}"><colorpicker :color="params.topCol" v-model="params.topCol"/>
      </div>
      <!-- ------ extra style ------------- -->
      <label><?php echo JText::_('MOD_OSS_TBG') ?></label>
      <div class="osi-colorpicker" :style="{background: params.topBg}"><colorpicker :color="params.topBg" v-model="params.topBg" :style="{background: params.topBg}"/></div>
      <label><?php echo JText::_('MOD_OSS_TSUB') ?></label>
      <div class="osi-colorpicker" :style="{background: params.topSubCol}"><colorpicker :color="params.topSubCol" v-model="params.topSubCol"/></div>
      <label><?php echo JText::_('MOD_OSS_TOOLTIP_POS') ?></label>
      <select v-model="params.tooltipPos">
        <option value="top">top</option>
        <option value="bottom">bottom</option>
        <option value="left">left</option>
        <option value="right">right</option>
      </select>
      <div class="dummy-div"></div>
    </li>
    <!-- SUB STYLE ---------------- -->
    <li v-if="tab==3" id="omi-sub">
      <h3><?php echo JText::_('MOD_OSS_H_DS') ?></h3>
      <label><?php echo JText::_('MOD_OSS_DROPSTYLE') ?><br>(some experimental)</label>
      <select v-model="params.dropStyle" @change="megaR()">
        <option value="omm-dst-default">Default</option>
        <option value="omm-dst-boxed">Boxed</option>
        <option value="omm-dst-rounded">Rounded</option>
        <option value="omm-dst-clean">Clean</option>
        <option value="omm-title-underlined">Title Underline</option>
        <option value="omm-desc-boxed">Boxed Description</option>
        <option v-if="params.dropType!==ok-mm-tree" value="omm-dst-cards">Card Colums</option>
      </select>
      <label><?php echo JText::_('MOD_OSS_MBG') ?> - {{params.subWidth}}px</label></i>
      <input type="range" min="120" max="340" step="10" v-model="params.subWidth" @change="megaNote()">
      <div class="omi-mega-note omi-reload" @click="megaR()"><i class="fas fa-sync"></i> <?php echo JText::_('MOD_OSS_REBUILD_N') ?></div>
      <label><?php echo JText::_('MOD_OSS_DSTYLE') ?></label>
      <select v-model="params.shadow">
        <option value="omm-simple-border">Simple Border</option>
        <option value="oku-rounded">Rounded</option>
        <option value="oku-rounded-05">Rounded Shadow</option>
        <option value="z-depth-default">Shadow Soft</option>
        <option value="z-depth-05">Shadow Tiny</option>
        <option value="z-depth-1">Shadow Depth-1</option>
        <option value="z-depth-2">Shadow Depth-2</option>
        <option value="z-depth-3">Shadow Depth-3</option>
        <option value="oss-depth-4">Shadow Depth-4</option>
        <option value="oss-depth-5">Shadow Depth-5</option>
        <option value="oss-depth-6">Shadow Depth-6</option>
        <option value="oss-depth-7">Shadow Depth-7</option>
      </select>
      <label><?php echo JText::_('MOD_OSS_DBG') ?></label>
      <div class="osi-colorpicker" :style="{background: params.dropBg}"><colorpicker :color="params.dropBg" v-model="params.dropBg"/></div>

      <template v-if="ok-mm-tree!=='ok-mm-tree' && params.groupBy=='oms-manual'">
      <label><?php echo JText::_('MOD_OSS_GROUPHEADING') ?></label>
      <div class="osi-colorpicker" :style="{background: params.groupBg}"><colorpicker :color="params.groupBg" v-model="params.groupBg"/></div>
      <label><?php echo JText::_('MOD_OSS_GROUPHEADINGCOL') ?></label>
      <div class="osi-colorpicker" :style="{background: params.groupCol}"><colorpicker :color="params.groupCol" v-model="params.groupCol"/></div>
      </template>


      <label><?php echo JText::_('MOD_OSS_DROPLINKBG') ?></label>
      <div class="osi-colorpicker" :style="{background: params.dropItemBg}"><colorpicker :color="params.dropItemBg" v-model="params.dropItemBg"/></div>
      <label><?php echo JText::_('MOD_OSS_DLINKCOL') ?></label>
      <div class="osi-colorpicker" :style="{background: params.dropCol}"><colorpicker :color="params.dropCol" v-model="params.dropCol"/></div>
      <label><?php echo JText::_('MOD_OSS_DSUBCOL') ?></label>
      <div class="osi-colorpicker omi-sidebar-last" :style="{background: params.dropSubCol}"><colorpicker :color="params.dropSubCol" v-model="params.dropSubCol"/></div>
      </li>
      <!-- //EXTRAS ------------- -->
      <li v-if="tab==4" id="omi-extra">
      <h3><?php echo JText::_('MOD_OSS_H_E') ?></h3>
        <p class="omi-premium"><?php echo JText::_('MOD_OSS_N_EXTRAPRO') ?>(demo only)</p>
        <template v-if="params.type!=='omm-horizontal'">
        <p><?php echo JText::_('MOD_OSS_N_EXTRAHOR') ?></p>
        </template>
        <template v-if="params.type=='omm-horizontal'">
        <label>Extra Icon Color</label>
        <div class="osi-colorpicker" :style="{background: params.extraColors}"><colorpicker :color="params.extraColors" v-model="params.extraColors"/></div>
        <p class="small-note">After add or disactivate icon, save to preview modal windows</p>
        <div class="omi-checkbox">
          <input type="checkbox" v-model="params.search">
          <label><?php echo JText::_('MOD_OSS_SEARCH') ?></label>
        </div>
        <div class="omi-checkbox">
          <input type="checkbox" v-model="params.mod1">
          <label><?php echo JText::_('MOD_OSS_MOD1') ?></label>
        </div>
        <template v-if="params.mod1">
        <p class="small-note"><?php echo JText::_('MOD_OSS_N_EXTRA') ?></p>
        <div class="omm-icon-group">
          <div class="omm-icon-select" @click="params.mod_1_icon_list='1'"><i :class="params.mod_1_icon"></i> <?php echo JText::_('MOD_OSS_SELECTICON') ?></div>
          <div v-show="params.mod_1_icon_list==1" class="oi-icon-list-wrap-heading oi-icons-hidden">
            <input class="oi-icon-filter" type="text" v-model="keyword" placeholder="Search Icon..." />
            <i class="fas fa-times" @click="params.mod_1_icon_list='0'"></i>
          </div>
          <div v-if="params.mod_1_icon_list==1" class="oi-icon-list-wrap oi-icons-hidden">
            <label v-for="icon in filteredList"><input type="radio" :value="icon.ic" v-model="params.mod_1_icon"><i :class="icon.ic"></i>{{icon.ic}}</label>
          </div>
        </div>
        </template>
        </template>
        <div class="dummy-div"></div>
      </li>
    </ul>
  </aside>
            <!-- item form ------------------- dev rm edit class---- -->
  <aside v-if="el.edit" v-for="(el, index) in items" class="omm-edit">
    <span class="omm-close" @click="el.edit=0"><i class="fas fa-times"></i></span>
    
    <h3><i :class="el.icon" :style="{color: el.col}"></i> {{el.title}}</h3>

    <template v-if="params.dropType!=='ok-mm-tree' || params.dropType!=='omm-columns-image'">

      <template v-if="params.groupBy=='oms-auto'">
          <label><?php echo JText::_('MOD_OSS_COL_AMOUNT') ?></label>
          <select class="osi-trigger" v-model="el.colQun" @change="megaR()">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>  
      </template>   

    </template>

    <template v-if="params.dropType!=='ok-mm-tree' || params.dropType!=='omm-columns-image'">
      <!-- pre -->
    </template> 


    <template v-if="params.dropType!=='ok-mm-tree' && params.groupBy=='oms-manual'">
      <div v-if="el.clsCh" class="omi-header-check">
        <input type="checkbox" value="omm-group-header" v-model="el.clsHeader" data-tooltip="" class="osi-trigger-check" @change="megaR()">
        <label data-osstt="<?php echo JText::_('MOD_OSS_SET_HEADER_TT') ?>"><?php echo JText::_('MOD_OSS_SET_HEADER') ?></label>
      </div>
    </template>






    <div class="omm-icon-group">
      <div class="omm-icon-select" @click="el.iconList='1'"><?php echo JText::_('MOD_OSS_SELECTICON') ?></div>
      <div v-show="el.iconList==1" class="oi-icon-list-wrap-heading oi-icons-hidden">
        <input class="oi-icon-filter" type="text" v-model="keyword" placeholder="Search Icon..." />
      <i class="fas fa-times" @click="el.iconList='0'"></i></div>
      <div class="oki_filter-count"></div>
      <div v-show="el.iconList==1" class="oi-icon-list-wrap oi-icons-hidden">
        <label v-for="icon in filteredList"><input type="radio" :value="icon.ic" v-model="el.icon"><i :class="icon.ic"></i>{{icon.ic}}</label>
        <!-- <label v-for="icon in filteredList"><input type="radio" :value="icon.ic" v-model="params.mod_1_icon"><i :class="icon.ic"></i>{{icon.ic}}</label> -->
        
      </div>
    </div>
    
    <label><?php echo JText::_('MOD_OSS_ICON_COLOR') ?></label>
    <div class="osi-colorpicker" :style="{background: el.col}"><colorpicker :color="el.col" v-model="el.col"/></div>
    <label><?php echo JText::_('MOD_OSS_DESC') ?></label>
    <textarea cols="30" rows="3" v-model="el.subtitle"></textarea>



    <template v-if="params.dropType=='omm-columns-preview'">
      <?php //if mode preview image parent and child can have image ?>
        <template v-if="el.clsP || el.clsCh">
        <label><?php echo JText::_('MOD_OSS_IMG') ?></label>
        <div class="os-media-manager">
          <div v-if="el.img" class="os-media-preview"><img :src="el.img" alt=""><i class="fas fa-times-circle" v-on:click="mediaRemove(index)"></i></div>
          <div class="omi-select-img os-media-manager-select" v-on:click="mediaLoad(index)">Select Image</div>
          <template v-if="el.imgInput">
          <!-- <div class="os-image-modal-bg"></div> -->
          <div class="os-image-select-buttons"><span class="os-img-select" v-on:click="mediaIn(index)">Select</span> <span class="os-img-cancel" v-on:click="mediaCansel(index)">Cancel</span> <p></p></div>
          </template>
        </div>
        </template>
    </template> 

    <template v-if="params.dropType=='omm-columns-image'">
      <?php //if mode column image only child can have image and only if they headings ?>
        <!-- <template v-if="el.clsCh && el.clsHeader"> -->
        <template v-if="el.clsCh">
        <label><?php echo JText::_('MOD_OSS_IMG') ?></label>
        <div class="os-media-manager">
          <div v-if="el.img" class="os-media-preview"><img :src="el.img" alt=""><i class="fas fa-times-circle" v-on:click="mediaRemove(index)"></i></div>
          <div class="omi-select-img os-media-manager-select" v-on:click="mediaLoad(index)">Select Image</div>
          <template v-if="el.imgInput">
          <!-- <div class="os-image-modal-bg"></div> -->
          <div class="os-image-select-buttons"><span class="os-img-select" v-on:click="mediaIn(index)">Select</span> <span class="os-img-cancel" v-on:click="mediaCansel(index)">Cancel</span> <p></p></div>
          </template>
        </div>
        </template>
    </template> 








    <!-- <textarea v-model="el.subtitle"></textarea> -->
    <label class="omi-premium"><?php echo JText::_('MOD_OSS_TOOLTIP') ?>(demo - Premium)</label>
    <input type="text" v-model="el.tooltip">
    <label class="omi-premium"><?php echo JText::_('MOD_OSS_BADGE') ?>(demo - Premium)</label>
    <div class="omi-badges">
      <?php
      /*
      render badges from a directory
      */
      $dir = JPATH_ROOT . '/modules/mod_oss_megamenu/assets/images/badges';
      $arr = glob($dir . "/*.png");
      //radio buttons
      echo '<label><input type="radio" value="" v-model="el.badge"><span>None</span></label>';
      foreach ($arr as $value) {
      $f_name = str_replace($dir ."/", "", $value);
      $f_name = str_replace(".png", "", $f_name);
      $file_url = JURI::root() . '/modules/mod_oss_megamenu/assets/images/badges/' . $f_name . '.png';
      echo '<label><input type="radio" value="' . $file_url . '" v-model="el.badge"><span><img src="' . $file_url . '">' . $f_name . '</span></label>';
      }
      ?>
    </div>
  </aside>
  <div class="omi-re omm-hidden">
    {{turnOfEditMode()}}
  </div>
