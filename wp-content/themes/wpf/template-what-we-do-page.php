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
?>

<div class="wwd">
  <div class="site-width">
    <div class="text">
      <h2><?php echo $post->wwd_page_section1_title; ?></h2>
      <?php echo nl2br(html_entity_decode($post->wwd_page_section1_text)); ?>
    </div>

    <div class="image" style="background-image: url(<?php echo $post->wwd_page_section1_image; ?>);"></div>
  </div>
</div>

<div class="wwd right">
  <div class="site-width">
    <div class="text">
      <h2><?php echo $post->wwd_page_section2_title; ?></h2>
      <?php echo nl2br(html_entity_decode($post->wwd_page_section2_text)); ?>
    </div>

    <div class="image" style="background-image: url(<?php echo $post->wwd_page_section2_image; ?>);"></div>
  </div>
</div>

<div class="wwd">
  <div class="site-width">
    <div class="text">
      <h2><?php echo $post->wwd_page_section3_title; ?></h2>
      <?php echo nl2br(html_entity_decode($post->wwd_page_section3_text)); ?>
    </div>

    <div class="image" style="background-image: url(<?php echo $post->wwd_page_section3_image; ?>);"></div>
  </div>
</div>

<div class="wwd right">
  <div class="site-width">
    <div class="text">
      <h2><?php echo $post->wwd_page_section4_title; ?></h2>
      <?php echo nl2br(html_entity_decode($post->wwd_page_section4_text)); ?>
    </div>

    <div class="image" style="background-image: url(<?php echo $post->wwd_page_section4_image; ?>);"></div>
  </div>
</div>

<?php get_footer(); ?>