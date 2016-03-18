<?php
/**
 * This class is responsible for the
 * pages data poses.
 *
 * @author Rune Krauss
 *
 */
class Pages extends Model {
	/**
	 * Table of the database
	 *
	 * @var String
	 */
	const TABLE = 'pages';
	/**
	 * Gets a list of pages.
	 *
	 * @param String $onlyPublished
	 *        	Published page
	 * @return Array List of pages
	 */
	public function getList($onlyPublished = false) {
		$sql = 'SELECT * FROM ' . self::TABLE;
		if ($onlyPublished) {
			$sql .= ' WHERE is_published = 1';
		}
		$this->db->query ( $sql );
		return $this->db->resultset ();
	}
	/**
	 * Gets a page by alias.
	 *
	 * @param String $alias
	 *        	Alias
	 * @return Array Page
	 */
	public function getByAlias($alias) {
		$sql = 'SELECT * FROM ' . self::TABLE . ' WHERE alias = :alias LIMIT 1';
		$this->db->query ( $sql );
		$this->db->bind ( ':alias', $alias );
		$rs = $this->db->single ( $sql );
		return $rs;
	}
	/**
	 * Gets a page by id.
	 *
	 * @param int $id
	 *        	ID
	 * @return Array Page
	 */
	public function getById($id) {
		$sql = 'SELECT * FROM ' . self::TABLE . ' WHERE id = :id LIMIT 1';
		$this->db->query ( $sql );
		$this->db->bind ( ':id', $id );
		$rs = $this->db->single ( $sql );
		return $rs;
	}
	/**
	 * Saves a page.
	 *
	 * @param Array $data        	
	 * @param int $id        	
	 * @return boolean Status
	 */
	public function save($data, $id = null) {
		if (! isset ( $data ['alias'] ) || ! isset ( $data ['title'] ) || ! isset ( $data ['content'] )) {
			return false;
		}
		$id = ( int ) $id;
		$isPublished = isset ( $data ['is_published'] ) ? 1 : 0;
		if (! $id) {
			$sql = 'INSERT INTO ' . self::TABLE . ' (alias, title, content, is_published) VALUES(:alias, :title, :content, :is_published)';
			$this->db->query ( $sql );
			$this->db->bind ( ':alias', $data ['alias'] );
			$this->db->bind ( ':title', $data ['title'] );
			$this->db->bind ( ':content', $data ['content'] );
			$this->db->bind ( ':is_published', $isPublished );
		} else {
			$sql = 'UPDATE ' . self::TABLE . ' SET alias = :alias, title = :title, content = :content, is_published = :is_published WHERE id = :id';
			$this->db->query ( $sql );
			$this->db->bind ( ':alias', $data ['alias'] );
			$this->db->bind ( ':title', $data ['title'] );
			$this->db->bind ( ':content', $data ['content'] );
			$this->db->bind ( ':is_published', $isPublished );
			$this->db->bind ( ':id', $id );
		}
		return $this->db->execute ();
	}
	/**
	 * Deletes a message.
	 *
	 * @param int $id        	
	 * @return boolean Status
	 */
	public function delete($id) {
		$id = ( int ) $id;
		$sql = 'DELETE FROM ' . self::TABLE . ' WHERE id = :id';
		$this->db->query ( $sql );
		$this->db->bind ( ':id', $id );
		return $this->db->execute ();
	}
}