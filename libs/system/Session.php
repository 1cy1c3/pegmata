<?php
/**
 * Implements the memory of this system, for example regarding 
 * login operations.
 * 
 * @author Rune Krauss
 *
 */
class Session {
	/**
	 * Sets a message.
	 *
	 * @param String $msg
	 *        	Message
	 * @param int $code
	 *        	Code
	 */
	public function setFlash($msg, $code = 0) {
		$_SESSION ['flash_message'] = $msg;
		switch ($code) {
			case 0 :
				$_SESSION ['flash_type'] = 'info';
				break;
			case 1 :
				$_SESSION ['flash_type'] = 'success';
				break;
			case 2 :
				$_SESSION ['flash_type'] = 'warning';
				break;
			case 3 :
				$_SESSION ['flash_type'] = 'danger';
				break;
		}
	}
	/**
	 * Checks whether a message exists.
	 *
	 * @return boolean Status regarding a message.
	 */
	public function hasFlash() {
		return ! empty ( $_SESSION ['flash_message'] ) ? true : false;
	}
	/**
	 * Returns the specific message.
	 *
	 * @return String Message
	 */
	public function flash() {
		$temp = "<div class='alert alert-" . $_SESSION ['flash_type'] . "' role='alert'>" . $_SESSION ['flash_message'] . "</div>";
		$_SESSION ['flash_message'] = null;
		return $temp;
	}
	/**
	 * Sets a session.
	 *
	 * @param String $key
	 *        	Key
	 * @param String $value
	 *        	Value
	 */
	public function set($key, $value) {
		$_SESSION [$key] = $value;
	}
	/**
	 * Gets a session.
	 *
	 * @param String $key
	 *        	Key
	 * @return Session Session
	 */
	public function get($key) {
		if (isset ( $_SESSION [$key] )) {
			return $_SESSION [$key];
		}
		return null;
	}
	/**
	 * Deletes a session.
	 *
	 * @param String $key
	 *        	Key
	 */
	public function delete($key) {
		if (isset ( $_SESSION [$key] )) {
			unset ( $_SESSION [$key] );
		}
	}
	/**
	 * Destroys a session.
	 */
	public function destroy() {
		session_destroy ();
	}
}