<?php
/**
 * This class is responsible for the
 * users data poses.
 *
 * @author Rune Krauss
 *
 */
class Users extends Model {
	/**
	 * Table of the database
	 *
	 * @var String
	 */
	const TABLE = 'users';
	/**
	 * Gets a user by username.
	 *
	 * @param String $username
	 *        	Username
	 * @return Array User
	 */
	public function getByUsername($username) {
		$sql = 'SELECT * FROM ' . self::TABLE . ' WHERE username = :username LIMIT 1';
		$this->db->query ( $sql );
		$this->db->bind ( ':username', $username );
		$rs = $this->db->single ( $sql );
		return $rs;
	}
}