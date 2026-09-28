<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

  <title><?php echo get_bloginfo('name'); if(!is_home() || !is_front_page()) wp_title('|', true, 'left'); ?></title>

  <?php wp_enqueue_script("jquery"); ?>
  <?php wp_head(); ?>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-WGRD3LR79D"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-WGRD3LR79D');
  </script>
</head>

<body <?php body_class(); ?>>

  <header>
    <section class="site-width">
      <a href="<?php echo home_url(); ?>" id="logo" aria-label="Return to home page"><?php if (get_theme_mod('fg_site_logo')) echo wp_get_attachment_image(get_theme_mod('fg_site_logo'), "full"); ?></a>

      <?php wp_nav_menu(array('theme_location'=>'top-menu','container'=>'nav','container_id'=>'header-right')); ?>
    </section>

    <input type="checkbox" id="toggle-menu">
    <label for="toggle-menu"></label>
    <?php wp_nav_menu(array('theme_location'=>'main-menu','container'=>'nav','container_id'=>'main','menu_class'=>'site-width')); ?>
  </header>

  <main role="main">