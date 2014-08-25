<?php
class Plugin_Name_Transifex_Stats {

	public $minimum_completion = '10'; // 10 is 10%

	public $default_lang_code = 'en_US'; // it should be 'en_US', WordPress standard.

	function __construct( ) {
		$this->project_slug  = Plugin_Name()->transifex_project_slug;
		$this->resource_slug = Plugin_Name()->transifex_resources_slug;
		$this->cache_time    = 3600;
		$this->api = new Plugin_Name_Transifex_API( $this->cache_time );
	}

	/**
	 * Get project resources
	 *
	 * @return array API result
	 */
	function get_project() {
		return $this->api->connect_api( "project/{$this->project_slug}?details" );
	}

	/**
	 * Getlanguage
	 *
	 * @param string $language_code Transifex language code
	 * @return array API result
	 */
	function get_language( $language_code ) {
		return $this->api->connect_api( "language/{$language_code}" );
	}

	/**
	 * Sort object by property
	 */
	function sort_objects_by_completion( $b, $a ) {
		if ( (int) $a->completed == (int) $b->completed ) return 0 ;
		return ( (int) $a->completed < (int) $b->completed) ? -1 : 1;
	}

	/**
	 * Is error
	 *
	 * @param string $response API response
	 * @return bool Error
	 */
	function maybe_display_error( $response ) {

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
	}

	/**
	 * Display users that contributed a translation to the project
	 *
	 * @access public
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

		$contributors = array_unique( $contributors );
		foreach ( $contributors as $username ) { ?>
			<a class="transifex-contributor" rel="nofollow external" href="https://www.transifex.com/accounts/profile/<?php echo $username; ?>"><?php echo $username; ?></a>
			<?php
		}
	}

	/**
	 * Display stats about translation progress
	 *
	 * @access public
	 * @param string $project_slug Transifex Project slug
	 * @param string $resource_slug Transifex Resource slug
	 */
	public function display_translations_progress() {

		if ( ! $this->project_slug ) {
			return;
		}

		$project = $this->get_project();
		if ( $this->maybe_display_error( $project ) ) {
			return;
		}

		// get first resource from project if left empty
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

		// sort stats by completion
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
	}
}

?>