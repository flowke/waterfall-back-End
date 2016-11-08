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
        if(!empty($ret)){
            $_SESSION['user'] = $ret['user_id'];
            echo json_encode([
                'message' => 1,
                'user_id' => $ret['user_id'],
                'user_name' => $ret['user_name'],
                'user_icon' => $ret['user_icon']
            ]);
        }else{
            echo json_encode([
                "message" => 0
            ]);
        }
    }

    public function registerAction(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = $_POST['cfpassword'];

        // 调用usermodel进行注册
        $userModel = new UserModel('user');
        $ret = $userModel->registerUser([$username, $password, $GLOBALS['config']['default_icon']]);

        if($ret === false){
            echo json_encode( ['message'=>0] );
        }else{
            echo json_encode(['message'=>1,'id'=>$ret]);
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
    public function changeMyAvatar(){

        $up = new upload('avatar','public/upload');
        $imgURL = $up->uploadFile();

        if($imgURL === false){
            echo json_encode(['message'=>2, 'desc'=>'图片保存失败']);
            return;
        }

        $userModel = new UserModel('user');
        $userModel->updateAvatar([$_SESSION['user']]);

        echo json_encode($imgURL);

    }
}
