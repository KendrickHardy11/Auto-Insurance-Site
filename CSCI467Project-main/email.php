<?php
/*
need to download and unzip phpmailer class in order to use
https://github.com/PHPMailer/PHPMailer/archive/refs/heads/master.zip

automatically emails quote information when a quote_id is posted to email.php
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

echo "Attempting to send email..." . "<br />";

$mail = new PHPMailer(true);

//setup smtp
$mail->isSMTP();
//$mail->SMTPDebug = SMTP::DEBUG_SERVER; //uncomment if mail error
$mail->Host = 'smtp.sendgrid.net';
$mail->SMTPAuth = true;
$mail->Username = 'apikey';
$mail->Password = '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';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

//get quote from sumbitted form
$quote_id = $_POST['quote_id']; 

//db connection
$conn = new mysqli("localhost", "root", "", "467");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//legacy db connection
$conn2 = new mysqli("blitz.cs.niu.edu", "student", "student", "csci467");
if ($conn2->connect_error) {
  die("Connection failed: " . $conn2->connect_error);
}

//query quote info
$sql = "SELECT * FROM `quote_db` WHERE `Repair_Order_Num` = $quote_id";
$result = $conn->query($sql);
$quote = $result->fetch_assoc();
$cust_email = $quote["Email"];
$cust_id = $quote['Cust_ID'];
$AID = $quote['AID'];
$parts_list_id = $quote['Parts_List_ID'];

//query customer info
$sql = "SELECT * FROM `customers` WHERE `id` = $cust_id";
$result = $conn2->query($sql);
$cust = $result->fetch_assoc();

//query associate info
$sql = "SELECT * FROM `associate` WHERE `AID` = $AID";
$result = $conn->query($sql);
$associate = $result->fetch_assoc();


$message = "Dear " . $cust["name"] . ",\n\nThank you for your interest in our services. Here is your quote:\n\n";
$message .= "Service Description: " . $quote["Service_Description"] . "\n";
$message .= "Price: $" . number_format($quote["Price"], 2) . "\n";
$message .= "Estimated Hours: " . $quote["EST_Hours"] . "\n";
$message .= "Hourly Rate: $" . number_format($quote["Hour_Rate"], 2) . "\n";
$message .= "Associate name: " . $associate["ANAME"] . "\n";

//query for parts
$sql = "SELECT * FROM `parts_lists` WHERE `Parts_List_ID` = $parts_list_id";
$result = $conn->query($sql);

// fetch details of each part from the parts table
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $part_id = $row['Part_ID'];
      $qty = $row['Qty'];
      $part_sql = "SELECT * FROM `parts` WHERE `Parts_ID` = $part_id";
      $part_result = $conn->query($part_sql);
      if ($part_result->num_rows > 0) {
        $part_row = $part_result->fetch_assoc();
        $description = $part_row['Description'];
        $price = $part_row['Price_USD'];
        // append part details to the message variable
        $message .= "Part: $description, quantity: $qty, price: $price\n";
      } else {
        $message .= "Error: Part not found.\n";
      }
    }
  } else {
    $message .= "Error: Parts list not found.\n";
  }
$message .= "\nPlease let us know if you have any questions or if you would like to proceed with this quote.\n\nBest regards,\nCompany Name";

// Set the email message parameters
$mail->setFrom('467testemail@gmail.com', '467 Quote System');
//check for invalid email
try {
$mail->addAddress($cust_email, 'Recipient Name'); 
}
catch (Exception $e) {
    echo 'Error: Invalid email';
}
$mail->Subject = 'Your Finalized Quote';
$mail->Body = $message;

//echo $message; //use for testing limit 100 emails per day on this key

// Attempt to send the email
try {
  if (!$mail->send()) {
      throw new Exception('Invalid email on quote');
  } else {
      echo 'Message sent!';
      $sql = "UPDATE `quote_db` SET status = 'sanctioned' WHERE `Repair_Order_Num` = $quote_id";
      $result = $conn->query($sql);
  }
} catch (Exception $e) {}

//return button
echo '</br><a href="sanction.php" class="return-button">Return</a>';
?>
