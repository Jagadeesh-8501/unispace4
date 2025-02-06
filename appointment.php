<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Edit the 2 lines below as required
    $email_to = "info@unispaceinteriors.in";
    $email_subject = "New Appointment Request";

    // Check if required data exists
    if (!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['phone']) ||
        !isset($_POST['scope']) ) {
        die("There was an issue with the form submission.");
    }

    // Get form values
    $name = $_POST['name'];
    $email_from = $_POST['email'];
    $phone = $_POST['phone'];
    $scope = $_POST['scope'];

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email_from)) {
        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br />';
    }

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $error_message .= 'The Phone Number you entered does not appear to be valid.<br />';
    }

    if (empty($scope)) {
        $error_message .= 'Please describe the scope of the work.<br />';
    }



    if (!empty($error_message)) {
        echo $error_message;
        die();
    }

    // Email message
    $email_message = "Form details below.\n\n";
    $email_message .= "Name: " . $name . "\n";
    $email_message .= "Email: " . $email_from . "\n";
    $email_message .= "Phone: " . $phone . "\n";
    $email_message .= "Scope of Work: " . $scope . "\n";

    // Send email
    $headers = 'From: ' . $email_from . "\r\n" .
        'Reply-To: ' . $email_from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
    if (@mail($email_to, $email_subject, $email_message, $headers)) {
        echo "success";
    } else {
        echo "There was a problem sending the email.";
    }
}
?>
