<?php 
	namespace app\back\controller;
	use think\Controller;
	use think\Session;
	use app\back\model\Admin as AdminModel;

	/**
	 * BaseController
	 */
	class BaseController extends Controller {
		
		// 构造函数
		function __construct() {
			// 调用父类构造函数
			parent::__construct();
			// 判断登陆状态
			if(!Session::has('admin.account')) {
				$this->redirect('Login/index');
			};

			// 判断token是否一致
			$admin = AdminModel::get(['account' => Session::get('admin.account')]);
			if (Session::get('admin.token') != $admin->token) {
				// 清除Session登录状态
            	Session::clear();
				$this->redirect('Login/index');
			}

			// 判断Session是否过期
			if(time() - Session::get('session_start_time') > config('session')['expire']) {
				// 清除Session登录状态
            	Session::clear();
				$this->redirect('Login/index');
			} else {
				Session::set('session_start_time', time());
			}
		}
	}
 ?>