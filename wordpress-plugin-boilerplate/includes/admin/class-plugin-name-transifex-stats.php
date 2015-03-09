<?php
/**
 * Transifex Stats
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  Plugin Name
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Transifex_Stats' ) ) {

	class Plugin_Name_Transifex_Stats {

		/**
		 * Percentage of minimum completion.
		 *
		 * This determins how much of the language has
		 * to be translated before it is listed as useable.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    $minimum_completion
		 */
		public $minimum_completion = '60';

		/**
		 * WordPress Standard Language.
		 *
		 * This should be left as 'en_US'.
		 * NOT RECOMMENDED TO BE ANY OTHER LANGUAGE.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    $default_lang_code
		 */
		public $default_lang_code = 'en_US';

		/**
		 * Construct
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function __construct( ) {
			$this->project_slug  = Plugin_Name()->transifex_project_slug;
			$this->resource_slug = Plugin_Name()->transifex_resources_slug;
			$this->cache_time    = 3600;
			$this->api = new Plugin_Name_Transifex_API( $this->cache_time );
		} // END __construct()

		/**
		 * Get project resources
		 *
		 * @since  1.0.0
		 * @access public
		 * @return array API result
		 */
		public function get_project() {
			return $this->api->connect_api( "project/{$this->project_slug}?details" );
		} // END get_project()

		/**
		 * Get language
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $language_code Transifex language code
		 * @return array API result
		 */
		public function get_language( $language_code ) {
			return $this->api->connect_api( "language/{$language_code}" );
		} // END get_language()

		/**
		 * Sort object by property
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  $b
		 * @param  $a
		 * @return int
		 */
		public function sort_objects_by_completion( $b, $a ) {
			if ( (int) $a->completed == (int) $b->completed ) return 0 ;
			return ( (int) $a->completed < (int) $b->completed) ? -1 : 1;
		} // END sort_objects_by_completion()

		/**
		 * Is error
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $response API response
		 * @return bool Error
		 */
		public function maybe_display_error( $response ) {
			$error = '';

			if ( ! $response ) {
				$error = __('No results', PLUGIN_NAME_TEXT_DOMAIN );
			}

			if ( is_array( $response ) && isset( $response['error'] ) ) {
				$error = $response['error']['message'] . ' (' . $response['error']['code'] . ')';
			}

			if ( ! $error ) {
				return false;
			}

			echo $error;
			return true;
		} // END maybe_display_error()

		/**
		 * Display users that contributed a translation to the project
		 *
		 * @since  1.0.0
		 * @access public
		 * @filter plugin_name_transifex_contributors
		 * @return array API result
		 */
		public function display_contributors() {
			$project = $this->get_project();

			if ( $this->maybe_display_error( $project ) ) {
				return;
			}

			$contributors = array();

			if ( ! empty( $project->teams ) ) {
				foreach( $project->teams as $team_language ) {
					$translators = $this->api->connect_api( "project/{$this->project_slug}/language/{$team_language}/" );
					if ( ! empty( $translators->translators ) ) {
						$contributors = array_merge( $contributors, $translators->translators );
					}
					if ( ! empty( $translators->coordinators ) ) {
						$contributors = array_merge( $contributors, $translators->coordinators );
					}
					if ( ! empty( $translators->reviewers ) ) {
						$contributors = array_merge( $contributors, $translators->reviewers );
					}
				}
			}

			if ( ! $contributors ) {
				return;
			}

			$contributors = apply_filters( 'plugin_name_transifex_contributors', array_unique( $contributors ) );

			natsort( $contributors ); // This sets all contributers in Alphabetical order.

			foreach ( $contributors as $username ) {
				echo '<a class="transifex-contributor" target="_blank" href="https://www.transifex.com/accounts/profile/' . $username . '">' . $username . '</a>';
			}
		} // END display_contributors()

		/**
		 * Display stats about translation progress
		 *
		 * @since  1.0.0
		 * @access public
		 * @filter plugin_name_transifex_stats
		 * @param  string $project_slug Transifex Project slug
		 * @param  string $resource_slug Transifex Resource slug
		 */
		public function display_translations_progress() {
			if ( ! $this->project_slug ) {
				return;
			}

			$project = $this->get_project();

			if ( $this->maybe_display_error( $project ) ) {
				return;
			}

			// Get first resource from project if left empty.
			$resource_slug = $this->resource_slug;

			if ( ! $resource_slug ) {
				if ( empty( $project->resources ) ) {
					return;
				}
				$resource_slug = $project->resources[0]->slug;
			}

			$languages = $this->api->connect_api( "project/{$this->project_slug}/resource/{$resource_slug}/stats/" );

			if ( $this->maybe_display_error( $languages ) ) {
				return;
			}

			// Sort stats by completion.
			$languages = (array) $languages;
			uasort( $languages, array( $this, 'sort_objects_by_completion' ) );

			$languages = apply_filters( 'plugin_name_transifex_stats', $languages, $project );

			if ( $languages ) {
			?>
			<ul>
				<?php
				foreach ( $languages as $language_code => $resource ) {
					$language = $this->get_language( $language_code );
					if( $resource->completed >= $this->minimum_completion && $this->default_lang_code != $language_code ) {
				?>
				<li class="clearfix">
					<div class="language_name">
						<?php echo $language->name; ?>
					</div>
					<div class="statbar">
						<div class="graph_resource">
							<div class="translated_comp" style="width:<?php echo str_replace('%', '', $resource->completed); ?>%;"></div>
						</div>
						<div class="stats_string_resource">
							<?php echo $resource->completed; ?>
						</div>
						<div class="go_translate">
							<a target="_blank" href="https://www.transifex.com/projects/p/<?php echo Plugin_Name()->transifex_project_slug; ?>/translate/#<?php echo $language_code; ?>"><?php _e( 'Translate', PLUGIN_NAME_TEXT_DOMAIN ); ?></a>
						</div>
					</div>
				</li>
				<?php
					} // end if
				} // end foreach
				?>
			</ul>
			<?php
			}
		} // END display_translations_progress()

	} // END class

} // END if class exists
?>
