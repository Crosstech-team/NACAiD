<?php

namespace K_Elements\Compat\Elementor\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


use Elementor\Core\Base\Module;
use K_Elements\Compat\Elementor\FunctionCaller;

class QueryControl extends Module {

	/**
	 * Module constructor.
	 *
	 * @param array $args
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Get the name of the module
	 *
	 * @return string
	 */
	public function get_name() {
		return 'stax-query-control';
	}

	/**
	 * Registeres actions to Elementor hooks
	 *
	 * @return void
	 */
	protected function add_actions() {
		add_action( 'elementor/ajax/register_actions', [ $this, 'register_ajax_actions' ] );
	}

	/**
	 * Register ajax actions
	 *
	 * @param [type] $ajax_manager
	 *
	 * @return void
	 */
	public function register_ajax_actions( $ajax_manager ) {
		$ajax_manager->register_ajax_action( 'stax_query_control_value_titles', [
			$this,
			'ajax_call_control_value_titles'
		] );
		$ajax_manager->register_ajax_action( 'stax_query_control_filter_autocomplete', [
			$this,
			'ajax_call_filter_autocomplete'
		] );
	}

	/**
	 * Call filter autocomplete
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function ajax_call_filter_autocomplete( array $data ) {
		if ( empty( $data['query_type'] ) || empty( $data['q'] ) ) {
			throw new \Exception( 'Bad Request' );
		}

		$results = call_user_func( [ $this, 'get_' . $data['query_type'] ], $data );

		return [
			'results' => $results,
		];
	}

	/**
	 * Calls function to get value titles depending on ajax query type
	 *
	 * @return array
	 */
	public function ajax_call_control_value_titles( $request ) {
		$results = call_user_func( [ $this, 'get_value_titles_for_' . $request['query_type'] ], $request );

		return $results;
	}

	/**
	 * Get fields (post/user/term)
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	protected function get_fields( $data ) {
		$results = [];

		if ( 'any' === $data['object_type'] ) {
			$object_types = [ 'user', 'category' ];
		} else {
			$object_types = [ $data['object_type'] ];
		}

		foreach ( $object_types as $object_type ) {
			$function = 'get_' . $object_type . '_fields';
			$fields   = FunctionCaller::{$function}( $data['q'] );

			if ( ! empty( $fields ) ) {
				foreach ( $fields as $field_key => $field_name ) {
					$results[] = [
						'id'   => $field_key,
						'text' => ( 'any' === $data['object_type'] ? '[' . $object_type . '] ' : '' ) . $field_name,
					];
				}
			}
		}

		return $results;
	}

	/**
	 * Get value for fields
	 *
	 * @param [type] $request
	 * @return array
	 */
	protected function get_value_titles_for_fields( $request ) {
		$ids     = (array) $request['id'];
		$results = [];

		if ( 'any' === $request['object_type'] ) {
			$object_types = [ 'user', 'category' ];
		} else {
			$object_types = [ $request['object_type'] ];
		}

		foreach ( $object_types as $object_type ) {
			$function = 'get_' . $object_type . '_fields';
			foreach ( $ids as $id ) {
				$fields = FunctionCaller::{$function}( $id );

				if ( ! empty( $fields ) ) {
					foreach ( $fields as $field_key => $field_name ) {
						if ( in_array( $field_key, $ids ) ) {
							$results[ $field_key ] = $field_name;
						}
					}
				}
			}
		}

		return $results;
	}


	/**
	 * Get values for terms
	 *
	 * @param [type] $request
	 *
	 * @return array
	 */
	protected function get_value_titles_for_category( $request ) {
		return FunctionCaller::get_value_titles_for_category( $request );

	}

	/**
	 * Get values for terms
	 *
	 * @param [type] $request
	 *
	 * @return array
	 */
	protected function get_value_titles_for_user( $request ) {
		return FunctionCaller::get_value_titles_for_user( $request );

	}
}