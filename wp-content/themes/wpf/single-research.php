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
      <?php
      }

    	the_title('<h1>','</h1>');

    	if ($post->fg_research_subtitle) echo "<h2>".$post->fg_research_subtitle."</h2>";

      echo "<h3>";
      if ($post->focus_volume) echo "Focus #" . $post->focus_volume . " &bull; ";
      the_date('F Y');
      echo "</h3>\n";

      if ($post->fg_research_full_report || $post->fg_research_report_brief || $post->fg_research_executive_summary || $post->fg_research_blog || $post->fg_research_press_release || $post->fg_research_video || $post->fg_research_interactive_data) {
        echo '<div class="view">';
          // echo "View:\n";
          if ($post->fg_research_full_report)
            echo '<a href="'.$post->fg_research_full_report.'">Full Report</a>';
          if ($post->fg_research_report_brief)
            echo '<a href="'.$post->fg_research_report_brief.'">Report Brief</a>';
          if ($post->fg_research_executive_summary)
            echo '<a href="'.$post->fg_research_executive_summary.'">Executive Summary</a>';
          if ($post->fg_research_blog)
            echo '<a href="'.$post->fg_research_blog.'">Presentation</a>';
          if ($post->fg_research_press_release)
            echo '<a href="'.$post->fg_research_press_release.'">Press Release</a>';
          if ($post->fg_research_video)
            echo '<a href="'.$post->fg_research_video.'">Video Summary</a>';
          if ($post->fg_research_interactive_data)
            echo '<a href="'.$post->fg_research_interactive_data.'">Interactive Data</a>';
        echo "</div>\n";
      }
    	?>
    </div>
    
    <div id="research-buttons">
      <?php
      $printlink = "javascript:window.print()";
      if ($post->focus_volume) $printlink = $post->focus_pdf;
      if ($post->fg_research_full_report) $printlink = $post->fg_research_full_report;
      ?>
      <a href="<?php echo $printlink; ?>" id="print-page">Print <i class="fas fa-print"></i></a>

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
        <a href="mailto:?subject=<?php echo the_title('','',false); ?>&amp;body=%0ACheck out this article from Wisconsin Policy Forum: %0A<?php the_permalink(); ?>" target="new" class="email"></a>
      </div>
    </div>
  </div>
</div>

<div class="bars research-single<?php if (!has_post_thumbnail() || $post->featured_image_page_display != "") echo ' noimg'; if (has_term('datatool', 'research-category')) echo ' datatool'; ?>">
  <?php if ($post->fg_research_video) { ?>
  	<div id="with-video">
  		<div class="site-width">
  			<div id="cover">
  				<?php if (has_post_thumbnail() && $post->featured_image_page_display == "") echo '<img src="'.get_the_post_thumbnail_url().'" alt="">'; ?>
  			</div>
  		</div>
      
      <div id="video-box">
      	<div class="site-width">
      		<div id="video-wrap">
      		  <h4>Video Summary</h4>

      		  <div class="video">
      		  	<?php echo wp_oembed_get($post->fg_research_video); ?>
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
      <div id="content">
        <?php if (has_post_thumbnail() && $post->featured_image_page_display == "") echo '<img src="'.get_the_post_thumbnail_url().'" alt="" id="cover-float">'; ?>

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