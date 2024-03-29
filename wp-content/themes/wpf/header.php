<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

  <title><?php echo get_bloginfo('name'); if(!is_home() || !is_front_page()) wp_title('|', true, 'left'); ?></title>

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png">
  
  <?php wp_enqueue_script("jquery"); ?>
  <?php wp_head(); ?>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?<?php echo filemtime(get_template_directory() . "/style.css"); ?>">

  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $("a[href^='http']").not("[href*='" + window.location.host + "']").prop('target','new');
      $("a[href$='.pdf']").prop('target', 'new');
    });
  </script>

  <!-- Global site tag (gtag.js) - Google Analytics - THIS WILL STOP WORKING JULY 1, 2023 -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-121729697-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-121729697-1');
  </script>

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

  <header class="site-width">
    <a href="<?php echo home_url(); ?>" id="logo">
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Wisconsin Policy Forum">
      <img src="<?php echo get_template_directory_uri(); ?>/images/logo-black.png" alt="" class="print">
    </a>

    <?php wp_nav_menu(array('theme_location'=>'top-menu','container'=>'div','container_id'=>'header-right')); ?>
  </header>

  <input type="checkbox" id="toggle-menu" role="button">
  <label for="toggle-menu"></label>
  <?php wp_nav_menu(array('theme_location'=>'main-menu','container'=>'nav','container_id'=>'headnav','menu_class'=>'site-width')); ?>