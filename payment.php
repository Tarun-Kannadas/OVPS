<html>
<head> 
    <title>Payment Gateway</title>
    <link rel = "stylesheet" href = "Styles\payment.css">
</head>
<body>
    <?php include 'menu.php'?>

    <center><h1> Payment </h1></center>

    <?php
        $id = $_SESSION["id"];

        $con = mysqli_connect("localhost", "root", "", "parkingsystem");
        
        if (!$con) 
        {
            die("Connection Failed!" . mysqli_connect_error());
        }
        
        $vtype = $_SESSION["vtype"];            
        $numberplate = $_SESSION["numplate"];


        $sql1 = "select numberplate, timein, timeout,ticketid from tickets where numberplate = '$numberplate'";
        
        $result1 = mysqli_query($con, $sql1);        
        
        if ($result1) 
        {
            $row = mysqli_fetch_assoc($result1);

            $ticid=$row['ticketid'];
            $time1=$row['timein'];
            $time2=$row['timeout'];
            $numberplate = $row['numberplate'];
            $vehicletype = [1 => 'Two Wheeler',2 => 'Four Wheeler',3 => 'Electric Two Wheeler',4 => 'Electric Two Wheeler'];
            $vehicletype2 = $vehicletype[$vtype];
            $ticketid = $_SESSION['ticketnum'];

            $formattedtime1 = date("H:i:s", strtotime($time1));
            $formattedtime2 = date("H:i:s", strtotime($time2));

            echo "<div class='center'>";
                echo "<div class='centerstyle'>";
                    echo "<label>Ticket Number:</label>";
                    echo "<input type='text' value='$ticketid' readonly>";
                    echo "<br><br>";
                    echo "<label>Username:</label>";
                    echo "<input type='text' value='$username' readonly>";
                    echo "<br><br>";
                    echo "<label>Vehicle Type:</label>";
                    echo "<input type='text' value='$vehicletype2' readonly>";
                    echo "<br><br>";
                    echo "<label>Time In:&nbsp;&nbsp;</label>";
                    echo "<input type='time' value='$formattedtime1' readonly>";
                    echo "<br><br>";
                    echo "<label>Time Out:&nbsp;&nbsp;</label>";
                    echo "<input type='time' value='$formattedtime2' readonly>";
                
                    $sql2 = "select slotnum from slot where ticketid = $ticid";
                    
                    $result2=mysqli_query($con,$sql2);
                
                    $row=mysqli_fetch_assoc($result2);
                
                    $slot=$row['slotnum'];
                
                    echo "<br><br>";
                    echo "<label>Slot Number:</label>";
                    echo "<input type='text' value='$slot' readonly>";
                
                
                    if ($vtype == 1) 
                    {
                        $price=10;
                    } 
                    else if ($vtype == 2) 
                    {
                        $price=20;
                    } 
                    else if ($vtype == 3) 
                    {
                        $price=5;
                        echo "Congrats on owning an Electric Two Wheeler";
                    } 
                    else 
                    {
                        $price=10;
                        echo "Congrats on owning an Electric Four Wheeler";
                    }

                    $sql3 = "SELECT 
                    SEC_TO_TIME((TIME_TO_SEC(timeout) - TIME_TO_SEC(timein) + 86400) % 86400) AS td
                  FROM tickets where numberplate = '$numberplate'";

                    $result3 = mysqli_query($con,$sql3);

                    $row = mysqli_fetch_assoc($result3);

                    $timediff = $row['td'];
                    
                    
                    $timediff = date("H", strtotime($timediff));

                    // echo $timediff;

                    if($timediff!=0)
                    {
                    $price = $price * $timediff;
                    }

                    echo"<form action='' method='post'>";
                        echo "<br>";
                        echo "<label>Price of Ticket:</label>";
                        echo "<input type='text' value='$price' readonly>";
                        echo "<br><br>";
                        echo"<input type='submit' class = 'payment' name='pay' value='Buy Ticket'>";
                    echo"</form>";
                echo "</div>";

                echo "<div class='price-details'>";
                    echo "<h2>Price Details</h2>";
                    echo "<label> Two Wheeler: &nbsp;</label>";
                    echo "<label1> $10/hour </label1>";
                    echo "<br><br>";
                    echo "<label> Four Wheeler: &nbsp;</label>";
                    echo "<label1> $20/hour </label1>";
                    echo "<br><br>";
                    echo "<label> Electric Two Wheeler: &nbsp;</label>";
                    echo "<label1> $5/hour </label1>";
                    echo "<br><br>";
                    echo "<label> Electric Four Wheeler: &nbsp;</label>";
                    echo "<label1> $10/hour </label1>";
                echo "</div>";
            echo "</div>";
            
            if(isset($_POST['pay']))
            {

                $sql4 = "insert into payment(price,slotnum) values('$price','$slot')";

                $result4 = mysqli_query($con,$sql4);

                if($result4)
                {
                    echo "<script>alert('Payment Confirmed for $username\\nvehicle number $numberplate\\nslot number $slot');</script>";
                    echo "<script>window.location='order.php?slot=$slot';</script>";
                }
                else
                {
                    echo"<script>alert('no')</script>";

                }
            }
        }

    ?>
</body>
</html>

<!-- Duplication of same ticket not fixed yet! -->