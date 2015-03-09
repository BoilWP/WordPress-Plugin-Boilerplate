<?php
/**
 * Welcome Page Class
 *
 * Shows a feature overview of your plugin, new changes, credits and translations.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Admin_Welcome' ) ) {

/**
 * Plugin_Name_Admin_Welcome class.
 */
class Plugin_Name_Admin_Welcome {

	/**
	 * Constructor.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus') );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'welcome' ) );
	} // END __construct()

	/**
	 * Register your dashboard pages, page slug, title, capability and screen.
	 *
	 * @todo   List your dashboard pages here.
	 * @since  1.0.0
	 * @filter plugin_name_register_dashboard_pages
	 * @access public
	 * @return array()
	 */
	public function register_admin_menu() {
		return $menus = apply_filters( 'plugin_name_register_dashboard_pages', array(
					array(
						'id'         => PLUGIN_NAME_PAGE . '-about',
						'title'      => sprintf( __( 'Welcome to %s', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ),
						'capability' => 'manage_options',
						'screen'     => 'about_screen',
						'tab_name'   => __( 'Getting Started', PLUGIN_NAME_TEXT_DOMAIN )
					),
					array(
						'id'         => PLUGIN_NAME_PAGE . '-changelog',
						'title'      => sprintf( __( '%s Changelog', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ),
						'capability' => 'manage_options',
						'screen'     => 'changelog_screen',
						'tab_name'   => __( 'Changelog', PLUGIN_NAME_TEXT_DOMAIN )
					),
					array(
						'id'         => PLUGIN_NAME_PAGE . '-credits',
						'title'      => sprintf( __( '%s Credits', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ),
						'capability' => 'manage_options',
						'screen'     => 'credits_screen',
						'tab_name'   => __( 'Credits', PLUGIN_NAME_TEXT_DOMAIN )
					),
					array(
						'id'         => PLUGIN_NAME_PAGE . '-translations',
						'title'      => sprintf( __( '%s Translations', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ),
						'capability' => 'manage_options',
						'screen'     => 'translations_screen',
						'tab_name'   => __( 'Translations', PLUGIN_NAME_TEXT_DOMAIN )
					),
					array(
						'id'         => PLUGIN_NAME_PAGE . '-freedoms',
						'title'      => sprintf( __( '%s Freedoms', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->name ),
						'capability' => 'manage_options',
						'screen'     => 'freedoms_screen',
						'tab_name'   => __( 'Freedoms', PLUGIN_NAME_TEXT_DOMAIN )
					),
		) );
	} // END register_admin_menu()

	/**
	 * Register the Dashboard Pages which are normally hidden.
	 * These pages are used to render the Welcome and Credits pages.
	 * Can be accessed again via the version number link at the
	 * bottom of the plugin pages.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_menus() {
		foreach ( $this->register_admin_menu() as $menu ) {
			$page_title = $menu['title'];
			$dashboard_page = add_dashboard_page( $page_title, $page_title, $menu['capability'], $menu['id'], array( $this, $menu['screen'] ) );
			add_action( 'admin_print_styles-'. $dashboard_page, array( $this, 'admin_css' ) );
		}
	} // END admin_menus()

	/**
	 * Remove submenus. This hides each submenu under the dashboard page.
	 *
	 * @todo   Replace the submenus with your own.
	 * @since  1.0.0
	 * @filter plugin_name_remove_submenus
	 * @access public
	 * @return array()
	 */
	public function remove_submenus() {
		$submenus = apply_filters( 'plugin_name_remove_submenus', array(
			array( 'id' => 'about' ),
			array( 'id' => 'changelog' ),
			array( 'id' => 'credits' ),
			array( 'id' => 'translations' ),
			array( 'id' => 'freedoms' ),
		) );

		return $submenus;
	} // END remove_submenus()

	/**
	 * Loads the stylesheets for each of the dashboard pages.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_css() {
		wp_enqueue_style( 'plugin-name-activation', Plugin_Name()->plugin_url() . '/assets/css/admin/welcome.css' );
	} // END admin_css()

	/**
	 * Add styles just for this page, and remove dashboard page links.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_head() {
		// This removes each submenu listed in function 'remove_submenus'.
		foreach ( $this->remove_submenus() as $submenu ) {
			remove_submenu_page( 'index.php', PLUGIN_NAME_PAGE . '-' . $submenu['id'] );
		}

		// Badge for welcome page
		$badge_url = Plugin_Name()->plugin_url() . '/assets/images/welcome/plugin-name-badge.png';
		?>
		<style type="text/css">
		.plugin-name-badge {
			background-image: url('<?php echo $badge_url; ?>') !important;
		}

		@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
			.plugin-name-badge {
				background-image: url('<?php echo str_replace( 'badge.png', 'badge@2x.png', $badge_url ); ?>') !important;
			}
		}
		</style>
		<?php
	} // END admin_head()

	/**
	 * Intro text and links shown on all welcome pages.
	 *
	 * @since  1.0.0
	 * @access private
	 * @filter plugin_name_docs_url
	 * @filter plugin_name_welcome_twitter_username
	 * @return void
	 */
	private function intro() {
		// Flush after upgrades
		if ( ! empty( $_GET['plugin-name-updated'] ) || ! empty( $_GET['plugin-name-installed'] ) ) {
			flush_rewrite_rules();
		}

		// Drop minor version if 0
		$major_version = substr( Plugin_Name()->version, 0, 3 );
		?>
		<h1><?php _e( sprintf( 'Welcome to %s %s', Plugin_Name()->name, $major_version ), PLUGIN_NAME_TEXT_DOMAIN ); ?></h1>

		<div class="about-text plugin-name-about-text">
			<?php
				do_action( 'plugin_name_welcome_text_before' );

				if ( ! empty( $_GET['plugin-name-installed'] ) ) {
					$message = __( 'Thanks, all done!', PLUGIN_NAME_TEXT_DOMAIN );
				}
				elseif ( ! empty( $_GET['plugin-name-updated'] ) ) {
					$message = __( 'Thank you for updating to the latest version!', PLUGIN_NAME_TEXT_DOMAIN );
				}
				else {
					$message = __( 'Thanks for installing!', PLUGIN_NAME_TEXT_DOMAIN );
				}

				echo sprintf( __( '%s %s %s is a powerful, stable, and secure plugin boilerplate. I hope you enjoy it.', PLUGIN_NAME_TEXT_DOMAIN ), $message, Plugin_Name()->name, $major_version );

				do_action( 'plugin_name_welcome_text_after' );
			?>
		</div>

		<div class="plugin-name-badge"><?php printf( __( 'Version %s', PLUGIN_NAME_TEXT_DOMAIN ), Plugin_Name()->version ); ?></div>

		<div class="plugin-name-social-links">
			<a class="facebook_link" href="https://www.facebook.com/<?php echo Plugin_Name()->facebook_page; ?>" target="_blank">
				<span class="dashicons dashicons-facebook-alt"></span>
			</a>

			<a class="twitter_link" href="https://twitter.com/<?php echo Plugin_Name()->twitter_username; ?>" target="_blank">
				<span class="dashicons dashicons-twitter"></span>
			</a>

			<a class="googleplus_link" href="https://plus.google.com/<?php echo Plugin_Name()->google_plus_id; ?>" target="_blank">
				<span class="dashicons dashicons-googleplus"></span>
			</a>

		</div><!-- .plugin-name-social-links -->

		<p class="plugin-name-actions">
			<a href="<?php echo admin_url( 'admin.php?page=' . PLUGIN_NAME_PAGE . '-settings' ); ?>" class="button button-primary"><?php _e( 'Settings', PLUGIN_NAME_TEXT_DOMAIN ); ?></a>
			<a class="docs button button-primary" href="<?php echo esc_url( apply_filters( 'plugin_name_docs_url', Plugin_Name()->doc_url, PLUGIN_NAME_TEXT_DOMAIN ) ); ?>"><?php _e( 'Docs', PLUGIN_NAME_TEXT_DOMAIN ); ?></a>
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo Plugin_Name()->web_url; ?>" data-text="<?php echo apply_filters( 'plugin_name_welcome_twitter_username', __( 'Your tweet message would be placed here.', PLUGIN_NAME_TEXT_DOMAIN ) ); ?>" data-via="<?php echo Plugin_Name()->twitter_username; ?>" data-size="large" data-hashtags="<?php echo Plugin_Name()->name; ?>">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

			<div id="social-blocks">
				<div class="fb" >
					<div id="fb-root"></div>
					<script>
					(function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) return;
						js = d.createElement(s); js.id = id;
						js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
						fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
					</script>
					<div class="fb-like" data-href="http://www.facebook.com/<?php echo Plugin_Name()->facebook_page; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
				</div>

				<div class="twitter">
				<a href="https://twitter.com/<?php echo Plugin_Name()->twitter_username; ?>" class="twitter-follow-button" data-show-count="true" data-show-screen-name="false">Follow us</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>

				<div class="gplus">
				<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
				<g:plusone href="https://plus.google.com/<?php echo Plugin_Name()->google_plus_id; ?>" size="medium"></g:plusone>
				</div>
			</div>

		</p><!-- .plugin-name-actions -->

		<h2 class="nav-tab-wrapper">
			<?php
			// Displays a tab for each dashboard page registered.
			foreach ($this->register_admin_menu() as $menu) {
				echo '<a class="nav-tab';
				if ( $_GET['page'] == $menu['id'] ) echo ' nav-tab-active';
				echo '" href=" ' . esc_url( admin_url( add_query_arg( array( 'page' => $menu['id'] ), 'index.php' ) ) ) . ' ">' . $menu['tab_name'] . '</a>';
			}
			?>
		</h2>
		<?php
	} // END intro()

	/**
	 * Output the about screen.
	 *
	 * @todo   Replace the about page with your own content.
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function about_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php _e( 'Use this page to show what the plugin does or what features you have added since your first release. Replace the placeholder images with screenshots of your plugin. You can even make the screenshots linkable to show a larger screenshot with or without caption or play an embedded video. It\'s all up to you.', PLUGIN_NAME_TEXT_DOMAIN ); ?></p>

			<div>
				<h3><?php _e( 'Three Columns with Screenshots', PLUGIN_NAME_TEXT_DOMAIN ); ?></h3>
				<div class="plugin-name-feature feature-section col three-col">
					<div>
						<a href="http://placekitten.com/720/480" data-rel="prettyPhoto[gallery]"><img src="http://placekitten.com/300/250" alt="<?php _e( 'Screenshot Title', PLUGIN_NAME_TEXT_DOMAIN ); ?>" style="width: 99%; margin: 0 0 1em;"></a>
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
					<div>
						<a href="http://placekitten.com/980/640" data-rel="prettyPhoto[gallery]" title="<?php _e( 'You can add captions to your screenshots.', PLUGIN_NAME_TEXT_DOMAIN ); ?>"><img src="http://placekitten.com/300/250" alt="" style="width: 99%; margin: 0 0 1em;"></a>
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
					<div class="last-feature">
						<a href="http://vimeo.com/88671403" data-rel="prettyPhoto" title="<?php _e( 'Or add captions on your videos.', PLUGIN_NAME_TEXT_DOMAIN ); ?>"><img src="http://placekitten.com/300/250" alt="<?php _e( 'Video Title', PLUGIN_NAME_TEXT_DOMAIN ); ?>" style="width: 99%; margin: 0 0 1em;"></a>
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
				</div>
			</div>

			<div>
				<h3><?php _e( 'Three Columns with a white background', PLUGIN_NAME_TEXT_DOMAIN ); ?></h3>
				<div class="plugin-name-feature feature-section col three-col bg-white">
					<div>
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
					<div>
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
					<div class="last-feature">
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
				</div>
			</div>

			<div>
				<h3><?php _e( 'Two Columns with Screenshots', PLUGIN_NAME_TEXT_DOMAIN ); ?></h3>
				<div class="plugin-name-feature feature-section col two-col">
					<div>
						<img src="http://placekitten.com/490/410" alt="" style="width: 99%; margin: 0 0 1em;">
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
					<div class="last-feature">
						<img src="http://placekitten.com/490/410" alt="" style="width: 99%; margin: 0 0 1em;">
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
				</div>
			</div>

			<div>
				<h3><?php _e( 'Two Columns with a Single Screenshot', PLUGIN_NAME_TEXT_DOMAIN ); ?></h3>
				<div class="plugin-name-feature feature-section col two-col">
					<img src="http://placekitten.com/1042/600" alt="" style="width: 99%; margin: 0 0 1em;">
					<div>
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
					<div class="last-feature">
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
				</div>
			</div>

			<div class="changelog">
				<h2 class="about-headline-callout"><?php _e( 'Callout Headline', PLUGIN_NAME_TEXT_DOMAIN ); ?></h2>
				<img src="http://placekitten.com/980/560" alt="" style="width: 99%; margin: 0 0 1em;">

				<div class="plugin-name-feature feature-section col one-col center-col">
					<div>
						<h3><?php _e( 'One Column centered with a Single Screenshot', PLUGIN_NAME_TEXT_DOMAIN ); ?></h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
				</div>
			</div>

			<div>
				<div class="plugin-name-feature feature-section col two-col">
					<div>
						<h3><?php _e( 'Two Columns, Content Left, Screenshot Right', PLUGIN_NAME_TEXT_DOMAIN ); ?></h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
						<h4><?php _e( 'Sub-Title (H4)', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
					<div class="last-feature">
						<img src="http://placekitten.com/526/394" alt="" style="width: 99%; margin: 0 0 1em;">
					</div>
				</div>
			</div>

			<div>
				<div class="plugin-name-feature feature-section col two-col">
					<div>
						<img src="http://placekitten.com/526/394" alt="" style="width: 99%; margin: 0 0 1em;">
					</div>
					<div class="last-feature">
						<h3><?php _e( 'Two Columns, Content Right, Screenshot Left', PLUGIN_NAME_TEXT_DOMAIN ); ?></h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
						<h4><?php _e( 'Sub-Title (H4)', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
				</div>
			</div>

			<div>
				<h3><?php _e( 'Three Columns with NO Screenshots', PLUGIN_NAME_TEXT_DOMAIN ); ?></h3>

				<div class="plugin-name-feature feature-section col three-col">
					<div>
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>

					<div>
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>

					<div class="last-feature">
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>
				</div>

				<div class="plugin-name-feature feature-section col three-col">

					<div>
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>

					<div>
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>

					<div class="last-feature">
						<h4><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
					</div>

				</div>

				<div class="plugin-name-feature feature-section col three-col">
					<div>
						<h2 class="about-headline-callout"><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h2>
						<p class="about-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis.</p>
					</div>

					<div>
						<h2 class="about-headline-callout"><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h2>
						<p class="about-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis.</p>
					</div>

					<div class="last-feature">
						<h2 class="about-headline-callout"><?php _e( 'Title of Feature or New Changes', PLUGIN_NAME_TEXT_DOMAIN ); ?></h2>
						<p class="about-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis.</p>
					</div>

				</div>

			</div>

			<div class="return-to-dashboard">
				<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => PLUGIN_NAME_PAGE . '-settings' ), 'admin.php' ) ) ); ?>"><?php _e( sprintf( 'Go to %s Settings', Plugin_Name()->name ), PLUGIN_NAME_TEXT_DOMAIN ); ?></a>
			</div>
		</div>
		<?php
	} // END about_screen()

	/**
	 * Output the changelog screen.
	 *
	 * @todo   List your own changelog
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function changelog_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p><?php _e( 'Bulletpoint your changelog like so.', PLUGIN_NAME_TEXT_DOMAIN ); ?></p>

			<div class="changelog point-releases">
				<h3><?php _e( 'Version', PLUGIN_NAME_TEXT_DOMAIN ); ?> 1.0.1 (2<?php _e( 'nd March', PLUGIN_NAME_TEXT_DOMAIN ); ?> 2015)</h3>
				<ul>
					<li>Tested on WordPress 4 and up.</li>
					<li>Corrected spelling errors within the whole of the boilerplate and README.md file.</li>
					<li>Improved the use of PHPDoc conventions to document the code.</li>
					<li>Improved @todo through out the boilerplate.</li>
					<li>Improved the System Report page and added a new filter for the status tabs.</li>
					<li>Removed 'Author Email', 'Requires at least' and 'Tested up to' from the plugin header as they are not read by WordPress. These are mainly for the Readme.txt file.</li>
					<li>Moved the global $wpdb to the top of the uninstall.php file so both single and multisites can query the database.</li>
					<li>Removed the `countries` class and variables. - Can be added by following the documentation.</li>
					<li>Removed variable $theme_author_url. - Can be added by following the documentation.</li>
					<li>Removed variable $changelog_url. - Can be added by following the documentation.</li>
					<li>Removed 'after_setup_theme' action and setup_enviroment() function. - Can be added by following the documentation.</li>
					<li>Removed function set_admin_menu_separator(). This is no longer supported.</li>
					<li>Removed support for older versions of WordPress lower than version 3.8</li>
				</ul>

				<h3><?php _e( 'Version', PLUGIN_NAME_TEXT_DOMAIN ); ?> 1.0.1 (25<?php _e( 'th August', PLUGIN_NAME_TEXT_DOMAIN ); ?> 2014)</h3>
				<ul>
					<li>Grunt Setup</li>
					<li>Text Domain corrections</li>
					<li>Admin javascript minified</li>
					<li>README.md file updated</li>
				</ul>

				<h3><?php _e( 'Version', PLUGIN_NAME_TEXT_DOMAIN ); ?> 1.0.0 (25<?php _e( 'th August', PLUGIN_NAME_TEXT_DOMAIN ); ?> 2014)</h3>
				<p><strong><?php _e( sprintf( 'First version of the %s.', Plugin_Name()->name ), PLUGIN_NAME_TEXT_DOMAIN ); ?></strong></p>
			</div>

		</div>
		<?php
	} // END changelog_screen()

	/**
	 * Output the credits.
	 *
	 * @todo   Place your own credits
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function credits_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php _e( sprintf( 'The %s is developed and maintained by "S&eacute;bastien Dumont". Are you a passionate individual, would you like to give your support and see your name here? <a href="%s" target="_blank">Contribute to %s</a>.', Plugin_Name()->name, PLUGIN_NAME_GITHUB_REPO_URI . 'blob/master/CONTRIBUTING.md', Plugin_Name()->name ), PLUGIN_NAME_TEXT_DOMAIN ); ?></p>

			<div class="plugin-name-feature feature-section col two-col">

				<div>
					<h2>S&eacute;bastien Dumont</h2>
					<h4 style="font-weight:0; margin-top:0"><?php _e( 'Project Leader &amp; Developer', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
					<p><img style="float:left; margin: 0 15px 0 0;" src="<?php echo Plugin_Name()->plugin_url() . '/assets/images/sebd.jpg'; ?>" width="100" height="100" /><?php _e( 'I am a freelance WordPress Developer and I have been developing for WordPress since 2009. I provide Code Reviews, e-Commerce installations and custom WordPress plugin and theme development services. I developed this boilerplate and many others.', PLUGIN_NAME_TEXT_DOMAIN ); ?></p>
					<div class="plugin-name-social-links">
						<a class="facebook_link" href="https://www.facebook.com/Sebd86" target="_blank">
							<span class="dashicons dashicons-facebook-alt"></span>
						</a>

						<a class="twitter_link" href="https://twitter.com/sebd86" target="_blank">
							<span class="dashicons dashicons-twitter"></span>
						</a>

						<a class="googleplus_link" href="https://plus.google.com/114016411970997366558" target="_blank">
							<span class="dashicons dashicons-googleplus"></span>
						</a>

					</div><!-- .plugin-name-social-links -->
					<p><a href="http://www.sebastiendumont.com" target="_blank"><?php _e( sprintf( 'View %s&rsquo;s website', 'S&eacute;bastien' ), PLUGIN_NAME_TEXT_DOMAIN ); ?></a></p>
				</div>

				<div class="last-feature">
					<h2>Francois-Xavier B&eacute;nard</h2>
					<h4 style="font-weight:0; margin-top:0"><?php _e( 'Translation Manager, CEO of WP-Translations.org', PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
					<p><img style="float:left; margin: 0 15px 0 0;" src="<?php echo Plugin_Name()->plugin_url() . '/assets/images/fxbenard.jpg'; ?>" width="100" height="100" /><?php _e( 'Translation is my hobby, make it a living is my plan. I translate but also check and code the missing i18n() functions in your plugins or themes. I run a FREE WP Community of translators on Transifex. So if you need someone who cares about quality work, get in touch. Many developers are already trusting me, Seb of course but also Yoast, Pippin and the Mailpoet Team.', PLUGIN_NAME_TEXT_DOMAIN ); ?></p>
					<div class="plugin-name-social-links">
						<a class="facebook_link" href="https://www.facebook.com/francoisxavier.benard" target="_blank">
							<span class="dashicons dashicons-facebook-alt"></span>
						</a>

						<a class="twitter_link" href="https://twitter.com/fxbenard" target="_blank">
							<span class="dashicons dashicons-twitter"></span>
						</a>

						<a class="googleplus_link" href="https://plus.google.com/115184248259085010066" target="_blank">
							<span class="dashicons dashicons-googleplus"></span>
						</a>

					</div><!-- .plugin-name-social-links -->
					<p><a href="http://wp-translations.org" target="_blank"><?php _e( sprintf( 'View %s&rsquo;s website', 'Francois' ), PLUGIN_NAME_TEXT_DOMAIN ); ?></a></p>
				</div>

			</div>

			<hr class="clear" />

			<h4 class="wp-people-group"><?php _e( 'Contributers' , PLUGIN_NAME_TEXT_DOMAIN ); ?></h4><span style="color:#aaa; float:right; position:relative; top:-40px;"><?php _e( 'These contributers are fetched from the GitHub repository.', PLUGIN_NAME_TEXT_DOMAIN ); ?></span>

			<?php echo $this->contributors(); ?>

			<hr class="clear">

			<h4 class="wp-people-group"><?php _e( 'Translators' , PLUGIN_NAME_TEXT_DOMAIN ); ?> <span style="color:#aaa; float:right;"><?php _e( sprintf( 'These translators are fetched from the Transifex project for %s.', Plugin_Name()->name ), PLUGIN_NAME_TEXT_DOMAIN ); ?></span></h4>

			<p class="about-description"><?php _e( sprintf( '<strong>%s</strong> has been kindly translated into several other languages thanks to the WordPress community.', Plugin_Name()->name ), PLUGIN_NAME_TEXT_DOMAIN ); ?></p>
			<?php
			// Display all translators on the project with a link to their profile.
			transifex_display_translators();
			?>
			<p><?php _e( sprintf( 'Is your name not listed? Then how about taking part in helping with the translation of this plugin. See the list of <a href="%s">languages to translate</a>.', admin_url( 'index.php?page=' . PLUGIN_NAME_PAGE . '-translations' ) ), PLUGIN_NAME_TEXT_DOMAIN ); ?></p>

			<hr class="clear">

			<h4 class="wp-people-group"><?php _e( 'External Libraries' , PLUGIN_NAME_TEXT_DOMAIN ); ?></h4>
			<p class="wp-credits-list">
			<a href="http://jquery.com/" target="_blank">jQuery</a>,
			<a href="http://jqueryui.com/" target="_blank">jQuery UI</a>,
			<a href="http://malsup.com/jquery/block/" target="_blank">jQuery Block UI</a>,
			<a href="https://github.com/harvesthq/chosen" target="_blank">jQuery Chosen</a>,
			<a href="https://github.com/carhartl/jquery-cookie" target="_blank">jQuery Cookie</a>,
			<a href="http://code.drewwilson.com/entry/tiptip-jquery-plugin" target="_blank">jQuery TipTip</a> and
			<a href="http://www.no-margin-for-errors.com/projects/prettyPhoto-jquery-lightbox-clone/" target="_blank">prettyPhoto</a>
			</p>
		</div>
		<?php
	} // END credits_screen()

	/**
	 * Output the translations.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function translations_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php _e( sprintf( 'Translations currently in progress and completed for %s. <a href="%s" target="_blank">View more on %s</a>.', Plugin_Name()->name, PLUGIN_NAME_TRANSIFEX_PROJECT_URI, 'Transifex' ), PLUGIN_NAME_TEXT_DOMAIN ); ?></p>

			<?php transifex_display_translation_progress(); ?>

		</div>
		<?php
	} // END translations_screen()

	/**
	 * Output the freedoms page.
	 *
	 * @todo   It's up to you if you want to keep this page.
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function freedoms_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php _e( 'WordPress Plugin Boilerplate is Free and open source software, built to help speed up plugin development and to be stable and secure for all WordPress versions. Below is a list explaining what you are allowed to do. Enjoy!', PLUGIN_NAME_TEXT_DOMAIN ); ?></p>

			<ol start="1">
				<li><p><?php _e( 'You have the freedom to run the program, for any purpose.', PLUGIN_NAME_TEXT_DOMAIN ); ?></p></li>
				<li><p><?php _e( 'You have access to the source code, the freedom to study how the program works, and the freedom to change it to make it do what you wish.', PLUGIN_NAME_TEXT_DOMAIN ); ?></p></li>
				<li><p><?php _e( 'You have the freedom to redistribute copies of the original program so you can help your neighbor.', PLUGIN_NAME_TEXT_DOMAIN ); ?></p></li>
				<li><p><?php _e( 'You have the freedom to distribute copies of your modified versions to others. By doing this you can give the whole community a chance to benefit from your changes.', PLUGIN_NAME_TEXT_DOMAIN ); ?></p></li>
			</ol>
		</div>
		<?php
	} // END freedoms_screen()

	/**
	 * Render Contributors List
	 *
	 * @since  1.0.0
	 * @access public
	 * @filter plugin_name_filter_contributors
	 * @return string $contributor_list HTML formatted list of contributors.
	 */
	public function contributors() {
		$contributors = $this->get_contributors();

		if ( empty( $contributors ) )
			return '';

		$contributor_list = '<ul class="wp-people-group">';

		$filtered_contributers = apply_filters( 'plugin_name_filter_contributors', $contributors );

		foreach ( $contributors as $contributor ) {

			if ( !in_array( $contributor->login, $filtered_contributers ) ) {

				// Get details about this contributor.
				$contributor_details = $this->get_indvidual_contributor( $contributor->login );

				$contributor_list .= '<li class="wp-person">';
				$contributor_list .= sprintf( '<a href="%s" target="_blank" title="%s">',
					esc_url( 'https://github.com/' . $contributor->login ),
					esc_html( sprintf( __( 'View %s\'s GitHub Profile', PLUGIN_NAME_TEXT_DOMAIN ), $contributor_details->name ) )
				);
				$contributor_list .= sprintf( '<img src="%s" width="64" height="64" class="gravatar" alt="%s" />', esc_url( $contributor->avatar_url ), esc_html( $contributor->login ) );
				$contributor_list .= '</a>';

				if( isset( $contributor_details->name ) ) {
					$contributor_list .= __( 'Name', PLUGIN_NAME_TEXT_DOMAIN ) . ': <strong>' . htmlspecialchars( $contributor_details->name ) . '</strong><br>';
				}

				$contributor_list .= sprintf( __( 'Username', PLUGIN_NAME_TEXT_DOMAIN ) . ': <strong><a href="%s" target="_blank">%s</a></strong><br>', esc_url( 'https://github.com/' . $contributor->login ), esc_html( $contributor->login ) );

				if( isset( $contributor_details->blog ) ) {
					$contributor_list .= sprintf( '<strong><a href="%s" target="_blank">%s</a></strong><br>', esc_url( $contributor_details->blog ), __( 'View Website', PLUGIN_NAME_TEXT_DOMAIN ) );
				}

				$contributor_list .= '</li>';

			} // END if

		} // END foreach

		$contributor_list .= '</ul>';

		return $contributor_list;
	} // END contributors()

	/**
	 * Retrieve list of contributors from GitHub.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return mixed
	 */
	public function get_contributors() {
		$contributors = get_transient( 'plugin_name_contributors' );

		if ( false !== $contributors ) {
			return $contributors;
		}

		$response = wp_remote_get( 'https://api.github.com/repos/seb86/WordPress-Plugin-Boilerplate/contributors', array( 'sslverify' => false ) );

		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
			return array();
		}

		$contributors = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! is_array( $contributors ) ) {
			return array();
		}

		set_transient( 'plugin_name_contributors', $contributors, 3600 );

		return $contributors;
	} // END get_contributors()

	/**
	 * Retrieve details about the single contributor from GitHub.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $username
	 * @return mixed
	 */
	public function get_indvidual_contributor( $username ) {
		$contributor = get_transient( 'plugin_name_' . $username . 'contributor' );

		if ( false !== $contributor ) {
			return $contributor;
		}

		$response = wp_remote_get( 'https://api.github.com/users/' . $username, array( 'sslverify' => false ) );

		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
			return array();
		}

		$contributor = json_decode( wp_remote_retrieve_body( $response ) );

		set_transient( 'plugin_name_' . $username . 'contributor', $contributor, 3600 );

		return $contributor;
	} // END get_indvidual_contributor()

	/**
	 * Sends user to the Welcome page on first activation of
	 * Plugin Name as well as each time Plugin Name is
	 * upgraded to a new version.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function welcome() {
		// Bail if no activation redirect transient is set
		if ( ! get_transient( '_plugin_name_activation_redirect' ) )
			return;

		// Delete the redirect transient
		delete_transient( '_plugin_name_activation_redirect' );

		// Bail if we are waiting to install or update via the interface update/install links
		if ( get_option( '_plugin_name_needs_update' ) == 1 )
			return;

		// Bail if activating from network, or bulk, or within an iFrame
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) || defined( 'IFRAME_REQUEST' ) )
			return;

		if ( ( isset( $_GET['action'] ) && 'upgrade-plugin' == $_GET['action'] ) && ( isset( $_GET['plugin'] ) && strstr( $_GET['plugin'], 'wordpress-plugin-boilerplate.php' ) ) )
			return;

		wp_redirect( admin_url( 'index.php?page=' . PLUGIN_NAME_PAGE . '-about' ) );
		exit;
	} // END welcome()

} // end class.

} // end if class exists.

new Plugin_Name_Admin_Welcome();

?>
