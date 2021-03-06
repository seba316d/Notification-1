<?php
/**
 * WordPress Plugin activated trigger
 *
 * @package notification
 */

namespace BracketSpace\Notification\Defaults\Trigger\Plugin;

use BracketSpace\Notification\Defaults\MergeTag;
use BracketSpace\Notification\Abstracts;

/**
 * Activated plugin trigger class
 */
class Activated extends PluginTrigger {

    /**
     * Constructor
     */
    public function __construct( ) {

		parent::__construct( 'wordpress/active_plugin', __( 'Plugin activated', 'notification' ) );

		$this->add_action( 'activated_plugin', 10, 2 );
		$this->set_group( __( 'WordPress', 'notification' ) );
		$this->set_description( __( 'Fires when plugin is activated', 'notification' ) );

	}

	/**
     * Trigger action
     *
     * @param  string $plugin_rel_path Plugin path.
     * @return void
     */
	 public function action( $plugin_rel_path ) {
		$plugin_dir                    = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $plugin_rel_path;
		$this->plugin                  = get_plugin_data( $plugin_dir );
		$this->plugin_active_date_time = strtotime( 'now' );
	 }

	/**
     * Registers attached merge tags
     *
     * @return void
     */
	public function merge_tags( )
	{

	    parent::merge_tags( );

		$this->add_merge_tag( new MergeTag\DateTime\DateTime( array(
			'slug' => 'plugin_active_date_time',
			'name' => __( 'Plugin activated date time', 'notification' ),
		) ) );
	}
}
