<html>
<head>
    <title>Ticket Booking</title>
    <link rel = "stylesheet" href = "Styles\webpagestyle.css">
</head>
<body>
    <?php include 'menu.php'?>
    <br><br>
    <div class = "centering">
        <div class = "centerstyle">
            <form action="" method="post">
                <h1>Ticket Booking</h1>
                <br>
                <center><label for="vehicletype">Vehicle Type:</label></center>
                <select id="vehicletype" name="vehicletype">
                    <option value="1" >Two Wheelers</option>
                    <option value="2">Four Wheelers</option>
                    <option value="3">Electric Two Wheelers</option>
                    <option value="4">Electric Four Wheelers</option>
                </select>
                <br><br>
                <center><label for = "numberplate">Vehicle Number Plate: </label></center>
                <input type = "text" id = "numberplate" name = "numberplate" placeholder = "Enter Vehicle Numberplate" autocomplete="off" required>
                <br><br>
                <center><label for = "ticketdate">Choose a Date: </label></center>
                <input type = "date" id = "ticketdate" name = "ticketdate" min = "<?php echo date('Y-m-d'); ?>" required>
                <br><br>
                <center><label for = "time-in">Time In:</label></center>
                <input type="time" id="timein" name="timein" min="<?php echo date('H:i'); ?>" required>
                <br><br>
                <center><label for = "time-out">Time Out:</label></center>
                <input type = "time" id = "timeout" name = "timeout" required>
                <br><br>
                <input type = "submit" name = "booking" value = "Book Ticket">
            </form>
            <br>
        </div>

        <?php

            // Allows user to book ticket
            if (isset($_POST['booking']))
            {
                $con = mysqli_connect("localhost","root","","parkingsystem");

                if(!$con)
                {
                    die("</br></br>Connection Failed!".mysqli_connect_error(die));
                }   

                $id = $_SESSION["id"];
                
                $Vehicle = $_POST['vehicletype'];
                $_SESSION["vtype"] = $Vehicle;

                $numberplate = $_POST['numberplate'];
                $_SESSION["numplate"] = $numberplate;
                
                $ticketdate = $_POST['ticketdate'];
                $Timein = $_POST['timein'];
                $Timeout = $_POST['timeout'];

                // Check if username has already booked a ticket
                $checknumberplatequery = "SELECT * FROM tickets where numberplate = '$numberplate'";
                $checknumberplateresult = mysqli_query($con,$checknumberplatequery);

                $row = mysqli_fetch_assoc($checknumberplateresult);

                if(mysqli_num_rows($checknumberplateresult) > 0)
                {
                    echo "<script>alert('$username has already booked a ticket for the same vehicle number $numberplate!');</script>";
                }
                else
                {
                    $sql = "insert into tickets(timein,timeout,ticketdate,vehicletype,numberplate,userid) values ('$Timein','$Timeout','$ticketdate', '$Vehicle','$numberplate','$id')";

                    if(mysqli_query($con,$sql))
                    {
        

                        echo "<script>alert('Ticket Successfully Created');</script>";
                        // sleep(3);

                        echo"<script>window.location='slotbooking.php';</script>";
                        exit();
                    }
                    else
                    {
                        echo "<script>alert('Ticket was Not Created!');</script>";
                    }
                }
                mysqli_close($con);
            }
        ?>
    </div>
</body>
</html>