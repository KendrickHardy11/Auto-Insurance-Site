<html>
	<head>
		<title>Quote 2B</title>
    	<style>
 		.button 
		{
            	display: inline-block;
            	padding: 10px 20px;
            	background-color: #4CAF50;
            	color: white;
            	text-align: center;
            	text-decoration: none;
            	font-size: 16px;
            	border-radius: 4px;
        	}
            	.container 
			{
            		display: flex;
            		justify-content: space-between;
            		align-items: center;
        	}
    	</style>
	</head>
	<body>
		<div class="container">
			<h1>Admin Quote viewing</h1>
            	<h2><a href="Admin.php" class="button">ADMIN HOME</a></h2>
            	<h2><a href="login.php" class="button">Logout</a></h2>
        	</div>
<?php
session_start();
error_reporting(E_ALL);
 function draw_table($rows)
        {
            if(empty($rows)) {
                echo "<p>No results found.</p>";
            } else {
                echo "<table border=1 cellspacing=1>";
                echo "<tr>";
                foreach($rows[0] as $key => $item) {
                    echo "<th>$key</th>";
                }
                echo "<th>Action</th>"; // add a new column for the action button
                echo "</tr>";
                foreach($rows as $row) {
                    echo "<tr>";
                    foreach($row as $key => $item) {
                        echo "<td>$item</td>";
                    }
                }
                echo "</table>";
            }
        }

  		// *** the following is script for connecting to the customer legacy DB *** -->

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

       	// *** the following is script for connecting to the local DB *** -->

            $Q_USERNAME = 'root';
            $Q_PASSWORD = '';

            try
            {
                $Qdsn = "mysql:host=localhost;dbname=467";
                $Qpdo = new PDO($Qdsn, $Q_USERNAME, $Q_PASSWORD);
                $Qpdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }

            catch(PDOexception $e)
            {
                echo "Connection to quote database failed: " . $e->getMessage();
            }
echo "<h2>All Qoute Database Information(use as reference)</h2>";
// print table
                echo "\n";
                $ro = $Qpdo->prepare("SELECT Repair_Order_Num, AID, Cust_Id, Date, Status FROM quote_db;");
                $ro->execute();
                $rows = $ro->fetchALL(PDO::FETCH_ASSOC);
                draw_table($rows);

/****************************************************************************************/

echo "<h3>Search quote based on:</h3>";
echo "<h4>Associate, Customer, Status, Date</h4>";

// script for viewing associate quotes and records -->
                echo "<form method=POST action= >";
                echo "<b>Enter Associate ID to view: </b>";
                echo '<input type="text" name="AID" value=""/>';
                echo '<input type="submit" name="Select" value="GO/CLEAR"/> <br/>';
                echo "\n";

if(!empty($_POST["AID"]))
{
    echo "<h2><b>Associates Quote Data</b></h2>";
    $ro = $Qpdo->prepare("SELECT Repair_Order_Num, Cust_Id, Date, Status FROM quote_db WHERE AID = ?;");
    $ro->execute(array($_POST["AID"]));
    $rows = $ro->fetchALL(PDO::FETCH_ASSOC);
    draw_table($rows);
echo "\n";
}

/****************************************************************************************/

// script for viewing customer quotes and records -->
		    echo "<form method=POST action= >";
                echo "<b>Enter Customer ID to View: </b>";
                echo '<input type="text" name="Cust_Id" value=""/>';
                echo '<input type="submit" name="Select" value="GO/CLEAR"/> <br/>';
                echo "\n";
if(!empty($_POST["Cust_Id"]))
{
    echo "<h3><b>Individual Quote Data for Customer</b></h3>";
    $ro = $Qpdo->prepare("SELECT Repair_Order_Num, AID, Date, Status FROM quote_db WHERE Cust_Id = ?;");
    $ro->execute(array($_POST["Cust_Id"]));
    $rows = $ro->fetchALL(PDO::FETCH_ASSOC);
    draw_table($rows);

echo "\n";
}

/****************************************************************************************/

// script for viewing Quote Status info -->
    		    echo "<form method=POST action= >";
                echo "<b>Enter Quote Status to View: </b>";
                echo '<input type="text" name="Status" value=""/>';
                echo '<input type="submit" name="Select" value="GO/CLEAR"/> <br/>';
                echo "\n";
if(!empty($_POST["Status"]))
{
    echo "<h2><b>Individual Quote Data for Status</b></h2>";
    $ro = $Qpdo->prepare("SELECT Repair_Order_Num, AID, Cust_Id, Date, Status FROM quote_db WHERE Status = ?;");
    $ro->execute(array($_POST["Status"]));
    $rows = $ro->fetchALL(PDO::FETCH_ASSOC);
    draw_table($rows);
echo "\n";
echo "\n";
}

/****************************************************************************************/

// script for viewing Date quotes and records -->
   
		    echo "<form method=POST action= >";
                echo "<b>Enter Date to View: </b>";
                echo '<input type="text" name="Date" value=""/>';
                echo '<input type="submit" name="Select" value="GO/CLEAR"/> <br/>';
                echo "\n";
if(!empty($_POST["Date"]))
{
    echo "<h4><b>Individual Quote Data for Date</b></h4>";
    $ro = $Qpdo->prepare("SELECT Repair_Order_Num, AID, Cust_Id, Status FROM quote_db WHERE Date = ?;");
    $ro->execute(array($_POST["Date"]));
    $rows = $ro->fetchALL(PDO::FETCH_ASSOC);
    draw_table($rows);

 echo "\n";
}
?>
<br/>
</body>
</html>
