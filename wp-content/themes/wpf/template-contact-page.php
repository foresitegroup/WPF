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

<div id="tabs">
  <input id="tab1" type="radio" name="tabs" checked>
  <label for="tab1">General</label>
  <input id="tab2" type="radio" name="tabs">
  <label for="tab2">Presentation Request</label>

  <div class="bars">
    <div class="site-width">
      <div id="general">
        GENERAL CONTENT HERE
      </div>

      <div id="presentation">
        PRESENTATION REQUEST CONTENT HERE
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>