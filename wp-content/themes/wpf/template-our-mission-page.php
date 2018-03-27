<?php
/* Template Name: Our Mission */

get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();
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
?>

<?php $mission = get_post(65); ?>
<div id="mission-mission">
  <div class="image" style="background-image: url(<?php echo get_the_post_thumbnail_url($mission->ID); ?>);"></div>

  <div class="site-width">
    <div class="text">
      <h2><?php echo $mission->post_title; ?></h2>
      <?php echo $mission->post_content; ?>
    </div>
  </div>
</div>

<?php $vision = get_post(69); ?>
<div id="mission-vision">
  <div class="image" style="background-image: url(<?php echo get_the_post_thumbnail_url($vision->ID); ?>);"></div>

  <div class="site-width">
    <div class="text">
      <h2><?php echo $vision->post_title; ?></h2>
      <?php echo nl2br($vision->post_content); ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>