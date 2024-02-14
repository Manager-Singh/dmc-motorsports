<!DOCTYPE html>
<html>
<head>
    <title>Contact Us Email</title>
</head>
<body>

<?php 
// print_r( $message);
// die;
?>
    <h1>Contact Us</h1>
    <p>Name: {{ $name }}</p>
    <p>Subject: {{  $subject }}</p>
    <p>Phone Number: {{  $phone }}</p>
    <p>Email: {{  $email }}</p>
    <p>Message: {!!  $body !!}</p>
</body>
</html>