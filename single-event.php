<?php
get_header();
?>

<div class="container">
    <div class="row">

        <?php while (have_posts()) : the_post(); ?>

            <div class="card col-lg-3 col-md-3 col-sm-12"> 
                <?php if (has_post_thumbnail()): ?>
                    <img src="<?php the_post_thumbnail_url('full'); ?>" class="img-fluid" alt="Event Image">
                <?php endif; ?>
                <div class="date-content btn btn-primary">
                    <p><?php echo get_the_date('M d'); ?></p>
                </div>
                <div class="info-content">
                    <p style="font-size:20px;font-weight:bold"><?php the_title(); ?></p>
                    <p><?php the_content(); ?></p>
                    <p><?php echo get_post_meta(get_the_ID(), 'event_time', true); ?></p>
                </div>
            </div>

        <?php endwhile; ?>

    </div>
</div>

<?php
get_footer();
?>
