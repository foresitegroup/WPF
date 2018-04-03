<?php
/* Template Name: What We Do */

get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();
  ?>
    <div class="title-banner">
      <?php the_title('<h1 class="site-width">','</h1>'); ?>
    </div>
  <?php
  endwhile;
endif;

$post = get_post(95);
?>

<div class="wwd">
  <div class="site-width">
    <div class="text">
      <h2><?php echo get_post_meta($post->ID, 'wwd_page_section1_title', true); ?></h2>
      <?php echo nl2br(get_post_meta($post->ID, 'wwd_page_section1_text', true)); ?>
    </div>

    <div class="image" style="background-image: url(<?php echo get_post_meta($post->ID, 'wwd_page_section1_image', true); ?>);"></div>
  </div>
</div>

<div class="wwd right">
  <div class="site-width">
    <div class="text">
      <h2><?php echo get_post_meta($post->ID, 'wwd_page_section2_title', true); ?></h2>
      <?php echo nl2br(get_post_meta($post->ID, 'wwd_page_section2_text', true)); ?>
    </div>

    <div class="image" style="background-image: url(<?php echo get_post_meta($post->ID, 'wwd_page_section2_image', true); ?>);"></div>
  </div>
</div>

<div class="wwd">
  <div class="site-width">
    <div class="text">
      <h2><?php echo get_post_meta($post->ID, 'wwd_page_section3_title', true); ?></h2>
      <?php echo nl2br(get_post_meta($post->ID, 'wwd_page_section3_text', true)); ?>
    </div>

    <div class="image" style="background-image: url(<?php echo get_post_meta($post->ID, 'wwd_page_section3_image', true); ?>);"></div>
  </div>
</div>

<?php get_footer(); ?>