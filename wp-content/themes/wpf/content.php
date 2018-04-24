<?php
if (is_single()) : ?>

	<?php the_title('<h1>', '</h1>'); ?>
  <h2>By <?php echo get_the_author(); ?></h2>

  <div class="single-post-image" style="<?php echo (wp_get_attachment_url(get_post_thumbnail_id()) != "") ? "background-image: url(" . wp_get_attachment_url(get_post_thumbnail_id()) . ")" : "padding-top: 0; margin-bottom: 0;"; ?>"></div>

  <?php the_content(); ?>
  
<?php endif; ?>