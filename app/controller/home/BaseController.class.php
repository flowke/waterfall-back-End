<?php

/**
 *
 */
class BaseController extends Controller{
    /**
     * 验证用户
     * @return [type] [description]
     */
    public function checkLogin(){
        // 判断session
        if( !isset($_SESSION['user']) ){
            return false ;
        }else{
            return true;
        }
    }
}
