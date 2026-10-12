<?php
get_header();

if (have_posts()) :
	while (have_posts()) : the_post();
    ?>
    <section id="page-title">
      <h1 class="site-width">404 Error</h1>
    </section>
    
    <section class="bars-left">
      <div class="site-width">
  		  <h2>The page you requested could not be found.</h2>
        <br>
        Go to the <a href="<?php echo home_url(); ?>">home page</a> or select a page from the menu.
      </div>
    </section>
    <?php
	endwhile;
endif;

get_footer();
?>