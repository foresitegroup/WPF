<?php
/* Template Name: What We Do */

get_header();

if (have_posts()) :
  while (have_posts() ) : the_post();
  ?>

    <section id="page-title">
      <?php the_title('<h1 class="site-width">','</h1>'); ?>
    </section>

    <section id="what-we-do">
      <?php
      for($i = 1; $i <= 4; $i++) {
        if ($post->{"wwd_page_section".$i."_text"}) {
          ?>
          <div class="wwd-row">
            <div class="text">
              <?php
              if ($post->{"wwd_page_section".$i."_title"}) echo "<h2>".$post->{"wwd_page_section".$i."_title"}."</h2>\n";
              echo nl2br(html_entity_decode($post->{"wwd_page_section".$i."_text"}))."\n";
              ?>
            </div>
            <?php if ($post->{"wwd_page_section".$i."_image"}) echo '<div class="image" style="background-image: url('.$post->{"wwd_page_section".$i."_image"}.');"></div>'."\n"; ?>
          </div>
          <?php
        }
      }
      ?>
    </section>

  <?php
  endwhile;
endif;

get_footer();
?>