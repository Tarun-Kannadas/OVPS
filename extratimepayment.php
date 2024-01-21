<html>
<head>
    <title>Add Extra Time</title>
    <link rel = "stylesheet" href = "Styles\extratimepayment.css">
</head>
<body>
    <?php include 'menu.php' ?>
    <br><br>

    <?php

        $id = $_GET["id"];

        $con = mysqli_connect("localhost", "root", "", "parkingsystem");
        
        if (!$con) 
        {
            die("Connection Failed!" . mysqli_connect_error());
        }          

        $sql1 = "select * from tickets where ticketid = '$id'";
        
        $result1 = mysqli_query($con, $sql1);        
        
        if ($result1) 
        {
            $row = mysqli_fetch_assoc($result1);

            $vtype = $row['vehicletype'];
            $ticid = $row['ticketid'];
            $time1 = $row['timein'];
            $time2 = $row['timeout'];
            $numberplate = $row['numberplate'];
            $vehicletype = [1 => 'Two Wheeler',2 => 'Four Wheeler',3 => 'Electric Two Wheeler',4 => 'Electric Two Wheeler'];
            $vehicletype2 = $vehicletype[$vtype];
            $dateofbooking = $row['dateofbooking'];
            $ticketid = $row['ticketid'];

            $formattedtime1 = date("H:i:s", strtotime($time1));
            $formattedtime2 = date("H:i:s", strtotime($time2));

            echo "<div class='centering2'>";
                echo "<div class='centerstyle2'>";
                    echo "<label>Ticket Number:</label>";
                    echo "<input type='text' value='$ticketid' readonly>";
                    echo "<br><br>";
                    echo "<label>Username:</label>";
                    echo "<input type='text' value='$username' readonly>";
                    echo "<br><br>";
                    echo "<label>Vehicle Type:</label>";
                    echo "<input type='text' value='$vehicletype2' readonly>";
                    echo "<br><br>";
                    echo "<center><label>Ticket Date:</label></center>";
                    echo "<input type='date' value='$dateofbooking' readonly>";
                    echo "<br><br>";
                    echo "<center><label>Time In:&nbsp;&nbsp;</label></center>";
                    echo "<input type='time' value='$formattedtime1' readonly>";
                    echo "<br><br>";
                    echo "<center><label>Time Out:&nbsp;&nbsp;</label></center>";
                    echo "<input type='time' value='$formattedtime2' readonly>";
                
                    $sql2 = "select slotnum from slot where ticketid = $ticid";
                    
                    $result2=mysqli_query($con,$sql2);

                    // $sql5 = "SELECT extraprice"
                
                    $row=mysqli_fetch_assoc($result2);
                
                    $slot=$row['slotnum'];
                
                    echo "<br><br>";
                    echo "<label>Slot Number:</label>";
                    echo "<input type='text' value='$slot' readonly>";
                    echo "<br><br>";

                    if ($vtype == 1) 
                    {
                        $price=7;
                    } 
                    else if ($vtype == 2) 
                    {
                        $price=10;
                    } 
                    else if ($vtype == 3) 
                    {
                        $price=5;
                        echo "Congrats on owning an Electric Two Wheeler";
                    } 
                    else 
                    {
                        $price=7;
                        echo "Congrats on owning an Electric Four Wheeler";
                    }

                    $sql3 = "SELECT extratime from tickets where ticketid = $id";

                    $result3 = mysqli_query($con,$sql3);

                    $row = mysqli_fetch_assoc($result3);

                    $extratime = $row['extratime'];

                    // echo $timediff;

                    if($extratime!=0)
                    {
                    $price = $price * $extratime;
                    }

                    echo"<form action='' method='post'>";
                        echo "<br>";
                        echo "<label>Price of Ticket:</label>";
                        echo "<input type='text' value='$price' readonly>";
                        echo "<br><br>";
                        echo"<input type='submit' class = 'payment' name='pay' value='Buy Extra Time'>";
                    echo"</form>";

                echo "</div>";
            echo "</div>";
        }

        // Check if the form is submitted
        if(isset($_POST['pay']))
        {

            $sql4 = "UPDATE payment SET extraprice = '$price' WHERE slotnum = '$slot'";

            $result4 = mysqli_query($con,$sql4);

            if($result4)
            {
                echo "<script>alert('Payment Confirmed for $username \\n vehicle number $numberplate \\n slot number $slot \\n Additional Time is $extratime hr');</script>";
                echo "<script>window.location='homepage.php?slot=$slot';</script>";
            }
            else
            {
                echo"<script>alert('no')</script>";

            }
        }
    ?>
</body>
</html>

