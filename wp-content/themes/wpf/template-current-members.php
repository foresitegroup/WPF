<?php
/* Template Name: Current Members */

get_header();

if (have_posts()) :
  while (have_posts()) : the_post();
    ?>

    <section id="page-title">
      <?php the_title('<h1 class="site-width">','</h1>'); ?>
    </section>

    <?php
    $members = get_post_meta($post->ID, 'members', true);
    if (isset($members['title'])) {
      echo '<section id="member-modals" class="bars-left">'."\n";
        echo '<div class="site-width">'."\n";
          for($i = 0; $i < count($members['title']); $i++) {
            echo '<button class="open-dialog" data-id="'.sanitize_title($members['title'][$i]).'"';
            if ($members['image'][$i] != "") echo ' style="background-image: url('.$members['image'][$i].');"';
            echo ">".$members['title'][$i]."</button>\n";
            echo '<dialog closedby="any" class="members-dialog" id="'.sanitize_title($members['title'][$i]).'">'."\n";
              echo '<div class="sidebar">'."\n";
                echo "<h2>";
                echo ($members['header'][$i] != "") ? $members['header'][$i] : $members['title'][$i];
                echo "</h2>";
                if ($members['subheader'][$i] != "") echo "<h3>".$members['subheader'][$i]."</h3>\n";
              echo "</div>\n";
              echo '<div class="text">'."\n";
                if ($members['content'][$i] != "") echo apply_filters('the_content', $members['content'][$i])."\n";
              echo "</div>\n";
              echo '<button class="close-dialog" data-id="'.sanitize_title($members['title'][$i]).'"></button>'."\n";
            echo "</dialog>\n";
          }
        echo "</div>\n";
      echo "</section>\n";
    }

    $members_slides = get_post_meta($post->ID, 'members_slides', true);
    if (isset($members_slides['image'])) {
      echo '<section id="member-slides">'."\n";
        if ($post->members_slides_title) echo '<h3 class="site-width">'.$post->members_slides_title."</h3>\n";

        echo '<div id="slides">'."\n";
          for($i = 0; $i < count($members_slides['image']); $i++) {
            echo wp_get_attachment_image(attachment_url_to_postid($members_slides['image'][$i]), 'full', '', array("class" => "f-carousel__slide"))."\n";
          }
        echo "</div>\n";
      echo "</section>\n";
    }
  endwhile;
endif;
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/carousel/carousel.css" />
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/carousel/carousel.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/carousel/carousel.autoscroll.umd.js"></script>

<script>
  document.querySelectorAll(".open-dialog").forEach(button => {
    button.addEventListener('click', (event) => {
      document.getElementById(button.dataset.id).showModal();
    });
  });

  document.querySelectorAll(".close-dialog").forEach(button => {
    button.addEventListener('click', (event) => {
      document.getElementById(button.dataset.id).close();
    });
  });

  Carousel(document.getElementById("slides"), { gestures: false }, { Autoscroll }).init();
</script>

<?php get_footer(); ?>