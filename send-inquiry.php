<?php
// Contact Form Handler for YQ Steel
// Sends inquiries to bianaiqiang@yqsteel.org

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $company = htmlspecialchars(trim($_POST['company'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $product = htmlspecialchars(trim($_POST['product'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: contact.html?status=error&message=" . urlencode("Please fill in all required fields."));
        exit;
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.html?status=error&message=" . urlencode("Please enter a valid email address."));
        exit;
    }
    
    // Prepare email
    $to = "bianaiqiang@yqsteel.org";
    $subject = "New Inquiry from YQ Steel Website";
    
    // Email headers
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // Email body
    $emailBody = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            h2 { color: #f97316; border-bottom: 2px solid #f97316; padding-bottom: 10px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #64748b; }
            .value { color: #0f172a; margin-top: 5px; }
            .message-box { background: #f8fafc; padding: 15px; border-radius: 8px; margin-top: 20px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>New Inquiry from YQ Steel Website</h2>
            
            <div class='field'>
                <div class='label'>Name:</div>
                <div class='value'>" . $name . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>Company:</div>
                <div class='value'>" . ($company ?: "Not provided") . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>Email:</div>
                <div class='value'>" . $email . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>Product Interest:</div>
                <div class='value'>" . ($product ?: "Not specified") . "</div>
            </div>
            
            <div class='message-box'>
                <div class='label'>Message / Requirements:</div>
                <div class='value'>" . nl2br($message) . "</div>
            </div>
            
            <hr style='margin: 30px 0; border: none; border-top: 1px solid #e2e8f0;'>
            <p style='font-size: 12px; color: #64748b;'>This email was sent from the YQ Steel website contact form.</p>
        </div>
    </body>
    </html>
    ";
    
    // Send email
    $mailSent = mail($to, $subject, $emailBody, $headers);
    
    if ($mailSent) {
        header("Location: contact.html?status=success&message=" . urlencode("Thank you! Your inquiry has been sent. We will get back to you soon."));
    } else {
        header("Location: contact.html?status=error&message=" . urlencode("Sorry, there was an error sending your message. Please try again or contact us directly at bianaiqiang@yqsteel.org"));
    }
    exit;
} else {
    // If accessed directly without POST, redirect to contact page
    header("Location: contact.html");
    exit;
}
?>
