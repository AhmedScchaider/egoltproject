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
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');
JLoader::register('EgoltProjectHelper', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_egoltproject' . DS . 'helpers' . DS . 'egoltproject.php');

class EgoltProjectController extends JController
{

	function display($cachable = false) 
	{
		// add stylesheet
		$lang =& JFactory::getLanguage();
			JHTML::_('stylesheet', 'egoltproject.css', 'components/com_egoltproject/assets/css/');	
		JHTML::_('stylesheet', 'egoltproject.css', 'components/com_egoltproject/assets/css/');	
		if($lang->isRTL()) {
			JHTML::_('stylesheet', 'egoltproject_rtl.css', 'components/com_egoltproject/assets/css/');	
			JHTML::_('stylesheet', 'grid_rtl.css', 'components/com_egoltproject/assets/css/');
		}
		else {
			JHTML::_('stylesheet', 'grid.css', 'components/com_egoltproject/assets/css/');
		}		
		$view = JRequest::getCmd('view', 'projects');
		JRequest::setVar('view', $view);
 		parent::display($cachable);
		EgoltProjectHelper::setSal('#ksdaKsdErOpll$sda^jdCa!Nad*+');
	}
	
}