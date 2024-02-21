<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "467";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$discount_type = $_POST["discount_type"];
$discount_value = $_POST["discount_value"];
$repair_order_num = $_POST["repair_order_num"];

// Get repair order details
$sql = "SELECT * FROM quote_db WHERE Repair_Order_Num = $repair_order_num";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Calculate new price
if ($discount_type == "percentage") {
  $new_price = $row["Price($)"] * (100 - $discount_value) / 100;
} else {
  $new_price = $row["Price($)"] - $discount_value;
}

// Update database
$sql = "UPDATE quote_db SET Price = $new_price WHERE Repair_Order_Num = $repair_order_num";
if ($conn->query($sql) === TRUE) {
   header("Location: sanction.php");
  exit;
} else {
  echo "Error updating record: " . $conn->error;
}

//return button
echo '</br><a href="sanction.php" class="return-button">Return</a>';

// Close connection
$conn->close();
?>
