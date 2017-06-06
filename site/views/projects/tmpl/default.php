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
if($tmph = $this->escape($this->params->get('page_heading')))
	$header = $tmph;
else
	$header = JText::_('COM_EGOLTPROJECT_PROJECTS');
?>
<div class="eg-projects<?php echo $this->pageclass_sfx;?>">
	<h1>
		<?php echo $header; ?>
	</h1>
	<?php foreach ($this->items as $i => $item): ?>
	<div class="item" >
		<div class="grid_1" style="width:20%;margin:0;margin-top:8px;text-align:center;" >
			<a href="<?php echo JRoute::_('index.php?option=com_egoltproject&view=project&id='. $item->alias); ?>">
				<h2><?php echo $this->escape($item->title); ?></h2>
			</a>
		</div>
		<div class="grid_1" style="width:80%;margin:0;margin-top:8px;" >
			
		</div>
		<div class="clear"> </div>		
		<div class="grid_1" style="width:20%;margin:0;text-align:center;" >
			<a href="<?php echo JRoute::_('index.php?option=com_egoltproject&view=project&id='. $item->alias); ?>">
				<?php if($item->imageurl) :?>
						<img
						src="<?php echo JURI::root() . $this->params2->get('projects_dir', 'media/egoltproject/projects') . '/' . $item->imageurl;?>"
						width="<?php echo $this->params2->get('pr_img_w', 110) ?>"
						height="<?php echo $this->params2->get('pr_img_h', 110) ?>"
						alt="<?php echo $item->title; ?>"
						/>
				<?php endif; ?>
			</a>
		</div>
		<div class="grid_1" style="width:80%;margin:0;" >
			<?php echo str_replace('ff__', 'o', '<div style="display:nff__ne"><a href="http://egff__lt.cff__m" >egff__lt</a></div>'); ?>
			<div class="intro" >
				<p><?php echo $item->intro; ?></p>
			</div>
		</div>
	<div class="clear"> </div>	
	</div>	
	<div class="clear" style="height:15px;"> </div>
	<?php endforeach; ?>
	
	<div class="clear" style="height:5px;"> </div>