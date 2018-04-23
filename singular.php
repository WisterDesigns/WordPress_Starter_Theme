<?php get_header(); ?>

<!-- CONTENT -->
<main id="content" class="main-content">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="page-<?php the_ID(); ?>" class="<?php post_class(); ?>">
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>

			<?php if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif; ?>

		<?php endwhile; ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/no-content' ); ?>

	<?php endif; ?>

</main>
<!-- /CONTENT -->

<!-- SIDEBAR -->
<?php get_sidebar(); ?>
<!-- /SIDEBAR -->

<?php get_footer(); ?>
