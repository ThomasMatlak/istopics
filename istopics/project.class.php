<?php

/**
 * @author Thomas Matlak <tmatlak18@wooster.edu>
 * 
 * A class to streamline database access and remove the need to write custom SQL statements when manipulating projects
 */
class Project {
	/**
	 * Constructor for Project class
	 */
	function __construct() {

	}

	/**
	 * Attempt to add a project to the database
	 *
	 * @param string $title
	 * @param string $proposal
	 * @param string $keywords
	 * @param string $comments
	 * @param string $discipline
	 * @param mysqli $conn
	 *
	 * @return int
	 */
	function create($title, $proposal, $keywords, $comments, $discipline, $project_type, $user_id, $conn) {
		$stmt = $conn->prepare("INSERT INTO projects (title, discipline, proposal, keywords, comments, project_type, date_created, last_updated) VALUES (?, ?, ?, ?, ?, ?, now(), now())");
		$stmt->bind_param("ssssss", $title, $discipline, $proposal, $keywords, $comments, $project_type);

		$stmt->execute();

		$proj_id = $conn->insert_id;

		// Link the project to the currently signed in user
		$stmt = $conn->prepare("INSERT INTO user_project_connections (userid, projectid) VALUES (?, ?)");

		$stmt->bind_param("ss", $user_id, $proj_id);

		$stmt->execute();
		$stmt->close();

		return $proj_id;
	}

	/**
	 * Attempt to retrieve a project from the database
	 *
	 * @param int $id
	 * @param mysqli $conn
	 *
	 * @return array|bool
	 */
	function get($id, $conn) {
		$sql = "SELECT projects.id AS proj_id, projects.title, projects.discipline, projects.proposal, projects.comments, projects.keywords, projects.project_type, projects.last_updated, projects.project_type, users.id AS user_id, users.first_name, users.last_name FROM projects INNER JOIN user_project_connections ON projects.id=user_project_connections.projectid INNER JOIN users ON user_project_connections.userid=users.id WHERE projects.id=?";
    	$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $id);

		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		if ($result->num_rows > 0) {
			return $result->fetch_assoc();
		}
		else {
			return false;
		}
	}

	/**
	 * Attempt to update a project in the database
	 *
	 * @param int    $id
	 * @param string $title
	 * @param string $proposal
	 * @param string $keywords
	 * @param string $comments
	 * @param string $discipline
	 * @param mysqli $conn
	 *
	 * @return bool
	 */
	function update($id, $title, $proposal, $keywords, $comments, $discipline, $project_type, $conn) {
		$stmt = $conn->prepare("UPDATE projects SET title=?, discipline=?, proposal=?, keywords=?, comments=?, project_type=?, last_updated=now() WHERE id=?");
		$stmt->bind_param("sssssss", $title, $discipline, $proposal, $keywords, $comments, $project_type, $id);

		$stmt->execute();
		$stmt->close();

		return true;
	}

	/**
	 * Attempt to delete a project from the database
	 *
	 * @param int $id
	 * @param mysqli $conn
	 *
	 * @return bool
	 */
	function delete($id, $conn) {
		$stmt = $conn->prepare("DELETE FROM projects WHERE id=?");
		$stmt->bind_param("s", $id);

		$stmt->execute();

		// Remove the connection between the user and the project
		$stmt = $conn->prepare("DELETE FROM user_project_connections WHERE projectid=?");
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
	 * @var string $title
	 */
	public $title;

	/**
	 * @var string $proposal
	 */
	public $proposal;

	/**
	 * @var string $keywords
	 */
	public $keywords;

	/**
	 * @var string $comments
	 */
	public $comments;

	/**
	 * @var string $discipline
	 */
	public $discipline;

	/**
	 * @var string $date_created
	 */
	public $date_created;

	/**
	 * @var string $last_updated
	 */
	public $last_updated;
}
