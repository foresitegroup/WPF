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
    <div id="publication-info">
      <img src="images/2017-03.jpg" alt="">

      <div>
        <h2>The Last Mile:</h2>
        <h3>Connecting Workers to Places of Employment</h3>
        <h4>March 2017</h4>
        <h5>Tags:</h5>

        <a href="#" class="tag">Sample Tag</a>
        <a href="#" class="tag">Sample Tag</a>
        <a href="#" class="tag">Sample Tag</a>
        <a href="#" class="tag">Longer Sample Tag</a>
      </div>
    </div>

    Our latest research suggests that flexible forms of transit service &mdash; and perhaps new strategies linked to partnerships with ride-hailing companies like Lyft and Uber &mdash; could help address the region's elusive "last mile" problem.<br>
    <br>

    <h2>Policy Recommendations</h2>
    <ul>
      <li>Build on recent efforts to improve transportation connections in the Milwaukee area through shared-ride taxi services.</li>
      <li>Build on recent efforts to improve transportation connections in the Milwaukee area through shared-ride taxi services.</li>
      <li>Build on recent efforts to improve transportation connections in the Milwaukee area through shared-ride taxi services.</li>
    </ul>

    <a href="#" class="button">View Publication</a>
  </div>
</div>

<?php $join = get_post(55); ?>
<div id="home-join" style="background-image: url(<?php echo get_the_post_thumbnail_url($join->ID); ?>);">
  <div>
  	<?php echo $join->post_content; ?>
  </div>
</div>

<div id="home-blog">
  <div class="site-width">
  	<?php
  	$blog = new WP_Query(array('showposts' => 3));

  	if ($blog->have_posts()) {
  		while ($blog->have_posts() ) : $blog->the_post();
  			echo '<div class="blog">';
  			  the_title("<h1>","</h1>");
  			  echo fg_excerpt(50);
  			  echo '<div><a href="';
  			  the_permalink();
  			  echo '">Read More</a></div>';
  			echo '</div>';
  		endwhile;
  	}
  	?>
  </div>
</div>

<?php get_footer(); ?>