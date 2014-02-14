<?php
/**
 * @version   $Id: item.php 13028 2013-08-28 13:14:00Z arifin $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * @var $item RokSprocket_Item
 */

// tagging
$tags                   = $item->getParam('lists_item_tags', false);
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
<?php if($parameters->get('lists_enable_accordion')): ?>
	<li <?php if (!$parameters->get('lists_enable_accordion') || $index == 0): ?>class="active" <?php endif;?>data-lists-item>
		<?php if ($item->custom_can_show_title): ?>
		<h4 class="sprocket-lists-title<?php if ($parameters->get('lists_enable_accordion')): ?> padding<?php endif; ?>" data-lists-toggler>
			<?php if ($item->custom_can_have_link): ?><a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>"><?php endif; ?>
				<?php echo $item->getTitle();?>
			<?php if ($item->custom_can_have_link): ?></a><?php endif; ?>
			<?php if ($parameters->get('lists_enable_accordion')): ?><span class="indicator"><span>+</span></span><?php endif; ?>
		</h4>
		<?php endif; ?>
		<span class="sprocket-lists-item" data-lists-content>
			<span class="sprocket-padding">
				<?php if ($item->getPrimaryImage()) :?>
				<a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>">
					<span class="sprocket-lists-image">
						<img src="<?php echo $item->getPrimaryImage()->getSource(); ?>" alt="" />
					</span>	
				</a>
				<?php endif; ?>
				<span class="sprocket-lists-desc">
					<?php echo $item->getText(); ?>
				</span>
				<?php if ($item->getPrimaryLink()) : ?>
				<span class="readon-wrapper">
					<a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>" class="readon"><span><?php rc_e('READ_MORE'); ?></span></a>
				</span>
				<?php endif; ?>
			</span>
		</span>
	</li>
<?php endif; ?>

<?php if (!$parameters->get('lists_enable_accordion')): ?>
	<li<?php echo strlen($item->custom_tags) ? ' class="'.$item->custom_tags.'"' : ''; ?> data-lists-item>
		<span class="sprocket-lists-item" data-lists-content>
			<span class="sprocket-padding">
				<?php if ($item->custom_can_show_title): ?>
				<span class="sprocket-lists-title<?php if ($parameters->get('lists_enable_accordion')): ?> padding<?php endif; ?>" data-lists-toggler>
					<?php if ($item->custom_can_have_link): ?><a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>"><?php endif; ?>
						<?php echo $item->getTitle();?>
					<?php if ($item->custom_can_have_link): ?></a><?php endif; ?>
					<?php if ($parameters->get('lists_enable_accordion')): ?><span class="indicator"><span>+</span></span><?php endif; ?>
				</span>
				<?php endif; ?>
				
				<?php if (($parameters->get('lists_article_details') !== '0')): ?>
				<span class="sprocket-lists-infos <?php if (($parameters->get('lists_article_details') == 'author') or ($parameters->get('lists_article_details') == '1')) echo "author-enabled"; ?> <?php if (($parameters->get('lists_article_details') == 'date') or ($parameters->get('lists_article_details') == '1')) echo "date-enabled"; ?>">
					<?php if (($parameters->get('lists_article_details') == 'author') or ($parameters->get('lists_article_details') == '1')) :?>
						<strong class="author"><?php echo $item->getAuthor(); ?></strong>
					<?php endif; ?>
					<?php if (($parameters->get('lists_article_details') == 'date') or ($parameters->get('lists_article_details') == '1')) :?>
					<span class="date">
						<?php if(($date = date_create($item->getDate())) !== false ){
						echo $date->format('M j, Y g:i a');
						} ?>
					</span>
					<?php endif; ?>										
				</span>
				<?php endif; ?>
						
				<?php if ($item->getPrimaryImage()) :?>
				<a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>">
					<span class="sprocket-lists-image">
						<img src="<?php echo $item->getPrimaryImage()->getSource(); ?>" alt="" />
					</span>	
				</a>
				<?php endif; ?>
				<span class="sprocket-lists-desc">
					<?php echo $item->getText(); ?>
				</span>
				<?php if (count($item->custom_tags_list)) : ?>
				<span class="rt-tags">
				<?php
					foreach($item->custom_tags_list as $key => $name){
				 		echo ' <span class="rt-tag rt-tag-'.$key.'">'.$name.'</span>';
					}
				?>
				</span>
				<?php endif; ?>
				<?php if ($item->getPrimaryLink()) : ?>
				<span class="readon-wrapper">
					<a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>" class="readon"><span><?php rc_e('READ_MORE'); ?></span></a>
				</span>
				<?php endif; ?>
			</span>
		</span>
		<span class="clear"></span>
	</li>
<?php endif; ?>
