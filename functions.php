<?php
if ( ! class_exists( 'Timber' ) ) {
	exit('Timber not activated.');
}

Timber::$dirname = ['templates', 'defaults'];

class Site extends Timber\Site {

	const POSTS_NAME = 'News';

	function __construct() {
		add_theme_support('post-formats');
		add_theme_support('post-thumbnails');
		add_theme_support('menus');
		add_filter('timber_context', [$this, 'addToContext']);
		add_filter('get_twig', [$this, 'addToTwig']);
		add_filter('nav_menu_css_class', [$this, 'setMenuActive'], 10, 3);
		add_action('init', [$this, 'renamePostsType']);
		add_action('admin_menu', [$this, 'renamePostsMenu']);
		add_action('admin_head', [$this, 'adminCSS']);
        $this->cleanup();
		parent::__construct();
	}

	public function adminCss() {
		echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/admin.css" type="text/css" media="all" />';
	}

	public function cleanup() {
		// Adminbar
		add_filter('show_admin_bar', '__return_false');

		// Emojis
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

		// Feeds
		remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
		remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
		remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link

		// Remove JSON API
		remove_action('wp_head', 'rest_output_link_wp_head');
		remove_action('wp_head', 'wp_oembed_add_discovery_links');

		// Others
		remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
		remove_action( 'wp_head', 'index_rel_link' ); // index link
		//remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
		//remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
		//remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
		remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
	}

	/**
	 * Rename "Posts" to something else.
	 */
	public function renamePostsMenu() {
		global $menu;
		global $submenu;
		!$menu[5][0] ?: $menu[5][0] = self::POSTS_NAME;
		!$submenu['edit.php'][5][0] ?: $submenu['edit.php'][5][0] = self::POSTS_NAME;
		$submenu['edit.php'][10][0] ?: $submenu['edit.php'][10][0] = 'Add Article';
		$submenu['edit.php'][16][0] ?: $submenu['edit.php'][16][0] = sprintf('%s Tags', self::POSTS_NAME);
	}

	/**
	 * Rename Posts type to something else
	 */
	public function renamePostsType() {
		global $wp_post_types;
		$labels = &$wp_post_types['post']->labels;
		$labels->name = self::POSTS_NAME;
		$labels->singular_name = self::POSTS_NAME;
		$labels->add_new = 'Add Article';
		$labels->add_new_item = 'Add Article';
		$labels->edit_item = 'Edit Article';
		$labels->new_item = self::POSTS_NAME;
		$labels->view_item = 'View Article';
		$labels->search_items = sprintf('Search %s', self::POSTS_NAME);
		$labels->not_found = 'No Article found';
		$labels->not_found_in_trash = 'No Article found in Trash';
	}

	function addToContext( $context ) {
		$context['navigation'] = [
			'main' => new Timber\Menu(),
		];
		$context['isIE'] = (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== FALSE));
		$context['site'] = $this;
		return $context;
	}

	function addToTwig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('cfs', new Twig_SimpleFilter('cfs', [$this, 'cfs']));
		$twig->addFilter('post', new Twig_SimpleFilter('post', [$this, 'post']));
		$twig->addFilter('dump', new Twig_SimpleFilter('dump', [$this, 'dump']));
		$twig->addFilter('image', new Twig_SimpleFilter('image', [$this, 'image']));
		$twig->addFilter('target', new Twig_SimpleFilter('target', [$this, 'target']));
		$twig->addFilter('webalize', new Twig_SimpleFilter('webalize', [$this, 'webalize']));
		return $twig;
	}

	public function setMenuActive($classes, Timber\MenuItem $menu) {
		$template = get_page_template_slug($menu->_menu_item_object_id);
		switch (TRUE) {
			case is_singular('post') && $template == 'pages/blog.php':
				$classes[] = 'current_page_item';
				break;
		}
		return $classes;
	}

	function cfs($field_name, $post_id = NULL, $options = []) {
		return CFS()->get($field_name, $post_id, $options);
	}

	function post($post_id) {
		return new Timber\Post($post_id);
	}

	public static function dump($value) {
		Tracy\Debugger::barDump($value);
	}

	public function image($id) {
		return new Timber\Image($id);
	}

	public function target($link) {
		if (!is_array($link)) {
			return '_self';
		}
		return $link['target'] == 'none' ? '_self' : $link['target'];
	}

	public function webalize($string) {
		$string = strtolower($string);
		$string = preg_replace('/[,\.\:\"\'\!\?]+/i', '', $string);
		$string = preg_replace('/[^a-z0-9]+/i', '-', $string);
		$string = trim($string, '-');
		return $string;
	}

}

new Site();
