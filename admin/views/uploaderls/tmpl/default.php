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
<?php //if (count($this->images) > 0 || count($this->folders) > 0 || count($this->docs) > 0) { ?>
<?php if (count($this->images) > 0 || count($this->docs) > 0) { ?>
<div class="manager">

		<?php /*for ($i=0, $n=count($this->folders); $i<$n; $i++) :
			$this->setFolder($i);
			echo $this->loadTemplate('folder');
		endfor; */?>
		
		<?php for ($i=0, $n=count($this->docs); $i<$n; $i++) :
			$this->setDoc($i);
			echo $this->loadTemplate('docs');
		endfor; ?>

		<?php for ($i=0, $n=count($this->images); $i<$n; $i++) :
			$this->setImage($i);
			echo $this->loadTemplate('image');
		endfor; ?>

</div>
<?php } else { ?>
	<div id="media-noimages">
		<p><?php echo JText::_('COM_MEDIA_NO_IMAGES_FOUND'); ?></p>
	</div>
<?php } ?>
