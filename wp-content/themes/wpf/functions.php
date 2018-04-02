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
add_filter( 'embed_oembed_html', 'my_oembed_filter', 10, 4 ) ;
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


///////////////////
// ANNUAL REPORTS
///////////////////
add_action('init', 'annual_reports');
function annual_reports() {
  register_post_type('annual_reports',
    array(
      'labels' => array(
        'name' => 'Annual Reports',
        'singular_name' => 'Annual Report',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Annual Report',
        'edit' => 'Edit',
        'edit_item' => 'Edit Annual Report',
        'new_item' => 'New Annual Report',
        'view' => 'View',
        'view_item' => 'View Annual Report',
        'search_items' => 'Search Annual Reports',
        'not_found' => 'No Annual Reports found',
        'not_found_in_trash' => 'No Annual Reports found in Trash',
        'parent' => 'Parent Annual Report'
      ),

      'public' => false,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 50,
      'supports' => array('title','editor','thumbnail'),
      'taxonomies' => array(''),
      'menu_icon' => 'dashicons-analytics',
      'has_archive' => true
    )
  );
}

add_action('add_meta_boxes', 'annual_reports_metabox');
function annual_reports_metabox() {
  add_meta_box('annual_reports_metabox_display_box',
    'Annual Report PDF',
    'annual_reports_metabox_display',
    'annual_reports',
    'normal',
    'high'
  );
}

function annual_reports_metabox_display($post) {
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
  echo '<style>
    #annual_report_pdf { width: 90%; padding: 0.32em 8px; margin-right: 0.75em; }
  </style>';
}

add_action('save_post', 'save_annual_reports');
function save_annual_reports($post_id) {
  if (isset($_POST['annual_report_pdf']))
    update_post_meta($post_id, 'annual_report_pdf', $_POST['annual_report_pdf']);
}


//////////
// STAFF
//////////
add_action('init', 'fg_staff');
function fg_staff() {
  register_post_type('fg_staff',
    array(
      'labels' => array(
        'name' => 'Staff',
        'singular_name' => 'Staff',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Staff',
        'edit' => 'Edit',
        'edit_item' => 'Edit Staff',
        'new_item' => 'New Staff',
        'view' => 'View',
        'view_item' => 'View Staff',
        'search_items' => 'Search Staff',
        'not_found' => 'No Staff found',
        'not_found_in_trash' => 'No Staff found in Trash',
        'parent' => 'Parent Staff'
      ),

      'public' => false,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 50,
      'supports' => array('title','editor','thumbnail'),
      'taxonomies' => array(''),
      'menu_icon' => 'dashicons-businessman',
      'has_archive' => true
    )
  );
}

add_action('add_meta_boxes', 'fg_staff_metabox');
function fg_staff_metabox() {
  add_meta_box('fg_staff_metabox_display_box',
    'Additional Information',
    'fg_staff_metabox_display',
    'fg_staff',
    'normal',
    'high'
  );
}

add_filter('enter_title_here', 'fg_staff_title');
function fg_staff_title($input) {
  if (get_post_type() === 'fg_staff') return "Enter name here";
  return $input;
}

function fg_staff_metabox_display($post) {
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
  echo '<style>
    #fg_staff_metabox_display_box INPUT { width: 100%; margin: 0.5em 0; padding: 0.32em 8px; box-sizing: border-box; }
    .column-fg_staff_email { width: 25%; }
    .column-fg_staff_phone { width: 15%; }
    .column-fg_staff_extension { width: 10%; }
    .column-fg_staff_image { width: 10%; }
  </style>';
}

add_action('save_post', 'save_fg_staff');
function save_fg_staff($post_id) {
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
  register_post_type('fg_board',
    array(
      'labels' => array(
        'name' => 'Board',
        'singular_name' => 'Board',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Board',
        'edit' => 'Edit',
        'edit_item' => 'Edit Board',
        'new_item' => 'New Board',
        'view' => 'View',
        'view_item' => 'View Board',
        'search_items' => 'Search Board',
        'not_found' => 'No Board found',
        'not_found_in_trash' => 'No Board found in Trash',
        'parent' => 'Parent Board'
      ),

      'public' => false,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 50,
      'supports' => array('title','thumbnail'),
      'taxonomies' => array(''),
      'menu_icon' => 'dashicons-groups',
      'has_archive' => true
    )
  );
}

add_filter('enter_title_here', 'fg_board_title');
function fg_board_title($input) {
  if (get_post_type() === 'fg_board') return "Enter full name here";
  return $input;
}

add_action('add_meta_boxes', 'fg_board_metabox');
function fg_board_metabox() {
  add_meta_box('fg_board_metabox_display_box',
    'Additional Information',
    'fg_board_metabox_display',
    'fg_board',
    'normal',
    'high'
  );
}

function fg_board_metabox_display($post) {
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
function fg_board_css($post) {
  // $fg_board_type = esc_html(get_post_meta($post->ID, 'fg_board_type', true));
  $meta = get_post_meta($post->ID);

  $fg_board_type = $meta['fg_board_type'][0];
  echo '<style>
    #fg_board_metabox_display_box INPUT[type="text"] { width: 100%; margin: 0.5em 0; padding: 0.32em 8px; box-sizing: border-box; }
    #fg_board_metabox_display_box LABEL { margin-right: 1em; }
  </style>';
}

add_action('save_post', 'save_fg_board');
function save_fg_board($post_id) {
  if (isset($_POST['fg_board_lastname']))
    update_post_meta($post_id, 'fg_board_lastname', $_POST['fg_board_lastname']);

  if (isset($_POST['fg_board_company']))
    update_post_meta($post_id, 'fg_board_company', $_POST['fg_board_company']);

  if (isset($_POST['fg_board_type']))
    update_post_meta($post_id, 'fg_board_type', $_POST['fg_board_type']);

  if (isset($_POST['fg_board_officer_title']))
    update_post_meta($post_id, 'fg_board_officer_title', $_POST['fg_board_officer_title']);
}
?>