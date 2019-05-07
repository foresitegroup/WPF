<?php
/* Template Name: Join/Renew */

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

<script type="text/javascript">
  // Display Presentation tab if URL is /join-renew/#renewal
  // and remove "#renew" from URL
  window.onload = function() {
    if(window.location.href.indexOf('#renewal') > 0) {
      document.getElementById("tab2").checked = true;
      window.history.pushState(null, null, window.location.pathname);
    }
  }
</script>

<div id="tabs">
  <input id="tab1" type="radio" name="tabs" checked>
  <label for="tab1">Join</label>
  <input id="tab2" type="radio" name="tabs">
  <label for="tab2">Renew</label>

  <div class="bars join-renew">
    <div class="site-width">
      <div id="join">
        <?php
        $join = get_post(101);
        echo wpautop($join->post_content);
        ?>
        <br>

        <div class="cf">
          <div id="join-form" class="join-form">
            <?php echo do_shortcode("[ninja_form id=5]"); ?>
          </div>

<!--           <script>
            jQuery(document).ready(function($){ 
              jQuery('#join-form').on('change','.join-type',function(){
                if (jQuery('.join-type').val() == 'Individual') {
                  jQuery('.join-ind').show();
                  jQuery('.join-comp').hide();
                } else {
                  jQuery('.join-ind').hide();
                  jQuery('.join-comp').show();
                }
              });
            });
          </script> -->

          <div class="jr-sidebar">
            <?php
            $join_sidebar = get_post(542);
            echo $join_sidebar->post_content;
            ?>
          </div>
        </div>
      </div> <!-- END Join tab -->

      <div id="renew">
        <?php
        $renew = get_post(103);
        echo wpautop($renew->post_content);
        ?>
        <br>

        <div class="cf">
          <div class="join-form">
            <?php echo do_shortcode("[ninja_form id=6]"); ?>
          </div>

          <div class="jr-sidebar">
            <?php
            $renew_sidebar = get_post(544);
            echo $renew_sidebar->post_content;
            ?>
          </div>
        </div>
      </div> <!-- END Renew tab -->
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
  });
</script>

<?php get_footer(); ?>