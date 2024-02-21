<html><head><title>View Data</title></head><body>
<?php

// *** the following is script for printing out data tables *** -->

function draw_table($rows)
{
	if(empty($rows)) {echo "<p>No results found.</p>";}
		else
		{
			echo "<table border=1 cellspacing=1>";
			echo "<tr>";
			foreach($rows[0] as $key => $item)
			{
				echo "<th>$key</th>";
			}
			echo "</tr>";
			foreach($rows as $row)
			{
				echo "<tr>";
				foreach($row as $key => $item)
				{
					echo "<td>$item</td>";
				}
				echo "</tr>";
			}
		echo "</table>";
	}
}

	session_start();
	//set login AID
	$AID = $_SESSION['AID'];
	
	error_reporting(E_ALL);

	echo"<h1>QUOTE VIEW AND CUSTOMER VIEW PAGE</h1>";

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

// *** the following is script for connecting to the local quote DB *** -->

	$Q_USERNAME = 'CSCI467';
	$Q_PASSWORD = 'xflxMg.V@r5NW.x7';

	try
	{
		$Qdsn = "mysql:host=localhost;dbname=467_q_project";
		$Qpdo = new PDO($Qdsn, $Q_USERNAME, $Q_PASSWORD);
		$Qpdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}

	catch(PDOexception $e)
	{
		echo "Connection to quote database failed: " . $e->getMessage();
	}

// *** the following is script for selecting a DB to view or edit *** -->

	echo"<form method=POST action= >";
	echo "<h2><b>Select database to view: </b></h2>";
	echo '<select name="ans"/>';
		echo '<option>SELECT</option>';
		echo '<option>Customer Legacy</option>';
		echo '<option>Quotes</option>';
		echo '<option>Parts</option>';
	echo '</select>';
	echo '<input type="submit" name="GO" value="GO/CLEAR"/>';
	echo "</form>";

// *** the following is script for processing customer view requests *** -->
// script for viewing a single customer -->
	
	if(empty($_POST["cust_id"]) && isset($_POST["ans"]) && $_POST["ans"] == "Customer Legacy")
	{
        	echo "<form method=POST action= >";    
        	echo "<b>Enter customer ID to view single customer:</b>";
        	echo "\n";
        	echo '<input type="text" name="cust_id" value=""/>';
        	echo '<input type="submit" name="go" value="GO"/> <br/>';
        	echo "</form>";
	}

// script for viewing all customer -->

	if(empty($_POST["cust_id"]) && isset($_POST["ans"]) && $_POST["ans"] == "Customer Legacy")
	{
		$ro = $Lpdo->prepare("SELECT * FROM customers;");
		$ro->execute();
		$rows = $ro->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);
	}

// script for viewing all customer -->

	elseif(!empty($_POST["cust_id"]))
	{
		$cust = $Lpdo->prepare("SELECT * FROM customers WHERE ID = ?;");
		$cust->execute(array($_POST["cust_id"]));
		$rows = $cust->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);
	}

// *** the following is script for processing view/edit quote requests *** -->
// script for viewing choosing what function to preform -->

	if(empty($_POST["cust_id"]) && isset($_POST["ans"]) && $_POST["ans"] == "Quotes")
	{
		echo "<form method=POST action= >";    
		echo "<b>Enter Repair Order Number (VIEW QUOTE AND PARTS LIST):</b>";
		echo "\n";
		echo '<input type="text" name="ro_num" value=""/>';
		echo '<input type="submit" name="go" value="GO"/><br/>';
		echo "\n";
		echo "<b>Enter Repair Order Number (EDIT QUOTE): </b>";
		echo '<input type="text" name="Ero_num" value=""/>';
		echo '<input type="submit" name="go" value="GO"/> <br/>';
		echo "\n";
		echo "<br/>";
		echo "<b>CREATE NEW QUOTE: </b>";
		echo '<input type="submit" name="go_new" value="GO"/> <br/>';
		echo "</form>";
	}

