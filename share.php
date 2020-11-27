<?php
require "db.php" ;
//var_dump($_POST);
if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST) ;
    
    $sql = "insert into share (bookmarkid, sender_id, receiver_id) values (?,?,?)" ;
    try{
      $stmt = $db->prepare($sql) ;
      $stmt->execute([$bmId ,$_SESSION["user"]["id"], $selectUser]) ;
      addMessage("Share Success") ;
    }catch(PDOException $ex) {
       addMessage("Bookmark Already Shared!") ;
    }
}

header("Location: index.php?page=main") ;
?>
