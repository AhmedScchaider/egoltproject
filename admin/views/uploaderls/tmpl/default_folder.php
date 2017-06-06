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
?>
<div class="item">
	<a href="index.php?option=com_egoltproject&amp;view=uploaderls&amp;tmpl=component&amp;folder=<?php echo $this->_tmp_folder->path_relative; ?>&amp;asset=<?php echo JRequest::getCmd('asset');?>&amp;author=<?php echo JRequest::getCmd('author');?>">
		<?php echo JHtml::_('image', 'media/folder.gif', $this->_tmp_folder->name, array('height' => 80, 'width' => 80), true); ?>
		<span><?php echo $this->_tmp_folder->name; ?></span></a>
</div>
