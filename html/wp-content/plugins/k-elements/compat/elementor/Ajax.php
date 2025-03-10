<?php

namespace K_Elements\Compat\Elementor;

use K_Elements\Compat\Elementor\Modules\QueryControl;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ajax {

	public $query_control;

	/**
	 * Ajax constructor
	 */
	public function __construct() {
		$this->init();
	}

	public function init() {
		include_once  'modules/QueryControl.php';

		$this->query_control = new QueryControl();
	}

}
