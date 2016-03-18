<?php
/**
 * This class is used for all database operations, so 
 * inserts, transactions and so on.
 * 
 * @author Rune Krauss
 *
 */
class Database {
	/**
	 * Host of the database
	 *
	 * @var String
	 */
	private $host;
	/**
	 * User of the database
	 *
	 * @var String
	 */
	private $user;
	/**
	 * Password of the database
	 *
	 * @var String
	 */
	private $password;
	/**
	 * Name of the database
	 *
	 * @var String
	 */
	private $database;
	/**
	 * Port of the database
	 *
	 * @var String
	 */
	private $port;
	/**
	 * Connection instance regarding the database
	 *
	 * @var String
	 */
	private $connection;
	/**
	 * Error regarding the database
	 *
	 * @var String
	 */
	private $error;
	/**
	 * Statement regarding the database
	 *
	 * @var String
	 */
	private $stmt;
	/**
	 * Creates a database connection based on the given parameters.
	 *
	 * @param String $host
	 *        	Host of the database
	 * @param String $user
	 *        	User of the database
	 * @param String $password
	 *        	Password of the database
	 * @param String $database
	 *        	Name of the database
	 * @param String $port
	 *        	Port of the database
	 */
	public function __construct($host, $user, $password, $database, $port) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->database = $database;
		$this->port = $port;
		// Set DSN
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database . ';port=' . $this->port;
		// Set options
		$options = array (
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
		);
		// Create a new PDO instance
		try {
			$this->connection = new PDO ( $dsn, $this->user, $this->password, $options );
		} catch ( PDOException $e ) {
			$this->error = $e->getMessage ();
			Logger::getInstance ()->log ( 'ERROR', $this->error );
		}
	}
	/**
	 * Prepares a given query.
	 *
	 * @param String $query
	 *        	Specific query
	 */
	public function query($query) {
		$this->stmt = $this->connection->prepare ( $query );
	}
	/**
	 * Binds a specific value.
	 *
	 * @param String $param
	 *        	Parameter
	 * @param String $value
	 *        	Value
	 * @param String $type
	 *        	Type
	 */
	public function bind($param, $value, $type = null) {
		if (is_null ( $type )) {
			switch (true) {
				case is_int ( $value ) :
					$type = PDO::PARAM_INT;
					break;
				case is_bool ( $value ) :
					$type = PDO::PARAM_BOOL;
					break;
				case is_null ( $value ) :
					$type = PDO::PARAM_NULL;
					break;
				default :
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue ( $param, $value, $type );
	}
	/**
	 * Executes the statement.
	 *
	 * @return boolean Status
	 */
	public function execute() {
		return $this->stmt->execute ();
	}
	/**
	 * Executes the statement and fetches all data.
	 *
	 * @return Array Specific data regarding the database
	 */
	public function resultset() {
		$this->execute ();
		return $this->stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	/**
	 * Executes the statement and fetches data.
	 *
	 * @return Array Specific data regarding the database
	 */
	public function single() {
		$this->execute ();
		return $this->stmt->fetch ( PDO::FETCH_ASSOC );
	}
	/**
	 * Counts the rows.
	 *
	 * @return int Specific data regarding the database
	 */
	public function rowCount() {
		return $this->stmt->rowCount ();
	}
	/**
	 * Determines the last insert id.
	 *
	 * @return int Specific data regarding the database
	 */
	public function lastInsertId() {
		return $this->connection->lastInsertId ();
	}
	/**
	 * Begins a transaction.
	 *
	 * @return boolean Transaction
	 */
	public function beginTransaction() {
		return $this->connection->beginTransaction ();
	}
	/**
	 * Finishes a transaction.
	 *
	 * @return boolean Commit
	 */
	public function endTransaction() {
		return $this->connection->commit ();
	}
	/**
	 * Drops a transaction.
	 *
	 * @return boolean Roll back
	 */
	public function cancelTransaction() {
		return $this->connection->rollBack ();
	}
	/**
	 * Debugs dump parameters.
	 *
	 * @return Array Specific data regarding the database
	 */
	public function debugDumpParams() {
		return $this->stmt->debugDumpParams ();
	}
}