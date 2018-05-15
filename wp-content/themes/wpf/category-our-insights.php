<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">Insights</h1>
</div>

<div id="tabs" class="insights-tabs">
  <label>Our Insights</label>
  <a href="<?php echo get_site_url(null, '/insights/in-the-news/'); ?>">In The News</a>
</div>

<?php get_template_part('content', 'insights'); ?>

<?php get_footer(); ?>