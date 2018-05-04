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
      ?>
      <div class="event-header">
        <div class="date">
          <div>
            <?php
            if ($post->event_date != "TBD") {
              echo date("M", $post->event_date);
              echo '<h3>'.date("d", $post->event_date).'</h3>';
            } else {
              echo "TBD";
            }
            ?>
          </div>
        </div> <!-- /.date -->
        
        <div class="details">
          <?php
          the_title('<h2>','</h2>');

          if ($post->event_start_time != "") {
            echo '<h3>'.$post->event_start_time;
            if ($post->event_start_time != "" && $post->event_end_time != "")
              echo " - ".$post->event_end_time;
            echo "</h3>\n";
          }
          
          if ($post->event_location_name != "" || $post->event_location_address) echo '<div class="location">'."\n";
            if ($post->event_location_name != "") echo $post->event_location_name;
            if ($post->event_location_name != "" && $post->event_location_address != "") echo '<span>&bull;</span>';
            if ($post->event_location_address != "") echo $post->event_location_address;
          if ($post->event_location_name != "" || $post->event_location_address != "") echo "</div>\n";
          ?>
        </div> <!-- /.details -->
        
        <?php
        if ($post->event_registration_text != "")
          echo '<div class="reg-text">'.$post->event_registration_text."</div>\n";

        if ($post->event_registration_link != "" && $post->event_register_button != "")
            echo '<a href="'.$post->event_registration_link.'" class="button">Register</a>';
        ?>
        <a href="#" class="more-info">More Info<div></div></a>
      </div> <!-- /.event-header -->

      <div class="event-body">
        <div class="event-body-content">
          <div class="event-sidebar">
            <?php
            if (has_post_thumbnail(get_the_ID()) || $post->event_video != "") {
              if (has_post_thumbnail(get_the_ID()))
                $event_media = '<img src="'.get_the_post_thumbnail_url(get_the_ID(),'full').'" alt="">';

              if ($post->event_video != "")
                $event_media = '<div class="video">'.wp_oembed_get($post->event_video)."</div>\n";

              echo $event_media;
            }

            if ($post->event_pricing_member != "" || $post->event_pricing_non_member != "" || $post->event_pricing_corporate != "" || $post->event_pricing_friends != "" || $post->event_pricing_government != "") {
              ?>
              <h4>Pricing</h4>
              <div class="pricing">
                <?php if ($post->event_pricing_member != "") { ?>
                  <div class="price">
                    <div>
                      <div>Member</div>
                      <?php echo $post->event_pricing_member; ?>
                    </div>
                  </div>
                <?php } ?>

                <?php if ($post->event_pricing_non_member != "") { ?>
                  <div class="price">
                    <div>
                      <div>Non-Member</div>
                      <?php echo $post->event_pricing_non_member; ?>
                    </div>
                  </div>
                <?php } ?>

                <?php if ($post->event_pricing_corporate != "") { ?>
                  <div class="price">
                    <div>
                      <div>Corporate Table</div>
                      <?php echo $post->event_pricing_corporate; ?>
                    </div>
                  </div>
                <?php } ?>

                <?php if ($post->event_pricing_friends != "") { ?>
                  <div class="price">
                    <div>
                      <div>Friends Table</div>
                      <?php echo $post->event_pricing_friends; ?>
                    </div>
                  </div>
                <?php } ?>

                <?php if ($post->event_pricing_government != "") { ?>
                  <div class="price">
                    <div>
                      <div>Government Table</div>
                      <?php echo $post->event_pricing_government; ?>
                    </div>
                  </div>
                <?php } ?>
              </div>
              <?php
            }
            ?>
            
            <a href="<?php echo home_url(); ?>/contact-us" class="button">Contact Us</a>
          </div> <!-- /.event-sidebar -->

          <div class="event-text">
            <?php the_content(); ?>
          </div>
        </div> <!-- /.event-body-content -->
      </div> <!-- /.event-body -->
    <?php endwhile; ?>
  </div> <!-- /.site-width -->
</div> <!-- /.bars -->

<?php get_footer(); ?>