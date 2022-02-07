<?php

get_header();

?>

<div class="single-book-main-wrapper">
<?php   

        while ( have_posts() ) : the_post();
        ?>
        <div class="single-book-inner">
                <div class="single-book-image">
                        <?php the_post_thumbnail(); ?>
                </div>
                <div class="single-book-container">
                        <div class="book-title-wrapper">
                                <?php the_title('<h2>', '</h2>'); ?>
                        </div>
                        <div class="single-book-meta">
                                <ul class="meta-wrapper">
                                        <li><?php the_date( 'd F, Y'); ?></li> | 
                                        <li>By - <?php the_author(); ?></li> | 
                                        <li>
                                        <?php echo get_the_term_list( $post->ID, 'book_category', '<span class="cat_item">', ', ', '</span>' ) ?>
                                        </li>
                                </ul>
                        </div>
                        <div class="single-book-content">
                                <?php the_content(); ?>
                        </div>
                </div>
        </div>
        <?php
        // End the loop.
        endwhile;

?>
</div>

<?php

get_footer();