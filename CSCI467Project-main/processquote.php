<!DOCTYPE html>
<html>
<head>
	<title>Process Orders</title>
	<style>
		h1 {
			font-size: 40px;
			text-align: center;
		}
	</style>
</head>
<body>
	<h1>Process Orders</h1>
	<div class="container">
        <h2><a href="Sanction.php" class="button">Sanction Quotes</a></h2>
        <h2><a href="login.php" class="button">Sign Out</a></h2>
    </div>
	<h2 style="font-family:Segoe UI">List of Sanctioned Quotes:</h2>
	<style>
		table, td {
		  border: 1px solid black;
		  border-collapse: collapse;
		  width: 100%;
		}

		td:first-child{
			width: 50%;
		}
	</style>
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

		$stmt = $Qpdo->prepare("SELECT email, `Price`, Repair_Order_Num as quote_ID FROM quote_db WHERE status = 'sanctioned'");
		$stmt->execute();

		$total = 0;

		echo "<table>";
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo "<tr>";
			echo "<td>" . $row["quote_ID"] . "-" . $row["email"] . "    $" . $row["Price"] . "</td>";
			echo "<td>";
			echo "<form method='post' action='finishingquote.php'>";
			echo "<input type='hidden' name='quote_id' value='" . $row["quote_ID"] . "'>";
			echo "<button type='submit'>Process Quote</button>";
			echo "</form>";
			echo "<form method='post' action='Discount.php'>";
			echo "<input type='hidden' name='quote_id' value='" . $row["quote_ID"] . "'>";
			echo "<button type='submit'>Discount Quote</button>";
			echo "</form>";
			echo "</td>";
			echo "</tr>";
			$total += 1;
		}
		echo "</table>";
		echo "<br>";
		echo "<p style='font-size:125%;'><b>$total quotes found</b></p>";
	?>
</body>
</html>
