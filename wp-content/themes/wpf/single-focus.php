<?php get_header(); ?>

<div id="focus-header">
  <div class="site-width">
    <h2>Focus<?php if ($post->focus_volume != "") echo " #" . $post->focus_volume; ?></h2>
    <h3><?php echo get_the_date('n/j/y') ?></h3>
    <?php the_title('<h1>', '</h1>'); ?>

    <div id="focus-header-buttons">
      <?php
      if ($post->focus_pdf != "")
        echo '<a href="' . $post->focus_pdf . '" class="button">PDF <i class="far fa-file-alt"></i></a>';
      ?>

      <input type="checkbox" id="toggle-share" role="button">
      <label for="toggle-share">Share <i class="fas fa-share-alt"></i></label>
      <div id="share-links">
        <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); if (has_post_thumbnail()) echo '&picture='.get_the_post_thumbnail_url(); ?>" target="new" class="facebook"></a>
        <a href="http://www.twitter.com/share?url=<?php the_permalink(); ?>&text=<?php echo str_replace(' ', '+', the_title('','',false)); ?>" target="new" class="twitter"></a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php echo str_replace(' ', '%20', the_title('','',false)); ?>" target="new" class="linkedin"></a>
      </div>
    </div>
  </div>
</div>

<div class="bars">
  <div class="site-width" id="focus-text">
    <?php
    while(have_posts()) : the_post();
      the_content();
    endwhile; ?>
  </div> <!-- /.site-width -->
</div> <!-- /.bars -->

<?php get_footer(); ?>