// script for viewing all quotes -->

	if(empty($_POST["ro_num"]) && isset($_POST["ans"]) && $_POST["ans"] == "Quotes")
	{
		echo "\n";
		echo "<h2>ALL QUOTES:</h2>";
		$ro = $Qpdo->prepare("SELECT * FROM quote_db;");
		$ro->execute();
		$rows = $ro->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);
	}

// script for viewing indvidual quotes with parts list -->

	elseif(!empty($_POST["ro_num"]))
	{
		echo "\n";
		echo "<h2><b>***REPAIR ORDER QUOTE***</b></h2>";

		$ro = $Qpdo->prepare("SELECT * FROM quote_db WHERE Repair_Order_Num = ?;");
		$ro->execute(array($_POST["ro_num"]));
		$rows = $ro->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);
		
		echo "\n";
		echo "<h2><b>***PARTS LIST***</b></h2>";
		$parts = $Qpdo->prepare("SELECT parts_lists.Part_ID, parts_lists.Qty, parts.Description, parts.price_USD 
			FROM parts_lists,quote_db,parts 
			WHERE Parts_Lists.Parts_List_ID = quote_db.Parts_List_ID
			AND parts.Parts_ID = parts_lists.Part_ID 
			AND quote_db.Repair_Order_Num = ?;");

		$parts->execute(array($_POST["ro_num"]));
		$rows = $parts->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);    
	}

// script for editing quotes -->

	if(!empty($_POST["Ero_num"]))
	{
		echo "<h2><b>***CURRENT QUOTE***</b></h2>";
		$ro = $Qpdo->prepare("SELECT * FROM quote_db WHERE Repair_Order_Num = ?;");
		$ro->execute(array($_POST["Ero_num"]));
		$rows = $ro->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);

		$passby = $_POST["Ero_num"];

		echo"<form method=POST action= >";
		echo "<h2><b>***SELECT ITEM TO UPDATE***</b></h2>";
		echo '<select name="upd1"/>';
			echo '<option>SELECT</option>';
			echo '<option>EST_Hours</option>';
			echo '<option>Hour_Rate</option>';
			echo '<option>Service_Description</option>';
			echo '<option>Email</option>';
			echo '<option>Status</option>';
			echo '<option>Notes</option>';
		echo '</select>';

		echo "<b>>>>Enter New Data>>></b>";
		echo '<input type="text" name="upd2" value=""/>';
		echo "<b>>>>Confirm RO Number>>></b>";
		echo '<input type="text" name="updC" value=""/>';
		echo '<input type="submit" name="GO" value="GO"/>';
		echo "</form>";
	}

// script for uploading edits to the quote db-->
    if(!empty($_POST["upd1"]) && !empty($_POST["upd2"]))
    {
        $sql = "UPDATE quote_db SET ".$_POST["upd1"]."=? WHERE Repair_Order_Num=?";
        $rs = $Qpdo->prepare($sql);
        $rs->execute(array($_POST["upd2"],$_POST["updC"]));
        $successful = $rs->rowCount();                                               

        if ($successful != 0)
        {               
            echo $_POST['upd1'] . " has been updated.";
            echo "<br/>";
        }
        else
        {                               
            echo "!!! ERROR WHEN UPDATING DATA !!!";
            echo "<br/>";
        }
    }

// script for creating new quotes -->

