<?php
/**
 * This class is responsible for the
 * pages logic.
 *
 * @author Rune Krauss
 *
 */
class PagesController extends Controller {
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
	 * Handles logic regarding the pages.
	 */
	public function index() {
		$dbdata = $this->model->getList ();
		$this->view->iterate ( 'pages', $dbdata );
	}
	/**
	 * Handles logic regarding the views.
	 */
	public function view() {
		if (isset ( $this->params [0] )) {
			$alias = strtolower ( $this->params [0] );
			$page = $this->model->getByAlias ( $alias );
			$this->view->assign ( 'id', $page ['id'] );
			$this->view->assign ( 'alias', $page ['alias'] );
			$this->view->assign ( 'title', $page ['title'] );
			$this->view->assign ( 'content', $page ['content'] );
			$this->view->assign ( 'is_published', $page ['is_published'] );
		}
	}
	/**
	 * Handles logic regarding the pages in the admin panel.
	 */
	public function admin_index() {
		$pages = $this->model->getList ();
		$this->view->iterate ( 'pages', $pages );
		$message = '';
		if ($this->session->hasFlash ())
			$message = $this->session->flash ();
		$this->view->assign ( 'message', $message );
	}
	/**
	 * Handles logic regarding the editing of pages in the admin panel.
	 */
	public function admin_edit() {
		$msg = '';
		if ($_POST) {
			
			$_POST = $this->validator->sanitize ( $_POST );
			
			$this->validator->validation_rules ( array (
					'alias' => 'required|alpha_numeric|max_len,32',
					'title' => 'required|max_len,32' 
			) );
			
			$this->validator->filter_rules ( array (
					'alias' => 'trim|sanitize_string',
					'title' => 'trim|sanitize_string',
					'content' => 'trim|sanitize_string' 
			) );
			
			$validated_data = $this->validator->run ( $_POST );
			
			if ($validated_data === false) {
				$this->session->setFlash ( $this->validator->get_readable_errors ( true ), 3 );
			} else {
				$id = isset ( $_POST ['id'] ) ? $_POST ['id'] : null;
				$rs = $this->model->save ( $validated_data, $id );
				if ($rs) {
					$this->session->setFlash ( $this->lang ['page_saved'], 1 );
				} else {
					$this->session->setFlash ( $this->lang ['error'], 3 );
				}
				$this->response->redirect ( '/admin/pages' );
			}
		}
		
		if (isset ( $this->params [0] )) {
			$page = $this->model->getById ( $this->params [0] );
			$this->view->assign ( 'id', $page ['id'] );
			$this->view->assign ( 'alias', $page ['alias'] );
			$this->view->assign ( 'title', $page ['title'] );
			$this->view->assign ( 'content', $page ['content'] );
			$isPublished = '';
			if ($page ['is_published']) {
				$isPublished = 'checked';
			}
			$this->view->assign ( 'isPublished', $isPublished );
		} else {
			$this->session->setFlash ( 'Wrong page id.', 3 );
			$this->response->redirect ( '/admin/pages/' );
		}
		if ($this->session->hasFlash ())
			$msg = $this->session->flash ();
		$this->view->assign ( 'message', $msg );
	}
	/**
	 * Handles logic regarding the adding of pages in the admin panel.
	 */
	public function admin_add() {
		$msg = '';
		if ($_POST) {
			
			$_POST = $this->validator->sanitize ( $_POST );
			
			$this->validator->validation_rules ( array (
					'alias' => 'required|alpha_numeric|max_len,32',
					'title' => 'required|max_len,32' 
			) );
			
			$this->validator->filter_rules ( array (
					'alias' => 'trim|sanitize_string',
					'title' => 'trim|sanitize_string',
					'content' => 'trim|sanitize_string' 
			) );
			
			$validated_data = $this->validator->run ( $_POST );
			
			if ($validated_data === false) {
				$this->session->setFlash ( $this->validator->get_readable_errors ( true ), 3 );
			} else {
				$rs = $this->model->save ( $validated_data );
				if ($rs) {
					$this->session->setFlash ( $this->lang ['page_saved'], 1 );
				} else {
					$this->session->setFlash ( $this->lang ['error'], 3 );
				}
				$this->response->redirect ( '/admin/pages' );
			}
			if ($this->session->hasFlash ())
				$msg = $this->session->flash ();
		}
		$this->view->assign ( 'message', $msg );
	}
	/**
	 * Handles logic regarding the deleting of pages in the admin panel.
	 */
	public function admin_delete() {
		if (isset ( $this->params [0] )) {
			$rs = $this->model->delete ( $this->params [0] );
			if ($rs) {
				$this->session->setFlash ( $this->lang ['page_deleted'], 1 );
			} else {
				$this->session->setFlash ( $this->lang ['error'], 3 );
			}
		}
		$this->response->redirect ( '/admin/pages' );
	}
}