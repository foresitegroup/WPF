<?php
/* Template Name: Renew */

get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();
  ?>

    <div class="title-banner">
      <h1 class="site-width">Join/Renew</h1>
    </div>

  <?php
  endwhile;
endif;
?>

<div id="tabs" class="insights-tabs">
  <a href="<?php echo get_site_url(null, '/join/'); ?>">Join</a>
  <label>Renew</label>
</div>

<div class="bars join-renew">
  <div class="site-width">
    <?php
    $renew = get_post(103);
    echo wpautop($renew->post_content);
    ?>
    <br>

    <div class="cf">
      <div id="join-form" class="join-form">
        <?php echo do_shortcode("[ninja_form id=6]"); ?>
      </div>

      <div class="jr-sidebar">
        <?php
        $renew_sidebar = get_post(544);
        echo $renew_sidebar->post_content;
        ?>
      </div>
    </div>
  </div>
</div>

<div id="dues">
  <div class="site-width">
    <?php
    $dues = get_post(105);
    echo '<h3>'.$dues->post_title.'</h3>';
    echo '<div class="columns">';
      echo $dues->post_content;
    echo '</div>';
    ?>
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
  });
</script>

<?php get_footer(); ?>