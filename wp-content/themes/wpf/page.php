<?php
get_header();

if (have_posts()) :
	while (have_posts()) : the_post();
    ?>
    <div class="title-banner">
      <?php the_title('<h1 class="site-width">','</h1>'); ?>
    </div>
    
    <div class="bars">
      <div class="site-width">
  		  <?php the_content(); ?>
      </div>
    </div>
    <?php
	endwhile;
endif;

get_footer();
?>