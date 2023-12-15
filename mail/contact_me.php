<?php
// Define variables and set to empty values
$name = $email = $message = '';
$nameErr = $emailErr = $messageErr = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $message = sanitize_input($_POST['message']);

    // Validate name
    if (empty($name)) {
        $nameErr = 'Name is required';
    }

    // Validate email
    if (empty($email)) {
        $emailErr = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = 'Invalid email format';
    }

    // Validate message
    if (empty($message)) {
        $messageErr = 'Message is required';
    }

    // If there are no errors, send the email
    if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
        $to = 'your@example.com'; // Replace with your email address
        $subject = 'New Contact Form Submission';
        $headers = 'From: ' . $email . "\r\n" .
                   'Reply-To: ' . $email . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        // Construct the email message
        $email_message = "Name: $name\n";
        $email_message .= "Email: $email\n";
        $email_message .= "Message:\n$message";

        // Send the email
        mail($to, $subject, $email_message, $headers);

        // Optionally, you can redirect the user to a thank-you page
        header('Location: thank_you.php');
        exit();
    }
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Me</title>
    <!-- Add any additional styles or scripts as needed -->
</head>
<body>

<h2>Contact Me</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?php echo $name; ?>">
    <span class="error"><?php echo $nameErr; ?></span>

    <br>

    <label for="email">Email:</label>
    <input type="text" name="email" id="email" value="<?php echo $email; ?>">
    <span class="error"><?php echo $emailErr; ?></span>

    <br>

    <label for="message">Message:</label>
    <textarea name="message" id="message"><?php echo $message; ?></textarea>
    <span class="error"><?php echo $messageErr; ?></span>

    <br>

    <input type="submit" value="Submit">
</form>

<!-- Add any additional HTML or scripts as needed -->

</body>
</html>
