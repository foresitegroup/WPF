<?php
get_header();

// Hero slider
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

// Figure out what will be shown in the Featured column
$publication_args = array('post_type' => 'focus', 'posts_per_page' => 1, 'meta_query' => array(array('key' => 'focus_featured', 'value' => '', 'compare' => '!=')));
$featured_publication = new WP_Query($publication_args);

if ($featured_publication->have_posts()) {
  $featured_args = $publication_args;
  $featured_title = "Publication";
} else {
  $featured_args = array('post_type' => 'research', 'posts_per_page' => 1);
  $featured_title = "Research";
}

wp_reset_postdata();
?>

<section id="home-twocol">
  <div id="upcoming-events">
    <h2><span>Upcoming</span> Events</h2>

    <div class="events">
      <?php
      $home_events = new WP_Query(array(
        'post_type' => 'events',
        'posts_per_page' => -1,
        'meta_query' => array(
          'relation' => 'AND',
          'mdate' => array('key' => 'event_date', 'value' => strtotime("Today"), 'compare' => '>='),
          'mpin' => array('key' => 'event_pin')
        ),
        'orderby' => array('mpin' => 'DESC', 'mdate'=> 'ASC')
      ));

      if ($home_events->have_posts()) :
        while ($home_events->have_posts()) : $home_events->the_post();
          ?>
          <a href="<?php the_permalink(); ?>" class="event<?php if ($post->event_pin == "on") echo " pinned"; ?>">
            <div class="date">
              <?php
              if ($post->event_date != "TBD") {
                echo date("M", $post->event_date);
                echo '<h3>'.date("d", $post->event_date).'</h3>';
              } else {
                echo "TBD";
              }
              ?>
            </div>
            
            <div class="details">
              <?php
              the_title("<h3>","</h3>\n");

              if ($post->event_start_time != "") {
                echo '<h4>'.$post->event_start_time;
                if ($post->event_start_time != "" && $post->event_end_time != "")
                  echo " - ".$post->event_end_time;
                echo "</h4>\n";
              }

              if ($post->event_location_name != "" || $post->event_location_address) echo '<div class="location">'."\n";
                if ($post->event_location_name != "") echo $post->event_location_name."\n";
                if ($post->event_location_name != "" && $post->event_location_address != "") echo "<br>\n";
                if ($post->event_location_address != "") echo $post->event_location_address."\n";
              if ($post->event_location_name != "" || $post->event_location_address != "") echo "</div>\n";
              ?>
            </div>
          </a>
          <?php
        endwhile;
      endif;

      wp_reset_postdata();
      ?>

      <a href="<?php echo home_url(); ?>/events/" class="button">View Event Calendar</a>
    </div>
  </div>

  <div id="featured">
    <h2><span>Featured</span> <?php echo $featured_title; ?></h2>

    <?php
    $home_featured = new WP_Query($featured_args);

    if ($home_featured->have_posts()) :
      while ($home_featured->have_posts()) : $home_featured->the_post();
        echo '<div class="content">'."\n";
        if (has_post_thumbnail()) echo '<a href="'.get_the_permalink().'" class="image">'.get_the_post_thumbnail($post->ID, 'medium', array('alt' => 'Read '.get_the_title(), 'aria-label' => 'Read '.get_the_title(), 'loading' => 'lazy'))."</a>\n";

          echo '<div class="info">';
            echo '<a href="'.get_the_permalink().'">'."\n";
              the_title("<h3>","</h3>\n");
            
              if ($post->fg_research_subtitle != "") echo "<h4>".$post->fg_research_subtitle."</h4>\n";
            echo "</a>\n";
            
            echo "<h5>";
              if ($post->focus_volume != "") echo "Focus #".$post->focus_volume." &bull; ";
              the_date('F Y');
            echo "</h5>\n";

            if (has_term('', 'research-tag')) {
              echo '<div class="tags">'."\n";
                echo "<h5>Tags:</h5>\n";
                the_terms(get_the_ID(), 'research-tag', '', '');
              echo "</div>\n";
            }
          echo "</div>\n";

          if (strpos($post->post_content, '<!--more-->')) {
            the_content('');
          } else {
            echo home_focus_excerpt();
          }

          echo '<a href="'.get_the_permalink().'" class="button">View '.$featured_title."</a>\n";
        echo "</div>\n";
      endwhile;
    endif;

    wp_reset_postdata();
    ?>
  </div>
</section>

<section id="home-join" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
  <div>
    <?php the_content(); ?>
  </div>
</section>

<section id="home-blog">
  <div class="site-width">
    <?php
    $news = new WP_Query(array('posts_per_page' => 3));

    if ($news->have_posts()) {
      while ($news->have_posts() ) : $news->the_post();
        echo "<div>\n";
          $categories = get_the_category();
          $slugs = [];

          if ($categories) {
            $slugs = array_column($categories, 'slug');
            $sep = ', '; $cats = '';

            foreach($categories as $category) { $cats .= $category->name.$sep; }

            echo "<h2>".trim($cats, $sep)."</h2>\n";
          }

          the_title("<h1>","</h1>");

          $TheText = (in_array('in-the-news', $slugs)) ? $post->inthenews_source : fg_excerpt(50);
          echo "<p>".$TheText."</p>\n";

          $TheLink = (in_array('in-the-news', $slugs)) ? $post->inthenews_link : get_permalink();
          echo '<a href="'.$TheLink.'" aria-label="Read more about '.get_the_title().'">Read More</a>'."\n";
        echo "</div>\n";
      endwhile;
    }

    wp_reset_postdata();
    ?>
  </div>
</section>

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
</script>

<?php get_footer(); ?>