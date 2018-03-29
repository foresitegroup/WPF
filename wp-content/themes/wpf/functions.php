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
  <input type="text" name="fg_staff_position" placeholder="Title/Position" value="<?php if (isset($meta['fg_staff_position'])) echo $ar_meta['fg_staff_position'][0]; ?>">
  <input type="email" name="fg_staff_email" placeholder="Email" value="<?php if (isset($meta['fg_staff_email'])) echo $ar_meta['fg_staff_email'][0]; ?>">
  <input type="text" name="fg_staff_phone" placeholder="Telephone" value="<?php if (isset($meta['fg_staff_phone'])) echo $ar_meta['fg_staff_phone'][0]; ?>">
  <?php
}

add_action('admin_head', 'fg_staff_css');
function fg_staff_css() {
  echo '<style>
    #fg_staff_metabox_display_box INPUT { width: 100%; margin: 0.5em 0; padding: 0.32em 8px; box-sizing: border-box; }
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
}
?>