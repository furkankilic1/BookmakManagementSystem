<?php
require "db.php" ;
//var_dump($_POST);
$stmt = "";
if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST) ;
    $sql = "delete from categories where categoryname = ?" ;
    try{
      $flag = 0;
      $stmt = $db->prepare($sql) ;
      $stmt->execute([$deletecategory ?? ""]) ;
      addMessage("Delete Category Success") ;
      $flag = 1;
    }catch(PDOException $ex) {
       addMessage("Deletion Failed!") ;
    }
}

if($flag == 1){
    try{
        $sqlnew = "update bookmark set category = NULL where category like ? " ;
        $stmtnew = $db->prepare($sqlnew);
        $stmtnew->execute([$deletecategory ?? ""]);
        addMessage("Edit Success!") ;

    }catch(PDOException $exx) {
        addMessage("Edit Failed!") ;
    }
}
header("Location: index.php?page=main") ;