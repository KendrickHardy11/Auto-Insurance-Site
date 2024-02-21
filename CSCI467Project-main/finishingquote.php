<!DOCTYPE html>
<html>
<head>
	<title>Finalize Quote</title>
</head>
<style>
		table, td {
		  border: 1px solid black;
		  border-collapse: collapse;
		}

		td:first-child{
			width: 50%;
		}
		tr:nth-child(even) {
			background-color: #dddddd;
		}
	</style>
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

			echo "<h1>Quote Description: </h1>";

			$stmt = $Qpdo->prepare("SELECT email FROM quote_db WHERE Repair_Order_Num = ?");
			$stmt->execute([$quote_id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			echo "<p>Customer Email: " . $row['email'] . "</p>";

			echo "<h2> List of Line Items:</h2>";

			$stmt = $Qpdo->prepare("SELECT parts_list_id FROM quote_db WHERE Repair_Order_Num = ?");
			$stmt->execute([$quote_id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$parts_list_id = $row['parts_list_id'];

			$stmt = $Qpdo->prepare("SELECT price_usd, description FROM parts WHERE parts_id IN (SELECT part_id FROM parts_lists WHERE parts_list_id = ?)");
			$stmt->execute([$parts_list_id]);

			echo "<table>";
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				echo "<tr>";
				echo "<td>" . "$" . $row['price_usd'] . "</td>";
				echo "<td>" . $row['description'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";

			echo "<h2> Quote Notes:</h2>";

			$stmt = $Qpdo->prepare("SELECT Notes FROM quote_db WHERE Repair_Order_Num = ?");
			$stmt->execute([$quote_id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			echo "<p>" . $row['Notes'] . "</p>";

			$stmt = $Qpdo->prepare("SELECT `Price` FROM quote_db WHERE Repair_Order_Num = ?");
			$stmt->execute([$quote_id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$amount = $row['Price'];

			echo "<p>Amount: $" . $amount . "</p>";

			echo "<form method='post'>";
			echo "<input type='hidden' name='process_po' value='" . $quote_id . "'>";
			echo "<p>To convert this quote into an order and process it, click here: <button type='submit'>Process PO</button></p>";
			echo "</form>";
		}
		else if(isset($_POST['process_po'])){
			$quote_id = $_POST['process_po'];

			$stmt = $Qpdo->prepare("SELECT EST_Hours, `Hour_Rate`, `Date`, AID FROM quote_db WHERE Repair_Order_Num = ?");
			$stmt->execute([$quote_id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$commission = $row['EST_Hours'] * $row['Hour_Rate'];
			$floatCommission = (float) $commission;

			$stmt = $Qpdo->prepare("UPDATE associate SET COMM = COMM + ? WHERE AID = ?");
			$stmt->execute([$floatCommission, $row['AID']]);

			echo "<p>Fulfilled On: " . $row['Date'] . "</p>";
			echo "<p>Commission: $" . $commission . "</p>";

			$stmt = $Qpdo->prepare("UPDATE quote_db SET Status = 'ordered' WHERE Repair_Order_Num = ?");
			$stmt->execute([$quote_id]);

			echo "</form>";
			echo "<form method='post' action='processquote.php'>";
			echo "<button type='submit'>Go Back</button>";
			echo "</form>";
		}
	?>
</body>
</html>