<?php

    class theHelperClass{
        
        private $sqlGetImage = "bla bla";
        private $sqlGetName = "bla bla";
        private $sqlGetSurname = "bla bla";
        
         public function __construct(){
         }
        
         public function randomPassword() {
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
             
             $pass = array();
             
            for($i = 0; $i < 6; $i++) {
                $n = rand(0, 61);
                $pass[$i] = $alphabet[$n];
            }
            $result = implode("",$pass);
            return $result;
        }
        
    }

?>