<!DOCTYPE html>
<html>
    <head>
        <title>Sanction</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 4px;
        }
            .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    </head>
    <body>
        <div class="container">
            <h1>Sanctioning Quotes</h1>
            <h2><a href="processquote.php" class="button">Process Quotes</a></h2>
            <h2><a href="login.php" class="button">Sign Out</a></h2>
        </div>

        <?php

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
                    echo "<td><form action='email.php' method='post'><input type='hidden' name='quote_id' value='".$row['Repair_Order_Num']."'><input type='submit' name='submit' value='SEND'></form></td>"; // add the submit button in the new column
                    echo "</tr>";
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

        // *** the following is script for connecting to the local quote DB *** -->

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
                $ro = $Qpdo->prepare("SELECT * FROM quote_db WHERE status = 'finalized';");
                $ro->execute();
                $rows = $ro->fetchALL(PDO::FETCH_ASSOC);
                draw_table($rows);



//choose option
                echo "<form method=POST action= >";
                echo "<b>Enter Repair Order Number (EDIT QUOTE): </b>";
                echo '<input type="text" name="Ero_num" value=""/>';
                echo '<input type="submit" name="go" value="GO/CLEAR"/> <br/>';
                echo "\n";
                echo "</form>";

                
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
        echo "<meta http-equiv='refresh' content='0'>";
    }
    else
    {                               
        echo "!!! ERROR WHEN UPDATING DATA !!!";
        echo "<br/>";
    }
}

    ?>

    <form action='apply_discount.php' method='post'>
        <label>
            <input type='radio' name='discount_type' value='percentage' checked> Percentage (%)
        </label>
        <label>
            <input type='radio' name='discount_type' value='number'> Number ($)
        </label>
        <input type='number' name='discount_value' placeholder='Enter discount value'>
        <input type='number' name='repair_order_num' placeholder='Enter repair order number'>
        <input type='submit' name=`nsumbit` value='Apply Discount'>
    </form>


    </body>
</html>
