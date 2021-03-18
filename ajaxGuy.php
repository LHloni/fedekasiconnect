<?php


class ajaxGuy{
     public $connection;
        
    public function __construct(){
            $this->connectToServer();
        }
        
    private function connectToServer(){
         $this->connection = mysqli_connect('localhost','root','');

            mysqli_select_db($this->connection,'fedekasiconnect');
        }
    
    public function updateImportant(){
        if(isset($_POST['impt']) && $_POST['impt'] == 'set1'){
            
          //  $idOfWhoPosted =  $_POST['IOWP']; 
            $IdOfPost = $_POST['IOP'];
            $idOfUser =  $_POST['IOU']; 
            
            $update = true;
            $update = $this->userAlreadyExists($IdOfPost,$idOfUser,"DO_ONCE_IMPT");
            
            if($update){
      
                 $IdOfPost = $_POST['IOP'];
                $idOfUser =  $_POST['IOU'];
                
                $newLikes = $this->updateTable($IdOfPost,$idOfUser,"DO_ONCE_IMPT","IMPORTANT");
                
                $otherlike = $this->removeUpdate($IdOfPost,$idOfUser,"DO_ONCE_NTIMPT","NOT_IMPORTANT");
                
                 if(empty($newLikes)){
                    $newLikes = 0;
                }elseif(empty($otherlike)){
                    $otherlike = 0;
                }
           
                $string = array("one"=>$newLikes,"two"=>$otherlike);
                //echo $newLikes.' '.$otherlike;
                echo json_encode($string);
            
            }
            else{
                  $IdOfPost = $_POST['IOP'];

                $newLikes = $this->degradetable($IdOfPost,$idOfUser,"DO_ONCE_IMPT","IMPORTANT");
                
                 $otherlike = $this->doNotUpdateTable($IdOfPost,"NOT_IMPORTANT");
                
                 if(empty($newLikes)){
                    $newLikes = 0;
                }elseif(empty($otherlike)){
                    $otherlike = 0;
                }
                 
               $string = array("one"=>$newLikes,"two"=>$otherlike);
                //echo $newLikes.' '.$otherlike;
                echo json_encode($string);
                
            }
            
        }
    }
        
    public function removeUpdate($IdOfPost,$idOfUser,$IorN,$table){
         $sql = "SELECT `$IorN` FROM `posts` WHERE `ID` LIKE '$IdOfPost'";
            
             $results = mysqli_query($this->connection,$sql) or die("couldnt send request 72");
            
            $assArr = mysqli_fetch_assoc($results);
            
            $arrOfInt = explode(",",$assArr[$IorN]);
        
            $newUsers = array();
            $i = 0;
            $updateTableIfUserFound = false;
        $newLikes;
            foreach($arrOfInt as $x){
                
                if($x == $idOfUser){
                   $sql = "SELECT `$table` FROM `posts` WHERE `ID` LIKE '$IdOfPost'";

                    $results = mysqli_query($this->connection,$sql) or die("couldnt send request 87");

                    $assArr = mysqli_fetch_assoc($results);
                    $stringResults = $assArr[$table];

                    if(!empty($stringResults)){
                       $newLikes = intval($stringResults) - 1; 
                    }else{
                        $newLikes = 0;
                    }
                    
                    if($newLikes >= 0){
                        $sql1 = "UPDATE `posts` SET `$table`='$newLikes' WHERE `ID` LIKE '$IdOfPost'";
                    
                    mysqli_query($this->connection,$sql1) or die("couldnt send request 101");
                    }
                     $updateTableIfUserFound = true;
                }else{
                    $newUsers[$i] = $x;
                    $i++;
                }
            }
        
        
        if($updateTableIfUserFound){
             $newUser2 = implode(",",$newUsers);
        
          $sql1 = "UPDATE `posts` SET `$IorN`='$newUser2' WHERE `ID` LIKE '$IdOfPost'";
                    
                    mysqli_query($this->connection,$sql1) or die("couldnt send request 116");
            
            return $newLikes;
        }else{
                 $newUser2 = implode(",",$newUsers);
        
          $sql1 = "UPDATE `posts` SET `$IorN`='$newUser2' WHERE `ID` LIKE '$IdOfPost'";
                    
                    mysqli_query($this->connection,$sql1) or die("couldnt send request 124");
        }
           
        
    
    }
    
