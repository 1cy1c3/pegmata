<?php
/**
 * This class is responsible for the
 * contacts data poses.
 *
 * @author Rune Krauss
 *
 */
class Contacts extends Model {
	/**
	 * Table of the database
	 *
	 * @var String
	 */
	const TABLE = 'messages';
	/**
	 * Saves a message.
	 *
	 * @param Array $data        	
	 * @param int $id        	
	 * @return boolean Status
	 */
	public function save($data, $id = null) {
		if (! isset ( $data ['name'] ) || ! isset ( $data ['email'] ) || ! isset ( $data ['message'] )) {
			return false;
		}
		$id = ( int ) $id;
		if (! $id) {
			$sql = 'INSERT INTO ' . self::TABLE . ' (name, email, message) VALUES(:name, :email, :message)';
			$this->db->query ( $sql );
			$this->db->bind ( ':name', $data ['name'] );
			$this->db->bind ( ':email', $data ['email'] );
			$this->db->bind ( ':message', $data ['message'] );
		} else {
			$sql = 'UPDATE ' . self::TABLE . ' SET name = :name, email = :email, message = :message WHERE id = :id';
			$this->db->query ( $sql );
			$this->db->bind ( ':name', $data ['name'] );
			$this->db->bind ( ':email', $data ['email'] );
			$this->db->bind ( ':message', $data ['message'] );
			$this->db->bind ( ':id', $id );
		}
		return $this->db->execute ();
	}
	/**
	 * Gets a list of messages.
	 *
	 * @return Array List of messages
	 */
	public function getList() {
		$sql = 'SELECT * FROM ' . self::TABLE;
		$this->db->query ( $sql );
		return $this->db->resultset ();
	}
}