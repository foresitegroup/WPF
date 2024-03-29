<div class="event-header<?php if (is_single()) echo " single"; ?>">
  <div class="date">
    <div>
      <?php
      if ($post->event_date != "TBD") {
        echo date("M", $post->event_date);
        echo '<h3>'.date("d", $post->event_date).'</h3>';
      } else {
        echo "TBD";
      }
      ?>
    </div>
  </div> <!-- /.date -->
  
  <div class="details">
    <?php
    the_title('<h2>','</h2>');

    if ($post->event_start_time != "") {
      echo '<h3>'.$post->event_start_time;
      if ($post->event_start_time != "" && $post->event_end_time != "")
        echo " - ".$post->event_end_time;
      echo "</h3>\n";
    }
    
    if ($post->event_location_name != "" || $post->event_location_address) echo '<div class="location">'."\n";
      if ($post->event_location_name != "") echo $post->event_location_name;
      if ($post->event_location_name != "" && $post->event_location_address != "") echo '<span>&bull;</span>';
      if ($post->event_location_address != "") echo $post->event_location_address;
    if ($post->event_location_name != "" || $post->event_location_address != "") echo "</div>\n";
    ?>
  </div> <!-- /.details -->
  
  <?php
  if ($post->event_registration_text != "")
    echo '<div class="reg-text">'.$post->event_registration_text."</div>\n";

  if (!is_single()) {
    if ($post->event_register_button != "")
      echo '<a href="'.$post->post_name.'" class="button">Register</a>'."\n";

    echo '<a href="#" class="more-info">More Info<div></div></a>'."\n";
  }
  ?>
</div> <!-- /.event-header -->

<div class="event-body<?php if (is_single()) echo " single"; ?>">
  <div class="event-body-content">
    <div class="event-sidebar">
      <?php
      if (has_post_thumbnail(get_the_ID()) || $post->event_video != "") {
        if (has_post_thumbnail(get_the_ID()))
          $event_media = '<img src="'.get_the_post_thumbnail_url(get_the_ID(),'full').'" alt="">';

        if ($post->event_video != "")
          $event_media = '<div class="video">'.wp_oembed_get($post->event_video)."</div>\n";

        echo $event_media;
      }

      if ($post->event_pricing_member != "" || $post->event_pricing_non_member != "" || $post->event_pricing_corporate != "" || $post->event_pricing_friends != "" || $post->event_pricing_government != "") {
        ?>
        <h4>Pricing</h4>
        <div class="pricing">
          <?php if ($post->event_pricing_member != "") { ?>
            <div class="price">
              <div>
                <div>Member</div>
                <?php echo $post->event_pricing_member; ?>
              </div>
            </div>
          <?php } ?>

          <?php if ($post->event_pricing_non_member != "") { ?>
            <div class="price">
              <div>
                <div>Non-Member</div>
                <?php echo $post->event_pricing_non_member; ?>
              </div>
            </div>
          <?php } ?>

          <?php if ($post->event_pricing_corporate != "") { ?>
            <div class="price">
              <div>
                <div>Corporate Table</div>
                <?php echo $post->event_pricing_corporate; ?>
              </div>
            </div>
          <?php } ?>

          <?php if ($post->event_pricing_friends != "") { ?>
            <div class="price">
              <div>
                <div>Friends Table</div>
                <?php echo $post->event_pricing_friends; ?>
              </div>
            </div>
          <?php } ?>

          <?php if ($post->event_pricing_government != "") { ?>
            <div class="price">
              <div>
                <div>Government Table</div>
                <?php echo $post->event_pricing_government; ?>
              </div>
            </div>
          <?php } ?>
        </div>
        <?php
      }

      if (is_single()) {
      ?>
      <div class="event-buttons cf">
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
      <?php } ?>
      
      <a href="<?php echo home_url(); ?>/contact-us" class="button">Contact Us</a>
      <?php if (is_single()) echo "</div>\n"; ?>
      
      <?php if ($post->event_date != "TBD") { ?>
        <form method="post" action="<?php echo get_template_directory_uri(); ?>/add-to-cal.php" class="addcal">
          <?php
          $allday = "";

          $startdate = date("Y-n-j", $post->event_date);
          if ($post->event_start_time == "") {
            $allday = "yes";
          } else {
            $startdate .= " ".$post->event_start_time;
          }

          $enddate = date("Y-n-j", $post->event_date);

          $endtime = "";
          if ($post->event_end_time != "") $endtime = $post->event_end_time;
          if ($post->event_start_time != "" && $post->event_end_time == "") $endtime = $post->event_start_time." + 1 hour";

          $enddate .= " ".$endtime;

          if ($allday == "") {
            $sdate = new DateTime($startdate, new DateTimeZone('America/Chicago'));
            $dts = date("Ymd\THis\Z", $sdate->format('U'));
            $edate = new DateTime($enddate, new DateTimeZone('America/Chicago'));
            $dte = date("Ymd\THis\Z", $edate->format('U'));
          } else {
            $dts = date("Ymd", $post->event_date);
            $dte = date("Ymd", $post->event_date+86400);
          }
          ?>
          <input type="hidden" name="date_start" value="<?php echo $dts; ?>">
          <input type="hidden" name="date_end" value="<?php echo $dte; ?>">
          <input type="hidden" name="summary" value="<?php the_title(); ?>">
          <input type="hidden" name="description" value="For details, go to <?php the_permalink(); ?>">
          <input type="hidden" name="location" value="<?php if ($post->event_location_address != "") echo $post->event_location_address ?>">
          <input type="submit" value="Add to Calendar">
        </form>
      <?php } ?>

      <?php
      if ($post->event_sidebar_text != "")
        echo '<div class="event-sidebar-text">'.wpautop($post->event_sidebar_text)."</div>\n";
      ?>
    </div> <!-- /.event-sidebar -->

    <div class="event-text">
      <?php the_content(); ?>
    </div>
  </div> <!-- /.event-body-content -->
</div> <!-- /.event-body -->