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

        $filterType = $_POST['filterType'];
        $sortBy = $_POST['sortBy'] == 'TIME' ? 'tile.tile_time' :  'tile.tile_star';
        $order = $_POST['order'] == 'DESC' ? 'DESC' : $_POST['order'];

        $tileModel = new TileModel('tile');
        $ret = $tileModel->getTile([$fromuser], $filterType, $sortBy, $order, $offset,$limit);
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

        $filterType = $_POST['filterType'] == 0 ? 1 : "tile.category_id = {$_POST['filterType']}";
        $sortBy = $_POST['sortBy'] == 'TIME' ? 'tile.tile_time' :  'tile.tile_star';
        $order = $_POST['order'] == 'DESC' ? 'DESC' : $_POST['order'];


        $tileModel = new TileModel('tile');
        $ret = $tileModel->getUserTile([$fromuser, $watchuser], $filterType, $sortBy, $order,$offset,$limit);
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

    public function dropTileAction(){
        $tileid = $_GET['tileid'];

        $thumbModel = new ThumbModel('thumb');
        $tileModel = new TileModel('tile');
        $thumbModel->dropThumb([$tileid]);
        $ret = $tileModel->dropTile([$tileid]);

        if($ret == 0){
            echo json_encode(["message"=>1]);
        }else{
            echo json_encode(["message"=>0]);
        }

    }
}