     public function updateNotImportant(){
        if(isset($_POST['ntimpt']) && $_POST['ntimpt'] == 'set2'){
            
               //  $idOfWhoPosted =  $_POST['IOWP']; 
            $IdOfPost = $_POST['IOP'];
            $idOfUser =  $_POST['IOU']; 
            
            $update = true;
            $update = $this->userAlreadyExists($IdOfPost,$idOfUser,"DO_ONCE_NTIMPT");
            
            if($update){
                
                $IdOfPost = $_POST['IOP'];
                $idOfUser =  $_POST['IOU'];
                
                $newLikes = $this->updateTable($IdOfPost,$idOfUser,"DO_ONCE_NTIMPT","NOT_IMPORTANT");

                  $otherlike = $this->removeUpdate($IdOfPost,$idOfUser,"DO_ONCE_IMPT","IMPORTANT");
                
                 if(empty($newLikes)){
                    $newLikes = 0;
                }elseif(empty($otherlike)){
                    $otherlike = 0;
                }
                
                 $string = array("one"=>$newLikes,"two"=>$otherlike);
                //echo $newLikes.' '.$otherlike;
                echo json_encode($string);
            }
            else{
                  $IdOfPost = $_POST['IOP'];
                
                $newLikes = $this->degradetable($IdOfPost,$idOfUser,"DO_ONCE_NTIMPT","NOT_IMPORTANT");
                
                $otherlike = $this->doNotUpdateTable($IdOfPost,"IMPORTANT");
                
                if(empty($newLikes)){
                    $newLikes = 0;
                }elseif(empty($otherlike)){
                    $otherlike = 0;
                }
                
                 $string = array("one"=>$newLikes,"two"=>$otherlike);
                //echo $newLikes.' '.$otherlike;
                echo json_encode($string);
            }
        }
    }
    
     public function userAlreadyExists($IdOfPost,$idOfUser,$IorN){
         $sql = "SELECT `$IorN` FROM `posts` WHERE `ID` LIKE '$IdOfPost'";
            
             $results = mysqli_query($this->connection,$sql) or die("couldnt send request 183");
            
            $assArr = mysqli_fetch_assoc($results);
            
            $arrOfInt = explode(",",$assArr[$IorN]);
            
            $ansa = true;
        
            foreach($arrOfInt as $x){
                if($x == $idOfUser){
                   $ansa = false;
                }
            }
        
        return $ansa;
    }
    
     public function updateTable($IdOfPost,$idOfUser,$IorN,$table){
             

            $sql = "SELECT `$table` FROM `posts` WHERE `ID` LIKE '$IdOfPost'";
            
            $results = mysqli_query($this->connection,$sql) or die("couldnt send request 205");
            
            $assArr = mysqli_fetch_assoc($results);
            $stringResults = $assArr[$table];
            
            $newLikes = intval($stringResults) + 1;
            
            $sql2 = "UPDATE `posts` SET `$table`='$newLikes' WHERE `ID` LIKE '$IdOfPost'";
            
            mysqli_query($this->connection,$sql2) or die("couldnt send request 214");
                
                //add user to the list off people who already liked page
            
            $sql = "SELECT `$IorN` FROM `posts` WHERE `ID` LIKE '$IdOfPost'";
            
             $results = mysqli_query($this->connection,$sql) or die("couldnt send request 220");
            
            $assArr = mysqli_fetch_assoc($results);
            
            $tempVar = $assArr[$IorN];
               
                 if(empty($tempVar)){
                   $updatedList = $idOfUser;
               }else{
                   $updatedList = $tempVar.','.$idOfUser;
               }
                
                $sql3 = "UPDATE `posts` SET `$IorN`='$updatedList' WHERE `ID` LIKE '$IdOfPost'";
            
            mysqli_query($this->connection,$sql3) or die("couldnt send request 234");
        
        return $newLikes;
    }
    
    public function degradetable($IdOfPost,$idOfUser,$IorN,$table){
             

            $sql = "SELECT `$table` FROM `posts` WHERE `ID` LIKE '$IdOfPost'";
            
            $results = mysqli_query($this->connection,$sql) or die("couldnt send request 244");
            
            $assArr = mysqli_fetch_assoc($results);
            $stringResults = $assArr[$table];
            
            $newLikes = intval($stringResults) -1 ;
            
            $sql2 = "UPDATE `posts` SET `$table`='$newLikes' WHERE `ID` LIKE '$IdOfPost'";
            
            mysqli_query($this->connection,$sql2) or die("couldnt send request");
                
                //remove user to the list off people who already liked page
            
            $sql = "SELECT `$IorN` FROM `posts` WHERE `ID` LIKE '$IdOfPost'";
            
             $results = mysqli_query($this->connection,$sql) or die("couldnt send request 259");
            
            $assArr = mysqli_fetch_assoc($results);
            
            $tempVar = explode(",",$assArr[$IorN]);
        
            $tempList = array();
            $i = 0;
        //remove the existing user
            foreach($tempVar as $x){
                if($x == $idOfUser){
                    
                }else{
                    $tempList[$i] = $x;
                    $i++;
                }
            }
        //update list
        // foreach($tempList as $y){
            //     $updatedList = $y;
    
           // }
        $updatedList= implode(",",$tempList);
        
             $sql3 = "UPDATE `posts` SET `$IorN`='$updatedList' WHERE `ID` LIKE '$IdOfPost'";
            
            mysqli_query($this->connection,$sql3) or die("couldnt send request 285");
        
        return $newLikes;
    }
    
