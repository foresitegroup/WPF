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
        echo nl2br($join->post_content);
        ?>

        <br><br><br><br>
        <div class="cf">
          <div class="join-form">
            JOIN FORM GOES HERE
          </div>

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
        echo nl2br($renew->post_content);
        ?>

        <br><br><br><br>
        <div class="cf">
          <div class="join-form">
            RENEW FORM GOES HERE
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
      jQuery(this).wrap('<a href="<?php echo home_url(); ?>/current-members/" style="background-image: url('+jQuery(this).attr('src')+');"></a>');
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