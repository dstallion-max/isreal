<?php

declare (strict_types= 1);


function homework(string $fullname, string $email, string $password, $confirm_password){
if ( !empty($fullname) && !empty($email) && !empty($password) && !empty($confirm_password)){

    if($password > 5){
        if ( $password === $confirm_password){
            $result = "Login successful. Welcome, $fullname. your email is $email.";
    }else{
        $result = "password and confirm password does not match";
    }
    
}else{
    $result = "password must be greater tham 5";
}
}else {
    $result = "All input are required";
}
return $result;
}

if ($_SERVER ["REQUEST_METHOD"] == "POST"){
    
    $fullname = $_POST[ "fullname"];
    $email = $_POST ["email"];
    $password = $_POST ["password"];
    $confirm_password = $_POST ["confirm_password"];


    $result = homework($fullname, $email, $password, $confirm_password);
    echo $result;
        } else{
            echo "request method is invalid";
        }


// declare(strict_types=1);

// function homework(string $fullname, string $email, string $password, string $confirm_password): string {
//     if (!empty($fullname) && !empty($email) && !empty($password) && !empty($confirm_password)) {
//         if ($password === $confirm_password) {
//             $result = "Login successful. Welcome, $fullname. Your email is $email.";
//         } else {
//             $result = "Password and confirm password do not match.";
//         }
//     } else {
//         $result = "All input fields are required.";
//     }
    
//     return $result;
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $fullname = $_POST["fullname"];
//     $email = $_POST["email"];
//     $password = $_POST["password"];
//     $confirm_password = $_POST["confirm_password"];

//     $result = homework($fullname, $email, $password, $confirm_password);
//     echo $result;
// } else {
//     echo "Request method is invalid.";
// }







?>