if (isset($_POST['go_new']))
	{
		echo "<h2>Enter ALL Data Points</h2>";
		echo"<form method=POST action= >";		
		echo "<b>Confirm AID>>></b>";
		echo '<input type="text" name="aid" value=""/>';
		echo "<b>>>>Enter Cust ID>>></b>";
		echo '<input type="text" name="cuid" value=""/>';
		echo "<b>>>>Hours Estimate>>></b>";
		echo '<input type="text" name="hret" value=""/>';
		echo "<br/>";
		echo "<b>Hourly Rate ($)>>></b>";
		echo '<input type="text" name="rate" value="200"/>';
		echo "<b>>>>Service Description>>></b>";
		echo '<input type="text" name="sd" value=""/>';
		echo "<b>>>>Cust Email>>></b>";
		echo '<input type="text" name="cuem" value=""/>';
		echo "<b>>>>Parts List Number></b>";
		echo '<input type="text" name="prt" value=""/>';
		echo "<br/>";
		echo "<br/>";
		echo '<input type="submit" name="GO" value="Submit New Repair Order Quote"/>';
		echo "</form>";

		echo"<b><h2>Available Parts Lists:</b></h2>";
		echo "<br/>";
		$ro = $Qpdo->prepare("SELECT * FROM parts_lists;");
		$ro->execute();
		$rows = $ro->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);      

		echo"<b><h2>Parts:</b></h2>";
		echo "<br/>";
		$ro = $Qpdo->prepare("SELECT * FROM parts;");
		$ro->execute();
		$rows = $ro->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);                                         

	}


	if(!empty($_POST["aid"])&&!empty($_POST["cuid"])&&!empty($_POST["hret"])&&!empty($_POST["rate"])&&!empty($_POST["sd"])&& !empty($_POST["cuem"])&&!empty($_POST["prt"]))
	{
	 	$Hbuffer = $_POST["hret"];
		$Rbuffer = $_POST["rate"];
		$Rbuffer *= $Hbuffer;

		$Asql = "SELECT SUM(total) FROM parts_lists WHERE parts_lists.Parts_List_ID = ?";
		$Ars = $Qpdo->prepare($Asql);
		$Ars->execute(array($_POST["prt"]));
		$pp = $Ars->fetchALL(PDO::FETCH_ASSOC);

		echo"<b>|Parts Pricing| UPDATE COST VIA QUOTE EDIT</b>";
		draw_table($pp);  

		$sql = "INSERT INTO quote_db (Cust_ID,AID,Price,EST_Hours,Hour_Rate,Parts_List_ID,Service_Description,Email,Status) VALUES (?,?,?,?,?,?,?,?,?)";
            $rs = $Qpdo->prepare($sql);
            $rs->execute(array($_POST["cuid"],$_POST["aid"],$Rbuffer,$_POST["hret"],$_POST["rate"],$_POST["prt"],$_POST["sd"],$_POST["cuem"],"draft"));
            $successful = $rs->rowCount();    

            if ($successful != 0)
            {               
            	echo "RO Quote has been created.";
            	echo "<br/>";
            }
            else
            {                               
            	echo "!!! ERROR WHEN UPLOADING DATA !!!";
			echo "<br/>";
		}

	}

	if(!empty($_POST["aid"])&&!empty($_POST["cuid"])&&!empty($_POST["hret"])&&!empty($_POST["rate"])&&!empty($_POST["sd"])&& !empty($_POST["cuem"])&&empty($_POST["prt"]))
	{
	 	$Hbuffer = $_POST["hret"];
		$Rbuffer = $_POST["rate"];
		$Rbuffer *= $Hbuffer;

		$sql = "INSERT INTO quote_db (Cust_ID,AID,Price,EST_Hours,Hour_Rate,Service_Description,Email,Status) VALUES (?,?,?,?,?,?,?,?)";
            $rs = $Qpdo->prepare($sql);
            $rs->execute(array($_POST["cuid"],$_POST["aid"],$Rbuffer,$_POST["hret"],$_POST["rate"],$_POST["sd"],$_POST["cuem"],"draft"));
            $successful = $rs->rowCount();    

            if ($successful != 0)
            {               
            	echo "RO Quote has been created.";
            	echo "<br/>";
            }
            else
            {                               
            	echo "!!! ERROR WHEN UPLOADING DATA !!!";
			echo "<br/>";
		}

	}

