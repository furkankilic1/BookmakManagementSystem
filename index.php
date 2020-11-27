<?php
  session_start() ; 

  require "helper.php" ;

  // Simple Routing Table
  $pageGuest = ["home", "login", "loginForm", "register", "registerForm"] ;
  $pageAuth = [
      "html" => ["main", "profile", "search", "sharedbm"],
      "webservice" => ["delete", "notification", "addBM", "editBM", "logout", "editUser", "addCat", "delCat","share","navbar", "addSharedBM"]
  ] ;

  $pageAll = array_merge($pageGuest, $pageAuth["html"], $pageAuth["webservice"]) ;
  
  // default page is home
  $page = $_GET["page"] ?? "home" ;

  // authenticated users can access only authenticated and WebServices pages
  if ( authenticated() && !(in_array($page, $pageAuth["html"]) || in_array($page, $pageAuth["webservice"]))) {
      $page = "main" ;
  }

  // unauthenticated users can access only Guest pages
  if (!authenticated() && !in_array($page, $pageGuest)) {
      $page = "loginForm" ;
  }

  // Web Services Routing. 
  if (in_array($page, $pageAuth["webservice"])) {
      header("Content-Type: application/json") ;
      require "$page.php" ;  // call web service
      exit ;
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title>Bookmark Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
    
?>
    <?php require "navbar.php" ; ?>
    <?php
       require "$page.php" ;  // Load appropriate module.

       // display if there is any toast message
       displayMessage() ;
   ?>

</body>
</html>