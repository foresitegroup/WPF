<div class="filter-topic">
  <div class="site-width">
    Filter By Topic:
    <?php
    global $wp;
    $tax = 'research-category';
    $rcats = get_terms($tax);
    foreach ($rcats as $rcat) {
      echo '<a href="'.get_term_link($rcat->slug, $tax).'"';
      if (get_term_link($rcat->slug, $tax) == home_url($wp->request.'/')) echo ' class="current-cat"';
      echo '>'.$rcat->name.'</a>';
    }
    ?>
  </div>
</div>

<div class="filter-gray">
  <div class="site-width">
    <form action="<?php echo home_url($wp->request.'/'); ?>" method="POST" name="FilterYear" id="FilterYear">
      Filter By Year:
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
    
    <form role="search" method="get" id="search" action="<?php echo esc_url(home_url('/')); ?>">
      Search:
      <div>
        <input type="search" id="search-field" name="s" autocomplete="off"><button type="submit" id="search-button"><i class="fas fa-search"></i></button>
        <input type="hidden" name="post_type" value="research">
      </div>
    </form>

    <div id="tags-menu-button">
      <input type="checkbox" id="toggle-tags" role="button">
      <label for="toggle-tags">Show All Tags</label>
    </div>
  </div>
</div>

<div id="tags-menu">
  <div class="site-width">
    <?php
    $rtags = get_terms('research-tag');
    foreach ($rtags as $rtag) {
      echo '<a href="'.get_term_link($rtag->slug, 'research-tag').'">'.$rtag->name.'</a>';
    }
    ?>
  </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('#toggle-tags').change(function(){
      if(this.checked) {
        jQuery(this).siblings('label').html('Hide All Tags');
        jQuery('#tags-menu').show();
      } else {
        jQuery(this).siblings('label').html('Show All Tags');
        jQuery('#tags-menu').hide();
      }
    });
  });
</script>

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
          // if (has_post_thumbnail()) echo '<img src="'.get_the_post_thumbnail_url().'" alt="">';
          $Rimg = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : get_template_directory_uri().'/images/footer-logo.png';
          echo '<img src="'.$Rimg.'" alt="">';
          
          echo '<div class="text';
          // if (!has_post_thumbnail()) echo ' noimg';
          echo '">';
            the_title('<h2>','</h2>');
            
            if (get_post_meta(get_the_ID(), 'fg_research_subtitle', true))
              echo "<h3>".get_post_meta(get_the_ID(), 'fg_research_subtitle', true)."</h3>";

            the_date('F Y','<h4>','</h4>');

            echo '<h5>Available Products:</h5>';
            echo '<div class="media">';
              if (get_post_meta(get_the_ID(), 'fg_research_full_report', true)) echo '<span>Full Report</span>';
              if (get_post_meta(get_the_ID(), 'fg_research_report_brief', true)) echo '<span>Report Brief</span>';
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