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

    <?php $corporate = get_post(793); ?>
    <div id="corporate" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><span>WPF's</span> <?php echo $corporate->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($corporate->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#corporate -->

    <?php $government = get_post(795); ?>
    <div id="government" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><span>WPF's</span> <?php echo $government->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($government->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#government -->

    <?php $education = get_post(797); ?>
    <div id="education" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><span>WPF's</span> <?php echo $education->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($education->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#education -->

    <?php $nonprofit = get_post(799); ?>
    <div id="nonprofit" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><span>WPF's</span> <?php echo $nonprofit->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($nonprofit->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#nonprofit -->

    <?php $individual = get_post(801); ?>
    <div id="individual" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><span>WPF's</span> <?php echo $individual->post_title; ?></h2>
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
      jQuery(this).wrap('<a href="<?php echo home_url(); ?>/current-members/" style="background-image: linear-gradient(rgba(36,169,224,0.5), rgba(36,169,224,0.5)), url('+jQuery(this).attr('src')+');"></a>');
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