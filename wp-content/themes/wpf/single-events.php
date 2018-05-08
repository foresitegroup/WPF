<?php get_header(); ?>

<div class="title-banner">
  <h1 class="site-width">Event Registration</h1>
</div>

<div class="bars">
  <div class="site-width">
    <?php
    while(have_posts()) : the_post();
      get_template_part('content', 'events');
    endwhile; ?>
  </div> <!-- /.site-width -->
</div> <!-- /.bars -->

<div id="eventreg">
  <div class="site-width">
    <form>
      <div class="line">
        <div></div>
        <h2>General Registration Information</h2>
      </div>
      
      <div id="general">
        <div>
          <label>Payment Options</label>
          <div class="select">
            <select name="payment">
              <option value="">Select...</option>
            </select>
          </div>
        </div>

        <div>
          <label>Are you a member?</label>
          <div class="select">
            <select name="member">
              <option value="">Select...</option>
            </select>
          </div>
        </div>

        <div>
          <span>(8 attendees per table)</span>
          <label>Purchasing a table?</label>
          <div class="select">
            <select name="table">
              <option value="">Select...</option>
            </select>
          </div>
        </div>

        <div>
          <label>Number of Attendees</label>
          <input type="number" name="number" id="number">
        </div>
      </div>

      <div class="line" id="attendee-header">
        <div></div>
        <h2>Attendee Information</h2>
      </div>

      <div id="attendees"></div>

      <input type="button" name="submit" value="register">
    </form>
  </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    function LineWidth() {
      if (window.innerWidth > 1100) {
        var Lwidth = jQuery(window).width() - ((jQuery(window).width() - 1100) / 2);
        jQuery('#eventreg .line > DIV').css('width', Lwidth);
      }
    }

    LineWidth();

    jQuery(window).resize(function(){
      setTimeout(function() { LineWidth(); },100);
    });

    $("#number").on("input",function(event){
      var fields = "";
      var num = $("#number").val();

      if (num >= 1) {
        $("#attendee-header").css("display", "block");
      } else {
        $("#attendee-header").css("display", "none");
      }

      for (var i = 1; i <= num; i++) {
        fields += '<h3>Attendee '+i+'</h3>';
        fields += '<div class="attendee">';
        fields += '<div><label>Name</label><input type="text" name="name'+i+'" placeholder="John Smith"></div>';
        fields += '<div><label>Company/Organization</label><input type="text" name="company'+i+'" placeholder="Company, Inc."></div>';
        fields += '<div><label>Email</label><input type="email" name="email'+i+'" placeholder="j.smith@company.org"></div>';
        fields += '<div><label>Phone</label><input type="text" name="phone'+i+'" placeholder="(414) 867-5309"></div>';
        fields += '</div>';
      }

      $("#attendees").html(fields);
    });
  });
</script>

<?php get_footer(); ?>