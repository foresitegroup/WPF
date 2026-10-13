<?php
/* Template Name: Sponsorship */

get_header();

if (have_posts()) :
  while (have_posts() ) : the_post();
    ?>

    <section id="page-title">
      <?php the_title('<h1 class="site-width">','</h1>'); ?>
    </section>

    <?php
    if ($post->sponsorship_after_title) {
      echo '<section class="site-width sponsorship-content">'."\n";
        echo $post->sponsorship_after_title."\n";
      echo "</section>\n";
    }
    ?>

    <section id="sponsorship">
      <?php
      for($i = 1; $i <= 2; $i++) {
        if ($post->{"sponsorship_section".$i."_text"}) {
          ?>
          <div class="row">
            <div class="text">
              <?php
              if ($post->{"sponsorship_section".$i."_title"}) echo "<h2>".$post->{"sponsorship_section".$i."_title"}."</h2>\n";
              echo apply_filters('the_content', $post->{"sponsorship_section".$i."_text"})."\n";
              ?>
            </div>
            <?php if ($post->{"sponsorship_section".$i."_image"}) echo '<div class="image" style="background-image: url('.$post->{"sponsorship_section".$i."_image"}.');"></div>'."\n"; ?>
          </div>
          <?php
        }
      }
      ?>
    </section>

    <section class="sponsorship-prefooter">
      <div class="site-width">
        <h2><?php echo $post->sponsorship_prefooter_title; ?></h2>
        <h3> <?php echo $post->sponsorship_prefooter_contact; ?></h3>
      </div>
    </section>

    <?php
  endwhile;
endif;

get_footer();
?>