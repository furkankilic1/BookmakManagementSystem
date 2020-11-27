<?php

function addMessage($msg) {
    $_SESSION["message"] = $msg ;
}

function displayMessage() {
    if (isset($_SESSION["message"])) {
        echo "<script> M.toast({html: '{$_SESSION["message"]}', classes: 'rounded'});</script>" ;
        unset($_SESSION["message"]) ;
    }
}

function authenticated() {
    return isset($_SESSION["user"]) ;
}
