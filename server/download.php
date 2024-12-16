<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

include 'gsheet.php';

$mail = new PHPMailer(true);


function formatPhoneNumber($phone) {
    if (substr($phone, 0, 1) === '0') {
        return '62' . substr($phone, 1);
    }
    return $phone;
}

function generateBodyContent($name,$phone,$email,$source){
    if ($email == '') {
        $email = '-';
    }

    return '<h2> ALOHA MICROSITE DATA </h2><br>' .
                        'Nama ' . $name . '<br>' .
                        'Email ' . $email . '<br>' .
                        'Phone ' . $phone . '<br>' .
                        'Unit '. $source . '<br><br>' .
                        '<a href="https://wa.me/' . formatPhoneNumber($phone) .'"
                        style="
                            display: inline-block;
                            padding: 12px 24px;
                            font-size: 16px;
                            font-family: Arial, sans-serif;
                            color: white;
                            background-color: #25D366;
                            text-decoration: none;
                            border-radius: 10px;
                            text-align: center;
                            font-weight: bold;">
                        Open on WA
                        </a>';
}


// Check if required fields are set
if (isset($_POST['name']) && isset($_POST['phone'])) {
    // Collect form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $source = $_POST['source'];

    // Process form data, e.g., save to database, send email notification, etc.
    try {
        // Server settings
        $mail->isSMTP();                                         // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server
        $mail->SMTPAuth   = true;                                // Enable SMTP authentication
        $mail->Username   = 'alohaproperty.id@gmail.com';        // SMTP username
        $mail->Password   = 'rwjyopfwwyxgyowm';                  // App Password or Gmail account password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
        $mail->Port       = 587;                                 // TCP port for TLS (587)
    
        // Recipients
        $mail->setFrom('alohaproperty.id@gmail.com', 'Aloha Bot');     // Sender's email and name
        $mail->addAddress('alohaproperty.id@gmail.com', 'Aloha Admin'); // Add a recipient
        //$mail->AddCC();

        // Content
        $mail->isHTML(true);                                     // Set email format to HTML
        $mail->Subject = 'ALOHA NEW DATA - MICROSITE';
        $mail->Body =  generateBodyContent($name,$phone,$email,$source);


        $mail->AltBody = 'Nama ' . $name . ' Phone https://wa.me/' . formatPhoneNumber($phone) . 'Unit ' . $source;
    
        // Send the email
        $mail->send();

        // Write data recap to gsheet
        writeToGoogleSheet($name,$phone,$email,$source);
    } catch (Exception $e) {
       //  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // File path to the e-brochure
    $filePath = "";

    switch ($source) {
    case "yara":
        $filePath = "../assets/brochure/brochure-yara.pdf";
        break;
    case "vicente":
        $filePath = "../assets/brochure/leaflet-vicente.pdf";
        break;
    case "levante":
        $filePath = "../assets/brochure/leaflet-levante.pdf";
        break;
    case "z-living":
        $filePath = "../assets/brochure/brochure-z-living.pdf";
        break;
    case "tanamas":
        $filePath = "../assets/brochure/brochure-tanamas.pdf";
        break;
    case "water-terrace":
        $filePath = "../assets/brochure/brochure-water-terrace.pdf";
        break;
    case "giva":
        $filePath = "../assets/brochure/brochure-giva.pdf"; // TODO : update brochure location, exist for honey pot :)
        break;
    }

    // Check if file exists
    if (file_exists($filePath)) {
        // Set headers to trigger a file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Clear the output buffer
        ob_clean();
        flush();

        // Read the file and output it to the response
        readfile($filePath); 
    } else {
        // echo "The requested file is not available.";
        header("Location: ../" . $_POST['source'] . ".html");
    }
    exit;
} else {
    echo "Required fields are missing.";
}


?>
