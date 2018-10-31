<?php
if (is_single()) : ?>
  
  <div id="insights-single-header">
    <div class="site-width">
      <?php
      $category = get_the_category();

      $cats = wp_get_post_categories(get_the_ID(), array('parent' =>  $category[0]->category_parent));
      if (!empty($cats)) {
        $sep = ', '; $output = '';
        foreach($cats as $cat) {
          $c = get_category($cat);
          $output .= esc_html($c->name) . $sep;
        }
        echo '<h4>'.trim($output, $sep).'</h4>';
      }

      echo '<h3>'.get_the_date('n/j/y').'</h3>';
      
      the_title('<h1>', '</h1>');
      ?>

      <h2>By <span><?php echo get_the_author(); ?></span></h2>

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
  
  <div class="bars">
    <div class="site-width insights-single<?php if (!has_post_thumbnail()) echo ' noimg'; ?>">
      <div id="insights-single-sidebar">
        <?php if (has_post_thumbnail()) { ?>
        <div id="insights-single-image" style="background-image: url(<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>);"></div>
        <?php } ?>

        <?php if (has_term('', 'post_tag')) { ?>
          <div id="tags">
            <?php
            echo "Tags: ";
            the_terms(get_the_ID(), 'post_tag', '', '');
            ?>
          </div>
        <?php } ?>

<!--         <div id="single-search">
          Search News Archive
          <form role="search" method="get" id="search" action="<?php //echo esc_url(home_url('/')); ?>">
            <div>
              <input type="search" id="search-field" name="s" autocomplete="off"><button type="submit" id="search-button"><i class="fas fa-search"></i></button>
              <input type="radio" name="cat" value="30" id="ro"<?php //if ($category[0]->category_parent == 30) echo " checked"; ?>> <label for="ro">Our News</label>
              <input type="radio" name="cat" value="31" id="ri"<?php //if ($category[0]->category_parent == 31) echo " checked"; ?>> <label for="ri">In The News</label>
            </div>
          </form>
        </div> -->
      </div>
      
      <div id="insights-single-text">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
  
<?php endif; ?>