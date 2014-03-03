<?php

if (!class_exists('Leaf_Scripts')) {

	class Leaf_Scripts extends Sprout_Module {
		
		protected function __construct() {

		}

		public function init() {

			$this->register_hooks();

		}

		public function register_hooks() {

			add_action('sprout_styles', array($this, 'insert_styles'), 100);
			add_action('sprout_scripts', array($this, 'insert_scripts'), 100);

		}

		/**
		 * Insert styles
		 */
		public function insert_styles($styles) {

			foreach ($styles as &$style) {

				if (strpos($style['id'], 'sprout_app') !== false) {

					$style['src'] = str_replace('themes/' . THEME_SLUG, 'themes/' . CHILD_THEME_SLUG, $style['src']);

				}

			}

			return $styles;

		}

		/**
		 * Insert scripts
		 */
		public function insert_scripts($scripts) {

			return $scripts;

		}

	}

	Sprout::add_module('Leaf_Scripts');

}

?>