<?php
class View

{
    public $data; 
    function setData($data =  NULL){
        $this->data=$data;
    }
    function doTemplate($template=""){
        global $config;        
        $data=$this->data;
        
        $do_url=$_SERVER['DOCUMENT_ROOT']."/".$config['base_url'];
        $do_url=trim($do_url,"/");
        $do_url=$do_url."/template/";
        



        if($template){
            include $do_url.$template;
        }else{
            include $do_url."index.html";
        }
        
    }
}