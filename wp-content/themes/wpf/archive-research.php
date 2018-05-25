<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">Research</h1>
</div>

<?php get_template_part('content', 'research'); ?>

<div id="focus">
  <div class="site-width">
    <div class="line">
      <div></div>
      <h2>Focus</h2>
    </div>

    <div id="focus-slideshow">
      <?php
      $focus = new WP_Query(array('post_type'=>'focus', 'showposts' => -1));

      while($focus->have_posts()) : $focus->the_post();
        echo "<div>";
          echo "<div>";
            echo '<div class="image" style="background-image: url(' . get_the_post_thumbnail_url(get_the_ID()) . ');"></div>';

            echo "<div class=\"text\">\n";
              echo "<h5>Focus";
              if ($post->focus_volume != "") echo " #" . $post->focus_volume;
              echo "</h5>\n";

              echo "<h4>".get_the_date('Y')."</h4>\n";

              the_title('<h3>','</h3>');

              echo '<div class="buttons">';
                echo '<a href="'.get_permalink().'">Read<span> More</span></a>';
                if ($post->focus_pdf != "") echo '<a href="' . $post->focus_pdf . '" class="pdf">Download<span> Issue <i class="fas fa-download"></i></span></a>';
              echo "</div>\n";
            echo "</div>\n";
          echo "</div>\n";
        echo "</div>\n";
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

      jQuery('#focus-slideshow').cycle({
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
      jQuery('#focus-slideshow').cycle('destroy');
      buildCarousel();
    }

    buildCarousel();

    jQuery(window).resize(function(){
      setTimeout(function() { resizeCarousel(); },100);
    });

    function LineWidth() {
      if (window.innerWidth > 1100) {
        var Lwidth = jQuery(window).width() - ((jQuery(window).width() - 1100) / 2);
        jQuery('#focus .line > DIV').css('width', Lwidth);
      }
    }

    LineWidth();

    jQuery(window).resize(function(){
      setTimeout(function() { LineWidth(); },100);
    });
  });
</script>

<?php get_footer(); ?>