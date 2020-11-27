<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "db.php";


    // start check part
    if (!isset($_FILES["profile"]) || $_FILES["profile"]["error"] != 0) {
        $invalid = "No File";
    } else {

        $filename = $_FILES["profile"]["name"];
        $bytes = $_FILES["profile"]["size"];
        $tmp_file = $_FILES["profile"]["tmp_name"];

        // Make sure that it is an image file.
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $whitelist = ["gif", "jpg", "png", "jpeg", "bmp"];
        if (!in_array($extension, $whitelist)) {
            $invalid = "extension error";
        }

        // Proper filename
        if (!preg_match("/^[\w.]+$/u", $filename)) {
            $invalid = "filename invalid";
        }

        // Check size, limited by 1Mb
        if ($bytes > 1024 * 1024) {
            $invalid = "size error";
        }

        // the orginal name is decorated by a string which is not easily guessed.
        // sha1 (20bytes) 40 hex characters
        $profile = sha1("ctis2020" . uniqid()) . "_" . $filename;

        if (!isset($invalid) && move_uploaded_file($tmp_file, "upload/$profile")) {
            $success = true;
        }
    }
    // end check part

    $id = $_GET["id"];

    try {
        if ( isset($success)) {
            extract($_POST) ;
            $sql = "update user set name=?, email=?, password=?, profile=? where id = ?" ;
            $stmt = $db->prepare($sql);
            $hash_password = password_hash($password, PASSWORD_DEFAULT) ;
            $stmt->execute([$name, $email, $hash_password, $profile, $id]);
            $_SESSION["user"]["profile"] = $profile;
            $_SESSION["user"]["name"] = $name;
            addMessage("Edit Successful!");
            header("Location: ?page=main") ;
            exit ;
        }
    } catch (PDOException $ex) {
        addMessage("Edit Failed!");
        header("Location: ?page=profile");
        exit;
    }
}
