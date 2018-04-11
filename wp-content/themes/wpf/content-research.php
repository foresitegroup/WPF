<?php
if(have_posts()) : while(have_posts()) : the_post();
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
endwhile; endif;
?>