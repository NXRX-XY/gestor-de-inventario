<?php
    //Define variables into of form
    $name = $lastname = $email = $gender = $password = "";
    //Insert PHP Superglobal
    if ($_SERVER ["REQUEST_METHOD"] == "POST") {
        $name = test_input($_POST["name"]);
        $lastname = test_input($_POST["lastname"]);
        $email = test_input($_POST["email"]);
        $gender = test_input($_POST["gender"]);
        $password = test_input($_POST["password"]);
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
?>


