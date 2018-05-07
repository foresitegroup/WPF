<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">Event Registration</h1>
</div>

<div class="bars">
  <div class="site-width">
    <?php
    while(have_posts()) : the_post();
      get_template_part('content', 'events');
    endwhile; ?>
  </div> <!-- /.site-width -->
</div> <!-- /.bars -->

REGISTER FORM HERE

<?php get_footer(); ?>