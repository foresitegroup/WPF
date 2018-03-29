<?php
/* Template Name: Staff/Board */

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

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/featherlight.css?<?php echo filemtime(get_template_directory() . "/inc/featherlight.css"); ?>">

<div id="tabs">
  <input id="tab1" type="radio" name="tabs" checked>
  <label for="tab1">Staff</label>
  <input id="tab2" type="radio" name="tabs">
  <label for="tab2">Board</label>

  <div class="bars">
    <div class="site-width">
      <div id="staff">
        <a href="#" data-featherlight="#mylightbox" class="staff">Open element in lightbox</a>
        <div id="mylightbox" class="lightbox">
          Rob Henken is the President of the Public Policy Forum. Since joining the Forum in January 2008, Henken has authored or co-authored four reports that won national awards from the Governmental Research Association. He was named one of Milwaukee's 100 most influential leaders in The Milwaukee Business Journal's annual "Power Book" in 2012 and one of Milwaukee's "Game Changers" by M Magazine in 2013.
        </div>
      </div>

      <div id="board">
        BOARD
      </div>
    </div>
  </div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/inc/featherlight.min.js"></script>

<?php get_footer(); ?>