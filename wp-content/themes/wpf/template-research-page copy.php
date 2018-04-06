<?php
/* Template Name: Research */

$pageid = basename(home_url($wp->request));

get_header();

if ($pageid == "research") {
  if ( have_posts() ) :
    while ( have_posts() ) : the_post();
    ?>
      <div class="title-banner">
        <?php the_title('<h1 class="site-width">','</h1>'); ?>
      </div>
    <?php
    endwhile;
  endif;
}



if ($pageid != "research") {
  echo "TERMINAL PAGE";
} else {
  echo "INDEX PAGE";
}
?>

<a href="/WPF/research/383/">LINK</a>

<?php get_footer(); ?>