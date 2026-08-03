<?php


namespace Palasthotel\FutureMonitor;


/**
 * @property Plugin plugin
 */
class DashboardWidget {

	public $plugin;

	const ID = "future-posts-monitor";

	public function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
		add_action('wp_dashboard_setup', array($this, 'setup'));
	}

	public function setup(){
		wp_add_dashboard_widget(self::ID, __("Future posts monitor", Plugin::DOMAIN), array($this, 'render_future_posts'));
	}

	public function render_future_posts(){
		$post_ids = $this->plugin->store->getScheduledPostIdsFromOptions();
		$watched_ids = $this->plugin->store->getFuturePostIds();

		$query = new \WP_Query(array(
			"post_status" => "future",
			"post_type" => "any",
			"order" => "asc",
			"orderby" => "post_date",
			"posts_per_page" => -1,
		));
		while ($query->have_posts()){
			$query->the_post();
			echo "<p>";
			if(in_array(get_the_ID(), $post_ids)) {
				echo "✅ ";
			} else if( $this->plugin->schedule->isScheduled() && in_array(get_the_ID(), $watched_ids)){
				echo "⚠️ ";
			} else {
				echo "🚨 ";
			}
			$link = get_edit_post_link(get_the_ID());
			echo "<a href='$link' target='_blank'>";
			the_title();
			echo "</a>";
			echo "<br/>";
			echo "<span class='description'>";

			echo date_i18n(get_option("date_format")." – ".get_option("time_format"), strtotime(get_post()->post_date));

			echo "</span>";
			echo "</p>";

		}
		wp_reset_postdata();
		echo "<hr>";

		echo "<p>";
		_e("✅️ posts are monitored by WordPress Core for future publication.", Plugin::DOMAIN);
		echo "</p>";

		echo "<p>";
		_e("⚠️ posts are not monitored by WordPress Core for future publication, but I promise to publish them (Future Monitor Plugin).", Plugin::DOMAIN);
		echo "</p>";

		echo "<p>";
		_e("Open and resave all future posts with 🚨.", Plugin::DOMAIN);
		echo "</p>";


	}
}
