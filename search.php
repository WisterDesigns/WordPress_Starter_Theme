<?php get_header(); ?>

<!-- CONTENT -->
<main id="content" class="main-content">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: "%s"', 'starter_theme' ), get_search_query() ); ?></h1>
		</header>

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" class="<?php post_class(); ?>">
				<header class="entry-header">
					<h2 class="entry-title"><?php the_title(); ?></h2>
				</header>
				<div class="entry-content">
					<?php the_excerpt(); ?>
				</div>
			</article>

		<?php endwhile; ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/no-content' ); ?>

	<?php endif; ?>

</main>
<!-- /CONTENT -->

<?php get_footer(); ?>
