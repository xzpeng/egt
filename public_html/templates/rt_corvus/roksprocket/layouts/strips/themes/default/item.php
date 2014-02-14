<?php
/**
 * @version   $Id: item.php 12854 2013-08-20 14:34:49Z james $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// tagging
$tags                   = $item->getParam('strips_item_tags', false);
$tags                   = ($tags ? explode(",", $tags) : array());
$item->custom_tags      = "";
$item->custom_tags_list = array();

foreach ($tags as $tag) {
	$cleanName = trim($tag);
	$key       = str_replace(' ', '-', str_replace(array("'", '"'), '', $cleanName));
	$name      = $cleanName;

	$item->custom_tags .= " sprocket-tags-" . $key;
	$item->custom_tags_list[$key] = $name;

}

$item->custom_tags = trim($item->custom_tags);

?>
<li data-strips-item>
	<div class="sprocket-strips-item" <?php if ($item->getPrimaryImage()) :?>style="background-image: url(<?php echo $item->getPrimaryImage()->getSource(); ?>);"<?php endif; ?> data-strips-content>
		<div class="sprocket-strips-content">		
			<?php if ($item->getTitle()) : ?>
			<h4 class="sprocket-strips-title" data-strips-toggler>
				<?php if ($item->getPrimaryLink()) : ?><a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>"><?php endif; ?>
					<?php echo $item->getTitle();?>
				<?php if ($item->getPrimaryLink()) : ?></a><?php endif; ?>
			</h4>
			<?php endif; ?>

			<?php if ($item->getText()) :?>
				<span class="sprocket-strips-text">
					<?php echo $item->getText(); ?>
				</span>
			<?php endif; ?>
			<?php if (count($item->custom_tags_list)) : ?>
			<span class="rt-tags">
			<?php
				foreach($item->custom_tags_list as $key => $name){
					$icon = "";
			 		echo '<span class="rt-tag rt-tag-'.$key.'">';
					if ($item->getParam('strips_item_icon') != '-none-') :  
					echo '<span class="'.$item->getParam('strips_item_icon').'"></span>';
					endif;
					echo $name;
					echo '</span>';
				}
			?>
			</span>
			<?php endif; ?>
			<?php if (($parameters->get('strips_article_details') !== '0') and ($parameters->get('strips_article_details_position') !== "outside")): ?>
			<span class="sprocket-strips-infos">
				<?php if (($parameters->get('strips_article_details') == 'author') or ($parameters->get('strips_article_details') == '1')) :?>
					<strong class="author"><?php echo $item->getAuthor(); ?></strong>
				<?php endif; ?>
				<?php if (($parameters->get('strips_article_details') == 'date') or ($parameters->get('strips_article_details') == '1')) :?>	
				<span class="sprocket-strips-date">
					<?php if(($date = date_create($item->getDate())) !== false ){
					echo $date->format('M j, Y g:i a');
					} ?>
				</span>
				<?php endif; ?>										
			</span>
			<?php endif; ?>
			
			<?php if ($item->getPrimaryLink()) : ?>
			<a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>" class="readon"><span><?php rc_e('READ_MORE'); ?></span></a>
			<?php endif; ?>
		</div>
		
		<?php if (($parameters->get('strips_article_details') !== '0') and ($parameters->get('strips_article_details_position') == "outside")): ?>
		<div class="sprocket-strips-infos">
			<?php if (($parameters->get('strips_article_details') == 'author') or ($parameters->get('strips_article_details') == '1')) :?>
				<strong class="author"><?php echo $item->getAuthor(); ?></strong>
			<?php endif; ?>
			<?php if (($parameters->get('strips_article_details') == 'date') or ($parameters->get('strips_article_details') == '1')) :?>	
			<span class="sprocket-strips-date">
				<?php if(($date = date_create($item->getDate())) !== false ){
				// Month
				echo '<span class="sprocket-strips-date-month">'.$date->format('M').'</span><span class="sprocket-strips-date-spacer">&nbsp;</span>';
				// Date
				echo '<span class="sprocket-strips-date-date">'.$date->format('d').'</span><span class="sprocket-strips-date-comma">,&nbsp;</span>';
				// Year
				echo '<span class="sprocket-strips-date-year">'.$date->format('Y').'</span>&nbsp;';
				// Time
				echo '<span class="sprocket-strips-date-time">'.$date->format('g:i a').'</span>';
				} ?>
			</span>
			<?php endif; ?>										
		</div>
		<?php endif; ?>
	</div>
</li>
