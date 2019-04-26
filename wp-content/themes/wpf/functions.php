<?php
// We want Featured Images on Pages and Posts
add_theme_support( 'post-thumbnails' );


// Don't resize Featured Images
function my_thumbnail_size() {
  set_post_thumbnail_size();
}
add_action('after_setup_theme', 'my_thumbnail_size', 11);


// Don't wrap images in P tags
add_filter('the_content', 'filter_ptags_on_images');
function filter_ptags_on_images($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


// Wrap video embed code in DIV for responsive goodness
add_filter('embed_oembed_html', 'my_oembed_filter', 10, 4);
function my_oembed_filter($html, $url, $attr, $post_ID) {
  $return = '<div class="video">'.$html.'</div>';
  return $return;
}


// Define menus
function register_my_menus() {
  register_nav_menus(
    array(
      'top-menu' => __('Top Menu'),
      'main-menu' => __('Main Menu'),
      'footer-buttons' => __('Footer Buttons'),
      'social' => __('Footer Social'),
      'footer-menu' => __('Footer Menu')
    )
  );
}
add_action( 'init', 'register_my_menus' );


// Show site styles in visual editor
function themename_setup() {
  add_editor_style();
}
add_action( 'after_setup_theme', 'themename_setup' );


// Custom excerpt
function my_excerpt_length($length) { return 1000; }
add_filter('excerpt_length', 'my_excerpt_length');

function fg_excerpt($limit, $more = '') {
  return wp_trim_words(get_the_excerpt(), $limit, $more);
}

function home_focus_excerpt(){
  $text = wpautop(get_the_content());
  $limit = 1100;
  if (strlen($text) < $limit+10) return $text;
  $break_pos = strpos($text, ' ', $limit);
  $visible = substr($text, 0, $break_pos);

  $tidy = new Tidy();
  $tidy->parseString($visible, array('show-body-only' => true, 'wrap' => 0));
  $tidy->cleanRepair();

  return $tidy . "...<br>";
}

// Remove visual editor on certain pages
add_filter('user_can_richedit', 'fg_remove_visual_editor');
function fg_remove_visual_editor($can) {
  global $post;

  if ($post->ID == 55) return false; // Home Join
  if ($post->ID == 542) return false; // Join Sidebar
  if ($post->ID == 544) return false; // Renew Sidebar
  if ($post->ID == 105) return false; // Join/Renew Dues Structure
  if ($post->ID == 765) return false; // Current Members

  return $can;
}


///////////////////
// ANNUAL REPORTS
///////////////////
add_action('init', 'annual_reports');
function annual_reports() {
  register_post_type('annual_reports', array(
      'labels' => array(
        'name' => 'Annual Reports',
        'singular_name' => 'Annual Report',
        'add_new_item' => 'Add New Annual Report',
        'edit_item' => 'Edit Annual Report',
        'search_items' => 'Search Annual Reports',
        'not_found' => 'No Annual Reports found'
      ),
      'show_ui' => true,
      'menu_position' => 50,
      'menu_icon' => 'dashicons-analytics',
      'supports' => array('title','editor','thumbnail')
  ));
}

add_action('add_meta_boxes', 'annual_reports_mb');
function annual_reports_mb() {
  add_meta_box('annual_reports_mb', 'Annual Report PDF', 'annual_reports_mb_content', 'annual_reports', 'normal');
}

function annual_reports_mb_content($post) {
  $ar_meta = get_post_meta($post->ID);
  ?>
  
  <input type="text" name="annual_report_pdf" id="annual_report_pdf" value="<?php if (isset($ar_meta['annual_report_pdf'])) echo $ar_meta['annual_report_pdf'][0]; ?>">
  <input type="button" id="annual_report_pdf_button" class="button" value="Add PDF">
  
  <script>
    jQuery('#annual_report_pdf_button').click(function() {
      var send_attachment_bkp = wp.media.editor.send.attachment;
      wp.media.editor.send.attachment = function(props, attachment) {
        jQuery('#annual_report_pdf').val(attachment.url);
        wp.media.editor.send.attachment = send_attachment_bkp;
      }
 
      wp.media.editor.open();
 
      return false;
    });
  </script>
  <?php
}

add_action('admin_head', 'annual_reports_css');
function annual_reports_css() {
  if (get_post_type() == 'annual_reports') {
    echo '<style>
      #annual_report_pdf { width: 90%; padding: 0.32em 8px; margin-right: 0.75em; }
    </style>';
  }
}

add_action('save_post', 'annual_reports_save');
function annual_reports_save($post_id) {
  if (isset($_POST['annual_report_pdf']))
    update_post_meta($post_id, 'annual_report_pdf', $_POST['annual_report_pdf']);
}


//////////
// STAFF
//////////
add_action('init', 'fg_staff');
function fg_staff() {
  register_post_type('fg_staff', array(
    'labels' => array(
      'name' => 'Staff',
      'singular_name' => 'Staff',
      'add_new_item' => 'Add New Staff',
      'edit_item' => 'Edit Staff',
      'search_items' => 'Search Staff',
      'not_found' => 'No Staff found'
    ),
    'show_ui' => true,
    'menu_position' => 51,
    'menu_icon' => 'dashicons-businessman',
    'supports' => array('title','editor','thumbnail')
  ));
}

add_filter('enter_title_here', 'fg_staff_title');
function fg_staff_title($input) {
  if (get_post_type() === 'fg_staff') return "Enter name here";
  return $input;
}

add_action('add_meta_boxes', 'fg_staff_mb');
function fg_staff_mb() {
  add_meta_box('fg_staff_mb', 'Additional Information', 'fg_staff_mb_content', 'fg_staff', 'normal');
}

function fg_staff_mb_content($post) {
  $meta = get_post_meta($post->ID);
  ?>
  <input type="text" name="fg_staff_position" placeholder="Title/Position" value="<?php if (isset($meta['fg_staff_position'])) echo $meta['fg_staff_position'][0]; ?>">
  <input type="email" name="fg_staff_email" placeholder="Email" value="<?php if (isset($meta['fg_staff_email'])) echo $meta['fg_staff_email'][0]; ?>">
  <input type="text" name="fg_staff_phone" placeholder="Telephone" value="<?php if (isset($meta['fg_staff_phone'])) echo $meta['fg_staff_phone'][0]; ?>">
  <input type="text" name="fg_staff_extension" placeholder="Extension" value="<?php if (isset($meta['fg_staff_extension'])) echo $meta['fg_staff_extension'][0]; ?>">
  <?php
}

add_action('admin_head', 'fg_staff_css');
function fg_staff_css() {
  if (get_post_type() == 'fg_staff') {
    echo '<style>
      #fg_staff_mb INPUT { width: 100%; margin: 0.5em 0; padding: 0.32em 8px; box-sizing: border-box; }
      .column-fg_staff_email { width: 25%; }
      .column-fg_staff_phone { width: 15%; }
      .column-fg_staff_extension { width: 10%; }
      .column-fg_staff_image { width: 10%; }
    </style>';
  }
}

add_action('save_post', 'fg_staff_save');
function fg_staff_save($post_id) {
  if (isset($_POST['fg_staff_position']))
    update_post_meta($post_id, 'fg_staff_position', $_POST['fg_staff_position']);
  if (isset($_POST['fg_staff_email']))
    update_post_meta($post_id, 'fg_staff_email', $_POST['fg_staff_email']);
  if (isset($_POST['fg_staff_phone']))
    update_post_meta($post_id, 'fg_staff_phone', $_POST['fg_staff_phone']);
  if (isset($_POST['fg_staff_extension']))
    update_post_meta($post_id, 'fg_staff_extension', $_POST['fg_staff_extension']);
}

add_filter('manage_fg_staff_posts_columns', 'set_custom_edit_fg_staff_columns');
function set_custom_edit_fg_staff_columns($columns) {
  $columns['title'] = "Name";
  $columns['fg_staff_position'] = "Position";
  $columns['fg_staff_email'] = "Email";
  $columns['fg_staff_phone'] = "Phone";
  $columns['fg_staff_extension'] = "Extension";
  $columns['fg_staff_image'] = "Image";

  unset($columns['date']);

  return $columns;
}

add_action('manage_fg_staff_posts_custom_column', 'custom_fg_staff_column', 10, 2);
function custom_fg_staff_column($column, $post_id) {
  switch ($column) {
    case 'fg_staff_position':
      echo get_post_meta($post_id, 'fg_staff_position', true);
      break;
    case 'fg_staff_email':
      echo get_post_meta($post_id, 'fg_staff_email', true);
      break;
    case 'fg_staff_phone':
      echo get_post_meta($post_id, 'fg_staff_phone', true);
      break;
    case 'fg_staff_extension':
      echo get_post_meta($post_id, 'fg_staff_extension', true);
      break;
    case 'fg_staff_image':
      echo get_the_post_thumbnail($post_id, array(40, 40));
      break;
  }
}

add_filter('manage_edit-fg_staff_sortable_columns', 'custom_fg_staff_sortable_columns' );
function custom_fg_staff_sortable_columns($column) {
  unset($column['title']);
  return $column;
}


//////////
// BOARD
//////////
add_action('init', 'fg_board');
function fg_board() {
  register_post_type('fg_board', array(
      'labels' => array(
        'name' => 'Board',
        'singular_name' => 'Board',
        'add_new_item' => 'Add New Board',
        'edit_item' => 'Edit Board',
        'search_items' => 'Search Board',
        'not_found' => 'No Board found'
      ),
      'show_ui' => true,
      'menu_position' => 51,
      'menu_icon' => 'dashicons-groups',
      'supports' => array('title','thumbnail')
  ));
}

add_filter('enter_title_here', 'fg_board_title');
function fg_board_title($input) {
  if (get_post_type() === 'fg_board') return "Enter full name here";
  return $input;
}

add_action('add_meta_boxes', 'fg_board_mb');
function fg_board_mb() {
  add_meta_box('fg_board_mb', 'Additional Information', 'fg_board_mb_content', 'fg_board', 'normal');
}

function fg_board_mb_content($post) {
  $meta = get_post_meta($post->ID);

  $fg_board_type = $meta['fg_board_type'][0];
  if ($fg_board_type == "") $fg_board_type = "director";

  if (isset($meta['fg_board_officer_title'])) $fg_board_officer_title = $meta['fg_board_officer_title'][0];
  ?>
  <input type="text" name="fg_board_lastname" placeholder="Last name for sorting purposes (REQUIRED)" value="<?php if (isset($meta['fg_board_lastname'])) echo $meta['fg_board_lastname'][0]; ?>" id="lastname">
  <input type="text" name="fg_board_company" placeholder="Company" value="<?php if (isset($meta['fg_board_company'])) echo $meta['fg_board_company'][0]; ?>">
  
  <br><br>

  <label><input type="radio" name="fg_board_type" value="officer"<?php if ($fg_board_type == "officer") echo " checked"; ?> id="r-officer"> Officer</label>
  <label><input type="radio" name="fg_board_type" value="director"<?php if ($fg_board_type == "director") echo " checked"; ?>> Director</label>
  <label><input type="radio" name="fg_board_type" value="emeritus"<?php if ($fg_board_type == "emeritus") echo " checked"; ?>> Emeritus</label>

  <div id="officer-info">
    <br>
    <select name="fg_board_officer_title">
      <option value="">Select Board Officer Title...</option>
      <option value="Board Chair"<?php if (isset($fg_board_officer_title) && $fg_board_officer_title == "Board Chair") echo ' selected'; ?>>Board Chair</option>
      <option value="Vice Chair"<?php if (isset($fg_board_officer_title) && $fg_board_officer_title == "Vice Chair") echo ' selected'; ?>>Vice Chair</option>
      <option value="Secretary"<?php if (isset($fg_board_officer_title) && $fg_board_officer_title == "Secretary") echo ' selected'; ?>>Secretary</option>
      <option value="Treasurer"<?php if (isset($fg_board_officer_title) && $fg_board_officer_title == "Treasurer") echo ' selected'; ?>>Treasurer</option>
      <option value="President"<?php if (isset($fg_board_officer_title) && $fg_board_officer_title == "President") echo ' selected'; ?>>President</option>
    </select>
  </div>
  
  <script>
    jQuery(function($) {
      if ($('#r-officer').is(':checked')) {
        $('#officer-info, #postimagediv').css('display', 'block');
      } else {
        $('#officer-info, #postimagediv').css('display', 'none');
      }

      $('input[type=radio]').change(function(){
        if (this.value == 'officer') {
          $('#officer-info, #postimagediv').css('display', 'block');
        } else {
          $('#officer-info, #postimagediv').css('display', 'none');
        }
      });

      $('#post').submit(function(e){
        if ($('#lastname').val() === '') { e.preventDefault(); alert('Last name required.'); }
      });
    });
  </script>
  <?php
}

add_action('admin_head', 'fg_board_css');
function fg_board_css() {
  if (get_post_type() == 'fg_board') {
    echo '<style>
      #fg_board_mb INPUT[type="text"] { width: 100%; margin: 0.5em 0; padding: 0.32em 8px; box-sizing: border-box; }
      #fg_board_mb LABEL { margin-right: 1em; }
    </style>';
  }
}

add_action('save_post', 'fg_board_save');
function fg_board_save($post_id) {
  if (isset($_POST['fg_board_lastname']))
    update_post_meta($post_id, 'fg_board_lastname', $_POST['fg_board_lastname']);

  if (isset($_POST['fg_board_company']))
    update_post_meta($post_id, 'fg_board_company', $_POST['fg_board_company']);

  if (isset($_POST['fg_board_type']))
    update_post_meta($post_id, 'fg_board_type', $_POST['fg_board_type']);

  if (isset($_POST['fg_board_officer_title']))
    update_post_meta($post_id, 'fg_board_officer_title', $_POST['fg_board_officer_title']);
}

add_filter('manage_fg_board_posts_columns', 'set_custom_edit_fg_board_columns');
function set_custom_edit_fg_board_columns($columns) {
  unset($columns['date']);

  $columns['title'] = "Name";
  $columns['fg_board_company'] = "Company";
  $columns['fg_board_type'] = "Section";

  $columns['date'] = "Date";

  return $columns;
}

add_action('manage_fg_board_posts_custom_column', 'custom_fg_board_column', 10, 2);
function custom_fg_board_column($column, $post_id) {
  switch ($column) {
    case 'fg_board_company':
      echo get_post_meta($post_id, 'fg_board_company', true);
      break;
    case 'fg_board_type':
      echo ucfirst(get_post_meta($post_id, 'fg_board_type', true));
      break;
  }
}

add_filter('manage_edit-fg_board_sortable_columns', 'set_custom_fg_board_sortable_columns');
function set_custom_fg_board_sortable_columns($columns) {
  $columns['fg_board_type'] = 'fg_board_type';
  return $columns;
}

add_action('pre_get_posts', 'fg_board_custom_orderby');
function fg_board_custom_orderby($query) {
  if (!is_admin()) return;

  $orderby = $query->get('orderby');

  if ($orderby == 'fg_board_type') {
    $query->set('meta_key', 'fg_board_type');
    $query->set('orderby', 'meta_value');
  }
}



///////////////
// WHAT WE DO
///////////////
add_action('admin_init', 'wwd_page');
function wwd_page() {
  $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
  if ($post_id == 95) {
    remove_post_type_support('page', 'editor');
    remove_post_type_support('page', 'thumbnail');
  }
}

add_action('add_meta_boxes', 'wwd_page_mb');
function wwd_page_mb() {
  global $post;
  if ('template-what-we-do-page.php' == $post->_wp_page_template) {
    add_meta_box('wwd_page_mb', 'Sections', 'wwd_page_mb_content', '', 'normal');
  }
}

function wwd_page_mb_content($post) {
  ?>
  <h3>Section 1</h3>
  <input type="text" name="wwd_page_section1_title" placeholder="Section 1 Title" value="<?php if ($post->wwd_page_section1_title) echo $post->wwd_page_section1_title; ?>">
  <?php
  wp_editor(html_entity_decode($post->wwd_page_section1_text, ENT_QUOTES), 'wwd_page_section1_text', array('textarea_rows' => 8));
  ?>
  <input type="text" name="wwd_page_section1_image" id="wwd_page_section1_image" class="wwd_page_image" value="<?php if ($post->wwd_page_section1_image) echo $post->wwd_page_section1_image; ?>">
  <input type="button" id="wwd_page_section1_image_button" class="button" value="Add/Edit Image">

  <hr>

  <h3>Section 2</h3>
  <input type="text" name="wwd_page_section2_title" placeholder="Section 2 Title" value="<?php if ($post->wwd_page_section2_title) echo $post->wwd_page_section2_title; ?>">
  <?php
  wp_editor(html_entity_decode($post->wwd_page_section2_text, ENT_QUOTES), 'wwd_page_section2_text', array('textarea_rows' => 8));
  ?>
  <input type="text" name="wwd_page_section2_image" id="wwd_page_section2_image" class="wwd_page_image" value="<?php if ($post->wwd_page_section2_image) echo $post->wwd_page_section2_image; ?>">
  <input type="button" id="wwd_page_section2_image_button" class="button" value="Add/Edit Image">

  <hr>

  <h3>Section 3</h3>
  <input type="text" name="wwd_page_section3_title" placeholder="Section 3 Title" value="<?php if ($post->wwd_page_section3_title) echo $post->wwd_page_section3_title; ?>">
  <?php
  wp_editor(html_entity_decode($post->wwd_page_section3_text, ENT_QUOTES), 'wwd_page_section3_text', array('textarea_rows' => 8));
  ?>
  <input type="text" name="wwd_page_section3_image" id="wwd_page_section3_image" class="wwd_page_image" value="<?php if ($post->wwd_page_section3_image) echo $post->wwd_page_section3_image; ?>">
  <input type="button" id="wwd_page_section3_image_button" class="button" value="Add/Edit Image">

  <hr>

  <h3>Section 4</h3>
  <input type="text" name="wwd_page_section4_title" placeholder="Section 4 Title" value="<?php if ($post->wwd_page_section4_title) echo $post->wwd_page_section4_title; ?>">
  <?php
  wp_editor(html_entity_decode($post->wwd_page_section4_text, ENT_QUOTES), 'wwd_page_section4_text', array('textarea_rows' => 8));
  ?>
  <input type="text" name="wwd_page_section4_image" id="wwd_page_section4_image" class="wwd_page_image" value="<?php if ($post->wwd_page_section4_image) echo $post->wwd_page_section4_image; ?>">
  <input type="button" id="wwd_page_section4_image_button" class="button" value="Add/Edit Image">

  <script>
    function WWDimage($image_id) {
      var send_attachment_bkp = wp.media.editor.send.attachment;
      wp.media.editor.send.attachment = function(props, attachment) {
        jQuery($image_id).val(attachment.url);
        wp.media.editor.send.attachment = send_attachment_bkp;
      }
      wp.media.editor.open();
      return false;
    }

    jQuery('#wwd_page_section1_image_button').click(function(){ WWDimage("#wwd_page_section1_image");});
    jQuery('#wwd_page_section2_image_button').click(function(){ WWDimage("#wwd_page_section2_image");});
    jQuery('#wwd_page_section3_image_button').click(function(){ WWDimage("#wwd_page_section3_image");});
    jQuery('#wwd_page_section4_image_button').click(function(){ WWDimage("#wwd_page_section4_image");});
  </script>
  <?php
}

add_action('admin_head', 'wwd_page_css');
function wwd_page_css() {
  global $post;
  if ($post->_wp_page_template == 'template-what-we-do-page.php') {
    echo '<style>
      #wwd_page_mb H3 { margin: 0 0 0.5em; }
      #wwd_page_mb .wp-editor-wrap { margin: 1em 0 2em; }
      #wwd_page_mb INPUT[type="text"] { width: 100%; padding: 0.32em 8px; box-sizing: border-box; }
      #wwd_page_mb INPUT[type="text"].wwd_page_image { width: 85%; margin-right: 0.75em; }
      #wwd_page_mb HR { margin: 3em 0 2.5em; border-top: 1px dashed #000000; }
    </style>';
  }
}

add_action('save_post', 'wwd_page_save');
function wwd_page_save($post_id) {
  if ($post_id != 95) return;
  update_post_meta($post_id, 'wwd_page_section1_title', $_POST['wwd_page_section1_title']);
  update_post_meta($post_id, 'wwd_page_section1_text', $_POST['wwd_page_section1_text']);
  update_post_meta($post_id, 'wwd_page_section1_image', $_POST['wwd_page_section1_image']);

  update_post_meta($post_id, 'wwd_page_section2_title', $_POST['wwd_page_section2_title']);
  update_post_meta($post_id, 'wwd_page_section2_text', $_POST['wwd_page_section2_text']);
  update_post_meta($post_id, 'wwd_page_section2_image', $_POST['wwd_page_section2_image']);

  update_post_meta($post_id, 'wwd_page_section3_title', $_POST['wwd_page_section3_title']);
  update_post_meta($post_id, 'wwd_page_section3_text', $_POST['wwd_page_section3_text']);
  update_post_meta($post_id, 'wwd_page_section3_image', $_POST['wwd_page_section3_image']);

  update_post_meta($post_id, 'wwd_page_section4_title', $_POST['wwd_page_section4_title']);
  update_post_meta($post_id, 'wwd_page_section4_text', $_POST['wwd_page_section4_text']);
  update_post_meta($post_id, 'wwd_page_section4_image', $_POST['wwd_page_section4_image']);
}


///////////////
// SPONSORSHIP
///////////////
add_action('admin_init', 'sponsorship_page');
function sponsorship_page() {
  $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
  if ('template-sponsorship.php' == get_post_meta($post_id,
  '_wp_page_template', true)) {
    remove_post_type_support('page', 'editor');
    remove_post_type_support('page', 'thumbnail');
  }
}

add_action('add_meta_boxes', 'sponsorship_page_mb');
function sponsorship_page_mb() {
  global $post;
  if ('template-sponsorship.php' == $post->_wp_page_template) {
    add_meta_box('sponsorship_page_mb_after_title', 'After Title Text', 'sponsorship_page_mb_content_after_title', '', 'normal');
    add_meta_box('sponsorship_page_mb', 'Sections', 'sponsorship_page_mb_content', '', 'normal');
    add_meta_box('sponsorship_page_mb_prefooter', 'Prefooter', 'sponsorship_page_mb_content_prefooter', '', 'normal');
  }
}

function sponsorship_page_mb_content_after_title($post) {
  ?>
  <input type="text" name="sponsorship_after_title" placeholder="After Title Text" value="<?php if ($post->sponsorship_after_title) echo $post->sponsorship_after_title; ?>">
  <?php
}

function sponsorship_page_mb_content($post) {
  ?>
  <h3>Section 1</h3>
  <input type="text" name="sponsorship_section1_title" placeholder="Section 1 Title" value="<?php if ($post->sponsorship_section1_title) echo $post->sponsorship_section1_title; ?>">
  <?php
  wp_editor(html_entity_decode($post->sponsorship_section1_text, ENT_QUOTES), 'sponsorship_section1_text', array('textarea_rows' => 8));
  ?>
  <input type="text" name="sponsorship_section1_image" id="sponsorship_section1_image" class="sponsorship_image" value="<?php if ($post->sponsorship_section1_image) echo $post->sponsorship_section1_image; ?>">
  <input type="button" id="sponsorship_section1_image_button" class="button" value="Add/Edit Image">

  <hr>

  <h3>Section 2</h3>
  <input type="text" name="sponsorship_section2_title" placeholder="Section 2 Title" value="<?php if ($post->sponsorship_section2_title) echo $post->sponsorship_section2_title; ?>">
  <?php
  wp_editor(html_entity_decode($post->sponsorship_section2_text, ENT_QUOTES), 'sponsorship_section2_text', array('textarea_rows' => 8));
  ?>
  <input type="text" name="sponsorship_section2_image" id="sponsorship_section2_image" class="sponsorship_image" value="<?php if ($post->sponsorship_section2_image) echo $post->sponsorship_section2_image; ?>">
  <input type="button" id="sponsorship_section2_image_button" class="button" value="Add/Edit Image">

  <script>
    function SPONSORSHIPimage($image_id) {
      var send_attachment_bkp = wp.media.editor.send.attachment;
      wp.media.editor.send.attachment = function(props, attachment) {
        jQuery($image_id).val(attachment.url);
        wp.media.editor.send.attachment = send_attachment_bkp;
      }
      wp.media.editor.open();
      return false;
    }

    jQuery('#sponsorship_section1_image_button').click(function(){ SPONSORSHIPimage("#sponsorship_section1_image");});
    jQuery('#sponsorship_section2_image_button').click(function(){ SPONSORSHIPimage("#sponsorship_section2_image");});
  </script>
  <?php
}

function sponsorship_page_mb_content_prefooter($post) {
  ?>
  <input type="text" name="sponsorship_prefooter_title" placeholder="Prefooter Title" value="<?php if ($post->sponsorship_prefooter_title) echo $post->sponsorship_prefooter_title; ?>"><br><br>
  <input type="text" name="sponsorship_prefooter_contact" placeholder="Prefooter contact" value="<?php if ($post->sponsorship_prefooter_contact) echo $post->sponsorship_prefooter_contact; ?>">
  <?php
}

add_action('admin_head', 'sponsorship_page_css');
function sponsorship_page_css() {
  global $post;
  if ($post->_wp_page_template == 'template-sponsorship.php') {
    echo '<style>
      #sponsorship_page_mb_after_title { border: 0; background: transparent; box-shadow: none; }
      #sponsorship_page_mb_after_title .handlediv, #sponsorship_page_mb_after_title H2 { display: none; }
      #sponsorship_page_mb_after_title .inside { padding: 0 }
      #sponsorship_page_mb_after_title INPUT { width: 100%; padding: 3px 8px; font-size: 1.4em; line-height: 1em; height: 1.7em; }
      #sponsorship_page_mb H3 { margin: 0 0 0.5em; }
      #sponsorship_page_mb .wp-editor-wrap { margin: 1em 0 2em; }
      #sponsorship_page_mb INPUT[type="text"],
      #sponsorship_page_mb_prefooter INPUT { width: 100%; padding: 0.32em 8px; box-sizing: border-box; }
      #sponsorship_page_mb INPUT[type="text"].sponsorship_image { width: 85%; margin-right: 0.75em; }
      #sponsorship_page_mb HR { margin: 3em 0 2.5em; border-top: 1px dashed #000000; }
    </style>';
  }
}

add_action('save_post', 'sponsorship_page_save');
function sponsorship_page_save($post_id) {
  if ($post->_wp_page_template != 'template-sponsorship.php') return;

  update_post_meta($post_id, 'sponsorship_after_title', $_POST['sponsorship_after_title']);

  update_post_meta($post_id, 'sponsorship_section1_title', $_POST['sponsorship_section1_title']);
  update_post_meta($post_id, 'sponsorship_section1_text', $_POST['sponsorship_section1_text']);
  update_post_meta($post_id, 'sponsorship_section1_image', $_POST['sponsorship_section1_image']);

  update_post_meta($post_id, 'sponsorship_section2_title', $_POST['sponsorship_section2_title']);
  update_post_meta($post_id, 'sponsorship_section2_text', $_POST['sponsorship_section2_text']);
  update_post_meta($post_id, 'sponsorship_section2_image', $_POST['sponsorship_section2_image']);

  update_post_meta($post_id, 'sponsorship_prefooter_title', $_POST['sponsorship_prefooter_title']);
  update_post_meta($post_id, 'sponsorship_prefooter_contact', $_POST['sponsorship_prefooter_contact']);
}


///////////
// EVENTS
///////////
add_action('init', 'events');
function events() {
  register_post_type('events', array(
    'labels' => array(
      'name' => 'Events',
      'singular_name' => 'Event',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'search_items' => 'Search Events',
      'not_found' => 'No Events found'
    ),
    'show_ui' => true,
    'menu_position' => 52,
    'menu_icon' => 'dashicons-calendar-alt',
    'supports' => array('title','editor','thumbnail'),
    'has_archive' => true,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'show_in_nav_menus' => true,
    'show_ui' => true
  ));
}

add_action('add_meta_boxes', 'events_mb');
function events_mb() {
  add_meta_box('events_mb', 'Event Fields', 'events_mb_content', 'events', 'normal');
  add_meta_box('events_mb_side', 'Event Video', 'events_mb_content_side', 'events', 'side', 'low');
}

function events_mb_content($post) {
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_style('jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css', true);
  wp_enqueue_script('timepicker', 'https://cdn.jsdelivr.net/npm/timepicker/jquery.timepicker.min.js', true);
  wp_enqueue_style('timepicker-style', 'https://cdn.jsdelivr.net/npm/timepicker/jquery.timepicker.min.css', true);
  ?>
  <script>
    jQuery(document).ready(function(){
      jQuery('#event_date').datepicker();
      jQuery('#event_start_time, #event_end_time').timepicker({ 'scrollDefault': 'now', 'timeFormat': 'g:i A' });
    });
  </script>

  <input type="checkbox" name="event_pin"<?php if ($post->event_pin != "") echo " checked"; ?>> Pin event to top of Home Page list<br>
  <br>

  <input type="text" name="event_date" placeholder="Event Date" value="<?php if ($post->event_date != "TBD") echo date("m/d/Y", $post->event_date); ?>" id="event_date">
  If not set, "TBD" will be displayed as the event date.<br>

  <input type="text" name="event_start_time" placeholder="Start Time" value="<?php if ($post->event_start_time != "") echo $post->event_start_time; ?>" id="event_start_time">
  -
  <input type="text" name="event_end_time" placeholder="End Time" value="<?php if ($post->event_end_time != "") echo $post->event_end_time; ?>" id="event_end_time">
  You may set a Start Time with no End Time.<br>
  <br>

  <input type="text" name="event_location_name" placeholder="Location Name" value="<?php if ($post->event_location_name != "") echo $post->event_location_name; ?>">
  <input type="text" name="event_location_address" placeholder="Location Address" value="<?php if ($post->event_location_address != "") echo $post->event_location_address; ?>"><br>
  <br>
  
  <input type="text" name="event_registration_text" placeholder="Registration Text (e.g. &quot;Registration ending soon!&quot;)" value="<?php if ($post->event_registration_text != "") echo $post->event_registration_text; ?>">
  <input type="checkbox" name="event_register_button"<?php if ($post->event_register_button != "") echo " checked"; ?>> Show "Register" button<br>
  <select name="event_registration_form">
    <option>Select a registration form...</option>
    <?php
    global $wpdb;
    $regforms = $wpdb->get_results("SELECT * FROM wp_nf3_forms ORDER BY title ASC", OBJECT);
    foreach ($regforms as $regform) {
      echo '<option value="'.$regform->id.'"';
      if ($post->event_registration_form == $regform->id) echo " selected";
      echo ">".$regform->title."</option>\n";
    }
    ?>
  </select><br>
  <br>

  <strong>PRICING</strong><br>
  <input type="text" name="event_pricing_member" placeholder="Member" value="<?php if ($post->event_pricing_member != "") echo $post->event_pricing_member; ?>">
  <input type="text" name="event_pricing_non_member" placeholder="Non-Member" value="<?php if ($post->event_pricing_non_member != "") echo $post->event_pricing_non_member; ?>">
  <input type="text" name="event_pricing_corporate" placeholder="Corporate" value="<?php if ($post->event_pricing_corporate != "") echo $post->event_pricing_corporate; ?>">
  <input type="text" name="event_pricing_friends" placeholder="Friends" value="<?php if ($post->event_pricing_friends != "") echo $post->event_pricing_friends; ?>">
  <input type="text" name="event_pricing_government" placeholder="Government" value="<?php if ($post->event_pricing_government != "") echo $post->event_pricing_government; ?>">
  
  <br><br><br>
  <strong>SIDEBAR TEXT</strong><br>
  <?php
  wp_editor(html_entity_decode($post->event_sidebar_text, ENT_QUOTES), 'event_sidebar_text', array('textarea_rows' => 10));
}

function events_mb_content_side($post) {
  ?>
  <input type="text" name="event_video" placeholder="URL to video page" value="<?php if ($post->event_video != "") echo $post->event_video; ?>"><br>
  Setting a video will override the Featured Image (if one is set).
  <?php
}

add_action('admin_head', 'events_css');
function events_css() {
  if (get_post_type() == 'events') {
    echo '<style>
      #events_mb INPUT[type="text"],
      #events_mb_side INPUT[type="text"] { width: 100%; margin: 0.5em 0; padding: 0.32em 8px; box-sizing: border-box; }
      #events_mb INPUT[type="text"]#event_date,
      #events_mb INPUT[type="text"]#event_start_time,
      #events_mb INPUT[type="text"]#event_end_time { width: 10em; }
      #events_mb SELECT { margin-top: 0.5em; }
    </style>';
  }
}

add_filter('wp_insert_post_data', 'events_custom_permalink');
function events_custom_permalink($data) {
  if ($data['post_type'] == 'events') {
    $data['post_name'] = sanitize_title($data['post_title']);
  }
  return $data;
}

add_action('save_post', 'events_save');
function events_save($post_id) {
  if (get_post_type() != 'events') return;
  update_post_meta($post_id, 'event_pin', $_POST['event_pin']);
  $edate = ($_POST['event_date'] != "") ? strtotime($_POST['event_date']) : "TBD";
  update_post_meta($post_id, 'event_date', $edate);
  update_post_meta($post_id, 'event_start_time', $_POST['event_start_time']);
  update_post_meta($post_id, 'event_end_time', $_POST['event_end_time']);
  update_post_meta($post_id, 'event_location_name', $_POST['event_location_name']);
  update_post_meta($post_id, 'event_location_address', $_POST['event_location_address']);
  update_post_meta($post_id, 'event_registration_text', $_POST['event_registration_text']);
  update_post_meta($post_id, 'event_register_button', $_POST['event_register_button']);
  update_post_meta($post_id, 'event_registration_form', $_POST['event_registration_form']);
  update_post_meta($post_id, 'event_pricing_member', $_POST['event_pricing_member']);
  update_post_meta($post_id, 'event_pricing_non_member', $_POST['event_pricing_non_member']);
  update_post_meta($post_id, 'event_pricing_corporate', $_POST['event_pricing_corporate']);
  update_post_meta($post_id, 'event_pricing_friends', $_POST['event_pricing_friends']);
  update_post_meta($post_id, 'event_pricing_government', $_POST['event_pricing_government']);
  update_post_meta($post_id, 'event_sidebar_text', $_POST['event_sidebar_text']);
  update_post_meta($post_id, 'event_video', $_POST['event_video']);
}

add_filter('manage_events_posts_columns', 'set_custom_edit_events_columns');
function set_custom_edit_events_columns($columns) {
  $columns['event_date'] = "Event Date";
  $columns['event_start_time'] = "Time";
  $columns['event_register_button'] = "Registration";
  $columns['event_pin'] = "Pinned";

  unset($columns['date']);

  return $columns;
}

add_action('manage_events_posts_custom_column', 'custom_events_column', 10, 2);
function custom_events_column($column, $post_id) {
  global $post;
  switch ($column) {
    case 'event_date':
      $edate = ($post->event_date != "TBD") ? date("m/d/Y", $post->event_date) : "TBD";
      echo $edate;
      break;
    case 'event_start_time':
      if ($post->event_start_time != "") echo $post->event_start_time;
      if ($post->event_start_time != "" && $post->event_end_time != "")
        echo " - ".$post->event_end_time;
      break;
    case 'event_register_button':
      if ($post->event_register_button != "") echo "Open";
      break;
    case 'event_pin':
      if ($post->event_pin == "on") echo "Yes";
      break;
  }
}

add_filter('manage_edit-events_sortable_columns', 'set_custom_events_sortable_columns');
function set_custom_events_sortable_columns($columns) {
  $columns['event_date'] = 'event_date';
  return $columns;
}

add_action('pre_get_posts', 'events_custom_orderby', 4);
function events_custom_orderby($query) {
  if (!$query->is_main_query() || 'events' != $query->get('post_type')) return;

  $orderby = $query->get('orderby');

  if ($orderby == '' || $orderby == 'event_date') {
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
  }
}

add_filter('post_row_actions', 'disable_events_quick_edit', 10, 2);
function disable_events_quick_edit($actions, $post) {
  if ('events' === $post->post_type) unset($actions['inline hide-if-no-js']);
  return $actions;
}


/////////////
// RESEARCH
/////////////
add_action('init', 'fg_research');
function fg_research() {
  register_post_type('research', array(
      'labels' => array(
        'name' => 'Research',
        'singular_name' => 'Research',
        'add_new_item' => 'Add New Research',
        'edit_item' => 'Edit Research',
        'search_items' => 'Search Research',
        'not_found' => 'No Research found'
      ),
      'show_ui' => true,
      'menu_position' => 53,
      'menu_icon' => 'dashicons-chart-pie',
      'supports' => array('title', 'editor','thumbnail'),
      'taxonomies' => array('research-category', 'research-tag'),
      'has_archive' => true,
      'exclude_from_search' => false,
      'publicly_queryable' => true,
      'show_in_nav_menus' => true
  ));
}

function fg_research_create_taxonomy() {
  register_taxonomy('research-category', 'research', array('label' => 'Category', 'hierarchical' => true));

  register_taxonomy(
    'research-tag',
    'research',
    array('label' => 'Tags')
  );
}
add_action('init', 'fg_research_create_taxonomy');

add_action('add_meta_boxes', 'fg_research_mb');
function fg_research_mb() {
  add_meta_box('fg_research_mb', 'Links', 'fg_research_mb_content', 'research', 'normal');
  add_meta_box('fg_research_mb_media', 'Media Coverage', 'fg_research_mb_media_content', 'research', 'normal');
}

function get_current_post_type() {
  global $post, $typenow, $current_screen;
  
  //we have a post so we can just get the post type from that
  if ( $post && $post->post_type )
    return $post->post_type;
    
  //check the global $typenow - set in admin.php
  elseif( $typenow )
    return $typenow;
    
  //check the global $current_screen object - set in sceen.php
  elseif( $current_screen && $current_screen->post_type )
    return $current_screen->post_type;
  
  //lastly check the post_type querystring
  elseif( isset( $_REQUEST['post_type'] ) )
    return sanitize_key( $_REQUEST['post_type'] );
  
  //we do not know the post type!
  return null;
}


// Place subtitle input after the title
add_action('edit_form_after_title', 'fg_research_subtitle');
function fg_research_subtitle($post) {
  if (get_post_type() == 'research') {
    echo '<input type="text" name="fg_research_subtitle" placeholder="Enter subtitle here" value="';
    if ($post->fg_research_subtitle != "") echo $post->fg_research_subtitle;
    echo '" id="fg_research_subtitle">';
  }
}

function fg_research_mb_content($post) {
  $meta = get_post_meta($post->ID);
  ?>
  <input type="text" name="fg_research_full_report" placeholder="Full Report" id="fg_research_full_report" class="with_button" value="<?php if (isset($meta['fg_research_full_report'])) echo $meta['fg_research_full_report'][0]; ?>">
  <input type="button" id="fg_research_full_report_button" class="button" value="Add/Edit PDF">

  <input type="text" name="fg_research_report_brief" placeholder="Report Brief" id="fg_research_report_brief" class="with_button" value="<?php if (isset($meta['fg_research_report_brief'])) echo $meta['fg_research_report_brief'][0]; ?>">
  <input type="button" id="fg_research_report_brief_button" class="button" value="Add/Edit PDF">

  <input type="text" name="fg_research_executive_summary" placeholder="Executive Summary" id="fg_research_executive_summary" class="with_button" value="<?php if (isset($meta['fg_research_executive_summary'])) echo $meta['fg_research_executive_summary'][0]; ?>">
  <input type="button" id="fg_research_executive_summary_button" class="button" value="Add/Edit PDF">

  <input type="text" name="fg_research_blog" placeholder="Blog (Full URL to page)" value="<?php if (isset($meta['fg_research_blog'])) echo $meta['fg_research_blog'][0]; ?>">

  <input type="text" name="fg_research_press_release" placeholder="Press Release" id="fg_research_press_release" class="with_button" value="<?php if (isset($meta['fg_research_press_release'])) echo $meta['fg_research_press_release'][0]; ?>">
  <input type="button" id="fg_research_press_release_button" class="button" value="Add/Edit PDF">

  <input type="text" name="fg_research_video" placeholder="Video Summary (URL to YouTube, Vimeo or Facebook page)" value="<?php if (isset($meta['fg_research_video'])) echo $meta['fg_research_video'][0]; ?>">

  <input type="text" name="fg_research_interactive_data" placeholder="Interactive Data (Full URL to page)" value="<?php if (isset($meta['fg_research_interactive_data'])) echo $meta['fg_research_interactive_data'][0]; ?>">
  
  <script>
    function WWDimage($image_id) {
      var send_attachment_bkp = wp.media.editor.send.attachment;
      wp.media.editor.send.attachment = function(props, attachment) {
        jQuery($image_id).val(attachment.url);
        wp.media.editor.send.attachment = send_attachment_bkp;
      }
      wp.media.editor.open();
      return false;
    }

    jQuery('#fg_research_full_report_button').click(function(){ WWDimage("#fg_research_full_report");});
    jQuery('#fg_research_report_brief_button').click(function(){ WWDimage("#fg_research_report_brief");});
    jQuery('#fg_research_executive_summary_button').click(function(){ WWDimage("#fg_research_executive_summary");});
    jQuery('#fg_research_press_release_button').click(function(){ WWDimage("#fg_research_press_release");});
  </script>
  <?php
}

function fg_research_mb_media_content($post) {
  $meta = get_post_meta($post->ID);
  ?>
  <div class="fg_research_mb_media_fields_wrap">
    <?php
    for ($i = 1; $i <= 20; $i++) {
      if (array_key_exists('fg_research_media_title_'.$i, $meta) || array_key_exists('fg_research_media_link_'.$i, $meta) || array_key_exists('fg_research_media_source_'.$i, $meta)) {
        if ($i > 1) echo '<hr>';
        ?>
        <div class="fg_research_mb_media_fields">
          <input type="text" name="fg_research_media_title_<?php echo $i; ?>" placeholder="Title <?php echo $i; ?>" value="<?php if (isset($meta['fg_research_media_title_'.$i])) echo $meta['fg_research_media_title_'.$i][0]; ?>">
          <input type="text" name="fg_research_media_link_<?php echo $i; ?>" placeholder="Link <?php echo $i; ?>" value="<?php if (isset($meta['fg_research_media_link_'.$i])) echo $meta['fg_research_media_link_'.$i][0]; ?>">
          <input type="text" name="fg_research_media_source_<?php echo $i; ?>" placeholder="Source <?php echo $i; ?>" value="<?php if (isset($meta['fg_research_media_source_'.$i])) echo $meta['fg_research_media_source_'.$i][0]; ?>">
        </div>
        <?php
      }
    }
    ?>
  </div>

  <input type="button" class="button add-another" value="Add Media">

  <script>
    var i = $('.fg_research_mb_media_fields_wrap .fg_research_mb_media_fields').size() + 1;

    $(".add-another").click(function(e){
      e.preventDefault();
      if (i > 1) $(".fg_research_mb_media_fields_wrap").append('<hr>');
      $(".fg_research_mb_media_fields_wrap").append('<div class="fg_research_mb_media_fields"><input type="text" name="fg_research_media_title_'+i+'" placeholder="Title '+i+'"><input type="text" name="fg_research_media_link_'+i+'" placeholder="Link '+i+'"><input type="text" name="fg_research_media_source_'+i+'" placeholder="Source '+i+'"></div>');
      i++;
    });
  </script>
  <?php
}

add_action('admin_head', 'fg_research_css');
function fg_research_css() {
  if (get_post_type() == 'research') {
    echo '<style>
      #edit-slug-box { display: none; }
      #fg_research_subtitle { padding: 3px 8px; font-size: 1.7em; line-height: 100%; height: 1.7em; width: 100%; outline: 0; }
      #fg_research_mb INPUT[type="text"], #fg_research_mb_media INPUT[type="text"] { width: 100%; padding: 0.32em 8px; box-sizing: border-box; margin: 0.5em 0; }
      #fg_research_mb INPUT[type="text"].with_button { width: 87%; margin-right: 0.75em; }
      #fg_research_mb .button { margin: 0.5em 0; }
      #fg_research_mb_media HR { border-top: 1px dotted #000000; }
      #fg_research_mb_media .add-another { margin-top: 1em; }
    </style>';
  }
}

// Add checkbox to Featured Image
add_filter('admin_post_thumbnail_html', 'add_featured_image_display_settings', 10, 2 );
function add_featured_image_display_settings($content, $post) {
  $fipd = get_post_meta($post, "featured_image_page_display", true);

  $fi_page_display = '<label><input type="checkbox" name="featured_image_page_display"';
  if ($fipd != "") $fi_page_display .= ' checked';
  $fi_page_display .= '> Do NOT show image on page</label>';

  return $content .= $fi_page_display;
}

add_action('save_post', 'save_featured_image_display_settings', 10, 3);
function save_featured_image_display_settings($post_id, $post, $update) {
  if (!empty($_POST['featured_image_page_display'])) {
    update_post_meta($post_id, 'featured_image_page_display', $_POST['featured_image_page_display']);
  } else {
    delete_post_meta($post_id, 'featured_image_page_display');
  }
}

add_filter('wp_insert_post_data', 'fg_research_custom_permalink');
function fg_research_custom_permalink($data) {
  if ($data['post_type'] == 'research') {
    if (isset($_POST['fg_research_subtitle']))
      $data['post_name'] = sanitize_title($data['post_title'].' '.$_POST['fg_research_subtitle']);
  }
  return $data;
}

add_action('save_post', 'fg_research_save');
function fg_research_save($post_id) {
  if (isset($_POST['fg_research_subtitle']))
    update_post_meta($post_id, 'fg_research_subtitle', $_POST['fg_research_subtitle']);

  if (isset($_POST['fg_research_full_report']))
    update_post_meta($post_id, 'fg_research_full_report', $_POST['fg_research_full_report']);
  if (isset($_POST['fg_research_report_brief']))
    update_post_meta($post_id, 'fg_research_report_brief', $_POST['fg_research_report_brief']);
  if (isset($_POST['fg_research_executive_summary']))
    update_post_meta($post_id, 'fg_research_executive_summary', $_POST['fg_research_executive_summary']);
  if (isset($_POST['fg_research_blog']))
    update_post_meta($post_id, 'fg_research_blog', $_POST['fg_research_blog']);
  if (isset($_POST['fg_research_press_release']))
    update_post_meta($post_id, 'fg_research_press_release', $_POST['fg_research_press_release']);
  if (isset($_POST['fg_research_video']))
    update_post_meta($post_id, 'fg_research_video', $_POST['fg_research_video']);
  if (isset($_POST['fg_research_interactive_data']))
    update_post_meta($post_id, 'fg_research_interactive_data', $_POST['fg_research_interactive_data']);

  for ($i = 1; $i <= 20; $i++) {
    if (isset($_POST['fg_research_media_title_'.$i]))
      update_post_meta($post_id, 'fg_research_media_title_'.$i, $_POST['fg_research_media_title_'.$i]);
    if (isset($_POST['fg_research_media_link_'.$i]))
      update_post_meta($post_id, 'fg_research_media_link_'.$i, $_POST['fg_research_media_link_'.$i]);
    if (isset($_POST['fg_research_media_source_'.$i]))
      update_post_meta($post_id, 'fg_research_media_source_'.$i, $_POST['fg_research_media_source_'.$i]);
  }
}

add_filter('manage_research_posts_columns', 'set_custom_edit_research_columns');
function set_custom_edit_research_columns($columns) {
  unset($columns['date']);

  $columns['research_subtitle'] = "Subtitle";
  $columns['research_category'] = "Category";

  $columns['date'] = "Date";

  return $columns;
}

add_action('manage_research_posts_custom_column', 'custom_research_column', 10, 2);
function custom_research_column($column, $post_id) {
  switch ($column) {
    case 'research_subtitle':
      echo get_post_meta($post_id, 'fg_research_subtitle', true);
      break;
    case 'research_category':
      the_terms($post->ID, 'research-category');
      break;
  }
}

add_action('pre_get_posts', 'research_posts_per_page');
function research_posts_per_page($query) {
  if (!is_admin() && $query->is_main_query() && is_post_type_archive('research') || is_tax(array('research-category','research-tag'))) {
    $query->set('posts_per_page', 6);
  }
}

add_action('wp_head', 'insert_open_graph');
function insert_open_graph($post) {
  if (is_front_page()) {
    setup_postdata($post);
    ?>
    <meta property="og:title" content="Wisconsin Policy Forum" />
    <meta property="og:url" content="https://wispolicyforum.org" />
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Wisconsin Policy Forum">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png">
    <?php
  }

  if (is_single()) {
    setup_postdata($post);
    ?>
    <meta property="og:title" content="<?php the_title(); ?>" />
    <meta property="og:url" content="<?php esc_url(the_permalink()); ?>" />
    <?php
    if(!has_post_thumbnail()) {
      $og_image = get_template_directory_uri().'/images/logo.png';
    } else {
      $og_image = wp_get_attachment_url(get_post_thumbnail_id());
    }
    ?>
    <meta property="og:image" content="<?php echo $og_image; ?>" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php the_title(); ?>">
    <meta name="twitter:description" content="<?php echo fg_excerpt(40); ?>">
    <meta name="twitter:image" content="<?php echo $og_image; ?>">
    <?php
  }
}

//////////
// FOCUS
//////////
add_action('init', 'focus');
function focus() {
  register_post_type('focus', array(
    'labels' => array(
      'name' => 'Focus',
      'singular_name' => 'Focus',
      'add_new_item' => 'Add New Focus',
      'edit_item' => 'Edit Focus',
      'search_items' => 'Search Focus',
      'not_found' => 'No Focus found'
    ),
    'show_ui' => true,
    'menu_position' => 51,
    'menu_icon' => 'dashicons-media-document',
    'supports' => array('title','editor','thumbnail'),
    'has_archive' => true,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'show_in_nav_menus' => true
  ));
}

add_action('add_meta_boxes', 'focus_mb');
function focus_mb() {
  add_meta_box('focus_mb_side', 'Volume # & PDF', 'focus_mb_content_side', 'focus', 'side', 'high');
  add_meta_box('focus_mb_media', 'Media Coverage', 'focus_mb_media_content', 'focus', 'normal');
}

function focus_mb_content_side($post) {
  ?>
  <input type="text" name="focus_volume" placeholder="Volume #" value="<?php if ($post->focus_volume != "") echo $post->focus_volume; ?>">
  <input type="text" name="focus_pdf" placeholder="PDF" id="focus_pdf" class="with_button" value="<?php if ($post->focus_pdf) echo $post->focus_pdf; ?>">
  <input type="button" id="focus_pdf_button" class="button" value="Add/Edit PDF">

  <script>
    function WWDimage($image_id) {
      var send_attachment_bkp = wp.media.editor.send.attachment;
      wp.media.editor.send.attachment = function(props, attachment) {
        jQuery($image_id).val(attachment.url);
        wp.media.editor.send.attachment = send_attachment_bkp;
      }
      wp.media.editor.open();
      return false;
    }

    jQuery('#focus_pdf_button').click(function(){ WWDimage("#focus_pdf");});
  </script>
  
  <br><br><br>
  <input type="checkbox" name="focus_featured"<?php if ($post->focus_featured != "") echo " checked"; ?>> <strong>Featured Publication</strong><br>
  Checking this will force this issue of Focus to display on the home page instead of the most recent research. It will remain that way until unchecked.
  <?php
}

function focus_mb_media_content($post) {
  $meta = get_post_meta($post->ID);
  ?>
  <div class="focus_mb_media_fields_wrap">
    <?php
    for ($i = 1; $i <= 20; $i++) {
      if (array_key_exists('focus_media_title_'.$i, $meta) || array_key_exists('focus_media_link_'.$i, $meta) || array_key_exists('focus_media_source_'.$i, $meta)) {
        if ($i > 1) echo '<hr>';
        ?>
        <div class="focus_mb_media_fields">
          <input type="text" name="focus_media_title_<?php echo $i; ?>" placeholder="Title <?php echo $i; ?>" value="<?php if (isset($meta['focus_media_title_'.$i])) echo $meta['focus_media_title_'.$i][0]; ?>">
          <input type="text" name="focus_media_link_<?php echo $i; ?>" placeholder="Link <?php echo $i; ?>" value="<?php if (isset($meta['focus_media_link_'.$i])) echo $meta['focus_media_link_'.$i][0]; ?>">
          <input type="text" name="focus_media_source_<?php echo $i; ?>" placeholder="Source <?php echo $i; ?>" value="<?php if (isset($meta['focus_media_source_'.$i])) echo $meta['focus_media_source_'.$i][0]; ?>">
        </div>
        <?php
      }
    }
    ?>
  </div>

  <input type="button" class="button add-another" value="Add Media">

  <script>
    var i = $('.focus_mb_media_fields_wrap .focus_mb_media_fields').size() + 1;

    $(".add-another").click(function(e){
      e.preventDefault();
      if (i > 1) $(".focus_mb_media_fields_wrap").append('<hr>');
      $(".focus_mb_media_fields_wrap").append('<div class="focus_mb_media_fields"><input type="text" name="focus_media_title_'+i+'" placeholder="Title '+i+'"><input type="text" name="focus_media_link_'+i+'" placeholder="Link '+i+'"><input type="text" name="focus_media_source_'+i+'" placeholder="Source '+i+'"></div>');
      i++;
    });
  </script>
  <?php
}

add_action('admin_head', 'focus_css');
function focus_css() {
  if (get_post_type() == 'focus') {
    echo '<style>
      #focus_mb_side INPUT[type="text"], #focus_mb_media INPUT[type="text"] { width: 100%; margin: 0.5em 0; padding: 0.32em 8px; box-sizing: border-box; }
      TH#focus_pdf, TH#focus_volume, TH#focus_featured { width: 10%; }
      #focus_mb_media HR { border-top: 1px dotted #000000; }
      #focus_mb_media .add-another { margin-top: 1em; }
    </style>';
  }
}

add_action('admin_head', 'focus_editor_style');
function focus_editor_style() {
  if (get_post_type() == 'focus') add_editor_style('editor-style-focus.css');
}

add_filter('tiny_mce_before_init', 'cache_bust');
function cache_bust($mce_init) {
  $mce_init['cache_suffix'] = 'v='.time();
  return $mce_init;
}

add_action('save_post', 'focus_save');
function focus_save($post_id) {
  if (get_post_type() != 'focus') return;
  update_post_meta($post_id, 'focus_volume', $_POST['focus_volume']);
  update_post_meta($post_id, 'focus_pdf', $_POST['focus_pdf']);
  update_post_meta($post_id, 'focus_featured', $_POST['focus_featured']);

  for ($i = 1; $i <= 20; $i++) {
    if (isset($_POST['focus_media_title_'.$i]))
      update_post_meta($post_id, 'focus_media_title_'.$i, $_POST['focus_media_title_'.$i]);
    if (isset($_POST['focus_media_link_'.$i]))
      update_post_meta($post_id, 'focus_media_link_'.$i, $_POST['focus_media_link_'.$i]);
    if (isset($_POST['focus_media_source_'.$i]))
      update_post_meta($post_id, 'focus_media_source_'.$i, $_POST['focus_media_source_'.$i]);
  }
}

add_filter('manage_focus_posts_columns', 'set_custom_edit_focus_columns');
function set_custom_edit_focus_columns($columns) {
  unset($columns['date']);
  
  $columns['focus_pdf'] = "PDF";
  $columns['focus_volume'] = "Volume";
  $columns['focus_featured'] = "Featured";

  $columns['date'] = "Date";

  return $columns;
}

add_action('manage_focus_posts_custom_column', 'custom_focus_column', 10, 2);
function custom_focus_column($column, $post_id) {
  switch ($column) {
    case 'focus_pdf':
      if (get_post_meta($post_id, 'focus_pdf', true) != "") echo "Yes";
      break;

    case 'focus_volume':
      echo get_post_meta($post_id, 'focus_volume', true);
      break;

    case 'focus_featured':
      if (get_post_meta($post_id, 'focus_featured', true) != "") echo "Yes";
      break;
  }
}


////////////////
// IN THE NEWS
////////////////
add_action('add_meta_boxes', 'insight_mb');
function insight_mb() {
  add_meta_box('insight_mb_radio', 'Insight Tabs', 'insight_mb_content_radio', 'post', 'side', 'high');
  add_meta_box('insight_mb_input', 'Source & Link', 'insight_mb_content_input', 'post', 'normal', 'high');
}

function insight_mb_content_radio($post) {
  $insight_tab = $post->insight_tab;
  if ($insight_tab == "") $insight_tab = "our-news";
  ?>
  <label><input type="radio" name="insight_tab" value="our-news" id="oi"<?php if ($insight_tab == "our-news") echo " checked"; ?>> Our News</label><br>
  <label><input type="radio" name="insight_tab" value="in-the-news" id="itn"<?php if ($insight_tab == "in-the-news") echo " checked"; ?>> In The News</label>

  <script>
    jQuery(function($) {
      if ($('#oi').is(':checked')) {
        $('#insight_mb_input').hide();
        $('#wp-content-wrap, #post-status-info, #tagsdiv-post_tag, #postimagediv').show();
      } else {
        $('#insight_mb_input').show();
        $('#wp-content-wrap, #post-status-info, #tagsdiv-post_tag, #postimagediv').hide();
      }

      $('input[type=radio]').change(function(){
        if (this.value == 'our-news') {
          $('#insight_mb_input').hide();
          $('#wp-content-wrap, #post-status-info, #tagsdiv-post_tag, #postimagediv').show();
          $('#in-category-31').prop('checked', false);
          $('#in-category-30').prop('checked', true);
          $('#inthenews_source, #inthenews_link').val('');
        } else {
          $('#insight_mb_input').show();
          $('#wp-content-wrap, #post-status-info, #tagsdiv-post_tag, #postimagediv').hide();
          $('#in-category-31').prop('checked', true);
          $('#in-category-30').prop('checked', false);
        }
      });
    });
  </script>
  <?php
}

function insight_mb_content_input($post) {
  ?>
  <input type="text" name="inthenews_source" id="inthenews_source" placeholder="Source" value="<?php if ($post->inthenews_source != "") echo $post->inthenews_source; ?>">
  <input type="text" name="inthenews_link" id="inthenews_link" placeholder="Link" value="<?php if ($post->inthenews_link != "") echo $post->inthenews_link; ?>">
  <?php
}

add_action('admin_head', 'insight_css');
function insight_css() {
  if (get_post_type() == 'post') {
    echo '<style>
      #insight_mb_input INPUT[type="text"] { width: 100%; margin: 0.5em 0; padding: 0.32em 8px; box-sizing: border-box; }
      #insight_mb_input LABEL { margin-right: 1em; }
    </style>';
  }
}

add_action('save_post', 'insight_save');
function insight_save($post_id) {
  if (get_post_type() == 'post') {
    update_post_meta($post_id, 'insight_tab', $_POST['insight_tab']);
    update_post_meta($post_id, 'inthenews_source', $_POST['inthenews_source']);
    update_post_meta($post_id, 'inthenews_link', $_POST['inthenews_link']);
  }
}


/////////////
// FG SLIDER
/////////////
add_action('init', 'fg_slider');
function fg_slider() {
  register_post_type('fg_slider', array(
    'labels' => array(
      'name' => 'Slider',
      'singular_name' => 'Slider',
      'add_new' => 'Add Slide',
      'add_new_item' => 'Add New Slide',
      'edit_item' => 'Edit Slide',
      'new_item' => 'New Slide',
      'search_items' => 'Search Slides',
      'not_found' => 'No Slides found'
    ),
    'show_ui' => true,
    'menu_position' => 30,
    'menu_icon' => 'dashicons-slides',
    'supports' => array('title','editor','thumbnail')
  ));
}

add_action('add_meta_boxes', 'fg_slider_mb');
function fg_slider_mb() {
  add_meta_box('fg_slider_mb', 'Button', 'fg_slider_mb_content', 'fg_slider', 'normal', 'high');
}

function fg_slider_mb_content($post) {
  ?>
  <input type="text" name="fg_slider_button_text" placeholder="Button Text" value="<?php if ($post->fg_slider_button_text) echo $post->fg_slider_button_text; ?>">

  <input type="text" name="fg_slider_button_link" placeholder="Button Link" id="fg_slider_button_link" class="with_button" value="<?php if ($post->fg_slider_button_link) echo $post->fg_slider_button_link; ?>">
  <input type="button" id="fg_slider_button_link_button" class="button" value="Add/Edit Link">

  <script>
    jQuery(document).ready(function($){
      'use strict';
      var _link_sideload = false;

      $('body').on('click', '#fg_slider_button_link_button', function(event) {
        _addLinkListeners();

        if ( typeof wpActiveEditor == 'undefined') {
          window.wpActiveEditor = true;
          _link_sideload = true;
        }

        wpLink.open();
        wpLink.textarea = $('#fg_slider_button_link');
      });

      function _addLinkListeners() {
        $('body').on('click', '#wp-link-submit', function(e) {
          var linkAtts = wpLink.getAttrs();
          $('#fg_slider_button_link').val(linkAtts.href);
          _removeLinkListeners();
          return false;
        });

        $('body').on('click', '#wp-link-cancel', function(e) {
          _removeLinkListeners();
          return false;
        });
      }

      function _removeLinkListeners() {
        if(_link_sideload){
          if (typeof wpActiveEditor != 'undefined') wpActiveEditor = undefined;
        }

        wpLink.close();
        wpLink.textarea = $('html');

        $('body').off('click', '#wp-link-submit');
        $('body').off('click', '#wp-link-cancel');
      }
    });
  </script>
  <?php
}

add_action('admin_head', 'fg_slider_css');
function fg_slider_css() {
  if (get_post_type() == 'fg_slider') {
    echo '<style>
      #fg_slider_mb INPUT[type="text"] { width: 100%; padding: 0.32em 8px; box-sizing: border-box; margin: 0.5em 0; }
      #fg_slider_mb INPUT[type="text"].with_button { width: 87%; margin-right: 0.75em; }
      #fg_slider_mb .button { margin: 0.5em 0; }
    </style>';
  }
}

add_action('save_post', 'fg_slider_save');
function fg_slider_save($post_id) {
  if (get_post_type() != 'fg_slider') return;
  update_post_meta($post_id, 'fg_slider_button_text', $_POST['fg_slider_button_text']);
  update_post_meta($post_id, 'fg_slider_button_link', $_POST['fg_slider_button_link']);
}

function fg_get_unique() {
  static $unique = 0;
  $unique++;

  return $unique;
}

add_shortcode('fg-slider','get_fg_slider');
function get_fg_slider($atts, $content = null) {          
  extract(shortcode_atts(array(
    "timeout"    => '5000',
    "speed"      => '2000',
    "transition" => 'fade',
    "pause"      => 'true',
    "dots"       => 'false',
    "arrows"     => 'false'
  ), $atts)); 

  $timeout = (!empty($timeout)) ? $timeout : 5000;
  $speed   = (!empty($speed)) ? $speed : 2000;

  $slider_conf = ' data-cycle-timeout="' . $timeout . '"';
  $slider_conf .= ' data-cycle-speed="' . $speed . '"';
  if ($transition != "fade") $slider_conf .= ' data-cycle-fx="' . $transition . '"';
  if ($pause == "true") $slider_conf .= ' data-cycle-pause-on-hover="true"';
  if ($dots == "true") $slider_conf .= ' data-cycle-pager-template="<span></span>"';
  
  // wp_enqueue_style('fg-cycle-style', get_template_directory_uri().'/inc/cycle.css');
  wp_enqueue_script('fg-cycle-jquery', get_template_directory_uri().'/inc/jquery.cycle2.min.js', array('jquery'), false, true);
  
  ob_start();
  
  global $post;
  $unique = fg_get_unique();  

  $query = new WP_Query(array('post_type' => 'fg_slider', 'orderby' => 'menu_order', 'order'  => 'ASC', 'posts_per_page' => -1));
  
  if ($query->have_posts()) :
    ?>
    <div class="cycle-slideshow slideshow-<?php echo $unique; ?>" data-cycle-slides="> div" data-cycle-auto-height="false"<?php echo $slider_conf; ?>>
      <?php
      if ($arrows == "true") echo "<a href=\"#\" class=\"fs fs-arrow cycle-prev\"></a><a href=\"#\" class=\"fs fs-arrow cycle-next\"></a>\n";
      if ($dots == "true") echo "<span class=\"cycle-pager\"></span>\n";
      
      while ($query->have_posts() ) : $query->the_post();   
      ?>
        <div style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
          <div class="box">
            <div class="site-width">
              <div class="box-text">
                <?php
                the_title('<h1>','</h1>');
                the_content();

                if ($post->fg_slider_button_text != "" && $post->fg_slider_button_link != "")
                  echo '<a href="'.$post->fg_slider_button_link.'" class="button">'.$post->fg_slider_button_text.'</a>';
                ?>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
    <?php
  endif; 

  wp_reset_query();
  return ob_get_clean();
}

add_action('admin_menu', 'register_fg_slider_instructions');
function register_fg_slider_instructions() {
  add_submenu_page('edit.php?post_type=fg_slider', 'How It Works', 'How It Works', 'manage_options', 'fg_slider_instructions_menu', 'fg_slider_instructions');
}

function fg_slider_instructions() { ?>
  <div id="post-body-content" style="width: 98%;">
    <div class="metabox-holder">
      <div class="meta-box-sortables ui-sortable">
        <div class="postbox">
          
          <h3 class="hndle">
            <span>How It Works</span>
          </h3>
          
          <div class="inside">
            <h3>Getting Started</h3>

            <strong>Add Slides</strong><br>
            <ol>
              <li>Go to "Slider > Add Slide".</li>
              <li>Add a title; this will be the headline of the slide.</li>
              <li>In the text box, add the content of the slide.</li>
              <li>Set the featured image. This will be the background image of the slide.</li>
              <li>Save the slide, then go to "Slider > Slider" to drag the slides in the order you would like them to appear.</li>
            </ol><br>
            <br>

            <strong>Adding a Slider to a Page</strong><br>
            <ol>
              <li>Copy the shortcode <code>[fg-slider]</code> for a default slider. (See "Slider Parameters" below for other slider options.)</li>
              <li>Edit the page you want the slider to appear on and paste in the shortcode.</li>
              <li>Save the page.</li>
            </ol>
            <br>
            You may also display a slider directly into a template using <code>&lt;?php echo do_shortcode('[fg-slider]'); ?&gt;</code><br>
            <br>
            <br>

            <h3>Slider Parameters</h3>
            You can add certain parameters to the shortcode to alter the default behavior of the slider. There is no need to add a parameter if you desire the default behavior. You may use multiple parameters, such as <code>[fg-slider pause="false" timeout="7000"]</code><br>
            <br>

<!--             <strong>Arrows</strong><br>
            <code>[fg-slider arrows="true"]</code><br>
            Display arrows to advance the slider manually. The default setting is "false".<br>
            <br>

            <strong>Dots</strong><br>
            <code>[fg-slider dots="true"]</code><br>
            Display dots to jump to a particular slide manually. The default setting is "false".<br>
            <br> -->

            <strong>Pause</strong><br>
            <code>[fg-slider pause="false"]</code><br>
            Pause the slideshow while the mouse is hovered over it. The default setting is "true".<br>
            <br>

            <strong>Timeout</strong><br>
            <code>[fg-slider timeout="7000"]</code><br>
            The amount of time in milliseconds that each slide will appear before automatically changing to the next slide. The default setting is "5000".<br>
            <br>

            <strong>Transition</strong><br>
            <code>[fg-slider transition="scrollHorz"]</code><br>
            The transition style of one one slide to the next. Transition styles include <code>fade</code>, <code>fadeout</code>, <code>none</code> and <code>scrollHorz</code>. The default setting is "fade".<br>
            <br>

            <strong>Transition Speed</strong><br>
            <code>[fg-slider speed="1000"]</code><br>
            The amount of time in milliseconds that it takes for one slide to change to the next. The default setting is "2000".
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>