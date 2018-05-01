<?php
/* Template Name: Events */

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

$events = new WP_Query(array('post_type'=>'events', 'orderby'=>'event_date', 'order'=> 'ASC', 'showposts' => -1));

while($events->have_posts()) : $events->the_post();
  the_title('<h3>','</h3>');

  if (get_post_meta(get_the_ID(), 'event_date', true) != "") {
    echo "<h4>".date("m/d/Y", get_post_meta(get_the_ID(), 'event_date', true))."</h4>";
  } else {
    echo "TBD";
  }
endwhile;

get_footer();
?>