<?php
/* Template Name: About */

get_header();

if (have_posts()) :
  while (have_posts()) : the_post();
  ?>

    <section id="page-title">
      <?php the_title('<h1 class="site-width">','</h1>'); ?>
    </section>

    <section class="bars-left">
      <div class="site-width">
        <?php the_content(); ?>
      </div>
    </section>
    
    <?php if ($post->about_mission) { ?>
      <section id="mission">
        <?php if ($post->about_mission_image) echo '<div class="image" style="background-image: url('.$post->about_mission_image.');"></div>'."\n"; ?>

        <div class="text">
          <h2><span>Our</span> Mission</h2>
          <?php echo apply_filters('the_content', $post->about_mission); ?>
        </div>
      </section>
    <?php } ?>

    <?php if ($post->about_purpose) { ?>
      <section id="purpose">
        <?php if ($post->about_purpose_image) echo '<div class="image" style="background-image: url('.$post->about_purpose_image.');"></div>'."\n"; ?>

        <div class="text">
          <h2><span>Our</span> Purpose</h2>
          <?php echo apply_filters('the_content', $post->about_purpose); ?>
        </div>
      </section>
    <?php } ?>

    <section id="reports">
      <h2>Organizational Documents</h2>

      <div id="od-slides" class="site-width">
        <?php
        $reports = new WP_Query(array('post_type'=>'annual_reports', 'orderby'=>'menu_order', 'showposts' => -1));

        while($reports->have_posts()) : $reports->the_post();
          echo '<div class="f-carousel__slide">'."\n";
            the_title('<h3>','</h3>');
            echo "<p>".fg_excerpt(35, '...')."</p>\n";
            if ($post->annual_report_pdf) echo '<a href="'.$post->annual_report_pdf.'" class="button">Download Report</a>'."\n";
          echo "</div>\n";
        endwhile;

        wp_reset_postdata();
        ?>
      </div>
    </section>

  <?php
  endwhile;
endif;
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.css">
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.arrows.css">
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.arrows.umd.js"></script>


<script type="text/javascript">
  // Remove "#reports" or "#mission" from URL if coming from another page
  window.onload = function() {
    if (window.location.href.indexOf('#reports') > 0 || window.location.href.indexOf('#mission') > 0) window.history.pushState(null, null, window.location.pathname);
  }

  Carousel(document.getElementById('od-slides'), {
    infinite: false, center: false, slidesPerPage: 1, gestures: false,
    Arrows: {
      nextTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256L34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941"/></svg>',
      prevTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94"/></svg>',
    },
  }, { Arrows } ).init();

  document.querySelectorAll('#od-slides H3').forEach(odsh => {
    odsh.innerHTML = odsh.innerHTML.replace(/^\s*(\S+)/, '<span>$1</span>');
  });
</script>

<?php get_footer(); ?>