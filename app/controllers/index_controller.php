<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author igor
 */
class Index_controller extends Controller {

    function __construct($link) {
        $this->view = new Index_view();
        $this->model = new Index_model($link);
    }
    function action_index() {
        $region = $this->model->getRegion();
        $this->view->setData($region);
        $this->view->doTemplate("index.html");
    }


}
