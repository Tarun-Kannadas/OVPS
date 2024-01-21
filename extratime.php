<html>
<head>
    <title>Add Extra Time</title>
    <link rel = "stylesheet" href = "Styles\extratime.css">
</head>
<body>
    <?php include 'menu.php' ?>
    <br><br>

    <?php

        $id = $_GET['id'];

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

            echo "<div class='centering'>";
                echo "<div class='centerstyle'>";
                    echo "<form action='' method='post'>";
                        echo "<h1>Add Extra Time</h1>";
                        echo "<br>";
                        echo "<label for='extratime'>Extra Time (in hours):</label>";
                        echo "<input type='number' id='extratime' name='extratime' min='1' step='0.5' required>";
                        echo "<br><br>";
                        echo "<label>Ticket Number:</label>";
                        echo "<input type='text' value = '$ticketid' name='ticketid' readonly>";
                        echo "<br><br>";
                        echo "<label>Vehicle Type:</label>";
                        echo "<input type='text' value = '$vehicletype2' name='vehicletype' readonly>";
                        echo "<br><br>";
                        echo "<input type='submit' class='addtime' name='addtime' value='Add Extra Time'>";
                    echo "</form>";
                echo "</div>";

                echo "<div class='price-details'>";
                    echo "<h2>Extra Time Price Details</h2>";
                    echo "<label> Two Wheeler: &nbsp;</label>";
                    echo "<label1> $7/hour </label1>";
                    echo "<br><br>";
                    echo "<label> Four Wheeler: &nbsp;</label>";
                    echo "<label1> $10/hour </label1>";
                    echo "<br><br>";
                    echo "<label> Electric Two Wheeler: &nbsp;</label>";
                    echo "<label1> $5/hour </label1>";
                    echo "<br><br>";
                    echo "<label> Electric Four Wheeler: &nbsp;</label>";
                    echo "<label1> $7/hour </label1>";
                echo "</div>";
            echo "</div>";
        }

        // Check if the form is submitted
        if (isset($_POST['addtime'])) 
        {
            $ticketid = $_POST['ticketid'];
            $extraTime = $_POST['extratime'];

            // Update the ticket with extra time
            $updateQuery = "UPDATE tickets SET timeout = ADDTIME(timeout, '$extraTime:00:00'), extratime = $extraTime WHERE ticketid = $ticketid";
            mysqli_query($con, $updateQuery);

            echo "<script>alert('Extra time added successfully.');</script>";
            echo "<script>window.location='extratimepayment.php?id=$id';</script>";
        }
    ?>
</body>
</html>