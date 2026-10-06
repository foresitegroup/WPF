  </main>

  <footer>
    <section class="site-width">
      <div class="left">
        <?php
        if (get_theme_mod('fg_site_logo')) echo wp_get_attachment_image(get_theme_mod('fg_site_logo'), "full", '', array("class" => "footer-logo"))."\n";

        wp_nav_menu(array('theme_location' => 'footer-buttons','container'=>'nav','container_id' => 'footer-buttons'));
        ?>

        <div class="social">
          <?php
          if (get_theme_mod('fg_facebook')) echo '<a href="'.get_theme_mod('fg_facebook').'" aria-label="Facebook" class="facebook"></a>'."\n";
          if (get_theme_mod('fg_twitter')) echo '<a href="'.get_theme_mod('fg_twitter').'" aria-label="Twitter" class="twitter"></a>'."\n";
          if (get_theme_mod('fg_linkedin')) echo '<a href="'.get_theme_mod('fg_linkedin').'" aria-label="LinkedIn" class="linkedin"></a>'."\n";
          ?>
        </div>
      </div>

      <?php wp_nav_menu(array('theme_location'=>'footer-menu','container'=>'nav','container_id'=>'footnav')); ?>
    </section>

    <section id="copyright">
      &copy; <?php echo date("Y"); ?> Wisconsin Policy Forum<br>
      <br>
      <a href="https://foresitegrp.com">WEBSITE BY FORESITE</a>
    </section>
  </footer>

  <script type="text/javascript">
    // Open external links and PDFs in new tab
    [...document.links].forEach(link => {
      if (link.hostname != window.location.hostname || link.href.split('.').pop() == "pdf") {
        link.target = '_blank'; link.rel = 'noopener';
      }
    });
  </script>

  <?php wp_footer(); ?>

</body>
</html>