<?php
/**
 * Post drafted trigger
 *
 * @package notification
 */

namespace BracketSpace\Notification\Defaults\Trigger\Post;

use BracketSpace\Notification\Defaults\MergeTag;

/**
 * Post drafted trigger class
 */
class PostDrafted extends PostTrigger {

	/**
	 * Constructor
	 *
	 * @param string $post_type optional, default: post.
	 */
	public function __construct( $post_type = 'post' ) {

		parent::__construct( array(
			'post_type' => $post_type,
			'slug'      => 'wordpress/' . $post_type . '/drafted',
			// translators: singular post name.
			'name'      => sprintf( __( '%s saved as a draft', 'notification' ), parent::get_post_type_name( $post_type ) ),
		) );

		$this->add_action( 'transition_post_status', 10, 3 );

		// translators: 1. singular post name, 2. post type slug.
		$this->set_description( sprintf( __( 'Fires when %s (%s) is saved as a draft', 'notification' ), parent::get_post_type_name( $post_type ), $post_type ) );

	}

	/**
	 * Assigns action callback args to object
	 *
	 * @param string $new_status New post status.
	 * @param string $old_status Old post status.
	 * @param object $post       Post object.
	 * @return mixed void or false if no notifications should be sent
	 */
	public function action( $new_status, $old_status, $post ) {

		$this->{ $this->post_type } = $post;

		if ( $this->{ $this->post_type }->post_type != $this->post_type ) {
			return false;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

		if ( $new_status != 'draft' ) {
			return false;
		}

		if ( $this->{ $this->post_type }->post_type != $this->post_type ) {
			return false;
		}

		$this->author          = get_userdata( $this->{ $this->post_type }->post_author );
		$this->publishing_user = get_userdata( get_current_user_id() );

		$this->{ $this->post_type . '_creation_datetime' }     = strtotime( $this->{ $this->post_type }->post_date );
		$this->{ $this->post_type . '_modification_datetime' } = strtotime( $this->{ $this->post_type }->post_modified );

	}

}
