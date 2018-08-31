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
        <?php
        $sharesearch = array(' ', '|', '&#038;');
        $treplace = array('+', '%7C', '%26');
        $lreplace = array('+', '%20', '%26');
        ?>
        <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); if (has_post_thumbnail()) echo '&picture='.get_the_post_thumbnail_url(); ?>" target="new" class="facebook"></a>
        <a href="http://www.twitter.com/share?url=<?php the_permalink(); ?>&text=<?php echo str_replace($sharesearch, $treplace, the_title('','',false)); ?>" target="new" class="twitter"></a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php echo str_replace($sharesearch, $lreplace, the_title('','',false)); ?>" target="new" class="linkedin"></a>
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

<?php
$meta = get_post_meta(get_the_ID());
if (count(preg_grep('/^focus_media_/', array_keys($meta))) !== 0) {
  $medialinks = '<strong>Links:</strong>';
  ?>
  <div id="media-without-video">
    <div class="site-width">
      <div id="media-coverage">
        <h4>Media Coverage</h4>

        <?php
        for ($i = 1; $i <= 20; $i++) {
          if (isset($meta['focus_media_link_'.$i])) echo '<a href="'.$meta['focus_media_link_'.$i][0].'">';

          if (isset($meta['focus_media_title_'.$i])) echo '"'.$meta['focus_media_title_'.$i][0].'"';

          if (isset($meta['focus_media_link_'.$i])) {
            echo ' <span class="print">['.$i.']</span></a>';
            $medialinks .= '<br>['.$i.'] '.$meta['focus_media_link_'.$i][0];
          }

          if (isset($meta['focus_media_source_'.$i])) echo '<em>'.$meta['focus_media_source_'.$i][0].'</em>';
        }
        ?>
      </div>
    </div>
  </div>
<?php } ?>

<?php get_footer(); ?>