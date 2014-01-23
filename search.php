<?php /* The template for displaying Search Results pages. */ ?>
<?php
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

foreach($query_args as $key => $string) {
	$query_split = explode("=", $string);
	$search_query[$query_split[0]] = urldecode($query_split[1]);
} // foreach

$search = new WP_Query($search_query);

global $wp_query;
$total_results = $wp_query->found_posts;

/* Paginate results */

$big = 999999999; // need an unlikely integer
$args = array(
	'base'         => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
	'format'       => '?paged=%#%',
	'total'        => $wp_query->max_num_pages,
	'current'      => max(1, get_query_var('paged')),
	'show_all'     => False,
	'end_size'     => 1,
	'mid_size'     => 2,
	'prev_next'    => True,
	'prev_text'    => __('Previous'),
	'next_text'    => __('Next'),
	'type'         => 'plain',
	'add_args'     => False,
	'add_fragment' => ''
);

?>

<?php get_header(); ?>

	<section class="main main--search" role="main"> 

	<?php if (!empty($search_query['s'])) : ?>

		<h1>Search Results ( <?php echo $total_results; ?> found )</h1>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		    <article class="article article--search-result">
		    	<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		        <?php the_excerpt(); ?>
		    </article>
		    
		<?php endwhile; ?>

			<div class="pagination pagination--search-result">
				<?php echo paginate_links($args); ?> 
			</div>

		<?php endif; ?>

	<?php else : $total_results = 0; ?>

		<h1>Search Results ( <?php echo $total_results; ?> found )</h1>
		<p>Sorry, there are no results matching your search criteria</p>

	<?php endif; ?>		

	</section>

<?php get_footer(); ?>