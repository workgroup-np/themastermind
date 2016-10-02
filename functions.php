<?php
/**
 * mastermind functions file.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();}

global $mastermind_options;

if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/options-config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/options-config.php' );
}
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( ABSPATH . 'wp-admin/includes/template.php' );
require( trailingslashit( get_template_directory() ) . 'inc/aq_resizer.php' );
require( trailingslashit( get_template_directory() ) . 'inc/navwalker.php' );
require( trailingslashit( get_template_directory() ) . 'inc/widgets.php' );
require( trailingslashit( get_template_directory() ) . 'inc/metabox.php' );
/*********************************************************************
* THEME SETUP
*/

function mastermind_setup() {

    global $mastermind_options;
    // Set content width
    global $content_width;
    if (!isset($content_width)) $content_width = 720;

    // Editor style (editor-style.css)
    add_editor_style(array('assets/css/editor-style.css'));

    // Load plugin checker
    require(get_template_directory() . '/inc/plugin-activation.php');

     // Nav Menu (Custom menu support)
    if (function_exists('register_nav_menu')) :
        global $mastermind_options;
        register_nav_menu('primary', __('Mastermind Primary Menu', 'mastermind'));
        register_nav_menu('secondary', __('Mastermind Footer Menu', 'mastermind'));
    endif;

    // Theme Features: Automatic Feed Links
    add_theme_support('automatic-feed-links');

    add_theme_support( 'title-tag' );
    // Theme Features: Dynamic Sidebar
    add_post_type_support( 'post', 'simple-page-sidebars' );


    // Theme Features: Post Thumbnails and custom image sizes for post-thumbnails
    add_theme_support('post-thumbnails', array('post', 'page','menu'));

    // Theme Features: Post Formats
    add_theme_support('post-formats', array( 'gallery', 'image', 'link', 'quote', 'video', 'audio'));



}
add_action('after_setup_theme', 'mastermind_setup');


function mastermind_widgets_setup() {

    global $mastermind_options;
    // Widget areas
    if (function_exists('register_sidebar')) :
        // Sidebar right
        register_sidebar(array(
            'name' => __("Post Sidebar Widget Here", 'mastermind'),
            'id' => "mastermind-post-sidebar",
            'description' => __('Widgets placed here will display in the post detail page', 'mastermind'),
            'before_widget' => '<div id="%1$s" class="widget %2$s tbeer-sidebar-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="mastermind-sidebar-widget-title">',
            'after_title'   => '</h3>'
        ));
        
        register_sidebar(array(
            'name' => __("Ad and Newslettr Widget Here", 'mastermind'),
            'id' => "mastermind-widgets-sidebar",
            'description' => __('Widgets placed here will display in the right sidebar', 'mastermind'),
            'before_widget' => '<div id="%1$s" class="widget %2$s tbeer-addvertisment-space tbeer-sidebar-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="mastermind-sidebar-widget-title">',
            'after_title'   => '</h3>'
        ));

        register_sidebar(array(
            'name' => __("Trending Widget Here", 'mastermind'),
            'id' => "mastermind-trending-sidebar",
            'description' => __('Sidebar for trending posts', 'mastermind'),
            'before_widget' => '<div id="%1$s" class="widget %2$s tbeer-sidebar-widget tbeer-trending-news-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="tbeer-sidebar-widget-title">',
            'after_title'   => '</h3>'
        ));
         register_sidebar(array(
            'name' => __("Top Banner Widget Here", 'mastermind'),
            'id' => "mastermind-banner-sidebar",
            'description' => __('Sidebar for Banner posts', 'mastermind'),
            'before_widget' => '<div id="%1$s" class="widget %2$s featured-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<header class="heading"><h2>',
            'after_title'   => '</h2></header>'
        ));
          register_sidebar(array(
            'name' => "Footer Block Widgets Here",
            'id' => "mastermind-widgets-footer-block-1",
            'description' => __('Widgets placed here will display in the footer block', 'mastermind'),
            'before_widget' => '<div id="%1$s" class="widget %2$s tbeer-footer-widget tbeer-links-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="tbeer-footer-widget-title">',
            'after_title'   => '</h3>'
        ));

    endif;

}
add_action('widgets_init', 'mastermind_widgets_setup');


