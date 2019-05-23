<?php
/* Template Name: Current Members */

get_header();

if (have_posts()) :
  while (have_posts()) : the_post();
  ?>

    <div class="title-banner">
      <?php the_title('<h1 class="site-width">','</h1>'); ?>
    </div>
  <?php
  endwhile;
endif;
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/featherlight.css?<?php echo filemtime(get_template_directory() . "/inc/featherlight.css"); ?>">

<div class="bars">
  <div class="site-width">
    <div id="modal-links">
      <?php echo $post->post_content; ?>
    </div>
    
    <?php $pillars = get_page_by_path('current-members/pillars-of-public-policy'); ?>
    <div id="pillars" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $pillars->post_title; ?><div>$15,000 Donors</div></h2>
        </div>

        <div class="content logos">
          <?php echo nl2br($pillars->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#pillars -->

    <?php $sentinels = get_page_by_path('current-members/sentinels-of-civil-conduct'); ?>
    <div id="sentinels" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $sentinels->post_title; ?><div>$10,000 Donors</div></h2>
        </div>

        <div class="content logos">
          <?php echo nl2br($sentinels->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#sentinels -->
    
    <?php $corporate = get_page_by_path('current-members/corporate-members'); ?>
    <div id="corporate" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $corporate->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($corporate->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#corporate -->

    <?php $government = get_page_by_path('current-members/government-members'); ?>
    <div id="government" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $government->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($government->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#government -->

    <?php $education = get_page_by_path('current-members/education-members'); ?>
    <div id="education" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $education->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($education->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#education -->

    <?php $nonprofit = get_page_by_path('current-members/nonprofit-members'); ?>
    <div id="nonprofit" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $nonprofit->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($nonprofit->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#nonprofit -->

    <?php $individual = get_page_by_path('current-members/chairmans-club'); ?>
    <div id="individual" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $individual->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($individual->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#individual -->
  </div>
</div>

<div id="sponsors">
  <div class="site-width">
    <?php
    $sponsors = get_post(107);
    echo '<h3>'.$sponsors->post_title.'</h3>';
    echo '<div id="sponsor-slideshow">';
      echo $sponsors->post_content;
    echo '</div>';
    ?>
  </div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.cycle2.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.cycle2.carousel.min.js"></script>

<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery('#sponsor-slideshow IMG').each(function() {
      jQuery(this).wrap('<a href="<?php echo home_url(); ?>/current-members/"><div style="background-image: linear-gradient(rgba(36,169,224,0.5), rgba(36,169,224,0.5)), url('+jQuery(this).attr('src')+');"></div></a>');
    });

    function buildCarousel() {
      var slides = 4;

      if (window.innerWidth < 801) { slides = 3; }
      if (window.innerWidth < 601) { slides = 2; }
      if (window.innerWidth < 481) { slides = 1; }

      jQuery('#sponsor-slideshow').cycle({
        slides: "> a",
        fx: 'carousel',
        carouselFluid: 'true',
        carouselVisible: slides
      });
    }

    function resizeCarousel() {
      jQuery('#sponsor-slideshow').cycle('destroy');
      buildCarousel();
    }

    buildCarousel();

    jQuery(window).resize(function(){
      setTimeout(function() { resizeCarousel(); },100);
    });

    jQuery('#modal-links A').each(function() {
      jQuery(this).wrapInner('<span></span>').css('background-image', 'url('+jQuery(this).find('img').attr('src')+')')
    });
  });
</script>

<script src="<?php echo get_template_directory_uri(); ?>/inc/featherlight.min.js"></script>

<?php get_footer(); ?>