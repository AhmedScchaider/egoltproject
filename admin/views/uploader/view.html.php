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

jimport('joomla.application.component.view');


class EgoltProjectViewUploader extends JView
{
	function display($tpl = null)
	{
		$language = JFactory::getLanguage();
		$language->load('com_media', JPATH_ADMINISTRATOR);
		

		$config = JComponentHelper::getParams('com_media');
		$app	= JFactory::getApplication();
		$lang	= JFactory::getLanguage();
		$append = '';

		JHtml::_('behavior.framework', true);
		JHtml::_('script', 'media/popup-imagemanager.js', true, true);
		JHtml::_('stylesheet', 'media/popup-imagemanager.css', array(), true);

		if ($lang->isRTL()) {
			JHtml::_('stylesheet', 'media/popup-imagemanager_rtl.css', array(), true);
		}

		if ($config->get('enable_flash', 1)) {
			$fileTypes = 'bmp,gif,jpg,png,jpeg,zip';
			$types = explode(',', $fileTypes);
			$displayTypes = '';		// this is what the user sees
			$filterTypes = '';		// this is what controls the logic
			$firstType = true;

			foreach($types as $type)
			{
				if(!$firstType) {
					$displayTypes .= ', ';
					$filterTypes .= '; ';
				}
				else {
					$firstType = false;
				}

				$displayTypes .= '*.'.$type;
				$filterTypes .= '*.'.$type;
			}

			$typeString = '{ \''.JText::_('COM_MEDIA_FILES', 'true').' ('.$displayTypes.')\': \''.$filterTypes.'\' }';

			JHtml::_('behavior.uploader', 'upload-flash',
				array(
					'onBeforeStart' => 'function(){ Uploader.setOptions({url: document.id(\'uploadForm\').action + \'&folder=\' + document.id(\'imageForm\').folderlist.value}); }',
					'onComplete' 	=> 'function(){ window.frames[\'imageframe\'].location.href = window.frames[\'imageframe\'].location.href; }',
					'targetURL' 	=> '\\document.id(\'uploadForm\').action',
					'typeFilter' 	=> $typeString,
					'fileSizeMax'	=> (int) ($config->get('upload_maxsize', 0) * 1024 * 1024),
				)
			);
		}


		$ftp = !JClientHelper::hasCredentials('ftp');

		$this->session = JFactory::getSession();
		$this->config = $config;
		$this->state = $this->get('state');
		$this->folder = JRequest::getVar('folder', '', '', 'path');
		$this->folderList = $this->get('folderList');
		$this->require_ftp = $ftp;

		parent::display($tpl);
	}
}