// The excerpt "more" button
function mastermind_excerpt($text) {
    return str_replace('[&hellip;]', '[&hellip;]<a class="" title="'. sprintf (__('Read more on %s','mastermind'), get_the_title()).'" href="'.get_permalink().'">' . __(' Read more','mastermind') . '</a>', $text);
}
add_filter('the_excerpt', 'mastermind_excerpt');

// wp_title filter
function mastermind_title($output) {
    echo $output;
    // Add the blog name
    bloginfo('name');
    // Add the blog description for the home/front page
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) echo ' - '.$site_description;
    // Add a page number if necessary
    if (!empty($paged) && ($paged >= 2 || $page >= 2)) echo ' - ' . sprintf(__('Page %s', 'mastermind'), max($paged, $page));
}
add_filter('wp_title', 'mastermind_title');
add_image_size( 'tranding-size', 170, 300, true );
add_image_size( 'related-posts-thumbnails', 390, 390, true );
/*********************************************************************
 * Function to load all theme assets (scripts and styles) in header
 */
function mastermind_load_theme_assets() {
    global $mastermind_options;
    wp_enqueue_style( 'mastermind-tbeer-font', '//fonts.googleapis.com/css?family=Montserrat:400,700%7CRaleway:400,500', '', '' );
    // Enqueue all the theme CSS   
    wp_enqueue_style('mastermind-main-css', get_template_directory_uri().'/assets/css/style.css');
    wp_enqueue_style('mastermind-color-style', get_template_directory_uri().'/assets/css/color.css');
    wp_enqueue_style( 'mastermind-style', get_stylesheet_uri() );
    // Enqueue all the js files of theme
    //wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/assets/js/vendors/jquery.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('mastermind_plugins-js', get_template_directory_uri().'/assets/js/plugins.js', array(), FALSE, TRUE);
    wp_enqueue_script('mastermind_jquery-main', get_template_directory_uri().'/assets/js/main.js', array(), FALSE, TRUE);
    // custom css append code here

    $inline_css='';
    if(isset($mastermind_options['extra-css'])){
    $inline_css.=$mastermind_options['extra-css'];
    }
    wp_add_inline_style( 'mastermind-style', $inline_css );
    if(isset($mastermind_options['typography-body']['font-family']) && $mastermind_options['typography-body']['font-family']!=''&& $mastermind_options['typography-body']['font-weight']!='') {
    wp_enqueue_style('googlefont-custom', 'http://fonts.googleapis.com/css?family='.esc_attr($mastermind_options['typography-body']['font-family']));
    }
    if(isset($mastermind_options['typography-h1']['font-family']) && $mastermind_options['typography-h1']['font-family']!=''&& $mastermind_options['typography-h1']['font-weight']!='') {
    wp_enqueue_style('googlefont-h1', 'http://fonts.googleapis.com/css?family='.esc_attr($mastermind_options['typography-h1']['font-family']));
    }
    if(isset($mastermind_options['typography-h2']['font-family']) && $mastermind_options['typography-h2']['font-family']!=''&& $mastermind_options['typography-h2']['font-weight']!='') {
    wp_enqueue_style('googlefont-h2', 'http://fonts.googleapis.com/css?family='.esc_attr($mastermind_options['typography-h2']['font-family']));
    }
    if(isset($mastermind_options['typography-h3']['font-family']) && $mastermind_options['typography-h3']['font-family']!=''&& $mastermind_options['typography-h3']['font-weight']!='') {
    wp_enqueue_style('googlefont-h3', 'http://fonts.googleapis.com/css?family='.esc_attr($mastermind_options['typography-h3']['font-family']));
    }
    if(isset($mastermind_options['typography-h4']['font-family']) && $mastermind_options['typography-h4']['font-family']!=''&& $mastermind_options['typography-h4']['font-weight']!='') {
    wp_enqueue_style('googlefont-h4', 'http://fonts.googleapis.com/css?family='.esc_attr($mastermind_options['typography-h4']['font-family']));
    }
    if(isset($mastermind_options['typography-h5']['font-family']) && $mastermind_options['typography-h5']['font-family']!=''&& $mastermind_options['typography-h5']['font-weight']!='') {
    wp_enqueue_style('googlefont-h5', 'http://fonts.googleapis.com/css?family='.$mastermind_options['typography-h5']['font-family']);
    }
    if(isset($mastermind_options['typography-h6']['font-family']) && $mastermind_options['typography-h6']['font-family']!=''&& $mastermind_options['typography-h6']['font-weight']!='') {
    wp_enqueue_style('googlefont-h6', 'http://fonts.googleapis.com/css?family='.$mastermind_options['typography-h6']['font-family']);
    }

    // theme color variation code here
    $color_variation ='';
    if(isset($mastermind_options['custom_color_primary']) && $mastermind_options['custom_color_primary']!=''){
    $main_custom_color_primary= esc_attr($mastermind_options['custom_color_primary']);
    } else {
    $main_custom_color_primary= "#ff6000";
    }
   
    $color_variation='
        ::selection {
  background: '.$main_custom_color_primary.';
}
::-moz-selection {
  background: '.$main_custom_color_primary.';
}@media only screen and (max-width: 767px) {
  header.tbeer-header .navbar .icon-bar {
    background-color: '.$main_custom_color_primary.';
  }
}header.tbeer-header .navbar .tbeer-header-bottombar .tbeer-menu-wrapper ul.tbeer-menus li a:hover {
  color: '.$main_custom_color_primary.';
}header.tbeer-header .navbar .tbeer-header-bottombar .tbeer-menu-wrapper ul.tbeer-menus li.has-submenu:hover:after {
  color: '.$main_custom_color_primary.';
}header.tbeer-header .navbar .tbeer-header-bottombar .tbeer-menu-wrapper ul.tbeer-menus li ul.tbeer-dropdown-menu li a:hover {
  color: '.$main_custom_color_primary.';
}
@media only screen and (max-width: 767px) {
  header.tbeer-header .navbar .tbeer-header-bottombar .tbeer-menu-wrapper ul.tbeer-menus li ul.tbeer-dropdown-menu li a:hover {
    color: '.$main_custom_color_primary.';
    font-weight: 700;
  }
}header.tbeer-header .navbar .tbeer-header-bottombar .tbeer-menu-wrapper ul.tbeer-menus li ul.tbeer-dropdown-menu li.has-submenu a:hover:after {
  color: '.$main_custom_color_primary.';
}header.tbeer-header .navbar .tbeer-header-bottombar .tbeer-header-search-wrapper a.tbeer-header-search-btn {
  color: '.$main_custom_color_primary.';
}footer .tbeer-footer-top .tbeer-fixed-widget h3 span {
  color: '.$main_custom_color_primary.';
}footer .tbeer-footer-top .tbeer-footer-widgets-area .tbeer-footer-post-widget h3 a:hover {
  color: '.$main_custom_color_primary.';
}footer .tbeer-footer-top .tbeer-footer-widgets-area .tbeer-footer-post-widget p a:hover {
  color: '.$main_custom_color_primary.';
}footer .tbeer-footer-bottom .tbeer-footer-menu ul li a:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-btn {
  background-color: '.$main_custom_color_primary.';
}.tbeer-btn.tbeer-outline-btn:hover {
  border-color: transparent;
  color: #ffffff;
  background-color: '.$main_custom_color_primary.';
}
a.tbeer-category-meta {
  background-color: '.$main_custom_color_primary.';
}.tbeer-featured-news .tbeer-news-details a.tbeer-category-meta {
  color: '.$main_custom_color_primary.';
}.tbeer-featured-news .tbeer-news-details h3 a:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-featured-news .tbeer-news-details .tbeer-news-post-meta a:hover {
  color: '.$main_custom_color_primary.';
}
.tbeer-featured-news .tbeer-news-details .tbeer-news-post-meta a:hover:before {
  background-color: '.$main_custom_color_primary.';
}.tbeer-latest-post .tbeer-image-wrapper a.tbeer-category-meta {
  color: '.$main_custom_color_primary.';
}.tbeer-latest-post .tbeer-latest-post-details h3 a:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-latest-post .tbeer-latest-post-details .tbeer-news-post-meta a:hover {
  color: '.$main_custom_color_primary.';
}
.tbeer-latest-post .tbeer-latest-post-details .tbeer-news-post-meta a:hover:before {
  background-color: '.$main_custom_color_primary.';
}.tbeer-comments .tbeer-comment-details h3 a:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-comments .tbeer-comment-details a.tbeer-comment-reply:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-trending-news-widget .tbeer-trending-news-post .tbeer-trending-news-details h3.tbeer-news-post-heading a:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-subscription-widget .tbeer-subscription-form form button {
  background-color: '.$main_custom_color_primary.';
}.tbeer-main-news-wrapper .tbeer-main-content .tbeer-load-more-wrapper a:hover, .tbeer-load-more-wrapper a:hover{
  background-color: '.$main_custom_color_primary.';
  color: #ffffff;
  border: 1px solid transparent;
}.tbeer-post-title-metas h1.tbeer-news-post-heading a:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-post-title-metas .tbeer-author-commnets-count .tbeer-posting-time-wrapper p a.tbeer-author-name:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-post-title-metas .tbeer-author-commnets-count .tbeer-comment-view-wrapper ul li a:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-next-prev-post-pagination .tbeer-prev-post .tbeer-other-post-title-wrapper h2 a:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-next-prev-post-pagination .tbeer-next-post .tbeer-other-post-title-wrapper h2 a:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-author-details-section .tbeer-author-wrapper .tbeer-author-details h3 a:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-related-post-secion .tbeer-related-post-wrapper .tbeer-related-post .tbeer-news-post-meta a:hover {
  color: '.$main_custom_color_primary.';
}
.tbeer-related-post-secion .tbeer-related-post-wrapper .tbeer-related-post .tbeer-news-post-meta a:hover:before {
  background-color: '.$main_custom_color_primary.';
}.tbeer-comments-submit-section .tbeer-comments-form form button:hover {
  background-color: '.$main_custom_color_primary.';
}.tbeer-search-result-section .tbeer-single-post-wrapper .tbeer-main-content .tbeer-search-result .tbeer-search-result-details a.tbeer-category-meta {
  color: '.$main_custom_color_primary.';
}.tbeer-search-result-section .tbeer-single-post-wrapper .tbeer-main-content .tbeer-search-result .tbeer-search-result-details h3 a:hover {
  color: '.$main_custom_color_primary.';
}.tbeer-search-result-section .tbeer-single-post-wrapper .tbeer-main-content .tbeer-search-result .tbeer-search-result-details .tbeer-news-post-meta a:hover {
  color: '.$main_custom_color_primary.';
}
.tbeer-search-result-section .tbeer-single-post-wrapper .tbeer-main-content .tbeer-search-result .tbeer-search-result-details .tbeer-news-post-meta a:hover:before {
  background-color: '.$main_custom_color_primary.';
}
        .tbeer-featured-news .tbeer-news-details .tbeer-category-meta, .tbeer-category-meta {
            color: '.$main_custom_color_primary.' !important;
        }
        .tbeer-category-meta a {
    color: '.$main_custom_color_primary.'!important;
}
        ';
    wp_add_inline_style( 'mastermind-color-style', $color_variation );

  }
