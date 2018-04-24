<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">News</h1>
</div>

<div id="tabs" class="news-tabs">
  <label>Our News</label>
  <a href="<?php echo get_site_url(null, '/news/in-the-news/'); ?>">In The News</a>
</div>

<?php get_template_part('content', 'news'); ?>

<?php get_footer(); ?>