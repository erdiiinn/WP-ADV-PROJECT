<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="casino-post">
            <h2 class="casino-post-title"><?php the_title(); ?></h2>
            <div class="casino-post-content"><?php the_content(); ?></div>
        </div>
    <?php endwhile; ?>
<?php else : ?>
    <p class="casino-no-posts">No posts found.</p>
<?php endif; ?>
