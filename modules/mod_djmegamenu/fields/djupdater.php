<?php
/**
 * @package DJ-Megamenu
 * @copyright Copyright (C) DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski, Michał Olczyk, Artur Kaczmarek
 *
 */

defined('JPATH_PLATFORM') or die;

define ('DJUPDATER_PATH', JPATH_ROOT.'/modules/mod_djmegamenu'); //plugin path
define ('DJUPDATER_ELEMENT', 'pkg_dj-megamenu'); //element name in database
define ('DJUPDATER_NAME', 'DJ-MegaMenu'); //name of update server

define ('DJUPDATER_URL_PRO', 'https://dj-extensions.com/index.php?option=com_ars&view=update&task=stream&format=xml&id=5');
define ('DJUPDATER_URL_LIGHT', 'https://dj-extensions.com/index.php?option=com_ars&view=update&task=stream&format=xml&id=6');


/**
 * Form Field class for the Joomla Platform.
 * Supports a one line text field.
 *
 * @link   http://www.w3.org/TR/html-markup/input.text.html#input.text
 * @since  11.1
 */
class JFormFieldDJUpdater extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'DJUpdater';
	
	/**
     * Method to get the field label markup for a spacer.
     * Use the label text or name from the XML element as the spacer or
     * Use a hr="true" to automatically generate plain hr markup
     *
     * @return  string  The field label markup.
     *
     * @since   11.1
     */
    protected function getLabel()
    {
    	return '';
    }

    /**
     * Method to get the field title.
     *
     * @return  string  The field title.
     *
     * @since   11.1
     */
    protected function getTitle()
    {
        return '';
    }

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{

		$version = new JVersion;
		$isJoomla4 = version_compare($version->getShortVersion(), '4', '>=');

		if( $isJoomla4 ) {
			return '';
		}
		
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
	
		$name = (string)$this->element['extension'];
		$path = DJUPDATER_PATH;
		
		$pro = (int)$this->element['pro'];
		$url = ( $pro ) ? DJUPDATER_URL_PRO : DJUPDATER_URL_LIGHT;

		if($name) {
			$lang = JFactory::getLanguage();
			$lang->load($name, JPATH_ROOT, 'en-GB', true, false);
			$lang->load($name, JPATH_ROOT . $path, 'en-GB', true, false);
			$lang->load($name, JPATH_ROOT, null, true, false);
			$lang->load($name, JPATH_ROOT . $path, null, true, false);

			$doc->addStyleDeclaration('.djspin {
				-webkit-animation-name: spin;
				-webkit-animation-duration: 500ms;
				-webkit-animation-iteration-count: infinite;
				-webkit-animation-timing-function: linear;
				animation-name: spin;
				animation-duration: 500ms;
				animation-iteration-count: infinite;
				animation-timing-function: linear;
			}
			@-webkit-keyframes spin {
				from { -webkit-transform: rotate(0deg); }
				to { -webkit-transform: rotate(360deg); }
			}
			@keyframes spin {
				from {
					transform:rotate(0deg);
				}
				to {
					transform:rotate(360deg);
				}
			}
			');
		}
		
		$task = $app->input->get('djtask');
		if($task) {
			ob_clean();
			echo 'DJUPDATERRESPONSE'.$this->$task($name);
			$app->close();
		}
		
		self::setUpdateServer( $url );
		
		$html = self::getSubscription( $pro );
		
		return $html;
	}

	public static function getSubscription( $pro ) {
		$app = JFactory::getApplication();
		$db = JFactory::getDBO();

		$query = "SELECT manifest_cache FROM #__extensions WHERE element='".DJUPDATER_ELEMENT."'";

		$db->setQuery($query);
		$mc = json_decode($db->loadResult());
		$version = $mc->version;

		if( ! $pro ) { // LIGHT
			$html  = '<h4>' . JText::_('MOD_DJMEGAMENU_LIGHT_MODULE_DESC') . '  ' . $version . '</h4>';
			$html .= '<p>'.JText::_('DJUPDATER_UPGRADE_TO_PRO').'</p>';
			$html .= JText::sprintf('MOD_DJMEGAMENU_GET_PRO_LINK', JText::_('MOD_DJMEGAMENU_GET_PRO'));
			$alert_type = 'info';
		} else { // PRO
			$html  = '<h4>' . JText::_('MOD_DJMEGAMENU_MODULE_DESC') . '  ' . $version . '</h4>';
			$html .= '<p>'.JText::_('DJUPDATER_LICENSE_INFO').'</p>';

			$config = JFactory::getConfig();
			$secret_file = JFile::makeSafe('license_'.$config->get('secret').'.txt');
			$license_file = JPath::clean(dirname(__FILE__).'/../'.$secret_file);
			
			if (JFile::exists($license_file)){
				$license =  file_get_contents($license_file);
			} else {
				$license = '';
			}

			$alert_type = ( !empty($license) ) ? 'success' : 'info';

			$html .= '<div class="input-append input-group">';
			$html .= '<input id="license" type="text" name="license" class="input input-large form-control" value="'.htmlspecialchars($license).'" placeholder="'. JText::_('DJUPDATER_PASTE_KEY').'" /> ';
			$html .= '<button id="register" class="btn btn-info" href="#">'.JText::_('DJUPDATER_SAVE_KEY').'</button> ';
			$html .= '</div>';
	
			$js = "
					jQuery(document).ready(function(){
				
						var button = jQuery('#register');
						var loader = jQuery('<span class=\"icon-refresh djspin\" />');
				
						button.click(function(e){
							button.prop('disabled', true);
							button.prepend(loader);
							e.preventDefault();
				
							jQuery.ajax({
								data: {
									license: jQuery('#license').val(),
									djtask: 'save'
								}
							}).done(function(data) {
								var message = data.substr(data.lastIndexOf('DJUPDATERRESPONSE')+17);
								button.closest('.alert').before(jQuery(message));
								setTimeout(function(){ location.reload(); }, 3000);
							})
							.fail(function() {
								alert( 'connection error' );
								button.prop('disabled', false);
								loader.detach();
							});
						});
				
					});
				";
			
			JFactory::getDocument()->addScriptDeclaration($js);
		}
		
		return self::renderAlert($html, $alert_type);
	}
	
	public static function renderAlert($msg, $type = '', $title = '') {
		
		if(!in_array($type, array('success', 'error', 'info', ''))) $type = 'info';
		
		$html = 	'<div class="alert alert-'.$type.'">'
				.		(!empty($title) ? '<h3>'.$title.'</h3>' : '')
				.		'<div class="alert-body">'.$msg.'</div>'
				.	'</div>';
		
		return $html;
	}
	
	private function save( $ext ) {
		$app	= JFactory::getApplication();
		$config = JFactory::getConfig();
		$db = JFactory::getDbo();
		
		$license = JFactory::getApplication()->input->get('license');

		$secret_file = JFile::makeSafe('license_'.$config->get('secret').'.txt');
		$license_file = JPath::clean(dirname(__FILE__).'/../'.$secret_file);
		
		if ($license == '') { // NO LICENSE, remove extra_query and old license
			$query = "UPDATE #__update_sites SET extra_query='' WHERE name='" . DJUPDATER_NAME . "' AND type='extension' ";
			$db->setQuery($query);
			$db->execute();
			
			JFile::delete($license_file);
		} else { // LICENSE, set extra_query and write license file
			$query = "SELECT manifest_cache FROM #__extensions WHERE element='" . DJUPDATER_ELEMENT . "' ";
			$db->setQuery($query);
			$mc = json_decode($db->loadResult());
			$version = $mc->version;
			
			$extra_query = 'dlid='.$license.'&site='.urlencode(JURI::root());
			
			$query = "UPDATE #__update_sites SET extra_query='".addslashes($extra_query)."' WHERE name='" . DJUPDATER_NAME . "' AND type='extension' ";
			$db->setQuery($query);
			$db->execute();
			
			JFile::write($license_file, $license);
		}
		
		$msg = ($license == '') ? JText::_('DJUPDATER_KEY_REMOVED') : JText::_('DJUPDATER_KEY_SAVED');
		
		return self::renderAlert($msg, 'success');
	}
	
	public static function setUpdateServer( $url ) {

		// update the update server information for package
		$db = JFactory::getDbo();
		$config = JFactory::getConfig();
		$secret_file = JFile::makeSafe('license_'.$config->get('secret').'.txt');
		$license_file = JPath::clean(DJUPDATER_PATH.'/'.$secret_file);
		
		if(JFile::exists($license_file)){
			$license = file_get_contents($license_file);
		}else{
			$license = '';
		}
	
		$query = "SELECT extension_id, manifest_cache FROM #__extensions WHERE element='".DJUPDATER_ELEMENT."'";
		$db->setQuery($query);
		$pkg = $db->loadObject();
			
		if($pkg) {
			$mc = json_decode($pkg->manifest_cache);
			$version = $mc->version;
	
			$extra_query = 'license='.$license.'&v='.$version.'&site='.JURI::root();
	
			$db->setQuery("SELECT COUNT(*) FROM #__update_sites WHERE name='".DJUPDATER_NAME."' AND type='extension'");
			if ($db->loadResult() > 0) {
				$db->setQuery("UPDATE #__update_sites SET
						location='".$url."',
						extra_query='".addslashes($extra_query)."'
						WHERE name='".DJUPDATER_NAME."' AND type='extension'");
			} else {
				$db->setQuery("INSERT INTO #__update_sites (`name`, `type`, `location`, `enabled`, `extra_query`) VALUES
				('".DJUPDATER_NAME."', 'extension', '".$url."', 1, '".addslashes($extra_query)."')");
				$db->execute();
					
				$update_site_id = $db->insertid();
				$db->setQuery("INSERT INTO #__update_sites_extensions (`update_site_id`, `extension_id`)
						VALUES (".$update_site_id.", ".$pkg->extension_id.")");
			}
			$db->execute();
		}
	}
}
