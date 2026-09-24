<?php
/* Template Name: Contact */

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
  // Display Presentation tab if URL is /contact-us/#presentationrequest
  // and remove "#presentation" from URL
  window.onload = function() {
    if(window.location.href.indexOf('#presentationrequest') > 0) {
      document.getElementById("tab2").checked = true;
      window.history.pushState(null, null, window.location.pathname);
    }
  }
</script>

<div id="tabs" class="contact">
  <input id="tab1" type="radio" name="tabs" checked>
  <label for="tab1">General</label>
  <input id="tab2" type="radio" name="tabs">
  <label for="tab2">Presentation Request</label>

  <div class="bars">
    <div class="site-width">
      <div id="general">
        <div class="contact-form">
          <?php echo do_shortcode("[ninja_form id=1]"); ?>
        </div>
      </div>

      <div id="presentation">
        <div class="contact-form">
          <?php echo do_shortcode("[ninja_form id=4]"); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="maps">
  <div class="site-width">
    <div class="line">
      <div></div>
      <h2>Wisconsin Policy Forum</h2>
    </div>

    <div id="maps-content">
      <div>
        <div class="map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3459.7463286391467!2d-87.92174292349489!3d43.027358392682736!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8805199129dc9fb5%3A0xcd0bd5232b277f50!2s600%20W%20Virginia%20St%2C%20Milwaukee%2C%20WI%2053204!5e1!3m2!1sen!2sus!4v1785427058755!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>
      </div>

      <div>
        <h3>Milwaukee</h3>
        Wisconsin Policy Forum<br>
        600 W. Virginia St. Suite 502<br>
        Milwaukee, WI 53204<br>
        <br>

        <span>Phone:</span> 414.276.8240
      </div>

      <div>
        <h3>Madison</h3>
        Wisconsin Policy Forum<br>
        30 W. Mifflin St. Suite 806<br>
        Madison, WI 53703<br>
        <br>

        <span>Phone:</span> 608.241.9789
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    function LineWidth() {
      if (window.innerWidth > 1100) {
        var Lwidth = jQuery(window).width() - ((jQuery(window).width() - 1100) / 2);
        jQuery('#maps .line > DIV').css('width', Lwidth);
      }
    }

    LineWidth();

    jQuery(window).resize(function(){
      setTimeout(function() { LineWidth(); },100);
    });
  });
</script>

<?php get_footer(); ?>