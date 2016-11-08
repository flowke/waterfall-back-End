<?php

class TileController extends BaseController{
    /**
     *  获取全局的tile
     * @return [type] [description]
     */
    public function getTileAction(){
        $offset = $_POST['offset'];
        $limit = $_POST['limit'];
        $fromuser = $_POST['from_user'];

        $tileModel = new TileModel('tile');
        $ret = $tileModel->getTile([$fromuser],$offset,$limit);
        echo json_encode($ret);
    }
    /**
     * 获取某个用户发的tile
     * @return [type] [description]
     */
    public function userTileAction(){
        $watchuser = $_POST['watch_user'];
        $fromuser = $_POST['from_user'];
        $offset = $_POST['offset'];
        $limit = $_POST['limit'];
        $tileModel = new TileModel('tile');
        $ret = $tileModel->getUserTile([$fromuser, $watchuser],$offset,$limit);
        echo json_encode($ret);
    }
    /**
     * 更新用户star后的动作
     * @return [type] [description]
     */
    public function updThumbAction(){
        $tileid = $_POST['tile_id'];
        $userid = $_POST['user_id'];
        $status = $_POST['status'];

        $thumbModel = new ThumbModel('thumb');
        $tileModel = new TileModel('tile');

        $hasThumb = !empty($thumbModel->checkThumb([$tileid, $userid]));
        if(!$hasThumb && $status==1){
            $tileModel->updateStar([$tileid], 1);
            $thumbModel->addThumbRecord([$tileid, $userid]);
        }else if($hasThumb && $status == 0){
            $tileModel->updateStar([$tileid], -1);
            $thumbModel->deleteThumbRecord([$tileid, $userid]);
        }


    }
}
