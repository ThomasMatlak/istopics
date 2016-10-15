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
	 * @param mysqli $conn
	 *
	 * @return int
	 */
	function create($first_name, $last_name, $email, $major, $role, $password, $year = null, $conn) {
		$sql = 'INSERT INTO users (first_name, last_name, email, ';
		$parm_bindings = 'sss';
		if ($role === 'student') {
			$sql .= 'major, year, ';
			$parm_bindings .= 'ss';
		}
		$sql .= 'password, role) VALUES (?,?,?,';
		$parm_bindings .= 'ss';
		if ($role === 'student') {
			$sql .= '?,?,';
		}
		$sql .= '?,?)';

		$stmt = $conn->prepare($sql);

		if ($role === 'student') {
			$stmt->bind_param($parm_bindings, $first_name, $last_name, $email, $major, $year, $password, $role);
		}
		else {
			$stmt->bind_param($parm_bindings, $first_name, $last_name, $email, $password, $role);
		}

		$stmt->execute();
		$stmt->close();

		return $conn->insert_id;
	}

	/**
	 * Attempt to retrieve a user profile from the database
	 *
	 * @param int $id
	 * @param mysqli $conn
	 *
	 * @return array
	 */
	function get($id, $conn) {
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
	 * @param mysqli $conn
	 *
	 * @return bool
	 */
	function update($id, $first_name, $last_name, $email, $major, $role, $password = null, $year = null, $conn) {
		$stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, major=?, year=?, email=?, password=? WHERE id=?");
		$stmt->bind_param("sssssss", $first_name, $last_name, $major, $year, $email, $id, $password);

		$stmt->execute();
		$stmt->close();

		return true;
	}

	/**
	 * Attempt to delete a user profile from the database
	 *
	 * @param int $id
	 * @param mysqli $conn
	 *
	 * @return bool
	 */
	function delete($id, $conn) {
		$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
		$stmt->bind_param("s", $id);

		$stmt->execute();

		// Remove connection between the user and projects
		$stmt = $conn->prepare("DELETE FROM user_project_connections WHERE userid=?");
		$stmt->bind_param("s", $id);

		$stmt->execute();
		$stmt->close();

		return true;
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
