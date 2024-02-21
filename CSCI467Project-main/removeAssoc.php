<html><title>Remove Associate</title></head><body>
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
                    foreach($row as $key => $item) 
			  {
                        echo "<td>$item</td>";
                    }
              }
              echo "</table>";
          }
      }
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
try{
if(isset($_POST['remove'])){
$aid = $_GET['AID'];
$delete = "DELETE from associate where AID = $id";
$id = $pdo->prepare($delete);
$id->execute([$id => 'AID']);

	if($id)
	{
    		echo "<p>Associate removed from Database</p>";
	} 
	else 
	{
    		echo "<p>Error Removing Associate</p>";
	}
}

	echo ' <a href="viewAssociates.php">Back</a>';

}

catch(PDOexception $e) 
{ //handle that expection
	echo "Connection to database failed: " . $e->getMessage();
}
?> 
<form method="post"> 
<div class="container" style="width:500px;">    
    <h1>Enter Associate For Removal</h1> 
    <form method="post"> 
<input type="text" name="AID" placeholder=" Enter Associate ID" class="form-control" style="height:5%"/>  
    <br/>
<input type="submit" name="remove" class="btn btn-info" value="delete"/>  
    </form> 
</body>
</html>
