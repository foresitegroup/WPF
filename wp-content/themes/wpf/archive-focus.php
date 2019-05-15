<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">Focus</h1>
</div>

<div class="bars insights-bars">
  <div class="site-width">
    <div class="insights-header cf">
      <div class="pagination">
        <?php
        $paginate_args = array('show_all' => true, 'prev_text' => '<', 'next_text' => '>');
        echo paginate_links($paginate_args);
        ?>
      </div> <!-- /.pagination -->
    </div> <!-- /.insights-header -->
    
    <div class="insights-posts">
      <?php
      while(have_posts()) : the_post();
        echo '<div class="insights-post focus-post">';
          echo "<h5>Focus";
          if ($post->focus_volume != "") echo " #" . $post->focus_volume;
          echo "</h5>\n";

          echo "<h4>".get_the_date('Y')."</h4>\n";

          the_title('<h3>','</h3>');

          if (strpos($post->post_content, '<!--more-->')) {
            echo wp_strip_all_tags(get_the_content('...'));
          } else {
            echo fg_excerpt(40, '...');
          }
          
          echo '<a href="'.get_permalink().'" class="button">Read More</a>';
        echo "</div>\n";
      endwhile;
      ?>
    </div> <!-- /.insights-posts -->
    
    <div class="insights-header bottom cf">
      <div class="pagination">
        <?php echo paginate_links($paginate_args); ?>
      </div> <!-- /.pagination -->
    </div> <!-- /.insights-header.bottom -->
  </div> <!-- /.site-width -->
</div> <!-- /.bars -->

<?php get_footer(); ?>