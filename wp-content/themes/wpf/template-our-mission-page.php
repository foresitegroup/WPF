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

<div id="reports">
  <div id="line"></div>

  <div class="site-width">
    <h2>Annual Reports</h2>

    <div id="reports-slideshow">
      <?php
      $reports = new WP_Query(array('post_type'=>'annual_reports', 'orderby'=>'title', 'showposts' => -1));

      while($reports->have_posts()) : $reports->the_post();
        echo "<div>";
          echo "<div>";
            echo '<img src="' . get_the_post_thumbnail_url(get_the_ID()) . '" alt="">';

            echo "<div>";
              the_title('<h3>','</h3>');
              echo fg_excerpt(35, '...');
              echo '<a href="' . get_post_meta(get_the_ID(), 'annual_report_pdf', true) . '">Download Report <i class="fas fa-download"></i></a>';
            echo "</div>";
          echo "</div>";
        echo "</div>";
      endwhile;
      ?>

      <a href=# id="prev"><i class="fas fa-chevron-left"></i></a> 
      <a href=# id="next"><i class="fas fa-chevron-right"></i></a>
    </div>
  </div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.cycle2.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.cycle2.carousel.min.js"></script>

<script type="text/javascript">
  jQuery(document).ready(function() {
    function buildCarousel() {
      var slides = 2;

      if (window.innerWidth < 601) { slides = 1; }

      jQuery('#reports-slideshow').cycle({
        timeout: 0,
        slides: "> div",
        prev: "#prev",
        next: "#next",
        fx: 'carousel',
        carouselFluid: 'true',
        carouselVisible: slides,
        allowWrap: false
      });
    }

    function resizeCarousel() {
      jQuery('#reports-slideshow').cycle('destroy');
      buildCarousel();
    }

    buildCarousel();

    jQuery(window).resize(function(){
      setTimeout(function() { resizeCarousel(); },100);
    });

    jQuery('#mission-mission H2, #mission-vision H2, #reports .cycle-slide H3').html(function(){
      var text = jQuery(this).text().trim().split(' ');
      var first = text.shift();
      return '<span>'+first+'</span>'+' '+text.join(' ');
    });
  });
</script>

<?php get_footer(); ?>