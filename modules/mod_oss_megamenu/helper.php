<?php

/**
 * @copyright    Copyright © 2022 - All rights reserved.
 * @license      GNU General Public License v2.0
 * @generator    https://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;
//get module data
//subitem--------------------
function extra($data, $id, $item)
{
    if (!empty($data)) {
        foreach ($data as $value) {
            $value = (object)$value;
            if ($value->id == $id) { // Get needful id
                if (isset($value->$item)) {
                    return $value->$item;
                }
            }
        }
    }
}
//parameters
function para($prm, $item)
{
    if (!empty($prm)) {
        if (isset($prm->$item)) {
            return $prm->$item; //diference from backend return, not echo
        }
    }
}
//css style in header
function ossStyle($prm, $id)
{
    $id = '#' . $id;
    $subCol = '';
    $subPad = '';
    //pro
    $topBg = $topCol = $topHeight = $groupBg = $groupCol = $dropItemBg = $topcol = $topcol = '';
    if (!empty($prm->topBg)) {
        $topBg = 'background:' . $prm->topBg . ';';
    }
    if (!empty($prm->topCol)) {
        $topCol = 'color:' . $prm->topCol . ';';
    }
    if ($prm->topHeight != 40) {
        $topHeight = 'height:' . $prm->topHeight . 'px;';
    }
    if (!empty($prm->groupBg)) {
        $groupBg = 'background:' . $prm->groupBg . ';';
    }
    if (!empty($prm->groupCol)) {
        $groupCol = 'color:' . $prm->groupCol . ';';
    }
    if (!empty($prm->dropItemBg)) {
        $dropItemBg = 'background:' . $prm->dropItemBg . ';';
    }
    if (!empty($prm->dropCol)) {
        $dropCol  = 'color:' . $prm->dropCol  . ';';
    }
    // if (!empty($prm->)) { $ = 'background:' . $prm-> . ';'; }
    $dropCol = 'green';
    //Arr
    $css = array();
    if (!empty($topBg)) {
        $css[] = PHP_EOL; //dev rm
        $css[] = $id . '{' . $topBg . '}' . PHP_EOL;
    }
    if (!empty($topCol) or !empty($topHeight)) {
        $css[] = $id . ' .omm-link{' . $topCol . $topHeight . '}' . PHP_EOL;
    }
    if (!empty($prm->topSubCol)) {
        $css[] = $id . ' .omm-link .omm-desc{color:' . $prm->topSubCol . '}' . PHP_EOL;
    }
    if (!empty($prm->dropBg)) {
        $css[] = $id . ' .omm-sub{background:' . $prm->dropBg . '}';
    }
    if ($prm->groupBy !== 'oms-manual') {
        $groupCol = $dropItemBg;
        $groupBg = $dropCol;
    }
    if (!empty($groupCol) or !empty($groupBg)) {
        $css[] = $id . ' .omm-sub  .omm-group-header .omm-cont{' . $groupCol . $groupBg . '}' . PHP_EOL;
    }
    if (!empty($dropItemBg) or !empty($dropCol)) {
        $css[] = $id . ' .omm-sub .omm-cont{' . $dropItemBg . $dropCol . '}' . PHP_EOL;
    }
    if (!empty($prm->dropSubCol)) {
        $css[] = $id . ' .omm-sub .omm-desc{color:' . $prm->dropSubCol . '}';
    }
    if ($prm->subWidth != 200) {
        $css[] = $id . ' .omm-sub{width:' . $prm->subWidth . 'px}';
    }
    // if (!empty($prm->topCol)) {
    //     $css[] = $id . ' .omm-link{color:' . $prm->topCol . '}'. PHP_EOL;
    // }
    if (!empty($prm->size)) {
        $css[] = $id . ' .omm-link{font-size:' . $prm->size . 'px}' . PHP_EOL;
    }
    $cssOverride = implode("", $css);
    return $cssOverride;
}
