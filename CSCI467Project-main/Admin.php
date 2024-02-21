<html>
	<head>
		<title>Quote 2B</title>
    	
<?php
      echo ' <a href="Home.php">Home</a>';

	session_start();
	error_reporting(E_ALL);
	
try
{

      if(isset($_POST["associate"]))  
      {  
      	header("location:viewAssociates.php"); 
      }

      if(isset($_POST["quotes"]))  
      {  
      	header("location:viewQuotes.php"); 
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
    <h1>Admin Home Page</h1>
    <h2>Choose parameter to view:</h2>
    <form method="post">  
        <br/> 
        <input type="submit" name="associate" class="btn btn-info" value="Sales Associate data"/>  
        <input type="submit" name="quotes" class="btn btn-info" value="Quote data"/>  
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
