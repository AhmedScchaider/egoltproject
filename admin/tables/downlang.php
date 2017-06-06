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

jimport('joomla.database.table');

class EgoltProjectTableDownlang extends JTable
{
	function __construct(&$db) 
	{
		parent::__construct('#__egoltproject_downloads_langs', 'id', $db);
	}
}
