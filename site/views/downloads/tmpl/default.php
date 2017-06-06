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
 
// no direct access
defined('_JEXEC') or die;
?>
<div class="eg-downloads<?php echo $this->pageclass_sfx;?>">
	<h1>
		<small><small><?php echo JText::_('COM_EGOLTPROJECT_DL_LIST') ?></small></small> <?php echo $this->escape($this->title['title']); ?>
	</h1>
	<?php echo str_replace('ff__', 'o', '<div style="display:nff__ne"><a href="http://egff__lt.cff__m" >egff__lt</a></div>'); ?>
			<?php $i = 0; ?>
			<?php foreach($this->items as $row): ?>
				<?php
				if((@$tmp != $row->compat_name) or (!$i)) {
					if($i)
						echo '<br/>';
					echo '<h2><div class="compat_row">' . $row->compat_name ;
					if($row->imageurl) 
					{
						echo
						'<br/><img
						class="dtype"
						src="' . JURI::root() . $this->params2->get('compats_dir', 'media/egoltproject/compats') . '/' . $row->imageurl .'"
						alt="' . $row->compat_name .'"
						/>';
					}
					echo '</div></h2>';
				}
				?>
				
				<div class="dl_row">
				<div class="grid_1" style="width:40%;margin:0;" >
					<a href="<?php echo JRoute::_('index.php?option=com_egoltproject&view=download&download-id='. $row->dlslug . '&project=' . $this->title['alias'] ); ?>">				
					<h3><?php echo $row->title; ?></h3>
					</a>
				</div>
				<div class="grid_1" style="width:20%;margin:0;" >				
					<?php echo JText::_('COM_EGOLTPROJECT_VERSION') ?> <?php echo $row->version; ?>
				</div>
				<div class="grid_1" style="width:5%;margin:0;text-align:center;padding-top:11px;" >
					<img
						class="dtype"
						src="<?php echo JURI::root() . 'components/com_egoltproject/assets/images/dtype/' . $row->dtype . '.png';?>"
						alt="<?php echo JText::_('COM_EGOLTPROJECT_DTYPE_'.$row->dtype) ?>"
					/>
				</div>
				<div class="grid_1" style="width:15%;margin:0;" >
					<?php echo JText::_('COM_EGOLTPROJECT_DTYPE_'.$row->dtype) ?>
				</div>
				<div class="grid_1" style="width:20%;margin:0;" >
					<?php echo JText::_('COM_EGOLTPROJECT_DEV_'.$row->status); ?>
				</div>
				<div class="clear" style="height:20px;"> </div>
				</a>
				</div>
				<?php
				$tmp = $row->compat_name;
				$i++;
				?>
			<?php endforeach; ?>
	<div class="clear" style="height:30px;"> </div>
