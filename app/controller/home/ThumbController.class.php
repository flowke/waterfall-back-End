<?php

class ThumbController extends BaseController{


    public function updateAction(){
        $userid = $_POST['user_id'];
        $tileid = $_POST['tile_id'];
        $status = $_POST['status'];

        $thumbModel = new ThumbModel('thumb');
        $ret = $thumbModel->updateThumb([$status, $userid, $tileid]);
    }

}
