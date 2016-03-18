<?php
/**
 * This class is responsible for the
 * users logic.
 *
 * @author Rune Krauss
 *
 */
class UsersController extends Controller {
	/**
	 * Validator instance
	 *
	 * @var Validator $validator
	 */
	protected $validator;
	/**
	 * Initializes the additional validator component.
	 *
	 * @param Model $model
	 *        	Model
	 * @param View $view
	 *        	View
	 * @param Response $response
	 *        	Response
	 * @param Session $session
	 *        	Session
	 */
	public function __construct($model, $view, $response, $session) {
		parent::__construct ( $model, $view, $response, $session );
		$this->validator = new GUMP ();
	}
	/**
	 * Handles the admin login.
	 */
	public function admin_login() {
		$msg = '';
		if ($_POST && isset ( $_POST ['username'] ) && isset ( $_POST ['password'] )) {
			
			$_POST = $this->validator->sanitize ( $_POST );
			
			$this->validator->validation_rules ( array (
					'username' => 'required|alpha_numeric|max_len,32',
					'password' => 'required|max_len,8' 
			) );
			
			$this->validator->filter_rules ( array (
					'username' => 'trim|sanitize_string',
					'password' => 'trim|sanitize_string' 
			) );
			
			$validated_data = $this->validator->run ( $_POST );
			
			if ($validated_data === false) {
				$this->session->setFlash ( $this->validator->get_readable_errors ( true ), 3 );
			} else {
				$user = $this->model->getByUsername ( $_POST ['username'] );
				$hash = hash ( 'sha256', Config::get ( 'salt' ) . $_POST ['password'] );
				if ($user && $user ['is_active'] && $hash == $user ['password']) {
					$this->session->set ( 'login', $user ['username'] );
					$this->session->set ( 'role', $user ['role'] );
					$this->logger->log ( 'INFO', $user ['username'] . ' has logged in.' );
					$this->response->redirect ( '/admin/' );
				} else {
					$this->session->setFlash ( $this->lang ['error'], 3 );
				}
			}
		}
		if ($this->session->hasFlash ())
			$msg = $this->session->flash ();
		$this->view->assign ( 'message', $msg );
	}
	/**
	 * Handles the admin logout.
	 */
	public function admin_logout() {
		$this->session->destroy ();
		$this->response->redirect ( '/admin/' );
	}
}