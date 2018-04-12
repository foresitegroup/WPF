<div class="filter-topic">
  <div class="site-width">
    Filter By Topic:
    <?php
    global $wp;
    $tax = 'research-category';
    $terms = get_terms($tax);
    foreach ($terms as $term) {
      echo '<a href="'.get_term_link($term->slug, $tax).'"';
      if (get_term_link($term->slug, $tax) == home_url($wp->request.'/')) echo ' class="current-cat"';
      echo '>'.$term->name.'</a>';
    }
    ?>
  </div>
</div>

<div class="filter-gray">
  <div class="site-width">
    Filter By Year:
    <form action="<?php echo home_url($wp->request.'/'); ?>" method="POST" name="FilterYear" id="FilterYear">
      <div class="select">
        <select name="year" onchange="document.FilterYear.submit()">
          <option value="">Year</option>
          <?php
          $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'research' ORDER BY post_date DESC");
          foreach($years as $year) :
             echo '<option value="'.$year.'"';
             if (isset($_REQUEST['year']) && $_REQUEST['year'] == $year) echo " selected";
             echo '>'.$year.'</option>';
          endforeach;
          ?>    
        </select>
      </div>
    </form>
  </div>
</div>

<div class="bars bars-research-index">
  <div class="site-width">
    <?php
    if (isset($_REQUEST['year'])) {
      global $wp_query;
      $args = array_merge($wp_query->query_vars, array('year' => $_REQUEST['year']));
      query_posts($args);
    }

    if(have_posts()) :
      echo '<div class="research-pagination">';
        $paginate_args = array('show_all' => true, 'prev_text' => '<', 'next_text' => '>');
        if (isset($_REQUEST['year'])) {
          $paginate_args['add_args'] = array('year' => $_REQUEST['year']);
        }
        echo paginate_links($paginate_args);
      echo '</div>';

      while(have_posts()) : the_post();
        echo '<a href="';
        the_permalink();
        echo '" class="research-index">';
          if (has_post_thumbnail()) echo '<img src="'.get_the_post_thumbnail_url().'" alt="">';
          
          echo '<div class="text">';
            the_title('<h2>','</h2>');
            
            if (get_post_meta(get_the_ID(), 'fg_research_subtitle', true))
              echo "<h3>".get_post_meta(get_the_ID(), 'fg_research_subtitle', true)."</h3>";

            the_date('F Y','<h4>','</h4>');

            echo '<h5>Available Media:</h5>';
            echo '<div class="media">';
              if (get_post_meta(get_the_ID(), 'fg_research_full_report', true)) echo '<span>Full Report</span>';
              if (get_post_meta(get_the_ID(), 'fg_research_executive_summary', true)) echo '<span>Executive Summary</span>';
              if (get_post_meta(get_the_ID(), 'fg_research_blog', true)) echo '<span>Blog</span>';
              if (get_post_meta(get_the_ID(), 'fg_research_press_release', true)) echo '<span>Press Release</span>';
              if (get_post_meta(get_the_ID(), 'fg_research_video', true)) echo '<span>Video Summary</span>';
            echo '</div>';

            if (has_term('', 'research-tag')) {
              echo '<div class="tags">';
                echo "<h5>Tags:</h5>";
                $tags = get_the_terms(get_the_ID(), 'research-tag');
                foreach ($tags as $tag) echo '<span>'.$tag->name.'</span>';
              echo '</div>';
            }
          echo '</div>';
        echo '</a>';
      endwhile;

      echo '<div class="research-pagination bottom">';
        echo paginate_links($paginate_args);
      echo '</div>';
    endif;
    ?>
  </div>
</div>