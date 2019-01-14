<?php 
	namespace app\back\controller;
	use app\back\controller\BaseController;
	use app\back\model\User as UserModel;
	use weixin\UserAPI;

	/**
	 * 
	 */
	class User extends BaseController {
		
		public function index() {
			return $this->fetch();
		}

		public function add() {
			return $this->fetch();
		}

		public function edit() {
			return $this->fetch();
		}

		public function black() {
			return $this->fetch();
		}

		// public function updateUsers() {
		// 	$uapi = new UserAPI;
		// 	print_r($uapi->get_user_list());
		// }


		// public function accesstoken() {
	 //        $uapi = new UserAPI;
	 //        dump($uapi->accesstoken());
	 //    }

	    // 更新用户列表
		public function updateList() {
	        //获取微信用户列表
	        $uapi = new UserAPI;
	        $result = $uapi->get_user_list();

	        //获取本地用户列表
	        $openidlist = UserModel::where('subscribe_status', 1)->column('openid');
	        // $openidlist = Db::name('user')->column('openid');
	        dump($openidlist);
	        
	        //计算未更新用户列表
	        $intersection = array_diff($result["data"]["openid"], $openidlist);
	        dump($intersection);

	        // //同步入库
	        // $data = array();
	        // foreach ($intersection as &$openid) {
	        //     $data[] = array('openid'=>$openid);
	        // }
	        // $insertresult = Db::name('user')->insertAll($data);
	        
	        // $this->success('更新了'.count($intersection).'个用户','index');
		}

		// 更新用户信息
		public function updateInfo() {
	        $weixin = new \weixin\Wxapi();

	         //获取本地用户列表
	        $updateUser = Db::name('user')->where('subscribe','')->limit(100)->select();
	       
	        if (count($updateUser) > 0){
	            $municipalities = array("北京", "上海", "天津", "重庆", "香港", "澳门");
	            $sexes = array("", "男", "女");

	            $new = 0;
	            foreach ($updateUser as &$user) {
	                $new ++;
	                $info = $weixin->get_user_info($user['openid']);
	                // var_dump($info);
	                $data = array();
	                $data['nickname'] = str_replace("'", "", $info['nickname']);
	                $data['sex'] = $sexes[$info['sex']];
	                $data['country'] = $info['country'];
	                $data['province'] = $info['province'];
	                $data['city'] = (in_array($info['province'], $municipalities))?$info['province'] : $info['city'];
	                $data['headimgurl'] = $info['headimgurl'];
	                $data['subscribe'] = $info['subscribe_time'];
	                $data['heartbeat'] = $info['subscribe_time'];
	                $data['remark'] = $info['remark'];
	                $data['tagid'] = $info['tagid_list'];
	                
	                Db::name('user')->where('openid', $user['openid'])->update($data);// 根据条件更新记录
	            }

	            $this->success('更新了'.$new.'个用户','updateInfo');
	        }else{
	            $this->success('更新完成','index');
	        }
		}
	}
 ?>