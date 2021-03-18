<?php

    class chats{
        
        public $connection;
        
        public function __construct(){
            $this->connectToServer();
        }
        
        private function connectToServer(){
         $this->connection = mysqli_connect('localhost','root','');

            mysqli_select_db($this->connection,'fedekasiconnect');
        }
        
        public function startConversation($userId){
        if(isset($_POST['SUBMIT_POST'])){
                
            if(!empty($_POST['SEND_TO']) && !empty($_POST['MESSAGE'])){
                    $seconduser = $_POST['SEND_TO'];
                
                    $sql1 = "SELECT `ID` FROM `user` WHERE `EMAIL` LIKE '$seconduser' OR `NUMBERPHONE` LIKE '$seconduser' ";
                    $friendId = "";
                    if($results = mysqli_query($this->connection,$sql1)){
                        $assArr = mysqli_fetch_assoc($results);
                        $friendId = $assArr['ID'];
                        
                    }else{
                        die("stop right there 862");
                    }
                
                    $message = $_POST['MESSAGE'];
                    
                    $messageFormat = $userId.'.'.'"'.$message.'"'.',';    
                
                    $sql = "INSERT INTO `chats`(`ID`, `ID_1`, `ID_2`, `MESSAGES`) VALUES (null,'$userId','$friendId','$messageFormat')";
                
                mysqli_query($this->connection,$sql) or die("couldn't send query 871");
                }
            }
        }
        
        public function messages($chatId){
            
            $sql = "SELECT `MESSAGES` FROM `chats` WHERE `ID` LIKE '$chatId'";
            
            $results = mysqli_query($this->connection,$sql) or die("couldnt send query 880");
            
            $assArr = mysqli_fetch_assoc($results);
            
            
             $arrOfMessages = explode(",",$assArr['MESSAGES']);
            
            //array of results
            $i = 0;
            $arrOfResults = array();
            
            if(!empty($arrOfMessages)){
                     foreach($arrOfMessages as $x){
                if(!empty($x)){
                       $arrIdAndMessage = explode(".",$x);
              //remove  this ->" before in and after the string/comment
                $sql1 = "SELECT `NAME`, `SURNAME` FROM `user` WHERE `ID` LIKE '$arrIdAndMessage[0]'";
                
                $results = mysqli_query($this->connection,$sql1);

                $assArr2 = mysqli_fetch_assoc($results);
                $name = $assArr2['NAME'];
                $surname = $assArr2['SURNAME'];
                $message = $arrIdAndMessage[1];
                
                $arrOfResults[$i] = $name.','.$surname.','.$message;
                $i++;
                }
              
            } 
        
            return $arrOfResults;
            }  
          
        }
        
        public function sendMessage($chatId,$userId){
                //if the nigga wanna send message
            if(isset($_POST['SUBMIT_CHAT'])){
                
              if(!empty($_POST['MESSAGE'])){
                 $message = $_POST['MESSAGE']; 
                   $sql1 = "SELECT `MESSAGES` FROM `chats` WHERE `ID` LIKE '$chatId'";
                  

                $results = mysqli_query($this->connection,$sql1);

                $assArr = mysqli_fetch_assoc($results);
                  
                  $userMessage = $userId.'.'.'"'.$message.'"'.',';
                  
                  $newMessages = $assArr['MESSAGES'].$userMessage;
                  
                  $sql = "UPDATE `chats` SET `MESSAGES`='$newMessages'WHERE `ID` LIKE '$chatId'";
                  
                  mysqli_query($this->connection,$sql) or die("couldnt send query 935");
                  
                  //empty out
                 // header('Location: homepage.php');
              }  
            }
            
        }
        
        public function myContacts($userId){
            
            $sql = "SELECT `ID`,`ID_1`, `ID_2` FROM `chats` WHERE `ID_1` LIKE '$userId' OR  `ID_2` LIKE '$userId'";
            
            $results = mysqli_query($this->connection,$sql);
            
            $arrOfIds = array();
            $idOfPostAndUser = array();
            $i = 0;
            
            while($assArr = mysqli_fetch_assoc($results)){
               $arrOfIds[$i] = $assArr['ID'];
                
                if($userId != $assArr['ID_1']){
                   $idOfPostAndUser[$i] = $assArr['ID_1'].','.$arrOfIds[$i]; 
                }elseif($userId != $assArr['ID_2']){
                   $idOfPostAndUser[$i] = $assArr['ID_2'].','.$arrOfIds[$i]; 
                }
            
                $i++;
            }
              
            $arrOfresults = array();
            $j = 0;
            if(!empty($idOfPostAndUser)){
                foreach($idOfPostAndUser as $r){
                $y = explode(",",$r);
                $idOfUser = $y[0];
                $idOfPost = $y[1];

                $sql1 = "SELECT `NAME`, `SURNAME`,`PROFILEPIC` FROM `user` WHERE `ID` LIKE '$idOfUser'";

                $results = mysqli_query($this->connection,$sql1);

                $assArr = mysqli_fetch_assoc($results) or die("couldnt send query 978");

                $name = $assArr['NAME'];
                $surname = $assArr['SURNAME'];
                $picName = $assArr['PROFILEPIC'];
                $arrOfresults[$j] = $idOfPost.','.$name.','.$surname.','.$picName;
                $j++;

            }
                return $arrOfresults;
            }else{
                return null;
            }
          
        }
        
        public function __destruct(){
             if($this->connection != null){
                 mysqli_close($this->connection) or die("couldnt disconnect to database 996");
             }      
        }
    }

?>