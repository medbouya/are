<?php
/**
 * @license     GNU General Public License v2.0
 * @version 1.0.0
 * @author Alexander Green
 * @copyright (C) 2022- OSSKit.Net. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die;
jimport('joomla.form.formfield');
use Joomla\CMS\Factory;
class JFormFieldApp extends JFormField
{
    protected $type = 'App';
    public $j_items;//joomla menu items data //v11 
    public $mod_items;//module items data//v11 
    public $dataItems;//rm
    public $parameters;
    public function getLabel()
    {
    }
    protected function getInput()
    {
        // Add css, scripts
        $assets_path = 'modules/mod_oss_megamenu/assets/';     
        JHTML::_('stylesheet', $assets_path . 'css/style.css');       
        JHTML::_('stylesheet', $assets_path . 'css/admin.css');       
        JHTML::_('stylesheet', $assets_path . 'css/oskit.css');      
        JHtml::_('script', $assets_path . 'js/admin.js');
        // JHtml::_('script', $assets_path . 'js/script.js'); 
        JHtml::_('script', $assets_path . 'js/vue.js');
        JHtml::_('script', $assets_path . 'js/vue-color.min.js');
        JHtml::_('script', $assets_path . 'js/color.js');
        JHtml::_('script', $assets_path . 'js/mega.js');
        JHtml::_('script', $assets_path . 'js/dev-jquery.js');//dev only
        // JHtml::_('script', $assets_path . 'js/dev.js');//dev only
        //render menu 
        // get field value;
        $data = $this->value;
        $data = json_decode($data, true);
        if (isset($data)) {
            $additional_data = $data['items'];
            $this->mod_items = $data['items'];
            $params = $data['params'];
            $this->parameters = $data['params'];
            $params = (object)$params;
            $selected_menu = $params->mid;
        }else{
            $additional_data = '';
            $params = '';
            $selected_menu = '';  
        } 
        //subitem-------------------- // TODO rm then
        function extra($data,$id,$item){
            if (!empty($data)) {
                foreach ($data as $value) {
                    $value = (object)$value;
                    if ($value->id == $id) {// Get needful id
                            if (isset($value->$item)) {
                                return $value->$item;
                        }
                    }
                }
            }
        }
        //return if parameter exist in field object
        function para($prm,$item,$default=''){//rm
            // if (!empty($prm)) {
                if (!empty($prm->$item)) {
                    echo $prm->$item;
                }else{
                    echo $default;
                }
            // }
        } 
        //get menu data
        $db = JFactory::getDBO();
        $query = "SELECT id, title, parent_id FROM #__menu WHERE menutype = '$selected_menu' and published = '1' ORDER BY lft ASC";
        $db->setQuery($query);
        $this->j_items = $db->loadObjectList(); //selected menu items    
        //Start Screen ---------------------
         echo '<div id="app">';//START APP
        if (empty($selected_menu)) {
            ?>
            <p><?php echo JText::_('MOD_OSS_SAVE') ?></p>
            <joomla-toolbar-button id="toolbar-apply" task="module.apply" form-validation=""><button class="button-apply btn btn-success omm-but-success" type="button"><span class="icon-apply" aria-hidden="true"></span> Save Data to Continue</button></joomla-toolbar-button>   
            <p v-show="params.showData">Selected Menu</p>
            <input v-show="params.showData" id="menu-selected" type="text" v-model="params.mid">
            <?php
        } else {
            ?>
            <p v-show="params.showData">Selected Menu</p>
            <input v-show="params.showData" id="menu-selected" type="text" v-model="params.mid">  
             <?php         
            include_once 'admin.php'; 
        }
        ?> 
        <div id="confirm-change-menu">
          <div id="confirm-change-menu-modal">
            <div>
            <?php echo JText::_('MOD_OSS_N_CHANGE'); ?>
            </div>
            <div>
              <span class="omm-but omm-but-cancel">Cancel Changing</span>
              <span class="omm-but omm-but omm-but-success">Confirm Changing</span>
            </div>
            
          </div>
        </div>
        <div id="confirm-change-menu-reload"><div class="custom-loader"></div></div>
        <?php
        echo '<span data-tooltip="Shows Data - for debugging and support" data-flow="right"><i class="fas fa-eye" @click="params.showData=!params.showData" style="color:#999"></i></span>';
        echo '<div v-show="params.showData">';
        echo '<p>Items Data</p>';
        echo '<textarea class="oss-data" name="' . $this->name . '" id="' . $this->id . '" cols="30" rows="10" :value="strData()">' . $this->value . '</textarea>';
        echo '<p>Parameters</p>';
        echo '<textarea cols="90" rows="20">{{params}}</textarea>';
        echo '</div>'; 
        echo '</div>'; //end APP
        // $db = JFactory::getDBO();
        // $query = "SELECT id, title, parent_id FROM #__menu WHERE menutype = '$selected_menu' and published = '1' ORDER BY lft ASC";
        // $db->setQuery($query);
        // $this->j_items = $db->loadObjectList(); //selected menu items
        include_once 'vuejs.php';
    }
    //get items from joomla menu & module parameters
    public function get_item_params($id,$prop,$default='')//v11 
    {
        if (!empty($this->mod_items)) {
            foreach ($this->mod_items as $value) {
                if ($value['id'] == $id) {// Get needful id
                    //if property exist print property->value like - (prop:"value",) if not print property and default(for new props)
                    if (isset($value[$prop])) {
                        echo $prop . ': "' . $value[$prop] . '",';
                    } else {
                       echo $prop . ': "' . $default . '",';
                    }
                }
            }
        }      
    }
    //get items as json for vue js
    public function get_items()//v11 
    { 
        if (!empty($this->j_items)) {
            foreach ($this->j_items as $value) {
                echo '{';
                echo 'id:' . $value->id.',';
                echo 'title:"' . $value->title .'",';
                echo 'scls:"cl' . $value->id.'",';
                echo 'parent:' . $value->parent_id .',';
                echo 'clsP:"' . $this->itemClassP($value->id,$value->parent_id) .'",';
                echo 'clsCh:"' . $this->itemClassCh($value->id,$value->parent_id) .'",';
                echo 'iconList: 0,';
                echo 'imgInput:false,';
                echo 'drop: false,';
                $this->get_item_params($value->id,'menuActive');
                $this->get_item_params($value->id,'clsHeader');
                $this->get_item_params($value->id,'icon');
                $this->get_item_params($value->id,'subtitle');
                $this->get_item_params($value->id,'tooltip');
                $this->get_item_params($value->id,'bg');
                $this->get_item_params($value->id,'col');
                $this->get_item_params($value->id,'badge');
                $this->get_item_params($value->id,'img');
                $this->get_item_params($value->id,'colQun');
                $this->get_item_params($value->id,'edit');
                $this->get_item_params($value->id,'subDsp');
                echo '},';
            }
        }
    }
    //get parameters - if parameter exists return with echo with value, else dreturn defaul value or empty
    public function get_param($prop,$default=''){
        $params = $this->parameters;      
        if (isset($params[$prop])) {
            echo $prop . ': "' . $params[$prop] . '",';
        } else {
           echo $prop . ': "' . $default . '",';
        }
        
    }
    public function reload(){
        ?>
        <!-- <span class="omi-re" data-tooltip="Reload Script to rebuild menu" data-flow="left"><i class="fas fa-redo"></i></span> -->
        <!-- <span class="omi-re" data-tooltip="Reload Script to rebuild menu" data-flow="left" @click="megaR()"><i class="fas fa-redo"></i></span> -->
        <span class="omi-re" data-tooltip="Reload Script to rebuild menu" data-flow="left"><i class="fas fa-redo"></i></span>
        <?php
    }
    public function showReloadNote(){//rm then
        ?>
<!--         <div class="omi-mega-note">
            <p>After changing parameters it can show wrong preview, if it's so just save to see it correct one
                <br><strong>We will fix it in next versions</strong></p>      
            <button class="btn btn-success omm-but-success omi-but-save" type="button"><span class="icon-apply" aria-hidden="true"></span> Save?</button>
        </div> -->
        <?php
    }
    public function icons($el, $ic_render)
    {   
        ?>
<!--  

TODO
     <div class="omm-icon-group">
        <label>Icon - <i :class="<?php echo $el ?>"></i></label>
        <input type="text" v-model="<?php echo $el ?>" style="margin-bottom: 10px;">
        <div class="omm-icon-select" @click="<?php echo $ic_render ?>='1'">Select Icon</div>
        <div v-show="<?php echo $ic_render ?>==1" class="oi-icon-list-wrap-heading oi-icons-hidden">
     
          <input class="oi-icon-filter" type="text" placeholder="Type some letters to filter"> 
        <i class="fas fa-times" @click="<?php echo $ic_render ?>='0'"></i></div>
        <div class="oki_filter-count"></div>
        <div v-show="<?php echo $ic_render ?>==1" class="oi-icon-list-wrap oi-icons-hidden">
          <div class="oi-icon-list">
            <label v-for="(elem, index) in icons" :key="index"><input type="radio" :value="<?php echo $el ?>" v-model="<?php echo $el ?>" @click="<?php echo $ic_render ?>='0'"><i :class="<?php echo $el ?>"></i>{{<?php echo $el ?>"}}</label>
          </div>
        </div>
      </div> -->
        <?php
    }


    public function itemClassP($id,$parent)
    {   
        /*
        add class parent if any in list has parent id as id of element
         */
        // $class = 'omm-item';     
        $items = array_column($this->j_items, 'parent_id');
        if (in_array($id, $items)) {
            return 'omm-parent';
        }
    }
    public function itemClassCh($id,$parent)
    {   
        /*
        add class child if has parent
         */
        if ($parent>1) {
            return  'omm-child';
        }
    }
    public function classLastChild($id,$parent)
    { 
        if ($parent>1) {
            //get items with same parent as array
            $arr = array();
            foreach ($this->j_items as $value) {
                if ($value->parent_id == $parent) {
                   $arr[] = $value->id;
                }
            }
            //get last in new array and if id is last returm class last
            foreach ($arr as $index => $value) { 
                $v = '';
                if ($index === array_key_last($arr)) {
                    $v = $value;
                }
                if ($v == $id) {
                    return true;
                }
            }
        }

    }
}
 