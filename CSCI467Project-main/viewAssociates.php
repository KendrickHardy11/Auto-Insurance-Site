<html><head><title>Quote 2B</title></head>
    	
<?php
 	echo ' <a href="Admin.php">ADMIN HOME</a>';
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

// print table
                echo "\n";
                $ro = $Qpdo->prepare("SELECT * FROM associate;");
                $ro->execute();
                $rows = $ro->fetchALL(PDO::FETCH_ASSOC);
                draw_table($rows);
//choose option
                echo "<form method=POST action= >";
                echo "<b>Enter Associate ID to edit: </b>";
                echo '<input type="text" name="AID" value=""/>';
                echo '<input type="submit" name="Select" value="GO/CLEAR"/> <br/>';
                echo "\n";
// script for editing quotes -->

if(!empty($_POST["AID"]))
{
    echo "<h2><b>***CURRENT ASSOCIATE***</b></h2>";
    $ro = $Qpdo->prepare("SELECT * FROM associate WHERE AID = ?;");
    $ro->execute(array($_POST["AID"]));
    $rows = $ro->fetchALL(PDO::FETCH_ASSOC);
    draw_table($rows);

    $passby = $_POST["AID"];

    echo"<form method=POST action= >";
    echo "<h2><b>***SELECT ITEM TO UPDATE***</b></h2>";
    echo '<select name="choose"/>';
        echo '<option>SELECT</option>';
        echo '<option>AID</option>';
        echo '<option>ANAME</option>';
        echo '<option>UNAME</option>';
        echo '<option>PASS</option>';
        echo '<option>COMM</option>';
        echo '<option>ADDR</option>';

    echo '</select>';

    echo "<b>>>>Enter UPDATE>>></b>";
    echo '<input type="text" name="enter" value=""/>';
    echo "<b>>>>Confirm ID>>></b>";
    echo '<input type="text" name="confirm" value=""/>';
    echo '<input type="submit" name="GO" value="GO"/>';
    echo "</form>";
}

// script for uploading edits to the quote db-->
if(!empty($_POST["choose"]) && !empty($_POST["enter"]))
{
    $sql = "UPDATE associate SET ".$_POST["choose"]."=? WHERE AID=?";
    $rs = $Qpdo->prepare($sql);
    $rs->execute(array($_POST["enter"],$_POST["confirm"]));
    $successful = $rs->rowCount();                                               

    if ($successful != 0)
    {               
        echo $_POST['choose'] . " has been updated.";
        echo "<br/>";
        echo "<meta http-equiv='refresh' content='0'>";
    }
    else
    {                               
        echo "!!! ERROR WHEN UPDATING DATA !!!";
        echo "<br/>";
    }
}
// script for adding new associate to db-->
if (isset($_POST['newA']))
	{
		echo "<h2>Enter ALL Data Points</h2>";
		echo"<form method=POST action= >";		
		echo "<b>Confirm AID>>></b>";
		echo '<input type="text" name="AID" value=""/>';
		echo "<b>>>>Enter Associate Name>>></b>";
		echo '<input type="text" name="ANAME" value=""/>';
		echo "<b>>>>Username>>></b>";
		echo '<input type="text" name="UNAME" value=""/>';
		echo "<br/>";
		echo "<b>Password>>></b>";
		echo '<input type="text" name="PASS" value="200"/>';
		echo "<b>>>>Commission>>></b>";
		echo '<input type="text" name="COMM" value=""/>';
		echo "<b>>>>Address>>></b>";
		echo '<input type="text" name="ADDR" value=""/>';
		echo "<br/>";
		echo "<br/>";
		echo '<input type="submit" name="go" value="Submit New Repair Order Quote"/>';
		echo "</form>";
	}


	if(!empty($_POST["AID"])&&!empty($_POST["ANAME"])&&!empty($_POST["UNAME"])&&!empty($_POST["PASS"])&&!empty($_POST["COMM"])&& !empty($_POST["ADDR"]))
	{
		$sql = "INSERT INTO associate (AID,ANAME,UNAME,PASS,COMM,ADDR) VALUES (?,?,?,?,?,?)";
            $rs = $Qpdo->prepare($sql);
            $rs->execute(array($_POST["AID"],$_POST["ANAME"],$Rbuffer,$_POST["UNAME"],$_POST["PASS"],$_POST["COMM"],$_POST["ADDR"],"draft"));
            $successful = $rs->rowCount();    

            if ($successful != 0)
            {               
            	echo "Associate Added to Database.";
            	echo "<br/>";
            }
            else
            {                               
            	echo "!!! ERROR WHEN UPLOADING DATA !!!";
			echo "<br/>";
		}

	}

	if(!empty($_POST["AID"])&&!empty($_POST["ANAME"])&&!empty($_POST["UNAME"])&&!empty($_POST["PASS"])&&!empty($_POST["COMM"])&& !empty($_POST["ADDR"]))
	{
		$sql = "INSERT INTO associate (AID,ANAME,UNAME,PASS,COMM,ADDR) VALUES (?,?,?,?,?,?)";
            $rs = $Qpdo->prepare($sql);
            $rs->execute(array($_POST["AID"],$_POST["ANAME"],$Rbuffer,$_POST["UNAME"],$_POST["PASS"],$_POST["COMM"],$_POST["ADDR"],"draft"));
            $successful = $rs->rowCount();    

            if ($successful != 0)
            {               
            	echo "Associate Added to Database.";
            	echo "<br/>";
            }
            else
            {                               
            	echo "!!! ERROR WHEN UPLOADING DATA !!!";
			echo "<br/>";
		}

	}

try
{
    if(isset($_POST["add"]))  
    {  
    header("location:addAssoc.php"); 
    }
    if(isset($_POST["delete"]))  
    {  
    header("location:removeAssoc.php"); 
    }
}
catch(PDOexception $e)
{
	echo "Connection to database failed: " . $e->getMessage();
}

?>
<body>  
    <br/>  
    <div class="container" style="width:500px;">  
    <form method="POST">  
    <button class="button" style='font-size:14;' name="add">Add New Associate</button>
    </form>
    <form method="POST">  
    <button class="button" style='font-size:14;' name="delete">Delete Associate</button>
    </form>  
    <?php  
        if(isset($message))  
        {  
            echo '<label class="text-danger">'.$message.'</label>';  
        }  
?>
        </div>  
        <br/>  
</body></html>
