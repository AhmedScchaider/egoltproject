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
 
defined('_JEXEC') or die;

abstract class EgoltProjectHelper
{
	public static function setEnv($active) 
	{
		$default_view = 'CONTROLPANEL';
		$egolt_title = JText::_( 'COM_EGOLTPROJECT' );
		$egolt_title1 = $egolt_title2 = $egolt_title;
		if ($active != 'EgoltProject') {
			$egolt_title_suffix = JText::_('COM_EGOLTPROJECT_'.strtoupper($active));
		}
		if(@$egolt_title_suffix) {
			$egolt_title1 = $egolt_title .  ' - [ ' . $egolt_title_suffix .' ]' ;
			$egolt_title2 = $egolt_title .  ' - ' . $egolt_title_suffix ;
		}
		
        JToolBarHelper::title($egolt_title1 ,'egoltproject');

		// set sub-menus with active menu decleration
		$submenus = array
		(
			'CONTROLPANEL' ,
			'PROJECTS',
			'DOWNLOADS',
			'DOWNLANGS', 	
			'REVS', 	
			'LICENSES', 	
			'COMPATS',	
			'ABOUT' 	
		);
		foreach($submenus as $val) {
			$flag = FALSE;
			if($val != $default_view) {
				$url_suffix = '&view='.strtolower($val);
			}
			else if($active == 'EgoltProject') {
				$flag = TRUE;
			}
			if($active == strtolower($val)) {
				$flag = TRUE;
			}
			JSubMenuHelper::addEntry(JText::_('COM_EGOLTPROJECT_' . $val),'index.php?option=com_egoltproject' . @$url_suffix, @$flag );
		}
	
		// set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-egoltproject 
		{background-image: url(components/com_egoltproject/assets/images/egoltproject.png);}');
		$document->setTitle($egolt_title2);

		$lang =& JFactory::getLanguage();
		$lang_tag = $lang->getTag();
		if(JRequest::getCmd('tmpl') != 'component')
		{
			if($lang->isRTL()) {
				JHTML::_('stylesheet', 'egoltproject_rtl.css', 'administrator/components/com_egoltproject/assets/css/');	
				JHTML::_('stylesheet', 'grid_rtl.css', 'administrator/components/com_egoltproject/assets/css/');					
			}
			else {
				JHTML::_('stylesheet', 'egoltproject.css', 'administrator/components/com_egoltproject/assets/css/');	
				JHTML::_('stylesheet', 'grid.css', 'administrator/components/com_egoltproject/assets/css/');							
			}
		}

	}

	public static function setSal($tp = null)
	{
		if (sha1('egolt') === '2e3340a60b208dd180664060422e299f1c42a2e6') 
		{
			if($tp)
				echo base64_decode( 'PC9kaXY+PHNtYWxsPjxzbWFsbD48Y2VudGVyPjxhIGhyZWY9Imh0dHA6Ly93d3cuZWdvbHQuY29tIiB0YXJnZXQ9Il9ibGFuayI+UG93ZXJlZCBieSBFZ29sdCBQcm9qZWN0IFB1Ymxpc2hlcjwvYT48L2NlbnRlcj48L3NtYWxsPjwvc21hbGw+');
			else
				return 'PC9kaXY+PGNlbnRlcj48YSBocmVmPSJodHRwOi8vd3d3LmVnb2x0LmNvbSIgdGFyZ2V0PSJfYmxhbmsiPlBvd2VyZWQgYnkgRWdvbHQgUHJvamVjdCBQdWJsaXNoZXI8L2E+PC9jZW50ZXI+';			
		}
	}
	
}
