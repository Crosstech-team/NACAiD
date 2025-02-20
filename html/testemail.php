<?php
$to = 'ankeshgupta0204@gmail.com'; // Replace with your email
$subject = 'Test Email';
$message = 'This is a test email to check the PHP mail function in WordPress.';
$headers = 'From: no-reply@nacaid.com';

if (mail($to, $subject, $message, $headers)) {
    echo 'Mail sent successfully!';
} else {
    echo 'Failed to send email.';
}
?>