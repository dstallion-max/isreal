<?php

require 'vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "databaseConnection.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = mysqli_real_escape_string($conn, $_POST["fullname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $con_password = mysqli_real_escape_string($conn, $_POST["con_pass"]);

    // Check if all input fields are filled
    if (!empty($fullname) && !empty($email) && !empty($password) && !empty($con_password)) {

        // Check if passwords match
        if ($con_password === $password) {
            // Check if the email already exists
            $sql = mysqli_query($conn, "SELECT email FROM people WHERE email = '$email'");

            if (!$sql) {
                die('Error: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($sql) > 0) {
                echo "Email already exists";
            } else {
                $unique_id = bin2hex(random_bytes(10)); // Generate a unique ID
                $otp = mt_rand(1111, 9999); // Generate a random OTP
                $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password

                // Insert the user details into the database
                $insert = mysqli_query($conn, "INSERT INTO people (fullname, email, password, otp, unique_id) VALUES ('{$fullname}', '{$email}', '{$hashed_password}', '{$otp}', '{$unique_id}')");

                if (!$insert) {
                    die('Error: ' . mysqli_error($conn));
                }

                if ($insert) {
                    $mail = new PHPMailer(true);

                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com'; 
                        $mail->SMTPAuth = true;
                        $mail->Username = 'emekaisaacisreal@gmail.com'; // Replace with environment variable if possible
                        $mail->Password = 'yszvmhdiyrrujllc'; // Replace with environment variable if possible
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->setFrom('emekaisaacisreal@gmail.com', 'GEO SOLUTION');
                        $mail->addAddress($email, $fullname);
                        $mail->Subject = 'OTP Verification';
                        $mail->Body = 'Dear ' . $fullname . ', Your OTP code is: ' . $otp . '. Do not share it with anyone. If you did not request this code, please ignore this email.';

                        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Disable verbose debug output in production
                        $mail->send();
                        echo "Email has been sent";
                    } catch (Exception $e) {
                        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
                    }
                }
            }
        } else {
            echo "Passwords do not match";
        }
    } else {
        echo "All input fields are required";
    }
} else {
    echo "Invalid request method";
}
?>
