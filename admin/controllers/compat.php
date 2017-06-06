<?php
/**
 * @package   	Egolt Project Publisher
 * @link 		http://www.egolt.com
 * @copyright 	Copyright (C) Egolt www.egolt.com
 * @author    	Soheil Novinfard
 * @license    	GNU/GPL 2
 *
 * Name:			Egolt Project Publisher
 * License:    		GNU/GPL 2
 * Project Page: 	http://www.egolt.com/products/egoltproject
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
class EgoltProjectControllerCompat extends JControllerForm
{
       protected function allowEdit($data = array()) {
             return true;
       }
       protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id') {
				$append = parent::getRedirectToItemAppend($recordId,$urlVar);
				if($elang = JRequest::getVar('elang'))
					return $append.'&elang='.JRequest::getVar('elang');
				else
					return $append;
       }
} 