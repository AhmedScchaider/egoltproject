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
 
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
JLoader::register('EgoltProjectHelper', JPATH_COMPONENT . DS . 'helpers' . DS . 'egoltproject.php');

class EgoltProjectController extends JController
{
	function display($cachable = false) 
	{
		$view = JRequest::getCmd('view', 'EgoltProject');
		JRequest::setVar('view', $view);
		EgoltProjectHelper::setEnv($view);
 		parent::display($cachable);
	}
}