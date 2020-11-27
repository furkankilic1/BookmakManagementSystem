<?php
require "db.php" ;
//var_dump($_POST);
if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST) ;
    $sql = "insert into categories (categoryname) values (?)" ;
    try{
      $stmt = $db->prepare($sql) ;
      $stmt->execute([$addnewcategory ?? ""]) ;
      addMessage("Success") ;
    }catch(PDOException $ex) {
       addMessage("Insert Failed!") ;
    }
}

header("Location: index.php?page=main") ;