<?php
include LIBRARY_PATH.'upload.class.php';

class UserController extends BaseController {
    /**
     * 验证登陆
     * 1. 收集用户名和密码
     * 2. 验证处理
     * 3. 调用模型完成检查并给出相应提示
     * @return [type] [description]
     */
    public function loginAction(){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userModel = new UserModel('user');

        $ret = $userModel->checkUser([$username, $password]);

        if(empty($ret[0])){
            echo json_encode([
                "message" => 1,
                "desc" => "用户名不存在"
            ]);
            return;
        }

        if( empty($ret[1]) ){
            echo json_encode([
                "message" => 2,
                "desc" => "密码错误"
            ]);
        }else{
            $_SESSION['user'] = $ret[1]['user_id'];
            echo json_encode([
                'message' => 0,
                'user_id' => $ret[1]['user_id'],
                'user_name' => $ret[1]['user_name'],
                'user_icon' => $ret[1]['user_icon']
            ]);
        }
    }

    public function registerAction(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = $_POST['cfpassword'];

        // 调用usermodel进行注册
        $userModel = new UserModel('user');

        $ret = $userModel->checkUserName([$username]);

        if(!empty($ret)){
            echo json_encode( ['message'=>2, 'desc'=>'用户名已存在'] );
            return;
        }

        $ret = $userModel->registerUser([$username, $password, $GLOBALS['config']['default_icon']]);

        if($ret == 0){
            echo json_encode( ['message'=>1, 'desc'=>'注册失败'] );
        }else{
            echo json_encode(['message'=>0,'id'=>$ret]);
        }
    }

    public function autologinAction(){
        if($this->checkLogin()){
            $userModel = new UserModel('user');
            $ret = $userModel->getUser([$_SESSION['user']]);
            echo json_encode([
                'message' => 1,
                'user_id' => $ret['user_id'],
                'user_name' => $ret['user_name'],
                'user_icon' => $ret['user_icon']
            ]);
        }else{
            echo json_encode(['message'=>0]);
        }
    }

    public function logoutAction(){
        unset($_SESSION['user']);
        // session_destroy();
        header("Location:{$GLOBALS['config']['index']}");
    }
    /**
     * 获取所有用户
     * @return [type] [description]
     */
    public function getListAction(){
        $userModel = new UserModel('user');
        $ret = $userModel->getUsersList();
        echo json_encode($ret);
    }
    /**
     * 更改用户头像
     * @return [type] [description]
     */
    public function changeMyAvatarAction(){

        $up = new upload('avatar','public/upload');
        $imgURL = $up->uploadFile();
        if($imgURL === false){
            echo json_encode(['message'=>2, 'desc'=>'图片保存失败']);
            return;
        }

        $userModel = new UserModel('user');
        $userModel->updateAvatar([$imgURL,$_SESSION['user']]);

        echo json_encode(["message"=>1, "url"=>$imgURL]);

    }
}
