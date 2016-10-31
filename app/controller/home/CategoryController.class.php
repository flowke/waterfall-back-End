<?php

/**
 *
 */
class CategoryController extends BaseController{
    public function getCategoryAction(){
        $categoryModel = new CategoryModel('category');
        $ret = $categoryModel->getCategory();
        echo json_encode($ret);
    }
}
