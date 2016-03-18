<?php
/**
 * This class is responsible for the 
 * message logic.
 * 
 * @author Rune Krauss
 *
 */
class ContactsController extends Controller {
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
	 * Handles logic regarding the contact form.
	 */
	public function index() {
		$msg = '';
		if ($_POST) {
			
			$_POST = $this->validator->sanitize ( $_POST );
			
			$this->validator->validation_rules ( array (
					'name' => 'required|alpha_numeric|max_len,100|min_len,6',
					'email' => 'required|valid_email',
					'message' => 'required|max_len,100|min_len,6' 
			) );
			
			$this->validator->filter_rules ( array (
					'name' => 'trim|sanitize_string',
					'email' => 'trim|sanitize_email',
					'message' => 'trim' 
			) );
			
			$validated_data = $this->validator->run ( $_POST );
			
			if ($validated_data === false) {
				$this->session->setFlash ( $this->validator->get_readable_errors ( true ), 3 );
				$msg = $this->session->flash ();
			} else {
				$this->model->save ( $validated_data );
				$this->session->setFlash ( $this->lang ['message_send'], 1 );
				$msg = $this->session->flash ();
				;
			}
		}
		$session = '';
		$this->view->assign ( 'message', $msg );
	}
	/**
	 * Handles logic regarding the showing of messages in the admin panel.
	 */
	public function admin_index() {
		$messages = $this->model->getList ();
		$this->view->iterate ( 'messages', $messages );
	}
}