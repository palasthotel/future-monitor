<?php
/**
 * Plugin Name: Future Monitor
 * Plugin URI: https://palasthotel.de
 * Description: Monitors the future of your system. For example planned posts...
 * Version: 1.0.0
 * Author: Palasthotel <edward.bock@palasthotel.de>
 * Author URI: https://palasthotel.de
 * Text Domain: future-monitor
 * Domain Path: /languages
 * Requires at least: 4.0
 * Tested up to: 5.2.2
 * License: http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 *
 * @copyright Copyright (c) 2019, Palasthotel
 * @package Palasthotel\FutureMonitor
 */

namespace Palasthotel\FutureMonitor;


/**
 * @property string url
 * @property string path
 * @property string basename
 * @property DashboardWidget dashboardWidget
 * @property Store store
 * @property Schedule schedule
 */
class Plugin {

	const DOMAIN = "future-monitor";
	const SCHEDULE_ACTION = "future_monitor_publish_future_posts";

	public function __construct() {

		load_plugin_textdomain(
			Plugin::DOMAIN,
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);

		$this->url      = plugin_dir_url( __FILE__ );
		$this->path     = plugin_dir_path( __FILE__ );
		$this->basename = plugin_basename( __FILE__ );

		require_once dirname(__FILE__)."/vendor/autoload.php";

		$this->store = new Store();
		$this->schedule = new Schedule($this);
		$this->dashboardWidget = new DashboardWidget($this);

		/**
		 * on activate or deactivate plugin
		 */
		register_activation_hook( __FILE__, array( $this, "activation" ) );
		register_deactivation_hook( __FILE__, array( $this, "deactivation" ) );
	}

	public function activation(){
		$this->schedule->start();
	}

	public function deactivation(){
		$this->schedule->stop();
	}
}

new Plugin();