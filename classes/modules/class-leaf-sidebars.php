<?php

if (!class_exists('Leaf_Sidebars')) {

	class Leaf_Sidebars extends Sprout_Module {

		protected function __construct() {

		}

		public function init() {

			$this->register_hooks();

		}

		public function register_hooks() {

			add_action('sprout_sidebars', array($this, 'insert_sidebars'));

		}

		/**
		 * Insert sidebars
		 */
		public function insert_sidebars($sidebars) {

			return $sidebars;

		}

	}

	Sprout::add_module('Leaf_Sidebars');

}

?>