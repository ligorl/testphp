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
class Api_controller extends Controller {

    function __construct($link) {
        $this->view = new Api_view();
        $this->model = new Api_model($link);
    }
    function action_city() {
        if(isset($_REQUEST['regionId']) && $_REQUEST['regionId']){
            $regionId = $_REQUEST['regionId'];
            $city = $this->model->getCity($regionId);
            echo json_encode(['answer'=>"ok",'data'=>$city]);
        }else{
            echo json_encode(['answer'=>"error"]);
        }

    }
    function action_district() {
        if(isset($_REQUEST['cityId']) && $_REQUEST['cityId']){
            $cityId = $_REQUEST['cityId'];
            $district = $this->model->getDistrict($cityId);
             echo json_encode(['answer'=>"ok",'data'=>$district]);

        }else{
            echo json_encode(['answer'=>"error"]);
        }


    }

    function action_form() {
        if(isset($_POST['fio'])
            && isset($_POST['email'])
            && isset($_POST['region'])
            && isset($_POST['city'])
            ){
            $form = $this->model->setForm($_POST);
            $cityId=$this->model->getRegionCity($form['data']['district']);
            $regionId=$this->model->getRegionCity($cityId);

            echo json_encode([
                'answer'=>"ok",
                'data'=>$form,
                'cityId'=>$cityId,
                'regionId'=>$regionId
            ]);

        }else{
            echo json_encode(['answer'=>"error"]);
        }


    }


}
