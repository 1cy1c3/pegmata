<?php
/**
 * This class is used for the configuration of
 * the main layout layout.html.
 *
 * @author Rune Krauss
 *
 */
class Layout {
	/**
	 * Prepares and calculates variables for
	 * the main layout layout.html, for example
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
		$tpl->assign ( 'activePages', $activePages );
		$tpl->assign ( 'activeContact', $activeContact );
		$tpl->assign ( 'websiteName', $websiteName );
		$tpl->assign ( 'assets', $assets );
		$tpl->assign ( 'content', $view->loadView () );
		
		$tpl->render ();
	}
}