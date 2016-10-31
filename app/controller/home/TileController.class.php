<?php

class TileController extends BaseController{

    public function getTileAction(){
        $offset = $_POST['offset'];
        $limit = $_POST['limit'];
        $tileModel = new TileModel('tile');
        $ret = $tileModel->getTile($offset,$limit);
        echo json_encode($ret);
    }

}
