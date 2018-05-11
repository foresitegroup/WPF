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
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2916.171091534933!2d-87.9220324845221!3d43.037831579147124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8805199dbf77da43%3A0x7f96bc00c3569c4b!2s633+W+Wisconsin+Ave%2C+Milwaukee%2C+WI+53203!5e0!3m2!1sen!2sus!4v1526051984757" width="600" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
      </div>

      <div>
        <h3>Milwaukee</h3>
        Wisconsin Policy Forum<br>
        633 W. Wisconsin Ave. Suite #406<br>
        Milwaukee, WI 53203<br>
        <br>

        <span>Phone:</span> 414.276.8240<br>
        <span>Fax:</span> 414.276.8240
      </div>

      <div>
        <div class="map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2913.018577457234!2d-89.34730078451997!3d43.10412447914389!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880654726c9a52b3%3A0xeb1f4aaad3e03b67!2s401+N+Lawn+Ave%2C+Madison%2C+WI+53704!5e0!3m2!1sen!2sus!4v1526052869301" width="600" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
      </div>

      <div>
        <h3>Madison</h3>
        Wisconsin Policy Forum<br>
        401 N. Lawn Ave.<br>
        Madison, WI 53704-5033<br>
        <br>

        <span>Phone:</span> 608.241.9789<br>
        <span>Fax:</span> 608.241.5807
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