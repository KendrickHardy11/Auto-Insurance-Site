<html><head><title>Quote System</title></head>
<?php
      session_start();
	error_reporting(E_ALL);
	
try
{

      if(isset($_POST["Admin"]))  
      {  
      	header("location:login.php"); 
      }
	if(isset($_POST["Assoc"]))  
      {  
      	header("location:login.php"); 
      }
      if(isset($_POST["HQ"]))  
      {  
      	header("location:login.php"); 
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
    <h1>Welcome to our Homepage</h1>
    <h2>Choose Interface:</h2>
    <form method="post">  
        <br/> 
        <input type="submit" name="Admin" class="btn btn-info" value="Admin Interface"/>  
        <input type="submit" name="Assoc" class="btn btn-info" value="Associate Login"/> 
	  <input type="submit" name="HQ" class="btn btn-info" value="HQ Interface"/>  
        <br/><br/>

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
