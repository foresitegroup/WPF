<?php
/* Template Name: Sponsorship */

get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();
  ?>
    <div class="title-banner spon-title">
      <?php the_title('<h1 class="site-width">','</h1>'); ?>
    </div>
  <?php
  endwhile;
endif;
?>

<div class="site-width sponsorship-after-title">
  <?php echo $post->sponsorship_after_title; ?>
</div>

<div class="wwd sponsorship">
  <div class="site-width">
    <div class="text">
      <h2><?php echo $post->sponsorship_section1_title; ?></h2>
      <?php echo wpautop(html_entity_decode($post->sponsorship_section1_text)); ?>
    </div>

    <div class="image" style="background-image: url(<?php echo $post->sponsorship_section1_image; ?>);"></div>
  </div>
</div>

<div class="wwd sponsorship right">
  <div class="site-width">
    <div class="text">
      <h2><?php echo $post->sponsorship_section2_title; ?></h2>
      <?php echo wpautop(html_entity_decode($post->sponsorship_section2_text)); ?>
    </div>

    <div class="image" style="background-image: url(<?php echo $post->sponsorship_section2_image; ?>);"></div>
  </div>
</div>

<div class="sponsorship-prefooter">
  <div class="site-width">
    <h2><?php echo $post->sponsorship_prefooter_title; ?></h2>

    <div id="spontact">
      <?php echo $post->sponsorship_prefooter_contact; ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>