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

jimport('joomla.application.component.model');

$params = &JComponentHelper::getParams('com_egoltproject');
define('COM_MEDIA_BASE',	JPATH_ROOT );
define('COM_MEDIA_BASEURL', JURI::root() );

class EgoltProjectModelUploader extends JModel
{

	function getState($property = null, $default = null)
	{
		static $set;

		if (!$set) {
			$folder = JRequest::getVar('folder', '', '', 'path');
			$this->setState('folder', $folder);

			$fieldid = JRequest::getCmd('fieldid', '');
			$this->setState('field.id', $fieldid);

			$parent = str_replace("\\", "/", dirname($folder));
			$parent = ($parent == '.') ? null : $parent;
			$this->setState('parent', $parent);
			$set = true;
		}

		return parent::getState($property, $default);
	}

	/**
	 * Image Manager Popup
	 *
	 * @param string $listFolder The image directory to display
	 * @since 1.5
	 */
	function getFolderList($base = null)
	{
		// Get some paths from the request
		if (empty($base)) {
			$base = COM_MEDIA_BASE;
		}
		//corrections for windows paths
		$base = str_replace(DS, '/', $base);
		$com_media_base_uni = str_replace(DS, '/', COM_MEDIA_BASE);

		// Get the list of folders
		jimport('joomla.filesystem.folder');
		$folders = JFolder::folders($base, '.', true, true);

		// Build the array of select options for the folder list
		$options[] = JHtml::_('select.option', "", "/");

		foreach ($folders as $folder)
		{
			$folder		= str_replace($com_media_base_uni, "", str_replace(DS, '/', $folder));
			$value		= substr($folder, 1);
			$text		= str_replace(DS, "/", $folder);
			$options[]	= JHtml::_('select.option', $value, $text);
		}

		// Sort the folder list array
		if (is_array($options)) {
			sort($options);
		}

		// Get asset and author id (use integer filter)
		$input = JFactory::getApplication()->input;
		$asset = $input->get('asset', 0, 'integer');
		$author = $input->get('author', 0, 'integer');

		// Create the drop-down folder select list
		$list = JHtml::_('select.genericlist',  $options, 'folderlist', 'class="inputbox" size="1" onchange="ImageManager.setFolder(this.options[this.selectedIndex].value, " '.$asset.'","'.$author.'")" ', 'value', 'text', $base);
		
		$list_text = '<input type="hidden" name="folderlist" id="folderlist" value="'. JRequest::getVar('folder') .'" >';

		// return $list;
		return $list_text;
	}

	function getFolderTree($base = null)
	{
		// Get some paths from the request
		if (empty($base)) {
			$base = COM_MEDIA_BASE;
		}

		$mediaBase = str_replace(DS, '/', COM_MEDIA_BASE.'/');

		// Get the list of folders
		jimport('joomla.filesystem.folder');
		$folders = JFolder::folders($base, '.', true, true);

		$tree = array();

		foreach ($folders as $folder)
		{
			$folder		= str_replace(DS, '/', $folder);
			$name		= substr($folder, strrpos($folder, '/') + 1);
			$relative	= str_replace($mediaBase, '', $folder);
			$absolute	= $folder;
			$path		= explode('/', $relative);
			$node		= (object) array('name' => $name, 'relative' => $relative, 'absolute' => $absolute);

			$tmp = &$tree;
			for ($i=0, $n=count($path); $i<$n; $i++)
			{
				if (!isset($tmp['children'])) {
					$tmp['children'] = array();
				}

				if ($i == $n-1) {
					// We need to place the node
					$tmp['children'][$relative] = array('data' =>$node, 'children' => array());
					break;
				}

				if (array_key_exists($key = implode('/', array_slice($path, 0, $i+1)), $tmp['children'])) {
					$tmp = &$tmp['children'][$key];
				}
			}
		}
		$tree['data'] = (object) array('name' => JText::_('COM_MEDIA_MEDIA'), 'relative' => '', 'absolute' => $base);

		return $tree;
	}
}
