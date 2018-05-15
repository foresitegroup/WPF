<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">Insights</h1>
</div>

<div id="tabs" class="insights-tabs">
  <a href="<?php echo get_site_url(null, '/insights/our-insights/'); ?>">Our Insights</a>
  <label>In The News</label>
</div>

<?php get_template_part('content', 'insights'); ?>

<?php get_footer(); ?>