<?php $total_comments = get_comments_number(); ?>
<section id="comments" class="comments-list-wrapper">
	<h2><?php printf( _n( 'No Comments', '1 Comment', '% Comments', $total_comments ), $total_comments ); ?></h2>
	<ol class="comment-list">

		<?php
		wp_list_comments( [
			'max_depth'   => 2,
			'avatar_size' => 64,
			'style'       => 'ol',
		] );
		?>

	</ol>

	<?php the_comments_navigation(); ?>

	<?php comment_form(); ?>

</section>