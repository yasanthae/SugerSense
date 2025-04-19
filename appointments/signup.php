<?php
//learn from w3schools.com
//Unset all the server side variables

session_start();

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

// Set the new timezone
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

$_SESSION["date"] = $date;

// Include PHPMailer directly
// Download these files from https://github.com/PHPMailer/PHPMailer/tree/master/src
// and place them in a folder called "PHPMailer" in your project
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Function to generate a random password
function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

// Function to send email using PHPMailer
function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com'; // Replace with your email
        $mail->Password = 'your_password'; // Replace with your password
        $mail->SMTPSecure = 'tls'; // or 'ssl'
        $mail->Port = 587; // or 465 for 'ssl'

        // Recipients
        $mail->setFrom('your_email@example.com', 'Appointment System');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log the error
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

// Handle form submission
if ($_POST) {
    // Check if this is a reset password request
    if (isset($_POST['reset_password']) && $_POST['reset_password'] == 1) {
        // Get the email from the form
        $email = $_POST['email'];
        
        // Here you would typically verify if the email exists in your database
        // For demonstration, we'll assume it exists
        
        // Generate a new password
        $newPassword = generateRandomPassword();
        
        // In a real application, you would update this password in your database
        // Example: UPDATE users SET password = md5($newPassword) WHERE email = $email;
        
        // Send the new password via email
        $subject = "Password Reset";
        $message = "
            <html>
            <head>
                <title>Password Reset</title>
            </head>
            <body>
                <h2>Password Reset</h2>
                <p>Your password has been reset. Your new password is: <strong>{$newPassword}</strong></p>
                <p>Please login and change your password immediately.</p>
            </body>
            </html>
        ";
        
        if (sendEmail($email, $subject, $message)) {
            $_SESSION['reset_message'] = "Password has been sent to your email.";
        } else {
            $_SESSION['reset_message'] = "Failed to send email. Please try again.";
        }
        
        // Redirect to login page
        header("location: /appointments/index.php");
        exit;
    }
    // Regular signup form submission
    else {
        $_SESSION["personal"] = array(
            'fname' => $_POST['fname'],
            'lname' => $_POST['lname'],
            'address' => $_POST['address'],
            'nic' => $_POST['nic'],
            'dob' => $_POST['dob'],
            'email' => $_POST['email'] // Make sure to add email field to your form
        );

        // Generate a password for the new user
        $password = generateRandomPassword();
        $_SESSION["temp_password"] = $password;
        
        // Send the password via email
        $to = $_POST['email'];
        $subject = "Your New Account";
        $message = "
            <html>
            <head>
                <title>Account Creation</title>
            </head>
            <body>
                <h2>Welcome to our Appointment System</h2>
                <p>Your account has been created. Here are your login details:</p>
                <p>Username: {$_POST['email']}</p>
                <p>Password: {$password}</p>
                <p>Please login and change your password for security purposes.</p>
            </body>
            </html>
        ";
        
        sendEmail($to, $subject, $message);
        
        // Redirect to create account page
        header("location: /appointments/create-account.php");
        exit;
    }
}

// Check if this is a reset password request page
$reset_mode = isset($_GET['reset']) && $_GET['reset'] == 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
        
    <title><?php echo $reset_mode ? 'Reset Password' : 'Sign Up'; ?></title>
</head>
<body>
    <center>
    <div class="container">
        <?php if ($reset_mode): ?>
            <!-- Password Reset Form -->
            <table border="0">
                <tr>
                    <td colspan="2">
                        <p class="header-text">Reset Password</p>
                        <p class="sub-text">Enter your email to receive a new password</p>
                    </td>
                </tr>
                <tr>
                    <form action="" method="POST">
                    <input type="hidden" name="reset_password" value="1">
                    <td class="label-td" colspan="2">
                        <label for="email" class="form-label">Email: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="email" name="email" class="input-text" placeholder="Email Address" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/appointments/index.php" class="login-btn btn-primary-soft btn">Back to Login</a>
                    </td>
                    <td>
                        <input type="submit" value="Reset Password" class="login-btn btn-primary btn">
                    </td>
                </tr>
                </form>
            </table>
        <?php else: ?>
            <!-- Sign Up Form -->
            <table border="0">
                <tr>
                    <td colspan="2">
                        <p class="header-text">Let's Get Started</p>
                        <p class="sub-text">Add Your Personal Details to Continue</p>
                    </td>
                </tr>
                <tr>
                    <form action="" method="POST">
                    <td class="label-td" colspan="2">
                        <label for="name" class="form-label">Name: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td">
                        <input type="text" name="fname" class="input-text" placeholder="First Name" required>
                    </td>
                    <td class="label-td">
                        <input type="text" name="lname" class="input-text" placeholder="Last Name" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="address" class="form-label">Address: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="address" class="input-text" placeholder="Address" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="nic" class="form-label">NIC: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="nic" class="input-text" placeholder="NIC Number" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="dob" class="form-label">Date of Birth: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="date" name="dob" class="input-text" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="email" class="form-label">Email: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="email" name="email" class="input-text" placeholder="Email Address" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
                    </td>
                    <td>
                        <input type="submit" value="Next" class="login-btn btn-primary btn">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                        <a href="/appointments/index.php" class="hover-link1 non-style-link">Login</a>
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">Forgot your password&#63; </label>
                        <a href="/appointments/signup.php?reset=1" class="hover-link1 non-style-link">Reset Password</a>
                        <br><br><br>
                    </td>
                </tr>
                    </form>
                </table>
            <?php endif; ?>
        </div>
    </center>
</body>
</html>