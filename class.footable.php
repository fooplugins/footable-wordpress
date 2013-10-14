<?php
/**
 * FooTable
 *
 * @package   FooTable
 * @author    Brad Vincent <brad@fooplugins.com>
 * @license   GPL-2.0+
 * @link      http://fooplugins.com/plugins/footable-lite/
 * @copyright 2013 FooPlugins LLC
 */


if (!class_exists('FooTable')) {

	define('FOOTABLE_PATH', plugin_dir_path( __FILE__ ));

	// Includes
	require_once( FOOTABLE_PATH . 'includes/Foo_Plugin_Base.php' );
	require_once( FOOTABLE_PATH . 'includes/admin_settings.php' );

	class FooTable extends Foo_Plugin_Base_v1_1 {

		const JS = 'footable.min.js';
		const JS_SORT = 'footable.sort.min.js';
		const JS_FILTER = 'footable.filter.min.js';
		const JS_PAGINATE = 'footable.paginate.min.js';

		const CSS = 'footable.core.min.css';
		const CSS_BOOTSTRAP = 'bootstrap.2.3.1.css';
		const CSS_METRO = 'footable.metro.min.css';
		const CSS_STANDALONE = 'footable.standalone.min.css';

		const URL_HOMEPAGE = 'http://fooplugins.com/plugins/footable-lite/';
		const URL_GITHUB = 'https://github.com/bradvin/FooTable';
		const URL_JQUERY = 'http://fooplugins.com/plugins/footable-jquery/';
		const URL_JQUERY_DEMOS = 'http://fooplugins.com/footable-demos/';
		const URL_DOCS = 'http://fooplugins.com/footable-lite/documentation/';

		function __construct($file) {
			$this->init(  $file, 'footable', '0.3.2', 'FooTable' );
			add_action( 'init', array($this, 'init_footable') );
		}

		function init_footable() {
			//TODO: translations
			//add_action('plugins_loaded', array($this, 'load_text_domain') );

			if (is_admin()) {
				add_action( $this->plugin_slug . '-admin_create_settings', array('FooTable_Settings', 'create_settings'), 10, 2 );
				add_action( $this->plugin_slug . '-settings_custom_type_render', array($this, 'custom_admin_settings_render') );
				add_action( 'admin_head', array($this, 'admin_inline_content') );
				add_filter( $this->plugin_slug . '-settings_summary', array($this, 'admin_settings_summary') );
				add_action( $this->plugin_slug . '-admin_print_styles', array($this, 'add_styles') );
				add_action( $this->plugin_slug . '-admin_print_scripts', array($this, 'add_scripts') );
			} else {
				$this->frontend_init();
			}
		}

		function admin_settings_summary() {
			$html = __('For more info about FooTable, please visit the <a href="%s" target="_blank">FooTable homepage</a>.', 'footable');
			return sprintf($html, self::HOMEPAGE_URL);
		}

		function custom_admin_settings_render( $args = array() ) {
			$type = '';

			extract( $args );

			if ($type == 'debug_output') {
				echo '</td></tr><tr valign="top"><td colspan="2">';
				$this->render_debug_info();
			} else if ( $type == 'demo') {
				echo '</td></tr><tr valign="top"><td colspan="2">';
				$this->render_demo();
			}
		}

		function generate_javascript($debug = false) {
			$js = '/* FooTable init code */
';
			$no_js = true;

			$js .= '
var $FOOTABLE = $FOOTABLE || {};
(function( $FOOTABLE, $, undefined ) {
	$FOOTABLE.init = function() {
';
			$breakpoint_tablet = $this->options()->get_int( 'breakpoint_tablet', 768 );
			$breakpoint_phone = $this->options()->get_int( 'breakpoint_phone', 320 );

			$columns_tablet = $this->options()->get_int( 'columns_tablet', 4 ) - 1;
			$columns_phone = $this->options()->get_int( 'columns_phone', 2 ) - 1;
			$manual_columns = $this->options()->is_checked( 'manual_columns' );
			$filtering = $this->options()->is_checked('enable_filtering', true);
			$pagination = $this->options()->is_checked('enable_pagination', true);
			$tablepress = $this->options()->is_checked('tablepress', true);

			//get custom JS (Before) from the settings page
			$custom_js_before = $this->options()->get( 'custom_js_before' );

			if ( !empty($custom_js_before) ) {
				$no_js = false;
				$js .= '    ' . $custom_js_before . '
';
			}

			$selector = $this->options()->get( 'selector', '.footable' );
			if ($tablepress) {
				$selector .= ', .tablepress';
			}
			if ( $this->screen()->is_plugin_settings_page() ) {
				$selector .= ', .footable-demo';
			}

			if ( !empty( $selector ) ) {
				$no_js = false;
				$js .= '		$("'.$selector.'")
';

				if ( !$manual_columns ) {
					$js .= '			.footableAttr('.$columns_tablet.','.$columns_phone.')
';
				}
				if ($filtering) {
					$js .= '			.footableFilter("' . __('search','footable') . '")
';
				}
				if ($pagination) {
					$js .= '			.footablePager()
';
				}

				$js .= '			.footable( { breakpoints: { phone: '.$breakpoint_phone.', tablet: '.$breakpoint_tablet.' } });
';
			}

			//get custom JS from the settings page
			$custom_js_after = $this->options()->get( 'custom_js_after' );

			if ( !empty($custom_js_after) ) {
				$no_js = false;
				$js .= '    ' . $custom_js_after . '
';
			}

			$js .= '
	};
}( $FOOTABLE, jQuery ));

jQuery(function($) {
	$FOOTABLE.init();
});
';

			if ($no_js) { return ''; }

			return $js;
		}

		function render_debug_info() {
			echo '<strong>Javascript:<br /><pre>';
			echo htmlentities($this->generate_javascript(true));
			echo '</pre><br />Settings:<br /><pre>';
			print_r( get_option( $this->plugin_slug ) );
			echo '</pre>';
		}

		function render_demo() {
			require_once "includes/demo.php";
		}

		function frontend_init() {
			add_action( 'wp_enqueue_scripts', array($this, 'add_styles'), 12 );
			add_action( 'wp_enqueue_scripts', array($this, 'add_scripts'), 12 );

			$where = 'wp_head';

			if ( $this->options()->is_checked( 'scripts_in_footer' ) ) { $where = 'wp_print_footer_scripts'; }

			add_action($where, array($this, 'inline_dynamic_js') );

			add_action('wp_print_styles', array($this, 'inline_dynamic_css') );
		}

		function add_styles() {
			if (is_admin() && $this->screen()->is_plugin_settings_page()) {
				$this->register_and_enqueue_css(self::CSS_BOOTSTRAP);
			}

			//enqueue footable CSS
			$this->register_and_enqueue_css(self::CSS);

			$theme = $this->options()->get('theme', 'bootstrap');
			if ($theme === 'metro') {
				$this->register_and_enqueue_css(self::CSS_METRO);
			} else if ($theme === 'original') {
				$this->register_and_enqueue_css(self::CSS_STANDALONE);
			}
		}

		function add_scripts() {
			//put JS in footer?
			$infooter = !is_admin() && $this->options()->is_checked( 'scripts_in_footer' );

			//enqueue core JS
			$this->register_and_enqueue_js(self::JS, array('jquery'), false, $infooter);

			//enqueue sorting
			if ($this->options()->is_checked('enable_sorting', true)) {
				$this->register_and_enqueue_js(self::JS_SORT, array('jquery'), false, $infooter);
			}

			//enqueue filtering
			if ($this->options()->is_checked('enable_filtering', true)) {
				$this->register_and_enqueue_js(self::JS_FILTER, array('jquery'), false, $infooter);
			}

			//enqueue paging
			if ($this->options()->is_checked('enable_pagination', true)) {
				$this->register_and_enqueue_js(self::JS_PAGINATE, array('jquery'), false, $infooter);
			}
		}

		function admin_inline_content() {
			if ($this->screen()->is_plugin_settings_page()) {
				$this->inline_dynamic_css();
				$this->inline_dynamic_js();
			}
		}

		function inline_dynamic_js() {
			$footable_js = $this->generate_javascript();

			echo '<script type="text/javascript">' . $footable_js . '</script>';
		}

		function inline_dynamic_css() {

			//get custom CSS from the settings page
			$custom_css = $this->options()->get( 'custom_css', '' );

			if (class_exists('TablePress')) {
				$custom_css .= '.tablepress.footable thead th div { float:left; }';
			}

			if (empty($custom_css)) return;

			echo '<style type="text/css">
	' . $custom_css;
			echo '
</style>';
		}
	}
}