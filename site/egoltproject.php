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
 
// No direct access.
defined('_JEXEC') or die;
jimport('joomla.application.component.controller');

$controller	= JController::getInstance('EgoltProject');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
