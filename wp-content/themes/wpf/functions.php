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
function fg_excerpt($limit, $more = '') {
  return wp_trim_words(get_the_excerpt(), $limit, $more);
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
  wp_editor($post->wwd_page_section1_text, 'wwd_page_section1_text', array('textarea_rows' => 5));
  ?>
  <input type="text" name="wwd_page_section1_image" id="wwd_page_section1_image" class="wwd_page_image" value="<?php if ($post->wwd_page_section1_image) echo $post->wwd_page_section1_image; ?>">
  <input type="button" id="wwd_page_section1_image_button" class="button" value="Add/Edit Image">

  <hr>

  <h3>Section 2</h3>
  <input type="text" name="wwd_page_section2_title" placeholder="Section 2 Title" value="<?php if ($post->wwd_page_section2_title) echo $post->wwd_page_section2_title; ?>">
  <?php
  wp_editor($post->wwd_page_section2_text, 'wwd_page_section2_text', array('textarea_rows' => 5));
  ?>
  <input type="text" name="wwd_page_section2_image" id="wwd_page_section2_image" class="wwd_page_image" value="<?php if ($post->wwd_page_section2_image) echo $post->wwd_page_section2_image; ?>">
  <input type="button" id="wwd_page_section2_image_button" class="button" value="Add/Edit Image">

  <hr>

  <h3>Section 3</h3>
  <input type="text" name="wwd_page_section3_title" placeholder="Section 3 Title" value="<?php if ($post->wwd_page_section3_title) echo $post->wwd_page_section3_title; ?>">
  <?php
  wp_editor($post->wwd_page_section3_text, 'wwd_page_section3_text', array('textarea_rows' => 5));
  ?>
  <input type="text" name="wwd_page_section3_image" id="wwd_page_section3_image" class="wwd_page_image" value="<?php if ($post->wwd_page_section3_image) echo $post->wwd_page_section3_image; ?>">
  <input type="button" id="wwd_page_section3_image_button" class="button" value="Add/Edit Image">

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
  </script>
  <?php
}

add_action('admin_head', 'wwd_page_css');
function wwd_page_css() {
  global $post;
  if ('template-what-we-do-page.php' == get_post_meta($post->ID, '_wp_page_template', true)) {
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
  if (isset($_POST['wwd_page_section1_title']))
    update_post_meta($post_id, 'wwd_page_section1_title', $_POST['wwd_page_section1_title']);
  if (isset($_POST['wwd_page_section1_text']))
    update_post_meta($post_id, 'wwd_page_section1_text', $_POST['wwd_page_section1_text']);
  if (isset($_POST['wwd_page_section1_image']))
    update_post_meta($post_id, 'wwd_page_section1_image', $_POST['wwd_page_section1_image']);

  if (isset($_POST['wwd_page_section2_title']))
    update_post_meta($post_id, 'wwd_page_section2_title', $_POST['wwd_page_section2_title']);
  if (isset($_POST['wwd_page_section2_text']))
    update_post_meta($post_id, 'wwd_page_section2_text', $_POST['wwd_page_section2_text']);
  if (isset($_POST['wwd_page_section2_image']))
    update_post_meta($post_id, 'wwd_page_section2_image', $_POST['wwd_page_section2_image']);

  if (isset($_POST['wwd_page_section3_title']))
    update_post_meta($post_id, 'wwd_page_section3_title', $_POST['wwd_page_section3_title']);
  if (isset($_POST['wwd_page_section3_text']))
    update_post_meta($post_id, 'wwd_page_section3_text', $_POST['wwd_page_section3_text']);
  if (isset($_POST['wwd_page_section3_image']))
    update_post_meta($post_id, 'wwd_page_section3_image', $_POST['wwd_page_section3_image']);
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
  <?php
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
      'show_in_nav_menus' => true,
      'show_ui' => true
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

  <input type="text" name="fg_research_executive_summary" placeholder="Executive Summary" id="fg_research_executive_summary" class="with_button" value="<?php if (isset($meta['fg_research_executive_summary'])) echo $meta['fg_research_executive_summary'][0]; ?>">
  <input type="button" id="fg_research_executive_summary_button" class="button" value="Add/Edit PDF">

  <input type="text" name="fg_research_blog" placeholder="Blog (Full URL to page)" value="<?php if (isset($meta['fg_research_blog'])) echo $meta['fg_research_blog'][0]; ?>">

  <input type="text" name="fg_research_press_release" placeholder="Press Release" id="fg_research_press_release" class="with_button" value="<?php if (isset($meta['fg_research_press_release'])) echo $meta['fg_research_press_release'][0]; ?>">
  <input type="button" id="fg_research_press_release_button" class="button" value="Add/Edit PDF">

  <input type="text" name="fg_research_video" placeholder="Video Summary (URL to YouTube, Vimeo or Facebook page)" value="<?php if (isset($meta['fg_research_video'])) echo $meta['fg_research_video'][0]; ?>">
  
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
  if (isset($_POST['fg_research_executive_summary']))
    update_post_meta($post_id, 'fg_research_executive_summary', $_POST['fg_research_executive_summary']);
  if (isset($_POST['fg_research_blog']))
    update_post_meta($post_id, 'fg_research_blog', $_POST['fg_research_blog']);
  if (isset($_POST['fg_research_press_release']))
    update_post_meta($post_id, 'fg_research_press_release', $_POST['fg_research_press_release']);
  if (isset($_POST['fg_research_video']))
    update_post_meta($post_id, 'fg_research_video', $_POST['fg_research_video']);

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
  if (is_single()) {
    ?>
    <meta property="og:title" content="<?php the_title(); ?>" />
    <meta property="og:url" content="<?php the_permalink(); ?>" />
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
    <meta name="twitter:description" content="<?php the_excerpt(); ?>">
    <meta name="twitter:image" content="<?php echo $og_image; ?>">
    <?php
  }
}

?>