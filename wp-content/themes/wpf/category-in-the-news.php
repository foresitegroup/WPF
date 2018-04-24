<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">News</h1>
</div>

<div id="tabs" class="news-tabs">
  <a href="<?php echo get_site_url(null, '/news/our-news/'); ?>">Our News</a>
  <label>In The News</label>
</div>

<?php get_template_part('content', 'news'); ?>

<?php get_footer(); ?>