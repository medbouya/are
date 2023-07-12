<?php
/**
 * @license		GNU General Public License v2.0
 * @version 1.0.0
 * @author Alexander Green
 * @copyright (C) 2022- OSSKit.Net. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die;
?>
<div class="omm-extra-icons" :style="extraS()">
	<span class="os-modal-click" v-if="params.search" data-os-modal="#omm-modal-search">
		<i class="fas fa-search"></i>
	</span>
	<span class="os-modal-click" v-if="params.mod1" data-os-modal="#omm-modal-m1">
		<i :class="params.mod_1_icon"></i>		
	</span>
	<span class="os-modal-click" v-if="params.mod2" data-os-modal="#omm-modal-m2">
		<i :class="params.mod_2_icon"></i>		
	</span>
</div>
<div class="os-modal-bg"></div>
<div id="omm-modal-search" class="os-modal-content os-modal-content-600">
	<i class="fas fa-times os-modal-close"></i>
	<p><?php echo JText::_('MOD_OSS_N_SEARCH') ?></p>
	<input type="text" placeholder="search...">
</div>
<div id="omm-modal-m1" class="os-modal-content os-modal-content-600"><i class="fas fa-times os-modal-close"></i><p><?php echo JText::_('MOD_OSS_N_MOD1') ?></p></div>
<div id="omm-modal-m2" class="os-modal-content os-modal-content-600"><i class="fas fa-times os-modal-close"></i><p><?php echo JText::_('MOD_OSS_N_MOD2') ?></p></div>
<div id="group-help" class="os-modal-content os-modal-content-1200">
	<i class="fas fa-times os-modal-close"></i>
	<p><?php echo JText::_('MOD_OSS_N_GROUP') ?></p>
	<p><?php echo JText::_('MOD_OSS_N_GROUP_1') ?></p>
	<img src="<?php echo JUri::root() ?>modules/mod_oss_megamenu/assets/images/docs/doc-4.png" alt="">
	<p><?php echo JText::_('MOD_OSS_N_GROUP_2') ?></p>
	<p><?php echo JText::_('MOD_OSS_N_GROUP_3') ?></p>
	<img src="<?php echo JUri::root() ?>modules/mod_oss_megamenu/assets/images/docs/doc-1.png" alt="">
	<hr>
	<img src="<?php echo JUri::root() ?>modules/mod_oss_megamenu/assets/images/docs/doc-3.png" alt="">
	<p><?php echo JText::_('MOD_OSS_N_GROUP_4') ?></p>
	
</div>