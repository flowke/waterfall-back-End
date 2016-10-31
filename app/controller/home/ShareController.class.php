<?php

include LIBRARY_PATH.'upload.class.php';
/**
 * 处理分享
 */
class ShareController extends BaseController{

    function shareAction(){
        if($this->checkLogin() === false){
            echo json_encode(['message' => 1, 'desc'=>'没有登陆']);
            return;
        }

        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $category_id = $_POST['category_id'];
        $user_id = $_POST['user_id'];

        $up = new upload('img','public/upload');
        $imgURL = $up->uploadFile();

        if($imgURL === false){
            echo json_encode(['message'=>2, 'desc'=>'图片保存失败']);
            return;
        }
        $tileModel = new TileModel('tile');
        $ret = $tileModel->addTile([$title,$desc,$imgURL,$user_id,$category_id]);
        echo json_encode(['message'=>0, 'id'=>$ret]);
    }
}
