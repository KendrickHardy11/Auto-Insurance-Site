<html><head><title>Add New Associate</title></head>
<body>
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
echo ' <a href="viewAssociates.php">Go Back</a>';

if(isset($_POST["add"])){

$aid = $_POST['aid'];
$name = $_POST['name'];	
$user = $_POST['user'];
$pass = $_POST['pw'];	
$comm = $_POST['com'];
$addr = $_POST['addr'];
            $sql = $Qpdo->query("INSERT INTO ASSOCIATE (AID, ANAME, UNAME, PASS,  COMM, ADDR) VALUES($aid, $user, $name, $pass, $comm, $addr);"); 
            $sql->execute(array($_POST['aid'], $_POST['name'], $_POST['user'], $_POST['pw'], $_POST['com'], $_POST['addr']));
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
        
            echo "<script>alert('Account added to Database'); window.location='viewAssociates.php'</script>";
        }
    
    }
    catch(PDOexception $e){
        echo "Connection to database failed: " . $e->getMessage();
    }	

?>
<body>  
    <br/>  
    <div class="container" style="width:500px;">    
    <h1>Add New Associate</h1> 
    <form method="post"> 
<input type="text" name="aid" placeholder="ID" class="form-control" style="height:5%"/>  
        <br/><br/> 
        <input type="text" name="name" placeholder="Enter Name" class="form-control" style="height:5%"/>  
        <br/><br/>
        <input type="text" name="user" placeholder="Enter Username" class="form-control" style="height:5%"/>  
        <br/><br/> 
        <input type="password" name="pw" placeholder ="Enter Password" class="form-control" style="height:5%"/>  
        <br/><br/> 
        <input type="text" name="com" placeholder="Commission" class="form-control" style="height:5%"/>  
        <br/><br/> 
<input type="text" name="addr" placeholder="Enter Address" class="form-control" style="height:5%"/>  
        <br/><br/>   
        <input type="submit" name="add" class="btn btn-info" value="Add"/>  
    </form>  
    <?php  
        if(isset($message))  
        {  
            echo '<label class="text-danger">'.$message.'</label>';  
        }  
    ?>
        </div>  
        <br/>  
</body>
<html/>
