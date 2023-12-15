<?php


namespace Palasthotel\FutureMonitor;


use Palasthotel\FutureMonitor\Components\Component;

class Schedule extends Component {
	public function onCreate(): void {
		add_action( 'admin_init', array( $this, 'start' ) );
		add_action( Plugin::SCHEDULE_ACTION, array($this,'execute'));
	}

	public function isScheduled(): bool|int {
		return wp_next_scheduled( Plugin::SCHEDULE_ACTION );
	}

	public function start(): void {
		if(!$this->isScheduled()){
			wp_schedule_event( time(), 'hourly', Plugin::SCHEDULE_ACTION );
		}
	}

	public function stop(): void {
		wp_clear_scheduled_hook(Plugin::SCHEDULE_ACTION);
	}

	public function execute(): void {
		$posts = $this->plugin->store->getPublishablePostIds();
		foreach ($posts as $post_id){
			wp_publish_post($post_id);
		}
	}

}