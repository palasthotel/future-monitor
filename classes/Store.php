<?php


namespace Palasthotel\FutureMonitor;


class Store {

	private $post_ids;

	/**
	 * @return array
	 */
	public function getScheduledPostIdsFromOptions() {

		if ( $this->post_ids == NULL ) {
			$cron = get_option( "cron" );

			$filtered       = array_filter( $cron, function ( $items ) {
				return isset( $items["publish_future_post"] );
			} );
			$mapped         = array_map( function ( $items ) {
				$it = array_values( $items["publish_future_post"] )[0];
				if ( isset( $it["args"] ) && is_array( $it["args"] ) ) {
					return array_pop( $it["args"] );
				}

				return NULL;
			}, $filtered );
			$this->post_ids = array_values( array_filter( $mapped, function ( $it ) {
				return $it != NULL;
			} ) );
		}

		return $this->post_ids;
	}

	/**
	 * @return \WP_Post[]
	 */
	public function getFuturePostIds() {
		return get_posts( array(
			'fields'         => 'ids',
			"post_status"    => "future",
			"post_type"      => "any",
			"order"          => "asc",
			"orderby"        => "post_date",
			"posts_per_page" => - 1,
		) );
	}

	/**
	 * @return \WP_Post[]
	 */
	public function getPublishablePostIds() {
		return get_posts( array(
			'fields'         => 'ids',
			"post_status"    => "future",
			"post_type"      => "any",
			"order"          => "asc",
			"orderby"        => "post_date",
			"posts_per_page" => - 1,
			"date_query"     => array(
				'before' => 'now',
			),
		) );
	}

}