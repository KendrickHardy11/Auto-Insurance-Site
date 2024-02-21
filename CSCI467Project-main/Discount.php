<!DOCTYPE html>
<html>
<head>
	<title>Quote Discount</title>
</head>
<body>
	<?php
		session_start();
		$L_USERNAME = 'student';
        $L_PASSWORD = 'student';

		try
        {
            $Ldsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
            $Lpdo = new PDO($Ldsn, $L_USERNAME, $L_PASSWORD);
            $Lpdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        catch(PDOexception $e)
        {
            echo "Connection to legacy database failed: " . $e->getMessage();
        }

		$Q_USERNAME = 'root';
        $Q_PASSWORD = '';

        try
        {
            $Qdsn = "mysql:host=localhost;dbname=csci467";
            $Qpdo = new PDO($Qdsn, $Q_USERNAME, $Q_PASSWORD);
            $Qpdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        catch(PDOexception $e)
        {
            echo "Connection to quote database failed: " . $e->getMessage();
        }

		if(isset($_POST['quote_id'])){
			$quote_id = $_POST['quote_id'];

			echo "<form method='post'>";
			echo "<p>Discount: <input type='text' name='discount' value='0'><button type='submit' name='apply'>Apply</button></p>";
			echo "<label><input type='radio' name='Dtype' value='percent'>Percent</label>";
			echo "<label><input type='radio' name='Dtype' value='amount'>Amount</label>";
			echo "<input type='hidden' name='apply' value='" . $quote_id . "'>";
			echo "</form>";
		}

		if(isset($_POST['apply'])){
			try{
				$quote_id = $_POST['apply'];
				$discount = $_POST['discount'];
				$dtype = $_POST['Dtype'];

				$stmt = $Qpdo->prepare("SELECT `Price` FROM quote_db WHERE Repair_Order_Num = ?");
				$stmt->execute([$quote_id]);
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$price = $row['Price'];

				if($dtype === 'amount'){
					$price = $price - $discount;
				}
				else if($dtype === 'percent'){
					$price = $price - (($discount / 100) * $price);
				}

				$stmt = $Qpdo->prepare("UPDATE quote_db SET `Price` = ? WHERE Repair_Order_Num = ?");
				$stmt->execute([$price, $quote_id]);
				echo "Discount applied successfully!";

				echo "<form method='post' action='processquote.php'>";
				echo "<button type='submit'>Go Back</button>";
				echo "</form>";
			}catch(PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
		}
	?>
</html>