// *** the following is script for processing view/edit part requests *** -->
// script for chosing view/edit part processes -->

	if(empty($_POST["cust_id"]) && isset($_POST["ans"]) && $_POST["ans"] == "Parts")
	{
		echo "<form method=POST action= >";   
 
		echo "<b>Enter part ID to VIEW part:</b>";
		echo "\n";
		echo "\n";
		echo '<input type="text" name="pnum" value=""/>';
		echo '<input type="submit" name="go" value="GO"/> <br/>';
		echo "<b>Enter part ID to EDIT part: </b>";
		echo "\n";
		echo "\n";
		echo '<input type="text" name="Epnum" value=""/>';
		echo '<input type="submit" name="go" value="GO"/> <br/>';
		echo "<br/>";
		echo "<b>Enter parts list ID to VIEW parts list:</b>";
		echo "\n";
		echo "\n";
		echo '<input type="text" name="PLnum" value=""/>';
		echo '<input type="submit" name="go" value="GO"/> <br/>';
		echo "</form>";
	}

// script for chosing viewing all parts -->

	if(empty($_POST["pnum"]) && isset($_POST["ans"]) && $_POST["ans"] == "Parts")
	{
		$ro = $Qpdo->prepare("SELECT * FROM parts;");
		$ro->execute();
		$rows = $ro->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);

		echo"<h2><b>Parts Lists:</b></h2>";
		echo "<br/>";
		$ro = $Qpdo->prepare("SELECT * FROM parts_lists;");
		$ro->execute();
		$rows = $ro->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);  
	}

// script for chosing viewing individual parts -->

	elseif(!empty($_POST["pnum"]))
	{
		echo "\n";
		$part = $Qpdo->prepare("SELECT * FROM parts WHERE Parts_ID = ?;");
		$part->execute(array($_POST["pnum"]));
		$rows = $part->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);
	}
	elseif(!empty($_POST["Epnum"]))
	{
		echo"<b><h2>Current Part:</b></h2>";
		echo "\n";
		$part = $Qpdo->prepare("SELECT * FROM parts WHERE Parts_ID = ?;");
		$part->execute(array($_POST["Epnum"]));
		$rows = $part->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);

		echo"<form method=POST action= >";
		echo "<h2><b>***SELECT ITEM TO UPDATE***</b></h2>";
		echo '<select name="Pupd1"/>';
			echo '<option>SELECT</option>';
			echo '<option>Price_USD</option>';
			echo '<option>Description</option>';
			echo '<option>Stock-Count</option>';
		echo '</select>';

		echo "<b>>>>Enter New Data>>></b>";
		echo '<input type="text" name="Pupd2" value=""/>';
		echo "<b>>>>Confirm Part Number>>></b>";
		echo '<input type="text" name="updP" value=""/>';
		echo '<input type="submit" name="GO" value="GO"/>';
		echo "</form>";
	}

	elseif(!empty($_POST["PLnum"]))
	{
		echo "\n";
		$part = $Qpdo->prepare("SELECT * FROM parts_lists WHERE Parts_List_ID = ?;");
		$part->execute(array($_POST["PLnum"]));
		$rows = $part->fetchALL(PDO::FETCH_ASSOC);
		draw_table($rows);
	}
    if(!empty($_POST["Pupd1"]) && !empty($_POST["Pupd2"]))
    {
        $sql = "UPDATE parts SET ".$_POST["Pupd1"]."=? WHERE Parts_ID=?";
        $rs = $Qpdo->prepare($sql);
        $rs->execute(array($_POST["Pupd2"],$_POST["updP"]));
        $successful = $rs->rowCount();                                               

        if ($successful != 0)
        {               
            echo $_POST['Pupd1'] . " has been updated.";
            echo "<br/>";
        }
        else
        {                               
            echo "!!! ERROR WHEN UPDATING DATA !!!";
            echo "<br/>";
        }
    }
?>
</body></html>