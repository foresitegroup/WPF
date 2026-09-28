<?php
get_header();

$hero = new WP_Query(array('post_type' => 'fg_slider', 'orderby' => 'menu_order', 'order'  => 'ASC', 'posts_per_page' => -1));

if ($hero->have_posts()) :
  echo '<section id="hero">'."\n";
    while ($hero->have_posts()) : $hero->the_post();
      echo '<div class="f-carousel__slide" style="background-image: url('.get_the_post_thumbnail_url().');">'."\n";
        echo '<div class="text">'."\n";
          the_title('<h1>','</h1>');
          the_content();
          if ($post->fg_slider_button_text != "" && $post->fg_slider_button_link != "") echo '<a href="'.$post->fg_slider_button_link.'" class="button">'.$post->fg_slider_button_text.'</a>';
        echo "</div>\n";
      echo "</div>\n";
    endwhile;
  echo "</section>\n";
endif;

wp_reset_postdata();

// echo do_shortcode('[fg-slider timeout="10000" random="true"]');

$fp_args = array('post_type' => 'focus', 'posts_per_page' => 1, 'meta_query' => array(array('key' => 'focus_featured', 'value' => '', 'compare' => '!=')));
$fp = new WP_Query($fp_args);

if ($fp->have_posts()) {
  $args = $fp_args;
  $fp_name = "Publication";
} else {
  $args = array('post_type' => 'research', 'posts_per_page' => 1);
  $fp_name = "Research";
}
?>

<div id="ep-header">
  <div class="site-width">
    <h1 class="left"><span>Upcoming</span> Events</h1>
    <h1 class="right"><span>Featured</span> <?php echo $fp_name; ?></h1>
  </div>
</div>

<div id="ep" class="site-width">
  <div id="events">
    <?php
    $hevents = new WP_Query(array(
      'post_type' => 'events',
      'posts_per_page' => -1,
      'meta_query' => array(
        'relation' => 'AND',
        'mdate' => array('key' => 'event_date', 'value' => strtotime("Today"), 'compare' => '>='),
        'mpin' => array('key' => 'event_pin')
      ),
      'orderby' => array('mpin' => 'DESC', 'mdate'=> 'ASC')
    ));

    if ($hevents->have_posts()) :
      while ($hevents->have_posts()) : $hevents->the_post();
        ?>
        <a href="<?php the_permalink(); ?>" class="event<?php if ($post->event_pin == "on") echo " pinned"; ?>">
          <div class="date-col">
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
          </div> <!-- /.date-col -->
          
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
              if ($post->event_location_name != "" && $post->event_location_address != "") echo "<br>\n";
              if ($post->event_location_address != "") echo $post->event_location_address;
            if ($post->event_location_name != "" || $post->event_location_address != "") echo "</div>\n";
            ?>
          </div>
        </a>
        <?php
      endwhile;
      wp_reset_postdata();
    endif;
    ?>

    <a href="<?php echo home_url(); ?>/events/" class="button">View Event Calendar</a>
  </div>

  <div id="publication-header"><span>Featured</span> <?php echo $fp_name; ?></div>

  <div id="publication">
    <?php
    $homepub = new WP_Query($args);

    if ($homepub->have_posts()) :
      while ($homepub->have_posts()) : $homepub->the_post();
        echo '<div id="publication-info">';
        if (has_post_thumbnail()) echo '<a href="'.get_the_permalink().'">'.get_the_post_thumbnail($post->ID, 'medium', array('alt' => 'Read '.get_the_title())).'</a>';

          echo '<div id="publication-title">';
            echo '<a href="'.get_the_permalink().'">';
              the_title('<h2>','</h2>');
            
              if ($post->fg_research_subtitle != "") echo "<h3>".$post->fg_research_subtitle."</h3>";
            echo "</a>\n";
            
            echo "<h4>";
              if ($post->focus_volume != "") echo "Focus #".$post->focus_volume." &bull; ";
              the_date('F Y');
            echo "</h4>\n";

            if (has_term('', 'research-tag')) {
              echo '<div id="tags">';
                echo "<h5>Tags:</h5>";
                the_terms(get_the_ID(), 'research-tag', '', '');
              echo "</div>";
            }
          echo "</div>";
        echo "</div>";

        if (strpos($post->post_content, '<!--more-->')) {
          the_content('');
        } else {
          echo home_focus_excerpt();
        }

        echo '<a href="'.get_the_permalink().'" class="button">View '.$fp_name.'</a>';
      endwhile;
      wp_reset_postdata();
    endif;
    ?>
  </div> <!-- #publication -->
</div>

<?php $join = get_post(55); ?>
<div id="home-join" style="background-image: url(<?php echo get_the_post_thumbnail_url($join->ID); ?>);">
  <div>
  	<?php echo $join->post_content; ?>
  </div>
</div>

<div id="home-insights">
  <div class="site-width">
  	<?php
  	$insights = new WP_Query(array('showposts' => 3));

  	if ($insights->have_posts()) {
  		while ($insights->have_posts() ) : $insights->the_post();
  			echo '<div class="insights-post">';
          $category = get_the_category();
          $cats = wp_get_post_categories(get_the_ID(), array('parent' => $category[0]->category_parent));
          if (!empty($cats)) {
            $sep = ', '; $output = '';
            foreach($cats as $cat) {
              $c = get_category($cat);
              $output .= esc_html($c->name) . $sep;
            }
            echo '<h2>'.trim($output, $sep).'</h2>';
          }

  			  the_title("<h1>","</h1>");

          echo ($category[0]->slug == "in-the-news") ? $post->inthenews_source : fg_excerpt(50);
          
          $TheLink = ($category[0]->slug == "in-the-news") ? $post->inthenews_link : get_permalink();

          echo '<a href="'.$TheLink.'" aria-label="Read more about '.get_the_title().'">Read More</a>';
  			echo '</div>';
  		endwhile;
  	}
  	?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.css">
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.autoplay.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.autoplay.css">

<script type="text/javascript">
  Carousel(document.getElementById('hero'), {
    style: { "--f-transition-duration" : "2s" }, gestures: false,
    Autoplay: { timeout: 10000, showProgressbar: false },
  }, { Autoplay } ).init();

  document.querySelectorAll('#hero H1').forEach(header => {
    const words = header.innerText.split(' ');
    if (words.length >= 2) {
      const firstTwo = `<span>${words[0]} ${words[1]}</span>`;
      const rest = words.slice(2).join(' ');
      header.innerHTML = `${firstTwo} ${rest}`;
    }
  });

  document.querySelector("#ep #events .pinned:last-child")?.classList.add("pinnedlast");
</script>

<?php get_footer(); ?>