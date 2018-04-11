<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">Tag: <?php echo single_term_title("", false); ?></h1>
</div>

<div class="bars">
  <div class="site-width">
    <?php get_template_part('content', 'research'); ?>
  </div>
</div>

<?php get_footer(); ?>