<?php

/**
* Plugin Name:       Future Monitor - DEV
* Description:       Dev inc file
* Version:           X.X.X
* Requires at least: X.X
* Tested up to:      X.X.X
* Author:            PALASTHOTEL by Edward
* Author URI:        http://www.palasthotel.de
* Domain Path:       /plugin/languages
*/


use Palasthotel\FutureMonitor\Plugin;

include dirname( __FILE__ ) . "/plugin/Plugin.php";

register_activation_hook(__FILE__, function($multisite){
	Plugin::instance()->onActivation($multisite);
});

register_deactivation_hook(__FILE__, function($multisite){
	Plugin::instance()->onDeactivation($multisite);
});