add_action('wp_enqueue_scripts', 'mastermind_load_theme_assets');


// Enqueue comment-reply script if comments_open and singular
function mastermind_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
        }
}
add_action( 'wp_enqueue_scripts', 'mastermind_enqueue_comment_reply' );

add_filter('nav_menu_css_class' , 'mastermind_special_nav_class' , 10 , 2);
function mastermind_special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     global $mastermind_options;
     return $classes;
}

add_action( 'tgmpa_register', 'mastermind_register_required_plugins' );

function mastermind_register_required_plugins() {


    $plugins = array(
        array(
            'name'      => 'CMB2',
            'slug'       => 'cmb2',
            'required'    => true,
        ),
        array(
            'name'      => 'Redux-Framework',
            'slug'       => 'redux-framework',
            'required'    => true,
        ),
        array(
            'name'      => 'MailChimp For Wordpress',
            'slug'       => 'mailchimp-for-wp',
            'required'    => true,
        ),array(
            'name'      => 'Mashsharer',
            'slug'       => 'mashsharer',
            'required'    => true,
        )
    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'mastermind' ),
            'menu_title'                      => __( 'Install Plugins', 'mastermind' ),
            'installing'                      => __( 'Installing Plugin: %s', 'mastermind' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'mastermind' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' , 'mastermind'), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'mastermind' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'mastermind' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'mastermind' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'mastermind' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'mastermind' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'mastermind' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' , 'mastermind'), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'mastermind' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'mastermind' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'mastermind' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'mastermind' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'mastermind' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}


