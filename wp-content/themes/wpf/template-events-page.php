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
?>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    $(".more-info").click(function(event) {
      event.preventDefault();
      $($(this).parent().next('.event-body').slideToggle('slow'));
    });
  });
</script>

<div class="bars">
  <div class="site-width">
    <?php
    $args = array(
      'post_type' => 'events',
      'showposts' => -1,
      'meta_query' => array(
        array('key' => 'event_date', 'value' => strtotime("Today"), 'compare' => '>=')
      ),
      'orderby' => 'meta_value',
      'order'=> 'ASC'
    );
    $events = new WP_Query($args);

    while($events->have_posts()) : $events->the_post();
      echo '<div class="event-header">'."\n";
        echo '<div class="date">'."\n";
          echo "<div>\n";
            if (get_post_meta(get_the_ID(), 'event_date', true) != "TBD") {
              echo date("M", get_post_meta(get_the_ID(), 'event_date', true));
              echo '<h3>'.date("d", get_post_meta(get_the_ID(), 'event_date', true)).'</h3>';
            } else {
              echo "TBD";
            }
          echo "</div>\n";
        echo "</div>\n";
        
        echo '<div class="details">'."\n";
          the_title('<h2>','</h2>');

          if (get_post_meta(get_the_ID(), 'event_start_time', true) != "") {
            echo '<h3>'.get_post_meta(get_the_ID(), 'event_start_time', true);
            if (get_post_meta(get_the_ID(), 'event_start_time', true) != "" && get_post_meta(get_the_ID(), 'event_end_time', true) != "")
              echo " - ".get_post_meta(get_the_ID(), 'event_end_time', true);
            echo "</h3>\n";
          }
          
          if (get_post_meta(get_the_ID(), 'event_location_name', true) != "" || get_post_meta(get_the_ID(), 'event_location_address', true) != "") echo '<div class="location">'."\n";
            if (get_post_meta(get_the_ID(), 'event_location_name', true) != "")
              echo get_post_meta(get_the_ID(), 'event_location_name', true);
            if (get_post_meta(get_the_ID(), 'event_location_name', true) != "" && get_post_meta(get_the_ID(), 'event_location_address', true) != "") echo ' &bull; ';
            if (get_post_meta(get_the_ID(), 'event_location_address', true) != "")
              echo get_post_meta(get_the_ID(), 'event_location_address', true);
          if (get_post_meta(get_the_ID(), 'event_location_name', true) != "" || get_post_meta(get_the_ID(), 'event_location_address', true) != "") echo "</div>\n";
        echo "</div>\n";
        
        if (get_post_meta(get_the_ID(), 'event_registration_text', true) != "")
          echo '<div class="reg-text">'.get_post_meta(get_the_ID(), 'event_registration_text', true)."</div>\n";

        if (get_post_meta(get_the_ID(), 'event_registration_link', true) != "" && get_post_meta(get_the_ID(), 'event_register_button', true) != "")
            echo '<a href="'.get_post_meta(get_the_ID(), 'event_registration_link', true).'" class="button">Register</a>';

        echo '<a href="#" class="more-info">More Info<div></div></a>';
      echo "</div>\n";

      echo '<div class="event-body">'."\n";
        echo '<div class="event-body-content">'."\n";
          echo '<div class="event-sidebar">'."\n";
            if (has_post_thumbnail(get_the_ID()) || get_post_meta(get_the_ID(), 'event_video', true) != "") {
              if (has_post_thumbnail(get_the_ID()))
                $event_media = '<img src="'.get_the_post_thumbnail_url(get_the_ID(),'full').'" alt="">';

              if (get_post_meta(get_the_ID(), 'event_video', true) != "")
                $event_media = '<div class="video">'.wp_oembed_get(get_post_meta(get_the_ID(), 'event_video', true))."</div>\n";

              echo $event_media;
            }

          echo "</div>\n";

          echo '<div class="event-text">'."\n";
            the_content();
          echo "</div>\n";
        echo "</div>\n";
      echo "</div>\n";
    endwhile;
    ?>
  </div>
</div>

<?php get_footer(); ?>