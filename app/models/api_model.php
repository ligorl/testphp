<?php

class Api_model extends Model {

    public function __construct($link) {

        $this->setDBConnect($link);
    }

    function getCity($regionId) {
        $result['city'] = [];
        $res = mysqli_query($this->getDBConnect(),"SELECT * FROM t_koatuu_tree WHERE ter_type_id=1 AND ter_pid=$regionId");
        if (!$res) {
            die('Неверный запрос: ' . mysqli_error($this->getDBConnect()));
            return null;
        }

        while ($row = mysqli_fetch_assoc($res)) {
            $result['city'][] = $row;
        }

        return $result;
    }

    function getDistrict($cityId) {
        $result['district'] = [];
        $res = mysqli_query($this->getDBConnect(),"SELECT * FROM t_koatuu_tree WHERE (ter_type_id >=2) AND ter_pid=$cityId");
        if (!$res) {
            die('Неверный запрос: ' . mysqli_error($this->getDBConnect()));
            return null;
        }

        while ($row = mysqli_fetch_assoc($res)) {
            $result['district'][] = $row;
        }

        return $result;
    }


    function setForm($form){

        $res1 = mysqli_query($this->getDBConnect(),"SELECT * FROM user WHERE email='".mysqli_real_escape_string($this->getDBConnect(),$form['email'])."'");
        $row = mysqli_fetch_assoc($res1);
        if(!empty($row)){
           return ['answer'=>"old",'data'=> $row];
        }

        $res = mysqli_query($this->getDBConnect(), "INSERT INTO user (fio,email,district) VALUES (" .
            "'".mysqli_real_escape_string($this->getDBConnect(),$form['fio'])."','"
            .mysqli_real_escape_string($this->getDBConnect(),$form['email']) ."','"
            .mysqli_real_escape_string($this->getDBConnect(),$form['district']). "')");
        if (!$res) {
            die('Неверный запрос: ' . mysqli_error($this->getDBConnect()));
            return null;
        }
        $res2 = mysqli_query($this->getDBConnect(),"SELECT * FROM user WHERE id=".mysqli_insert_id($this->getDBConnect()));
        return ['answer'=>"new",'data'=>mysqli_fetch_assoc($res2)];
    }

    function getRegionCity($districtId){

        $res = mysqli_query($this->getDBConnect(),"(SELECT ter_pid FROM t_koatuu_tree WHERE ter_id=$districtId)");
        if (!$res) {
            die('Неверный запрос: ' . mysqli_error($this->getDBConnect()));
            return null;
        }
        $row = mysqli_fetch_assoc($res);
        $result = $row['ter_pid'];

        return $result;
    }
}
