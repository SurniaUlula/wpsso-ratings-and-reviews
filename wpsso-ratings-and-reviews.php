<?php
/*
 * Plugin Name: WPSSO Ratings and Reviews (WPSSO RAR)
 * Text Domain: wpsso-ratings-and-reviews
 * Domain Path: /languages
 * Plugin URI: https://surniaulula.com/extend/plugins/wpsso-ratings-and-reviews/
 * Assets URI: https://jsmoriss.github.io/wpsso-ratings-and-reviews/assets/
 * Author: JS Morisset
 * Author URI: https://surniaulula.com/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl.txt
 * Description: WPSSO extension to add ratings and reviews for WordPress comments, with aggregate rating meta tags and (optional) Schema Review markup.
 * Requires At Least: 3.7
 * Tested Up To: 4.7.3
 * Version: 1.0.2-dev2
 *
 * Version Components: {major}.{minor}.{bugfix}-{stage}{level}
 *
 *	{major}		Major code changes / re-writes or significant feature changes.
 *	{minor}		New features / options were added or improved.
 *	{bugfix}	Bugfixes or minor improvements.
 *	{stage}{level}	dev < a (alpha) < b (beta) < rc (release candidate) < # (production).
 *
 * See PHP's version_compare() documentation at http://php.net/manual/en/function.version-compare.php.
 * 
 * Copyright 2017 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoRar' ) ) {

	class WpssoRar {

		public $p;		// Wpsso
		public $reg;		// WpssoRarRegister
		public $admin;		// WpssoRarAdmin
		public $comment;	// WpssoRarComment
		public $filters;	// WpssoRarFilters
		public $script;		// WpssoRarScript
		public $style;		// WpssoRarStyle

		private static $instance;
		private static $have_req_min = true;	// have at least minimum wpsso version

		public function __construct() {

			require_once ( dirname( __FILE__ ).'/lib/config.php' );
			WpssoRarConfig::set_constants( __FILE__ );
			WpssoRarConfig::require_libs( __FILE__ );	// includes the register.php class library
			$this->reg = new WpssoRarRegister();		// activate, deactivate, uninstall hooks

			if ( is_admin() ) {
				add_action( 'admin_init', array( __CLASS__, 'required_check' ) );
			}

			add_action( 'wpsso_init_textdomain', array( __CLASS__, 'wpsso_init_textdomain' ) );
			add_filter( 'wpsso_get_config', array( &$this, 'wpsso_get_config' ), 10, 2 );
			add_action( 'wpsso_init_options', array( &$this, 'wpsso_init_options' ), 10 );
			add_action( 'wpsso_init_objects', array( &$this, 'wpsso_init_objects' ), 10 );
			add_action( 'wpsso_init_plugin', array( &$this, 'wpsso_init_plugin' ), 10 );
		}

		public static function &get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		public static function required_check() {
			if ( ! class_exists( 'Wpsso' ) ) {
				add_action( 'all_admin_notices', array( __CLASS__, 'required_notice' ) );
			}
		}

		// also called from the activate_plugin method with $deactivate = true
		public static function required_notice( $deactivate = false ) {
			self::wpsso_init_textdomain();
			$info = WpssoRarConfig::$cf['plugin']['wpssorar'];
			$die_msg = __( '%1$s is an extension for the %2$s plugin &mdash; please install and activate the %3$s plugin before activating %4$s.',
				'wpsso-ratings-and-reviews' );
			$err_msg = __( 'The %1$s extension requires the %2$s plugin &mdash; please install and activate the %3$s plugin.',
				'wpsso-ratings-and-reviews' );
			if ( $deactivate === true ) {
				if ( ! function_exists( 'deactivate_plugins' ) ) {
					require_once trailingslashit( ABSPATH ).'wp-admin/includes/plugin.php';
				}
				deactivate_plugins( $info['base'], true );	// $silent = true
				wp_die( '<p>'.sprintf( $die_msg, $info['name'], $info['req']['name'], $info['req']['short'], $info['short'] ).'</p>' );
			} else {
				echo '<div class="notice notice-error error"><p>'.
					sprintf( $err_msg, $info['name'], $info['req']['name'], $info['req']['short'] ).'</p></div>';
			}
		}

		public static function wpsso_init_textdomain() {
			load_plugin_textdomain( 'wpsso-ratings-and-reviews', false, 'wpsso-ratings-and-reviews/languages/' );
		}

		public function wpsso_get_config( $cf, $plugin_version = 0 ) {
			$info = WpssoRarConfig::$cf['plugin']['wpssorar'];

			if ( version_compare( $plugin_version, $info['req']['min_version'], '<' ) ) {
				self::$have_req_min = false;
				return $cf;
			}

			return SucomUtil::array_merge_recursive_distinct( $cf, WpssoRarConfig::$cf );
		}

		public function wpsso_init_options() {
			if ( method_exists( 'Wpsso', 'get_instance' ) ) {
				$this->p =& Wpsso::get_instance();
			} else {
				$this->p =& $GLOBALS['wpsso'];
			}

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( self::$have_req_min === false ) {
				return;		// stop here
			}

			$this->p->is_avail['rar'] = true;
		}

		public function wpsso_init_objects() {
			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( self::$have_req_min === false ) {
				return;		// stop here
			}

			// disable reviews on products if competing feature exists
			if ( $this->p->is_avail['ecom']['woocommerce'] ) {
				if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' || 
					! empty( $this->p->is_avail['ecom']['yotpowc'] ) ) {

					if ( ! empty( $this->p->options['rar_add_to_product'] ) ) {
						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'ratings feature for products found - ratings for the product post type disabled' );
						}
						if ( is_admin() ) {
							$this->p->notice->warn( sprintf( __( 'An existing products rating feature has been found &mdash; %1$s for the "product" custom post type has been disabled.', 'wpsso-ratings-and-reviews' ), $this->p->cf['plugin']['wpssorar']['short'] ) );
						}
						$this->p->options['rar_add_to_product'] = 0;
						$this->p->opt->save_options( WPSSO_OPTIONS_NAME, $this->p->options, false, true );	// $has_diff = true
					}
					$this->p->options['rar_add_to_product:is'] = 'disabled';
				}
			}

			$this->comment = new WpssoRarComment( $this->p );
			$this->filters = new WpssoRarFilters( $this->p );
			$this->script = new WpssoRarScript( $this->p );
			$this->style = new WpssoRarStyle( $this->p );

			if ( is_admin() ) {
				$this->admin = new WpssoRarAdmin( $this->p );
			}
		}

		public function wpsso_init_plugin() {
			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( self::$have_req_min === false ) {
				return $this->min_version_notice();
			}
		}

		private function min_version_notice() {
			$info = WpssoRarConfig::$cf['plugin']['wpssorar'];
			$wpsso_version = $this->p->cf['plugin']['wpsso']['version'];

			if ( $this->p->debug->enabled ) {
				$this->p->debug->log( $info['name'].' requires '.$info['req']['short'].' v'.
					$info['req']['min_version'].' or newer ('.$wpsso_version.' installed)' );
			}

			if ( is_admin() ) {
				$this->p->notice->err( sprintf( __( 'The %1$s extension v%2$s requires %3$s v%4$s or newer (v%5$s currently installed).',
					'wpsso-ratings-and-reviews' ), $info['name'], $info['version'], $info['req']['short'],
						$info['req']['min_version'], $wpsso_version ) );
			}
		}
	}

	WpssoRar::get_instance();
}

?>