function mastermind_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);
?>
    <li <?php comment_class( empty( $args['has_children'] ) ? 'tbeer-comments tbeer-replied-comment' : 'tbeer-comments' ) ?> id="comment-<?php comment_ID() ?>">
        <div class="tbeer-user-img">
            <img class="img-circle media-object" src="<?php echo get_avatar_url(get_avatar( $comment, $args['avatar_size'] )); ?>" alt="Author avatar">
        </div>
        <div class="tbeer-comment-details">
        <?php if($depth>1): echo '<div class="media">'; else : echo'<div class="media-body">'; endif;?>
            <h3><a href="#!"><?php echo get_comment_author_link(); ?></a>
                <span class="tbeer-comment-time"><?php
                            /* translators: 1: date, 2: time */
                            echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></a><?php edit_comment_link( __( '(Edit)','mastermind' ), '  ', '' );
                        ?>
                </span>
            </h3>
            <p><?php echo get_comment_text(); ?></p>
            <div class="reply-box tbeer-comment-reply"><?php comment_reply_link(array_merge( $args, array('reply_text' => 'Reply','depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
            <div class="comment-block">
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','mastermind' ); ?></em>
                <br />
            <?php endif; ?>
            </div>
        </div>
    </li>
<?php
}


// BY Rafin

/*====================================*\
    POPULAR POSTS
\*====================================*/

function mastermind_getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == ''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

function mastermind_setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == ''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//For excerpt
function mastermind_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'mastermind_excerpt_more');

function mastermind_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'mastermind_excerpt_length', 999 );
// cmb2
function mastermind_post_meta() {

    $cmb = new_cmb2_box( array(
        'id'           => 'mastermind_post_meta',
        'title'        => 'Post Information',
        'object_types' => array( 'post' ),
    ) );

    $cmb->add_field( array(
        'name' => 'Featured Post',
        'id'   => '_mastermind_featured',
        'type' => 'checkbox',
        'desc' => 'Check if post is featured post.',
    ) );
     $cmb->add_field( array(
        'name' => 'Top Post',
        'id'   => '_mastermind_post',
        'type' => 'checkbox',
        'desc' => 'Check if post is top post.',
    ) );


}
add_action( 'cmb2_admin_init', 'mastermind_post_meta' );
// mastermind leak comment arrange
add_filter( 'comment_form_fields', 'mastermind_move_comment_field' );
function mastermind_move_comment_field( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}


