<?php
require "db.php" ;
//var_dump($_POST);
if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST) ;

    try{
        $sql = "update bookmark set title=?, category=?, url=?, note=? where id = ?" ;
        $stmt = $db->prepare($sql);
        $stmt->execute([$edittitle, $editcategory ,$editurl, $editnote, $bookid]);
        addMessage("Edit Success") ;
        header("Location: index.php?page=main") ;
        
    }catch(PDOException $ex) {
        addMessage("Edit Failed!") ;
        header("Location: index.php?page=main") ;
    }
    
}
