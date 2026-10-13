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
  endwhile;
endif;
?>

<button class="open-dialog" data-id="pillars-of-public-policy">Pillars of Public Policy</button>
<button class="open-dialog" data-id="sentinels-of-civil-conduct">Sentinels of Civil Conduct</button>

<dialog closedby="any" class="members-dialog" id="pillars-of-public-policy">
  <div class="sidebar">
    <h2>Pillars of Public Policy<div>$15,000 Donors</div></h2>
  </div>

  <div class="text">
    ACTS Community Development Corporation<br />
    Advocate Aurora Health<br />
    Argosy Foundation<br />
    Ascension<br />
    Avenues West Association<br />
    Bader Philanthropies, Inc.<br />
    Burke Foundation<br />
    Children's Health Alliance of WI<br />
    Children's Wisconsin<br />
    Community Advocates, Inc.<br />
    Community Care, Inc.<br />
    Daniel Hoan Foundation<br />
    Employ Milwaukee<br />
    Evan and Marion Helfaer Foundation<br />
    Froedtert<br />
    Gathering Waters Inc.<br />
    Goodwill Industries of Southeastern Wisconsin<br />
    Greater Milwaukee Committee<br />
    Greater Milwaukee Foundation<br />
    Heil Family Foundation<br />
    Herbert Kohl Philanthropies<br />
    Herzfeld Foundation<br />
    Higher Expectations for Racine County<br />
    Hunger Task Force<br />
    IFF<br />
    IMPACT<br />
    IndependenceFirst<br />
    International Brotherhood of Electrical Workers Local 494<br />
    Jewish Family Services<br />
    Johnson Foundation at Wingspread<br />
    League of Wisconsin Municipalities<br />
    Legacy Redevelopment Corp.<br />
    Local Initiatives Support Corp.<br />
    Lutheran Social Services of Wis.<br />
    Lynde and Harry Bradley Foundation<br />
    Madison Public Schools Foundation<br />
    Marcus Center for the Performing Arts<br />
    Medical College of Wisconsin<br />
    Medical Society of Milwaukee County<br />
    Menomonee Valley Partners, Inc<br />
    Metropolitan Milwaukee Association of Commerce<br />
    Milwaukee Art Museum<br />
    Milwaukee Center for Independence<br />
    Milwaukee Downtown, Bid #21<br />
    Milwaukee Film, Inc.<br />
    Milwaukee Public Library<br />
    Milwaukee Public Museum<br />
    Milwaukee Regional Medical Center<br />
    Milwaukee Urban League<br />
    Next Door<br />
    Northwest Side Community Development Corporation<br />
    Penfield Children's Center, Inc.<br />
    Rogers Memorial Hospital<br />
    Rotary Club of Milwaukee<br />
    Schools That Can Milwaukee<br />
    Seeds of Health, Inc.<br />
    Southeastern Wisconsin School Alliance (SWSA)<br />
    St. Charles Youth &amp; Family Services Inc.<br />
    Thrive ED<br />
    United Way of Greater Milwaukee &amp; Waukesha County<br />
    VISIT Milwaukee<br />
    Waukesha County Business Alliance<br />
    Weiss Family Foundation<br />
    Wisconsin Council of Religious &amp; Independent Schools<br />
    Wisconsin Hospital Association<br />
    Wisconsin Philanthropy Network<br />
    Wisconsin Women's Business Initiative Corporation<br />
    YWCA Southeast Wisconsin
  </div>
  <button class="close-dialog" data-id="pillars-of-public-policy"></button>
</dialog>

<dialog closedby="any" class="members-dialog" id="sentinels-of-civil-conduct">
  Sentinels dialog
  <button class="close-dialog" data-id="sentinels-of-civil-conduct"></button>
</dialog>

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

  // [...document.getElementsByTagName("DIALOG")].forEach(dialog => {
  //   dialog.addEventListener("click", function(event) { this.close(); });
  // });
</script>



