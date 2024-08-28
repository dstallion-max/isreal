
<?php
declare(strict_types=1); // Enforce strict types

// Function to process and return the information
function processRegistration(string $fullname, string $email, string $password, string $confirm_password): string {
    if (!empty($fullname) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            return "Registration successful! Welcome, $fullname. Your email is $email.";
        } else {
            return "Error: Passwords do not match.";
        }
    } else {
        return "Error: All fields are required.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Call the function and display the result
    $result = processRegistration($fullname, $email, $password, $confirm_password);
    echo $result;
} else {
    echo "Invalid request method.";
}
?>




<!-- if($_SERVER["REQUEST_METHOD"] == "POST"){

$fistname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$password = $_POST["password"];
$con_password = $_POST["con_pass"];


if(!empty($fistname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($con_password)){
    if($con_password === $password){
        echo "success";
        
    }else{
        echo "Password does not match";
    }
}else{
    echo "All input fields are required";
}





}else{
echo "Request Method is Invalid";
} -->

