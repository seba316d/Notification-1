<?php
/**
 * User password changed trigger
 *
 * @package notification
 */

namespace BracketSpace\Notification\Defaults\Trigger\User;

use BracketSpace\Notification\Defaults\MergeTag;
use BracketSpace\Notification\Abstracts;

/**
 * User password changed trigger class
 */
class UserPasswordResetRequest extends Abstracts\Trigger {

	/**
	 * Constructor
	 */
	public function __construct() {

		parent::__construct( 'wordpress/user_password_reset_request', __( 'User password reset request', 'notification' ) );

		$this->add_action( 'retrieve_password_key', 10, 2 );
		$this->set_group( __( 'User', 'notification' ) );
		$this->set_description( __( 'Fires when user requests password change', 'notification' ) );

	}

	/**
	 * Assigns action callback args to object
	 *
	 * @param string $username  username.
	 * @param string $reset_key password reset key.
	 * @return void
	 */
	public function action( $username, $reset_key ) {

		$user = get_user_by( 'login', $username );

		$this->user_id     = $user->data->ID;
		$this->user_login  = $user->data->user_login;
		$this->user_object = get_userdata( $this->user_id );

		$this->password_reset_key = $reset_key;

		$this->user_registered_datetime        = strtotime( $this->user_object->user_registered );
		$this->password_reset_request_datetime = time();

	}

	/**
	 * Registers attached merge tags
	 *
	 * @return void
	 */
	public function merge_tags() {

		$this->add_merge_tag( new MergeTag\User\UserID() );
    	$this->add_merge_tag( new MergeTag\User\UserLogin() );
        $this->add_merge_tag( new MergeTag\User\UserEmail() );
		$this->add_merge_tag( new MergeTag\User\UserNicename() );
		$this->add_merge_tag( new MergeTag\User\UserDisplayName() );
        $this->add_merge_tag( new MergeTag\User\UserFirstName() );
		$this->add_merge_tag( new MergeTag\User\UserLastName() );
		$this->add_merge_tag( new MergeTag\User\UserPasswordResetLink() );

		$this->add_merge_tag( new MergeTag\DateTime\DateTime( array(
			'slug' => 'user_registered_datetime',
			'name' => __( 'User registration date', 'notification' ),
		) ) );

		$this->add_merge_tag( new MergeTag\User\UserRole() );
		$this->add_merge_tag( new MergeTag\User\UserBio() );

		$this->add_merge_tag( new MergeTag\DateTime\DateTime( array(
			'slug' => 'password_reset_request_datetime',
			'name' => __( 'Password reset request date', 'notification' ),
		) ) );

    }

}
