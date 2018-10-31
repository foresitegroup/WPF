<?php
get_header();

if(have_posts()) : while(have_posts()) : the_post();
?>

<div id="research-single-banner">
  <div class="site-width">
    <div id="research-banner-text">
      <?php if (has_term('', 'research-category')) { ?>
        <div class="category">
          <?php
          echo "Category: ";
          the_terms(get_the_ID(), 'research-category', '', '');
          ?>
        </div>
      <?php } ?>

    	<?php
    	the_title('<h1>','</h1>');

    	if (get_post_meta(get_the_ID(), 'fg_research_subtitle', true))
        echo "<h2>".get_post_meta(get_the_ID(), 'fg_research_subtitle', true)."</h2>";

      the_date('F Y','<h3>','</h3>');
    	?>

      <div class="view">
      	View: 
      	<?php
      	if (get_post_meta(get_the_ID(), 'fg_research_full_report', true))
          echo '<a href="'.get_post_meta(get_the_ID(), 'fg_research_full_report', true).'">Full Report</a>';
        if (get_post_meta(get_the_ID(), 'fg_research_report_brief', true))
          echo '<a href="'.get_post_meta(get_the_ID(), 'fg_research_report_brief', true).'">Full Report</a>';
        if (get_post_meta(get_the_ID(), 'fg_research_executive_summary', true))
          echo '<a href="'.get_post_meta(get_the_ID(), 'fg_research_executive_summary', true).'">Executive Summary</a>';
        if (get_post_meta(get_the_ID(), 'fg_research_blog', true))
          echo '<a href="'.get_post_meta(get_the_ID(), 'fg_research_blog', true).'">Blog</a>';
        if (get_post_meta(get_the_ID(), 'fg_research_press_release', true))
          echo '<a href="'.get_post_meta(get_the_ID(), 'fg_research_press_release', true).'">Press Release</a>';
        if (get_post_meta(get_the_ID(), 'fg_research_video', true))
          echo '<a href="'.get_post_meta(get_the_ID(), 'fg_research_video', true).'">Video Summary</a>';
        ?>
      </div>
    </div>
    
    <div id="research-buttons">
      <a href="javascript:window.print()" id="print-page">Print <i class="fas fa-print"></i></a>

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

<div class="bars research-single<?php if (!has_post_thumbnail()) echo ' noimg'; ?>">
  <?php if (get_post_meta(get_the_ID(), 'fg_research_video', true)) { ?>
  	<div id="with-video">
  		<div class="site-width">
  			<div id="cover">
  				<?php if (has_post_thumbnail()) echo '<img src="'.get_the_post_thumbnail_url().'" alt="">'; ?>
  			</div>
  		</div>
      
      <div id="video-box">
      	<div class="site-width">
      		<div id="video-wrap">
      		  <h4>Video Summary</h4>

      		  <div class="video">
      		  	<?php echo wp_oembed_get(get_post_meta(get_the_ID(), 'fg_research_video', true)); ?>
      		  </div>
      		</div>
      	</div>
      </div>
  	</div>

  	<div id="content-with-video">
  		<div class="site-width">
  			<div id="content">
  				<?php the_content(); ?>
          
          <?php if (has_term('', 'research-tag')) { ?>
            <div id="tags">
              <?php
              echo "Tags: ";
              the_terms(get_the_ID(), 'research-tag', '', '');
              ?>
            </div>
          <?php } ?>
  			</div>
  		</div>

      <?php
      $meta = get_post_meta(get_the_ID());
      if (count(preg_grep('/^fg_research_media_/', array_keys($meta))) !== 0) {
        $medialinks = '<strong>Links:</strong>';
        ?>
        <div id="media">
          <div class="site-width">
            <div id="media-coverage">
              <h4>Media Coverage</h4>

              <?php
              for ($i = 1; $i <= 20; $i++) {
                if (isset($meta['fg_research_media_link_'.$i])) echo '<a href="'.$meta['fg_research_media_link_'.$i][0].'">';

                if (isset($meta['fg_research_media_title_'.$i])) echo '"'.$meta['fg_research_media_title_'.$i][0].'"';

                if (isset($meta['fg_research_media_link_'.$i])) {
                  echo ' <span class="print">['.$i.']</span></a>';
                  $medialinks .= '<br>['.$i.'] '.$meta['fg_research_media_link_'.$i][0];
                }

                if (isset($meta['fg_research_media_source_'.$i])) echo '<em>'.$meta['fg_research_media_source_'.$i][0].'</em>';
              }
              ?>
            </div>
          </div>
        </div>
      <?php } ?>
  	</div>

    <script>
      jQuery(function($) {
        jQuery('#content').css({'min-height': jQuery('#media').height()});
      });
    </script>

  <?php } else { ?>

    <div class="site-width">
      <div id="cover">
        <?php if (has_post_thumbnail()) echo '<img src="'.get_the_post_thumbnail_url().'" alt="">'; ?>
      </div>

      <div id="content">
        <?php the_content(); ?>

        <?php if (has_term('', 'research-tag')) { ?>
          <div id="tags">
            <?php
            echo "Tags: ";
            the_terms(get_the_ID(), 'research-tag', '', '');
            ?>
          </div>
        <?php } ?>
      </div>
    </div>
    
    <?php
    $meta = get_post_meta(get_the_ID());
    if (count(preg_grep('/^fg_research_media_/', array_keys($meta))) !== 0) {
      $medialinks = '<strong>Links:</strong>';
      ?>
      <div id="media-without-video">
        <div id="media-coverage" class="site-width">
          <h4>Media Coverage</h4>
          
          <div id="columns">
            <?php
            for ($i = 1; $i <= 20; $i++) {
              if (array_key_exists('fg_research_media_title_'.$i, $meta) || array_key_exists('fg_research_media_link_'.$i, $meta) || array_key_exists('fg_research_media_source_'.$i, $meta)) echo '<div>';

              if (isset($meta['fg_research_media_link_'.$i])) echo '<a href="'.$meta['fg_research_media_link_'.$i][0].'">';

              if (isset($meta['fg_research_media_title_'.$i])) echo '"'.$meta['fg_research_media_title_'.$i][0].'"';

              if (isset($meta['fg_research_media_link_'.$i])) {
                echo ' <span class="print">['.$i.']</span></a>';
                $medialinks .= '<br>['.$i.'] '.$meta['fg_research_media_link_'.$i][0];
              }

              if (isset($meta['fg_research_media_source_'.$i])) echo '<em>'.$meta['fg_research_media_source_'.$i][0].'</em>';

              if (array_key_exists('fg_research_media_title_'.$i, $meta) || array_key_exists('fg_research_media_link_'.$i, $meta) || array_key_exists('fg_research_media_source_'.$i, $meta)) echo '</div>';
            }
            ?>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } ?>
</div>

<div class="print links">
  <strong>Source URL:</strong> <?php the_permalink(); ?><br><br>
  <?php echo $medialinks; ?>
</div>

<?php
endwhile; endif;

get_footer();
?>