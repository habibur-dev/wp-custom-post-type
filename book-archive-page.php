<?php

get_header();
?>
<div class="book-archive-page-wrapper">
	<h2>All Books</h2>
<?php
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$args = array(
    'post_type' 	 	=> 'book',
    'posts_per_page'	=> 8,
	'paged' 			=> $paged,
);
$books_query = new WP_Query( $args );

if ( $books_query->have_posts() ) {
	?>
	<div class="book-archive-items-wrapper">
	<?php
	
	// Load posts loop.
	while ( $books_query->have_posts() ) { $books_query->the_post();
		?>
		<div class="book-archive-item">
			<div class="book-archive-item-inner">
				<div class="book-thumbnail">
					<a href="<?php the_permalink(); ?>">
					<img src="<?php the_post_thumbnail_url(); ?>" alt="">
					</a>
				</div>
				<div class="book-archive-cotent">
					<a href="<?php the_permalink(); ?>">
					<?php the_title( '<h3>', '</h3>' ); ?>
					</a>
				
					<?php the_excerpt(); ?>
					<a href="<?php the_permalink(); ?>" class="view-btn button">View Details</a>
				</div>
			</div>
		</div>
		<?php
	}

	
	
	?>
		<div class="book-archive-pagination">
			<?php
			echo paginate_links(array(
				'total' => $books_query->max_num_pages
			));
			?>
		</div>
	</div>
	<?php
	
} else {
	echo "No posts found!";
}

?>
</div>
<?php

get_footer();