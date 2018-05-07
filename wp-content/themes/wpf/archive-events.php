<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">Events</h1>
</div>

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
      get_template_part('content', 'events');
    endwhile; ?>
  </div> <!-- /.site-width -->
</div> <!-- /.bars -->

<?php get_footer(); ?>