<br><br>
<button id="openModal">Open Modal</button>
<dialog id="myDialog" closedby="any">
  <h2>Native Dialog</h2>
  <p>This is a native HTML modal window.</p>
  <button id="closeModal" commandfor="myDialog" command="close">Close</button>
</dialog>
<script>
  const dialog = document.getElementById('myDialog');
  const openBtn = document.getElementById('openModal');
  const closeBtn = document.getElementById('closeModal');
  openBtn.addEventListener('click', () => { dialog.showModal(); });
  closeBtn.addEventListener('click', () => { dialog.close(); });
</script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/featherlight.css?<?php echo filemtime(get_template_directory() . "/inc/featherlight.css"); ?>">

<div class="bars">
  <div class="site-width">
    <div id="modal-links">
      <?php echo $post->post_content; ?>
    </div>
    
    <?php $pillars = get_page_by_path('current-members/pillars-of-public-policy'); ?>
    <div id="pillars" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $pillars->post_title; ?><div>$15,000 Donors</div></h2>
        </div>

        <div class="content logos">
          <?php echo nl2br($pillars->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#pillars -->

    <?php $sentinels = get_page_by_path('current-members/sentinels-of-civil-conduct'); ?>
    <div id="sentinels" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $sentinels->post_title; ?><div>$10,000 Donors</div></h2>
        </div>

        <div class="content logos">
          <?php echo nl2br($sentinels->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#sentinels -->
    
    <?php $corporate = get_page_by_path('current-members/corporate-members'); ?>
    <div id="corporate" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $corporate->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($corporate->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#corporate -->

    <?php $government = get_page_by_path('current-members/government-members'); ?>
    <div id="government" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $government->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($government->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#government -->

    <?php $education = get_page_by_path('current-members/education-members'); ?>
    <div id="education" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $education->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($education->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#education -->

    <?php $nonprofit = get_page_by_path('current-members/nonprofit-members'); ?>
    <div id="nonprofit" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $nonprofit->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($nonprofit->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#nonprofit -->

    <?php $individual = get_page_by_path('current-members/chairmans-club'); ?>
    <div id="individual" class="modal modal-members">
      <div class="site-width">
        <div class="sidebar">
          <h2><?php echo $individual->post_title; ?></h2>
        </div>

        <div class="content">
          <?php echo nl2br($individual->post_content); ?>
        </div>
      </div> <!-- /.site-width-->
    </div> <!-- /#individual -->
  </div>
</div>

<div id="sponsors">
  <div class="site-width">
    <?php
    $sponsors = get_post(107);
    echo '<h3>'.$sponsors->post_title.'</h3>';
    echo '<div id="sponsor-slideshow">';
      echo $sponsors->post_content;
    echo '</div>';
    ?>
  </div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.cycle2.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.cycle2.carousel.min.js"></script>

<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery('#sponsor-slideshow IMG').each(function() {
      jQuery(this).wrap('<a href="<?php echo home_url(); ?>/current-members/"><div style="background-image: linear-gradient(rgba(36,169,224,0.5), rgba(36,169,224,0.5)), url('+jQuery(this).attr('src')+');"></div></a>');
    });

    function buildCarousel() {
      var slides = 4;

      if (window.innerWidth < 801) { slides = 3; }
      if (window.innerWidth < 601) { slides = 2; }
      if (window.innerWidth < 481) { slides = 1; }

      jQuery('#sponsor-slideshow').cycle({
        slides: "> a",
        fx: 'carousel',
        carouselFluid: 'true',
        carouselVisible: slides
      });
    }

    function resizeCarousel() {
      jQuery('#sponsor-slideshow').cycle('destroy');
      buildCarousel();
    }

    buildCarousel();

    jQuery(window).resize(function(){
      setTimeout(function() { resizeCarousel(); },100);
    });

    jQuery('#modal-links A').each(function() {
      jQuery(this).wrapInner('<span></span>').css('background-image', 'url('+jQuery(this).find('img').attr('src')+')')
    });
  });
</script>

<script src="<?php echo get_template_directory_uri(); ?>/inc/featherlight.min.js"></script>

<?php get_footer(); ?>