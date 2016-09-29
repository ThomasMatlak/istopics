<?php

require_once('db_credentials.php');

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
		$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, major, year, password, role) VALUES (?,?,?,?,?,?,?)");
		$stmt->bind_param("sssssss", $first_name, $last_name, $email, $major, $year, $password, $role);

		$stmt->execute();
		$stmt->close();
	}

	/**
	 * Attempt to retrieve a user profile from the database
	 *
	 * @param int $id
	 *
	 * @return array
	 */
	function get($id) {
		$sql = "SELECT id, first_name, last_name, major, year, email, role FROM users WHERE id={$id}";
    	$result = $conn->query($sql);

		return $result->fetch_assoc();
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
		$stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, major=?, year=?, email=?, password=? WHERE id=?");
		$stmt->bind_param("sssssss", $first_name, $last_name, $major, $year, $email, $id, $password);

		$stmt->execute();
		$stmt->close();
	}

	/**
	 * Attempt to delete a user profile from the database
	 *
	 * @param int $id
	 *
	 * @return bool
	 */
	function delete($id) {
		$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
		$stmt->bind_param("s", $id);

		$stmt->execute();
		$stmt->close();
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
