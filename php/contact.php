<?php
// define variables and set to empty values
$nameErr = $emailErr = $phoneErr = $messageErr = "";
$name = $email = $phone = $message = "";
$errors = array();

// sanitize input data
function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// validate input data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $errors['name'] = "Name is required";
    } else {
        $name = sanitizeData($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $errors['name'] = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $errors['email'] = "Email is required";
    } else {
        $email = sanitizeData($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }
    }

    if (empty($_POST["phone"])) {
        $errors['phone'] = 'Phone number is required';
    } else {
        $phone = sanitizeData($_POST["phone"]);
        // Check if phone number is well-formed
        if (!preg_match("//",$phone)) {
            $errors['phone'] = 'Only numbers allowed';
        }
    }

    if (empty($_POST["message"])) {
        $errors['message'] = "Message is required";
    } else {
        $message = sanitizeData($_POST["message"]);
    }
}

// send email if no validation errors
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors)) {
    $to = "youremail@example.com"; // your email address here
    $subject = "Contact Form Submission";
    $messageBody = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";
    $headers = "From: $email\nReply-To: $email\n";

    if (mail($to, $subject, $messageBody, $headers)) {
        $confirmationMsg = "Thank you for your message!";
        $name = $email = $phone = $message = "";
    } else {
        $errorMsg = "Oops! Something went wrong. Please try again later.";
    }
}
?>
<?php
if(isset($_POST['submit'])){
    // If there are no errors, send the email and show a success message
    if(empty($errors)){
        $to = "example@gmail.com";
        $subject = "New Message from Contact Form";
        $message = "Name: $name \n\n Email: $email \n\n Phone: $phone \n\n Message: $message";
        $headers = "From: example@gmail.com";
        if(mail($to, $subject, $message, $headers)){
            echo "<p class='success'>Your message has been sent successfully!</p>";
        } else{
            echo "<p class='error'>Sorry, there was an error sending your message. Please try again later.</p>";
        }
    }
}
?>
