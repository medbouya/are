<?php
/**
 * @license		GNU General Public License v2.0
 * @version 1.0.0
 * @author Alexander Green
 * @copyright (C) 2022- OSSKit.Net. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die;
//TODO OR REMOVE THEN
jimport('joomla.form.formfield');

use Joomla\CMS\Factory;
class JFormFieldOsshidden extends JFormField
{
    protected $type = 'Osshidden';


    public function getLabel()
    {

    }

    protected function getInput()
    {
        return '<input class="omm-hidden-selected-in" name="' . $this->name . '" id="' . $this->id . '" type="text" value="' . $this->value . '">';
    
    }
}


 