<?php $category = get_queried_object(); ?>

<div class="bars insight-bars">
  <div class="site-width insights-index">
    <div class="insights-header cf">
      <div class="insights-search">
        <form role="search" method="get" id="search" action="<?php echo esc_url(home_url('/')); ?>">
          Search:
          <div>
            <input type="search" id="search-field" name="s" autocomplete="off"><button type="submit" id="search-button"><i class="fas fa-search"></i></button>
            <input type="hidden" name="cat" value="<?php echo $category->term_id; ?>">
          </div>
        </form>
      </div> <!-- /.insights-search -->

      <div class="pagination">
        <?php
        $paginate_args = array('show_all' => true, 'prev_text' => '<', 'next_text' => '>');
        echo paginate_links($paginate_args);
        ?>
      </div> <!-- /.pagination -->
    </div> <!-- /.insights-header -->

    <?php
    if(have_posts()) :
      ?>
      <div class="insights-posts">
        <?php
        while(have_posts()) : the_post();
          echo '<div class="insights-post">';
            $cats = wp_get_post_categories(get_the_ID(), array('parent' => $category->term_id));
            if (!empty($cats)) {
              $sep = ', '; $output = '';
              foreach($cats as $cat) {
                $c = get_category($cat);
                $output .= esc_html($c->name) . $sep;
              }
              echo '<h5>'.trim($output, $sep).'</h5>';
            }

            echo '<h4>'.get_the_date('n/j/y').'</h4>';

            the_title('<h3>','</h3>');

            echo fg_excerpt(50);

            echo '<a href="'.get_permalink().'" class="button">Read More</a>';
          echo '</div>';
        endwhile;
        ?>
      </div> <!-- /.insights-posts -->
    <?php
    else:
      if (is_search()) {
        echo 'Sorry, there are no results for "'.$_GET['s'].'"';
      }
    endif;
    ?>

    <div class="insights-header bottom cf">
      <div class="pagination">
        <?php
        $paginate_args = array('show_all' => true, 'prev_text' => '<', 'next_text' => '>');
        echo paginate_links($paginate_args);
        ?>
      </div> <!-- /.pagination -->
    </div> <!-- /.insights-header.bottom -->
  </div> <!-- /.insights-index -->
</div> <!-- /.bars -->