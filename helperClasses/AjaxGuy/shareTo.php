<?php

    require "connect.php";

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

?>