<?php
/**
 * This class is used for the configuration of 
 * the admin layout admin.html.
 * 
 * @author Rune Krauss
 *
 */
class Admin {
	/**
	 * Prepares and calculates variables for
	 * the admin layout admin.html, for example
	 * classes and sessions.
	 *
	 * @param View $tpl
	 *        	Admin layout
	 * @param View $view
	 *        	Template
	 * @param Array $lang
	 *        	Languages
	 * @param Session $session
	 *        	Session
	 */
	public function __construct($tpl, $view, $lang, $session) {
		$websiteName = Config::get ( 'websiteName' );
		$assets = Config::get ( 'assets' );
		$activePages = '';
		$activeContact = '';
		$router = App::getRouter ();
		if ($router->getController () == 'pages') {
			$activePages = " class='active'";
		} else if ($router->getController () == 'contacts') {
			$activeContact = " class='active'";
		}
		$login = '';
		if ($session->get ( 'login' )) {
			$login = '<ul class="nav navbar-nav"><li' . $activePages . '><a href="/admin/pages/">' . $lang ['pages'] . '</a></li><li' . $activeContact . '><a href="/admin/contacts/">' . $lang ['contacts'] . '</a></li><li><a href="/admin/users/logout">Logout</a></li></ul>';
		}
		$tpl->assign ( 'activePages', $activePages );
		$tpl->assign ( 'activeContact', $activeContact );
		$tpl->assign ( 'websiteName', $websiteName );
		$tpl->assign ( 'assets', $assets );
		$tpl->assign ( 'login', $login );
		$tpl->assign ( 'content', $view->loadView () );
		
		$tpl->render ();
	}
}