<?php

/**
 * @author Thomas Matlak <tmatlak18@wooster.edu>
 */
class UserProfile {
	/**
	 * Constructor for the UserProfile class
	 */
	function __construct() {
		
	}

	/**
	 * Attempt to create a new user profile in the database
	 *
	 * @param string $first_name
	 * @param string $last_name
	 * @param string $email
	 * @param string $major
	 * @param string $role
	 * @param string $password
	 * @param int    $year (optional)
	 *
	 * @return int
	 */
	function create($first_name, $last_name, $email, $major, $role, $password, $year = null) {

	}

	/**
	 * Attempt to retrieve a user profile from the database
	 *
	 * @param int $id
	 *
	 * @return 
	 */
	function get($id) {

	}

	/**
	 * Attempt to update a user profile in the database
	 *
	 * @param int    $id
	 * @param string $first_name
	 * @param string $last_name
	 * @param string $email
	 * @param string $major
	 * @param string $role
	 * @param string $password (optional)
	 * @param int    $year (optional)
	 *
	 * @return bool
	 */
	function update($id, $first_name, $last_name, $email, $major, $role, $password = null, $year = null) {

	}

	/**
	 * Attempt to delete a user profile from the database
	 *
	 * @param int $id
	 *
	 * @return bool
	 */
	function delete($id) {
		
	}

	/**
	 * @var int $id
	 */
	public $id;

	/**
	 * @var string $first_name
	 */
	public $first_name;

	/**
	 * @var string $last_name
	 */
	public $last_name;

	/**
	 * @var string $email
	 */
	public $email;

	/**
	 * @var string $password
	 */
	private $password;

	/**
	 * @var string $major
	 */
	public $major;

	/**
	 * @var int $year
	 */
	public $year;

	/**
	 * @var string $role
	 */
	public $role;
}
