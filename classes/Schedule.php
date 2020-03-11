<?php


namespace Palasthotel\FutureMonitor;


/**
 * @property Plugin plugin
 */
class Schedule {

	/**
	 * Schedule constructor.
	 *
	 * @param Plugin $plugin
	 */
	public function __construct($plugin) {
		$this->plugin = $plugin;
		add_action( 'admin_init', array( $this, 'start' ) );
		add_action( Plugin::SCHEDULE_ACTION, array($this,'execute'));
	}

	/**
	 * @return false|int
	 */
	public function isScheduled() {
		return wp_next_scheduled( Plugin::SCHEDULE_ACTION );
	}

	public function start(){
		if(!$this->isScheduled()){
			wp_schedule_event( time(), 'hourly', Plugin::SCHEDULE_ACTION );
		}
	}

	public function stop(){
		wp_clear_scheduled_hook(Plugin::SCHEDULE_ACTION);
	}

	public function execute(){
		$posts = $this->plugin->store->getPublishablePostIds();
		foreach ($posts as $post_id){
			wp_publish_post($post_id);
		}
	}

}