    public function doNotUpdateTable($IdOfPost,$table){
         $sql = "SELECT `$table` FROM `posts` WHERE `ID` LIKE '$IdOfPost'";

                $results = mysqli_query($this->connection,$sql) or die("couldnt send request 293");

                $assArr = mysqli_fetch_assoc($results);
                $stringResults = $assArr[$table];
                return intval($stringResults);
    }
    
    public function setpostSesssion(){
        if(isset($_POST['cmmt']) && $_POST['cmmt'] == 'set3'){
             session_start();
            $tempVar = $_POST['ID_POST'];
            $idOfWhoPosted = $_POST['IOWP'];
            
            echo $tempVar;
            echo $idOfWhoPosted;
            
            $_SESSION['TEMP_ID_POST'] = $tempVar;
            $_SESSION['TEMP_OF_WHO_ID_POST'] = $idOfWhoPosted;
            
        }
    }
    
    public function setchatSesssion(){
        if(isset($_POST['cht']) && $_POST['cht'] == 'set4'){
             session_start();
            $idOfChat = $_POST['ID_CHAT'];
        
            $_SESSION['TEMP_CHAT_ID'] = $idOfChat;
        
        }
    }
    
    public function deletePost(){
           if(isset($_POST['del']) && $_POST['del'] == 'set7'){
           $idOfPost = $_POST['IOP'];
                $sql = "DELETE FROM `posts` WHERE `ID` LIKE '$idOfPost'";
                
                mysqli_query($this->connection,$sql) or die("couldnt send query 330");
                
        }
    }
        
    public function getPostInformation(){
           if(isset($_POST['edit']) && $_POST['edit'] == 'set6'){
           $idOfPost = $_POST['IOP'];
                $sql = "SELECT  `DESCRIPTION`, `PICTURE`,`CATEGORY`,`PRICE`,`LOCATION` FROM `posts` WHERE `ID` LIKE '$idOfPost'";
                
                $results = mysqli_query($this->connection,$sql) or die("couldnt send query 340");
               
               $assArr = mysqli_fetch_assoc($results) or die('couldnt get array 342');
               echo json_encode($assArr);
                
        }
    }
    
    public function shareTo(){
            
            if(isset($_POST['share']) && $_POST['share'] == 'set8'){
                
                if(!empty($_POST['NUMBERPHONEorEMAIL'])){
                    
                    $IdOfPost = $_POST['ID_POST'];
                    $idOfUser =  $_POST['IOU'];
                    $emailOrNumber = $_POST['NUMBERPHONEorEMAIL'];
                    
                    //notifi the user who posted that you commenting on thier post
                  
                  $sql2 = "SELECT `ID` FROM `user` WHERE `EMAIL` LIKE '$emailOrNumber'";
                  

                $results2 = mysqli_query($this->connection,$sql2) or die("couldnt send query 364");
                  
                  $assArr2 = mysqli_fetch_assoc($results2);
                  
                  
                  $userIdToNotifi = $assArr2['ID'];
                    ////////
                    
                    $userID = $idOfUser;
                    // post,who,what
                    
                    $commentOrShare = "s";
            
                    $sql1 = "SELECT `NOTIFICATIONIDS`FROM `user` WHERE `ID` LIKE '$userIdToNotifi'";
            
                    $results = mysqli_query($this->connection,$sql1) or die("couldnt send query 379");
            
                    $assArr = mysqli_fetch_assoc($results);
                    
                    $notifiString  = $assArr['NOTIFICATIONIDS'];
                   
                    if(strtolower($commentOrShare) == "c"){
                        if(empty($notifiString)){
                             $newNotification = $IdOfPost.".".$userID."."."c";
                        }else{
                           $newNotification = $notifiString.",".$IdOfPost.".".$userID."."."c"; 
                        }
                          
                    }elseif(strtolower($commentOrShare) == "s"){
                         if(empty($notifiString)){
                             $newNotification = $IdOfPost.".".$userID."."."s";
                        }else{
                           $newNotification = $notifiString.",".$IdOfPost.".".$userID."."."s";
                        }
                        
                    }
            
                    $sql = "UPDATE `user` SET `NOTIFICATIONIDS`='$newNotification' WHERE `ID` LIKE '$userIdToNotifi'";
            
                    mysqli_query($this->connection,$sql) or die("couldnt send query 405");
                    
                }
                
            }
            
        }
    
    public function logout(){
        
           if(isset($_POST['logout']) && $_POST['logout'] == 'set5'){
                   session_start();
                   session_unset($_SESSION['USER_ID']);
               }
        }
}

$theGuy = new ajaxGuy;

$theGuy->updateImportant();

$theGuy->updateNotImportant();

$theGuy->setpostSesssion();

$theGuy->setchatSesssion();
  
$theGuy->getPostInformation();
    
$theGuy->deletePost();

$theGuy->shareTo();

$theGuy->logout();
    
?>