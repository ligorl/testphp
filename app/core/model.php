<?php

        
class Model extends ConectDB
 
{
   
    public function getDBConnect(){
        return $this->db;
    }
    public function setDBConnect($link){
        $this->db = $link;
    }
   

}