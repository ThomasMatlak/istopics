<?php

/**
 * @author Thomas Matlak <tmatlak18@wooster.edu>
 */
class Project {
	/**
	 * Constructor for Project class
	 */
	function __construct() {

	}

	/**
	 * Attempt to adda a project to the database
	 *
	 * @param int    $id
	 * @param string $title
	 * @param string $proposal
	 * @param string $keywords
	 * @param string $comments
	 * @param string $discipline 
	 *
	 * @return int
	 */
	function create($id, $title, $proposal, $keywords, $comments, $discipline) {
		
	}

	/**
	 * Attempt to retrieve a project from the database
	 *
	 * @param int $id
	 *
	 * @return 
	 */
	function get($id) {
		
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
	 *
	 * @return bool
	 */
	function update($id, $title, $proposal, $keywords, $comments, $discipline) {
		
	}

	/**
	 * Attempt to delete a project from the database
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
