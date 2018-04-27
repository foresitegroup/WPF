<?php get_header(); ?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		?>
		<div id="hero" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
      <div class="box">
        <div class="site-width">
          <div class="box-text">
          	<?php the_title('<h1>','</h1>'); ?>
		        <?php the_content(); ?>
		      </div>
        </div>
      </div>
    </div>
		<?php
	endwhile;
endif;
?>

<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery('#hero H1').html(function(){
      var text = jQuery(this).text().trim().split(' ');
      var first = text.shift();
      var second = text.shift();
      return '<span>'+first+' '+second+'</span>'+' '+text.join(' ');
    });
  });
</script>

<div id="ep-header">
  <div class="site-width">
    <h1 class="left"><span>Upcoming</span> Events</h1>
    <h1 class="right"><span>Featured</span> Publication</h1>
  </div>
</div>

<div id="ep" class="site-width">
  <div id="events">
    <div id="pinned">
      <div class="event">
        <h2><div>May<div>30</div></div></h2>
        <div>
          <h3>The Big Event: A Top-Pinned Event To Generate Buzz</h3>
          <h4>6:00 - 9:00 PM</h4>
          The Big Event Location<br>
          123 Main St., Madison, WI
        </div>
      </div>
    </div>

    <div class="event">
      <h2><div>Mar<div>06</div></div></h2>
      <div>
        <h3>2018 Wisconsin Policy Forum Annual Meeting</h3>
        <h4>5:00 - 7:00 PM</h4>
        The Wisconsin Club<br>
        900 W Wisconsin Ave., Milwaukee, WI
      </div>
    </div>

    <div class="event">
      <h2><div>Mar<div>13</div></div></h2>
      <div>
        <h3>Wisconsin Policy Forum Madison Kick-Off Event</h3>
        <h4>5:00 - 7:00 PM</h4>
        Brocach Irish Pub & Whiskey Den<br>
        7 W Main St., Madison, WI
      </div>
    </div>

    <div class="event">
      <h2><div>Apr<div>30</div></div></h2>
      <div>
        <h3>2018 Budget Meeting</h3>
        <h4>5:00 - 7:00 PM</h4>
        Brocach Irish Pub & Whiskey Den<br>
        7 W Main St., Madison, WI
      </div>
    </div>

    <a href="#" class="button">View Event Calendar</a>
  </div>

  <div id="publication-header"><span>Featured</span> Publication</div>

  <div id="publication">
    <?php
    $homepub = new WP_Query(array('post_type' => 'research', 'posts_per_page' => 1));

    if ($homepub->have_posts()) :
      while ($homepub->have_posts()) : $homepub->the_post();
        echo '<div id="publication-info">';
          if (has_post_thumbnail()) echo '<img src="'.get_the_post_thumbnail_url().'" alt="">';

          echo "<div>";
            the_title('<h2>','</h2>');

            if (get_post_meta(get_the_ID(), 'fg_research_subtitle', true))
              echo "<h3>".get_post_meta(get_the_ID(), 'fg_research_subtitle', true)."</h3>";

            the_date('F Y','<h4>','</h4>');

            if (has_term('', 'research-tag')) {
              echo '<div id="tags">';
                echo "<h5>Tags:</h5>";
                the_terms(get_the_ID(), 'research-tag', '', '');
              echo "</div>";
            }
          echo "</div>";
        echo "</div>";

        the_content();

        echo '<a href="';
        the_permalink();
        echo '" class="button">View Publication</a>';
      endwhile;
      wp_reset_postdata();
    endif;
    ?>
  </div>
</div>

<?php $join = get_post(55); ?>
<div id="home-join" style="background-image: url(<?php echo get_the_post_thumbnail_url($join->ID); ?>);">
  <div>
  	<?php echo $join->post_content; ?>
  </div>
</div>

<div id="home-news">
  <div class="site-width">
  	<?php
  	$news = new WP_Query(array('showposts' => 3));

  	if ($news->have_posts()) {
  		while ($news->have_posts() ) : $news->the_post();
  			echo '<div class="news-post">';
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

  			  echo fg_excerpt(50);

          echo '<a href="'.get_permalink().'">Read More</a>';
  			echo '</div>';
  		endwhile;
  	}
  	?>
  </div>
</div>

<?php get_footer(); ?>