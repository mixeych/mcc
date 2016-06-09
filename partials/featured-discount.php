<?php
	$featured_posts = get_posts(array(
		'showposts' => -1,
		'post_type' => 'discount',
		'tax_query' => array(
			array(
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => array('featured')
		))
	));
	
	
?>

<?php while ( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>
<div class="featured-discount">
<div class="discount-preview">
<?php 
if ( has_post_thumbnail() ) {
	the_post_thumbnail();
}
?>
<div class="discount-preview-footer">
<div class="discount-preview-title">
<?php get_the_title(); ?>
</div>
<div class="discount-preview-location">
</div>
<div class="discount-preview-value">
</div>
</div>
</div>
</div>
<?php endwhile; ?>