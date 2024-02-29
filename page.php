<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php the_content(); ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer">
            <?php edit_post_link(__('Edit', 'your-theme'), '<span class="edit-link">', '</span>'); ?>
        </footer><!-- .entry-footer -->
    </article><!-- #post-<?php the_ID(); ?> -->
<?php endwhile; ?>

<?php get_footer(); ?>
