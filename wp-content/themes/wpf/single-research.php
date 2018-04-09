<?php
get_header();

if(have_posts()) : while(have_posts()) : the_post();
?>

<div id="research-single-banner">
  <div class="site-width">
  	<div class="category">
  	  Category: 
  	  <?php
	  	$terms = get_terms('research-category');
	  	foreach ($terms as $term)
	  		echo '<a href="'.get_term_link($term->slug, 'research-category').'">'.$term->name.'</a>';
	  	?>
	  </div>

  	<?php
  	the_title('<h1>','</h1>');

  	if (get_post_meta(get_the_ID(), 'fg_research_subtitle', true))
      echo "<h2>".get_post_meta(get_the_ID(), 'fg_research_subtitle', true)."</h2>";

    the_date('F Y','<h3>','</h3>');
  	?>

    <div class="view">
    	View: 
    	<?php
    	if (get_post_meta(get_the_ID(), 'fg_research_full_report', true))
        echo '<a href="'.get_post_meta(get_the_ID(), 'fg_research_full_report', true).'">Full Report</a>';
      if (get_post_meta(get_the_ID(), 'fg_research_executive_summary', true))
        echo '<a href="'.get_post_meta(get_the_ID(), 'fg_research_executive_summary', true).'">Executive Summary</a>';
      if (get_post_meta(get_the_ID(), 'fg_research_blog', true))
        echo '<a href="'.get_post_meta(get_the_ID(), 'fg_research_blog', true).'">Blog</a>';
      if (get_post_meta(get_the_ID(), 'fg_research_press_release', true))
        echo '<a href="'.get_post_meta(get_the_ID(), 'fg_research_press_release', true).'">Press Release</a>';
      if (get_post_meta(get_the_ID(), 'fg_research_video', true))
        echo '<a href="'.get_post_meta(get_the_ID(), 'fg_research_video', true).'">Video Summary</a>';
      ?>
    </div>
  </div>
</div>

<div class="bars">
	<div class="with-video">
		<div class="site-width">
			<div class="cover">
				<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
			</div>
		</div>
    
    <div class="video-box">
    	<div class="site-width">
    		<div class="video-wrap">
    		  <h4>Video Summary</h4>

    		  <div class="video">
    		  	<?php echo wp_oembed_get(get_post_meta(get_the_ID(), 'fg_research_video', true)); ?>
    		  </div>
    		</div>
    	</div>
    </div>
	</div>

	<div class="content-with-video">
		<div class="media">
			<div class="site-width">
				<div class="media-coverage">
					<h4>Media Coverage</h4>

					<?php
					// for ($i = 1; $i <= 20; $i++) {
						
					// }
					?>
				</div>
			</div>
		</div>

		<div class="site-width">
			<div class="content">
				<?php the_content(); ?>
			</div>
		</div>
	</div>



  <div class="site-width">
  	<?php //the_content(); ?>
  </div>
</div>

<?php
endwhile; endif;

get_footer();
?>