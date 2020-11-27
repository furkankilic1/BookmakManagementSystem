<?php

      require "db.php" ;
      header("Content-Type: application/json") ;
      
      $data = 0;
      if ( $_SERVER["REQUEST_METHOD"] == "GET") {
          extract($_GET) ;
          if(isset($isseen)){
            $sql = "update share set seen = 1 where receiver_id = ? and seen = 0" ;
            try{
                $stmt = $db->prepare($sql) ;
                $stmt->execute([$userid ?? ""]) ;
                $data = $stmt->rowCount();
            }catch(PDOException $ex) {
                $data = "error";
            }
          }else{
            $sql = "select * from share where receiver_id = ? and seen = 0" ;
            try{
                $stmt = $db->prepare($sql) ;
                $stmt->execute([$userid ?? ""]) ;
                $data = $stmt->rowCount();
            }catch(PDOException $ex) {
            }
            
          }
          echo json_encode($data) ;
      }

      
      