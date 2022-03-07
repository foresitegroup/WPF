<footer>
  <div class="site-width">
    <div class="left">
      <img src="<?php echo get_template_directory_uri(); ?>/images/footer-logo.png" alt="Wisconsin Policy Forum">

      <?php wp_nav_menu(array('theme_location' => 'footer-buttons', 'container_class' => 'footer-buttons')); ?>

      <?php wp_nav_menu(array('theme_location'=>'social','container'=>'div','container_class'=>'social')); ?>
    </div>

    <?php wp_nav_menu(array('theme_location'=>'footer-menu','container'=>'nav','container_id'=>'footnav')); ?>
  </div>
</footer>

<div id="copyright">
  &copy; <?php echo date("Y"); ?> Wisconsin Policy Forum<br>
  <br>
  <a href="https://foresitegrp.com" style="font-size: 0.6875rem; color: #B5B5B5; letter-spacing: 0;">WEBSITE BY FORESITE</a>
</div>

<?php wp_footer(); ?>

</body>
</html>