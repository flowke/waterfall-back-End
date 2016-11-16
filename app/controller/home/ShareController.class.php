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
        $tile_id = $tileModel->addTile([$title, $desc, $imgURL, $user_id, $category_id]) ;

        if($tile_id == 0){
            echo json_encode(['message'=>3, 'desc'=> '插入失败']);
        }else{
            $ret = $tileModel->getTileById([ $user_id, $tile_id]);
            $ret = array_merge($ret, $tileModel->getTile([$user_id], 0, 'tile.tile_time', 'DESC' ,1,20));
            echo json_encode(['message'=>0, 'tile_id' => $tile_id, 'data'=>$ret]);
        }


    }
}