if ( ! function_exists( 'mastermind_load_widgets' ) ) :

    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function mastermind_load_widgets() {
        // Advanced Recent Posts widget.
        register_widget( 'Mastermind_Recent_Posts_Widget' );
    }

endif;

add_action( 'widgets_init', 'mastermind_load_widgets' );
if ( ! class_exists( 'Mastermind_Recent_Posts_Widget' ) ) :

    /**
     * Advanced Recent Posts Widget Class
     *
     * @since 1.0.0
     */
    class Mastermind_Recent_Posts_Widget extends WP_Widget {

        /**
         * Constructor.
         *
         * @since 1.0.0
         */
        function __construct() {
            $opts = array(
                'classname'   => 'mastermind_advanced_recent_posts',
                'description' => __( 'Featured Post Widget. Displays recent posts with thumbnail.', 'mastermind' ),
            );

            parent::__construct( 'mastermind-advanced-recent-posts', __( 'Mastermind: Featured Posts', 'mastermind' ), $opts );
        }

        /**
         * Echo the widget content.
         *
         * @since 1.0.0
         *
         * @param array $args     Display arguments including before_title, after_title,
         *                        before_widget, and after_widget.
         * @param array $instance The settings for the particular instance of the widget.
         */
        function widget( $args, $instance ) {

            $title             = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
            $post_category     = ! empty( $instance['post_category'] ) ? $instance['post_category'] : 0;

            echo $args['before_widget'];
            if ( absint( $post_category ) > 0  ) {

                $header_args=array(
                'post_type'=>'post',
                'posts_per_page'=>1,
                'orderby' => 'date',
                'order'   => 'DESC',
                'cat' => $post_category,
             );
            }
            else{
            $header_args=array(
                'post_type'=>'post',
                'posts_per_page'=>1,
                'orderby' => 'date',
                'order'   => 'DESC',
                'meta_query' => array(
                    array(
                        'key'     => '_mastermind_featured',
                        'value'   => 'on',
                        'compare' => '=',
                    ),
                ),
            );
        }
        $header_query= new WP_Query($header_args);
                $header_query= new WP_Query($header_args);
                if($header_query->have_posts()):$i=1;
                    echo ' <!-- FEATURED NEWS SECTION -->
                            <div class="tbeer-featured-news">';
                                        while($header_query->have_posts()):
                                            $header_query->the_post(); ?>
                                        <?php
                                            $thumbnail = get_post_thumbnail_id();
                                            $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                                            $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                                          
                                            if($img_url)
                                                $url = aq_resize( $img_url[0], $width =780, $height = 1073, $crop = true, $single = true, $upscale = true );
                                            else{
                                                $url=get_template_directory_uri().'/assets/images/no-image.png';
                                                $alt="No Image";
                                                $img_url[0]=$url;
                                            } ?>
                                                <div class="tbeer-featured-news">
                                                    <div class="tbeer-featured-img">
                                                        <img class="hidden-xs hidden-sm" src="<?php echo esc_url($url);?>" alt="<?php echo esc_attr($alt);?>">
                                                        <img class="hidden-md" src="<?php echo esc_url($img_url[0]);?>" alt="<?php echo esc_attr($alt);?>">
                                                    </div>
                                                    <div class="tbeer-news-details">
                                                        <span class="tbeer-category-meta"> <?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></span>
                                                        <h3 class="tbeer-news-post-heading">
                                                            <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                                        </h3>
                                                        <?php  if($i<4){ ?>
                                                            <div class="tbeer-news-post-meta">
                                                                <span class="tbeer-news-post-date"><?php _e('by','mastermind');?>
                                                                <span class="tbeer-news-post-author"><?php the_author_posts_link(); ?></span></span>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                        <?php
                                            $i++;
                                        endwhile;
                        echo '
                        </div>';
                endif;
                wp_reset_postdata();
               ?>
            <?php
            echo $args['after_widget'];

        }

        /**
         * Update widget instance.
         *
         * @since 1.0.0
         *
         * @param array $new_instance New settings for this instance as input by the user via
         *                            {@see WP_Widget::form()}.
         * @param array $old_instance Old settings for this instance.
         * @return array Settings to save or bool false to cancel saving.
         */
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title']             = sanitize_text_field( $new_instance['title'] );
            $instance['post_category']     = absint( $new_instance['post_category'] );

            return $instance;
        }

        /**
         * Output the settings update form.
         *
         * @since 1.0.0
         *
         * @param array $instance Current settings.
         */
        function form( $instance ) {
            // Defaults.
            $instance = wp_parse_args( (array) $instance, array(
                'title'             => '',
                'post_category'     => '',

            ) );

            $title             = esc_attr( $instance['title'] );
            $post_category     = absint( $instance['post_category'] );


            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>"><?php _e( 'Select Category:', 'mastermind' ); ?></label>
                <?php
                $cat_args = array(
                    'orderby'         => 'name',
                    'hide_empty'      => 0,
                    'taxonomy'        => 'category',
                    'name'            => $this->get_field_name( 'post_category' ),
                    'id'              => $this->get_field_id( 'post_category' ),
                    'selected'        => $post_category,
                    'show_option_all' => __( 'All Categories','mastermind' ),
                );
                wp_dropdown_categories( $cat_args );
                ?>
            </p>
            <?php
        }
    }

endif;
// excerpt
//excerpt max charlenght
function mastermind_the_excerpt_max_charlength($charlength) {
    $excerpt = get_the_excerpt();
    $charlength++;
    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 7 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            return mb_substr( $subex, 0, $excut );
        } else {
            return $subex;
        }
    } else {
        return $excerpt;
    }
}
