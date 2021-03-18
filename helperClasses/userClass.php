<?php

     class user{
        public $userID;
        public $name;
        public $surname;
        public $email;
        public $kasi;
        public $numberPhone;
        public $gender;
        public $province;
        public $age;
        public $address;
        public $postalCode;
        public $password;
        public $profilePic;
        public $myFriendsIds;
        public $postIdYouCanView;
        public $notificationIds;
        
        private $connection;
        
    public function __construct(){
         $this->connectToServer();
     }
        
    private function connectToServer(){
         $this->connection = mysqli_connect('localhost','root','');

            mysqli_select_db($this->connection,'fedekasiconnect');
    }
        
    public function init($sessionId){
       if(!empty($sessionId)){
           $sql = "SELECT * FROM `user` WHERE `ID` LIKE '$sessionId'";
           $results = mysqli_query($this->connection,$sql);
           $assArr = mysqli_fetch_assoc($results);
           $this->userID = $assArr['ID'];
           $this->name = $assArr['NAME'];
           $this->surname = $assArr['SURNAME'];
           $this->email = $assArr['EMAIL'];
           $this->kasi = $assArr['KASI'];
           $this->numberPhone = $assArr['NUMBERPHONE'];
           $this->gender = $assArr['GENDER'];
           $this->province = $assArr['PROVINCE'];
           $this->age = $assArr['AGE'];
           $this->address = $assArr['ADDRESS'];
           $this->postalCode = $assArr['POSTALCODE'];
           $this->password = $assArr['PASSWORD'];
           $this->profilePic = $assArr['PROFILEPIC'];
           $this->myFriendsIds = $assArr['MYFRIENDSIDS'];
           $this->postIdYouCanView = $assArr['POSTIDYOUCANVIEW'];
           $this->notificationIds = $assArr['NOTIFICATIONIDS'];
              
       }
        
    }
   
    public function __destruct(){
                mysqli_close($this->connection) or die("couldnt disconnect to database 1070");
        }
        
    }

?>