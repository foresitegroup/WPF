<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">Research</h1>
</div>

<div class="bars">
  <div class="site-width">
    <?php
    if(have_posts()) : while(have_posts()) : the_post();
      the_title();
      echo '<div class="entry-content">';
        the_content();
        the_permalink();
      echo '</div>';
    endwhile; endif;
    ?>
  </div>
</div>

<?php get_footer(); ?>