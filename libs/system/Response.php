<?php

/**
 * This class refers to responds regarding the system, for 
 * example redirects or status codes.
 * 
 * @author Rune Krauss
 *
 */
class Response {
	/**
	 * Generates a response based on a status code.
	 *
	 * @param String $status_code
	 *        	Status code
	 */
	public function status($status_code) {
		if (strpos ( php_sapi_name (), 'apache' ) !== false) {
			header ( 'HTTP/1.0 ' . $status_code );
		} else {
			header ( 'Status: ' . $status_code );
		}
	}
	
	/**
	 * Handles redirects.
	 *
	 * @param String $uri
	 *        	URI
	 */
	public function redirect($uri) {
		header ( 'Location: ' . $uri );
		exit ();
	}
	
	/**
	 * Prevents XSS.
	 *
	 * @param Array $policies
	 *        	Data lists
	 */
	public function csp(array $policies = array()) {
		$policies ['default-src'] = "'self'";
		$values = '';
		
		foreach ( $policies as $policy => $hosts ) {
			
			if (is_array ( $hosts )) {
				
				$acl = '';
				
				foreach ( $hosts as &$host ) {
					
					if ($host === '*' || $host === 'self' || strpos ( $host, 'http' ) === 0) {
						$acl .= $host . ' ';
					}
				}
			} else {
				
				$acl = $hosts;
			}
			
			$values .= $policy . ' ' . trim ( $acl ) . '; ';
		}
		
		header ( 'Content-Security-Policy: ' . $values );
	}
	
	/**
	 * Prevents sniffing.
	 */
	public function nosniff() {
		header ( 'X-Content-Type-Options: nosniff' );
	}
	
	/**
	 * Prevents XSS.
	 */
	public function xss() {
		header ( 'X-XSS-Protection: 1; mode=block' );
	}
	
	/**
	 * Limits the data transport.
	 */
	public function hsts() {
		header ( 'Strict-Transport-Security: max-age=31536000' );
	}
	
	/**
	 * Sets options regarding X frames
	 *
	 * @param String $mode
	 *        	Mode
	 * @param Array $uris
	 *        	URIs
	 */
	public function xframe($mode = 'DENY', array $uris = array()) {
		header ( 'X-Frame-Options: ' . $mode . ' ' . implode ( ' ', $uris ) );
	}
}
