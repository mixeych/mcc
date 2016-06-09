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

	$featured_post = $featured_posts[0];
	
?>

<div><?php echo get_the_title($featured_post->ID); ?>
<img>

</div>