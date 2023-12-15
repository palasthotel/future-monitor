<?php


namespace Palasthotel\FutureMonitor\Components;

/**
 * Class Component
 *
 * @package Palasthotel\WordPress
 * @version 0.1.3
 */
abstract class Component {
	protected \Palasthotel\FutureMonitor\Plugin $plugin;

	/**
	 * _Component constructor.
	 */
	public function __construct(\Palasthotel\FutureMonitor\Plugin $plugin) {
		$this->plugin = $plugin;
		$this->onCreate();
	}

	public function getPlugin(): \Palasthotel\FutureMonitor\Plugin {
		return $this->plugin;
	}

	/**
	 * overwrite this method in component implementations
	 */
	public function onCreate(){
		// init your hooks and stuff
	}
}
