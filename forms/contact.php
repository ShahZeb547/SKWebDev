<?php
// Simple contact form handler
// Replace with your real receiving email address
$receiving_email_address = 'shahzeboffical933@gmail.com';

header('Content-Type: text/plain; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo 'Method Not Allowed';
  exit;
}

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : 'New Contact Message';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

// Basic validation
if (empty($name) || empty($email) || empty($message)) {
  http_response_code(400);
  echo 'Please fill in the required fields.';
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo 'Please provide a valid email address.';
  exit;
}

// Build email
$email_subject = $subject;
$email_body = "You have received a new message from your website contact form.\n\n";
$email_body .= "Name: $name\n";
$email_body .= "Email: $email\n";
if (!empty($phone)) {
  $email_body .= "Phone: $phone\n";
}
$email_body .= "\nMessage:\n$message\n";

$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Attempt to send the email
if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
  echo 'OK';
} else {
  http_response_code(500);
  echo 'There was a problem sending the email. Please try again later.';
}

?>
