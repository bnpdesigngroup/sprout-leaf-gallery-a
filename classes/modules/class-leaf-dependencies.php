<?php

if (!class_exists('Leaf_Dependencies')) {

	class Leaf_Dependencies extends Sprout_Module {
		
		protected function __construct() {

		}

		public function init() {

			$this->register_hooks();

		}

		public function register_hooks() {

			add_filter('sprout_plugins', array($this, 'insert_plugins'), 1);

		}

		public function insert_plugins($plugins) {

			$leaf_plugins = array(
				array(
					'name'     => 'Meta Slider',
					'slug'     => 'ml-slider',
					'required' => false,
				),
				array(
					'name'     => 'Mobile Gallery',
					'slug'     => 'mobile-gallery',
					'required' => false,
				),
			);

			$plugins = array_merge($plugins, $leaf_plugins);

			return $plugins;

		}

	}

	Sprout::add_module('Leaf_Dependencies');

}

?>