<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">Event Registration</h1>
</div>

<div class="bars">
  <div class="site-width">
    <?php
    while(have_posts()) : the_post();
      get_template_part('content', 'events');
    endwhile; ?>
  </div> <!-- /.site-width -->
</div> <!-- /.bars -->

<div id="eventreg">
  <div class="site-width">
    <?php echo do_shortcode("[ninja_form id=".$post->event_registration_form."]"); ?>
  </div>
</div>

<script type="text/javascript">
  jQuery(document).on('nfFormReady', function(e, layoutView) {
    function LineWidth() {
      if (window.innerWidth > 1100) {
        var Lwidth = jQuery(window).width() - ((jQuery(window).width() - 1100) / 2);
        jQuery('#eventreg .line > DIV').css('width', Lwidth);
      }
    }

    LineWidth();

    jQuery(window).resize(function(){
      setTimeout(function() { LineWidth(); },100);
    });
  });
</script>

<?php get_footer(); ?>