<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">Tag: <?php echo single_term_title("", false); ?></h1>
</div>

<?php get_template_part('content', 'news'); ?>

<?php get_footer(); ?>