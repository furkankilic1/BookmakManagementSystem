<?php
require "db.php" ;
//var_dump($_POST);
if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST) ;
    $sql = "insert into bookmark (title, category, url, note, owner) values (?,?,?,?,?)" ;
    try{
      $stmt = $db->prepare($sql) ;
      $stmt->execute([$title, $addcategory, $url, $note, $owner ?? ""]) ;
      addMessage("Success") ;
    }catch(PDOException $ex) {
       addMessage("Insert Failed!") ;
    }
}

header("Location: index.php?page=main") ;
?>
