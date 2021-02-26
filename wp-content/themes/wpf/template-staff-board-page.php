<?php
/* Template Name: Staff/Board */

get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();
  ?>

    <div class="title-banner">
      <?php the_title('<h1 class="site-width">','</h1>'); ?>
    </div>

  <?php
  endwhile;
endif;
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/featherlight.css?<?php echo filemtime(get_template_directory() . "/inc/featherlight.css"); ?>">

<div id="tabs">
  <input id="tab1" type="radio" name="tabs" checked>
  <label for="tab1">Staff</label>
  <input id="tab2" type="radio" name="tabs"<?php if ($_SERVER['QUERY_STRING'] == "board") echo ' checked'; ?>>
  <label for="tab2">Board</label>

  <div class="bars">
    <div class="site-width">
      <div id="staff">
        <?php
        $staff = new WP_Query(array('post_type'=>'fg_staff', 'orderby'=>'menu_order', 'order'=> 'ASC', 'showposts' => -1));

        while($staff->have_posts()) : $staff->the_post();
          ?>
          <a href="#" data-featherlight="#staff<?php echo get_the_ID(); ?>" class="staff"<?php if (has_post_thumbnail()) echo ' style="background-image: url('.get_the_post_thumbnail_url().')"'; ?>>
            <?php if (!has_post_thumbnail()) the_title('<div class="no-image-name">','</div>'); ?>

            <div class="staff-content">
              <?php
              the_title('<h3>','</h3>');

              if (get_post_meta(get_the_ID(), 'fg_staff_position', true))
                echo "<h4>".get_post_meta(get_the_ID(), 'fg_staff_position', true)."</h4>";

              if (get_post_meta(get_the_ID(), 'fg_staff_email', true))
                echo '<div><i class="far fa-envelope"></i> '.get_post_meta(get_the_ID(), 'fg_staff_email', true).'</div>';

              if (get_post_meta(get_the_ID(), 'fg_staff_phone', true)) {
                echo '<div><i class="fas fa-phone"></i> '.get_post_meta(get_the_ID(), 'fg_staff_phone', true);

                if (get_post_meta(get_the_ID(), 'fg_staff_extension', true)) echo " ext. ".get_post_meta(get_the_ID(), 'fg_staff_extension', true);

                echo '</div>';
              }
              ?>
              <div class="info"></div>
            </div>
          </a>
          <div id="staff<?php echo get_the_ID(); ?>" class="modal staff-modal">
            <div class="site-width">
              <div class="sidebar info">
                <?php
                if (has_post_thumbnail()) echo '<img src="'.get_the_post_thumbnail_url().'" alt="">';

                the_title('<h3>','</h3>');

                if (get_post_meta(get_the_ID(), 'fg_staff_position', true))
                  echo "<h4>".get_post_meta(get_the_ID(), 'fg_staff_position', true)."</h4>";

                if (get_post_meta(get_the_ID(), 'fg_staff_email', true))
                  echo '<br><a href="mailto:'.get_post_meta(get_the_ID(), 'fg_staff_email', true).'"><i class="far fa-envelope"></i> '.get_post_meta(get_the_ID(), 'fg_staff_email', true).'</a>';

                if (get_post_meta(get_the_ID(), 'fg_staff_phone', true)) {
                  $phone = preg_replace("/[^0-9,.]/", "", get_post_meta(get_the_ID(), 'fg_staff_phone', true));

                  if (get_post_meta(get_the_ID(), 'fg_staff_extension', true))
                    $phone .= ";ext=".get_post_meta(get_the_ID(), 'fg_staff_extension', true);

                  echo '<br><a href="tel:'.$phone.'"><i class="fas fa-phone"></i> '.get_post_meta(get_the_ID(), 'fg_staff_phone', true);

                  if (get_post_meta(get_the_ID(), 'fg_staff_extension', true)) echo " ext. ".get_post_meta(get_the_ID(), 'fg_staff_extension', true);

                  echo "</a>";
                }
                ?>
              </div>

              <div class="content">
                <h4>BIO</h4>
                <?php nl2br(the_content()); ?>
              </div>
            </div>
          </div>
          <?php
        endwhile;
        ?>
      </div>

      <div id="board">
        <div id="officers">
          <h2>Executive Committee</h2>
          <div class="flex">
            <?php
            function ListOfficers($option) {
              $officer = new WP_Query(array('post_type' => 'fg_board', 'showposts' => -1, 'meta_query' => array(array('key' => 'fg_board_officer_title', 'value' => $option), 'sort_clause' => array('key' => 'fg_board_lastname')), 'orderby' => array('sort_clause' => 'ASC')));

              while($officer->have_posts()) : $officer->the_post();
                echo '<div class="officer">'."\n";
                  echo '<div class="image"';
                  if (has_post_thumbnail()) echo ' style="background-image: url('.get_the_post_thumbnail_url().')"';
                  echo "></div>\n";
                  echo "<h3>".$option."</h3>\n";
                  the_title("<h4>","</h4>\n");
                  if (get_post_meta(get_the_ID(), 'fg_board_company', true))
                    echo "<h5>".get_post_meta(get_the_ID(), 'fg_board_company', true)."</h5>\n";
                echo "</div> <!-- /.officer -->\n\n";
              endwhile;
            }
            
            ListOfficers('Board Chair');
            ListOfficers('Vice Chair');
            ListOfficers('Secretary');
            ListOfficers('Treasurer');
            ListOfficers('President');
            ListOfficers('Member');
            ?>
          </div> <!-- /.flex -->
        </div> <!-- /#officers -->
        
        <div class="line">
          <div></div>
          <h2>Board of Directors</h2>
        </div>
        
        <div class="directors">
          <?php
          $directors = new WP_Query(array('post_type' => 'fg_board', 'showposts' => -1, 'meta_query' => array(array('key' => 'fg_board_lastname'), array('key'=> 'fg_board_type', 'value'=> 'director')), 'orderby' => array('fg_board_lastname' => 'ASC', 'title' => 'ASC')));

          while($directors->have_posts()) : $directors->the_post();
            echo '<div class="director">';
              the_title('<h3>','</h3>');
              if (get_post_meta(get_the_ID(), 'fg_board_company', true))
                echo get_post_meta(get_the_ID(), 'fg_board_company', true);
            echo "</div>";
          endwhile;
          ?>
        </div>

        <div class="line">
          <div></div>
          <h2>Emeritus Directors</h2>
        </div>
        
        <div class="emeritus-directors">
          <?php
          $emeritus = new WP_Query(array('post_type' => 'fg_board', 'showposts' => -1, 'meta_query' => array(array('key' => 'fg_board_lastname'), array('key'=> 'fg_board_type', 'value'=> 'emeritus')), 'orderby' => array('fg_board_lastname' => 'ASC', 'title' => 'ASC')));

          while($emeritus->have_posts()) : $emeritus->the_post();
            echo '<div class="emeritus">';
              the_title('<h3>','</h3>');
              if (get_post_meta(get_the_ID(), 'fg_board_company', true))
                echo get_post_meta(get_the_ID(), 'fg_board_company', true);
            echo "</div>";
          endwhile;
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function() {
    function LineWidth() {
      if (window.innerWidth > 1100) {
        var Lwidth = jQuery(window).width() - ((jQuery(window).width() - 1100) / 2);
        jQuery('#board .line > DIV').css('width', Lwidth);
      }
    }

    LineWidth();

    jQuery(window).resize(function(){
      setTimeout(function() { LineWidth(); },100);
    });
  });
</script>

<script src="<?php echo get_template_directory_uri(); ?>/inc/featherlight.min.js"></script>

<?php get_footer(); ?>