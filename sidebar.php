<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package dukkha
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
</div><!-- .paper -->
	</div><!-- .sm-12.md-8.col -->
	</div>
<div id="secondary" class="sm-12 md-4 col sidebar">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
