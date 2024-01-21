<html>
<head>
    <title>Ticket Booking</title>
    <link rel="stylesheet" href="Styles\ticket.css">
</head>
<body>
    <?php include 'menu.php'?>
    <br><br>
    <?php

        $con = mysqli_connect("localhost", "root", "", "parkingsystem");

        if (!$con) 
        {
            die("</br></br>Connection Failed!" . mysqli_connect_error());
        }

        $id = $_SESSION["id"];

        // Check if the user has booked a ticket before
        $checkTicketQuery = "SELECT * FROM tickets WHERE userid = '$id'";
        $checkTicketResult = mysqli_query($con, $checkTicketQuery);

        if (mysqli_num_rows($checkTicketResult) > 0) 
        {
            // User has booked a ticket before, check if they have submitted feedback
            $checkFeedbackQuery = "SELECT * FROM feedbacks WHERE userid = '$id'";
            $checkFeedbackResult = mysqli_query($con, $checkFeedbackQuery);

            if (mysqli_num_rows($checkFeedbackResult) == 0) 
            {
                // User has not submitted feedback, redirect to feedback form
                echo "<script>alert('Please provide a feedback before booking another ticket');</script>";
                
                sleep(1);

                echo "<script>window.location='feedback.php';</script>";                
                exit();
            }
        }

        // User is allowed to book a ticket
    ?>
    <div class="centering">
        <div class="centerstyle">
            <form action="" method="post">
                <h1>Ticket Booking</h1>
                <br>
                <center><label for="vehicletype">Vehicle Type:</label></center>
                <select id="vehicletype" name="vehicletype">
                    <option value="1">Two Wheelers</option>
                    <option value="2">Four Wheelers</option>
                    <option value="3">Electric Two Wheelers</option>
                    <option value="4">Electric Four Wheelers</option>
                </select>
                <br><br>
                <center><label for="numberplate">Vehicle Number Plate: </label></center>
                <input type="text" id="numberplate" name="numberplate" oninput="this.value = this.value.toUpperCase();" placeholder="Enter Vehicle Numberplate" autocomplete="off" required>
                <br><br>
                <center><label for = "dateofbooking">Date of Ticket Booking: </label></center>
                <input type = "text" id = "dateofbooking" name = "dateofbooking" value = "<?php echo date('d-m-Y'); ?>" readonly>
                <br><br>
                <center><label for = "time-in">Time In:</label></center>
                <input type="time" id="timein" name="timein" required>
                <script>
                        // Get the current time
                        var currentTime = new Date();
                        var currentHours = currentTime.getHours();
                        var currentMinutes = currentTime.getMinutes();

                        // Function to update the min attribute based on current time
                        function updateMinTime() 
                        {
                            var timeInput = document.getElementById("timein");
                            var selectedHours = parseInt(timeInput.value.split(":")[0]);
                            var selectedMinutes = parseInt(timeInput.value.split(":")[1]);

                            if (selectedHours < currentHours || (selectedHours === currentHours && selectedMinutes < currentMinutes)) 
                            {
                                // If the selected time is earlier than the current time, reset to the current time
                                timeInput.value = (currentHours < 10 ? "0" : "") + currentHours + ":" + (currentMinutes < 10 ? "0" : "") + currentMinutes;
                            }
                        }

                        // Attach the function to the input's change event
                        document.getElementById("timein").addEventListener("input", updateMinTime);

                        // Set the initial min attribute
                        updateMinTime();
                    </script>
                <br><br>
                <center><label for="time-out">Time Out:</label></center>
                <input type="time" id="timeout" name="timeout" required>
                <script>
                        // Get the current time
                        var currentTime = new Date();
                        var currentHours = currentTime.getHours();
                        var currentMinutes = currentTime.getMinutes();

                        // Function to update the min attribute based on current time
                        function updateMinTime() 
                        {
                            var timeInput = document.getElementById("timeout");
                            var selectedHours = parseInt(timeInput.value.split(":")[0]);
                            var selectedMinutes = parseInt(timeInput.value.split(":")[1]);

                            if (selectedHours < currentHours || (selectedHours === currentHours && selectedMinutes < currentMinutes)) 
                            {
                                // If the selected time is earlier than the current time, reset to the current time
                                timeInput.value = (currentHours < 10 ? "0" : "") + currentHours + ":" + (currentMinutes < 10 ? "0" : "") + currentMinutes;
                            }
                        }

                        // Attach the function to the input's change event
                        document.getElementById("timeout").addEventListener("input", updateMinTime);

                        // Set the initial min attribute
                        updateMinTime();
                    </script>
                <br><br>
                <input type="submit" class = "booking" name="booking" value="Book Ticket">
            </form>
            <br>
        </div>
        <?php
            if (isset($_POST['booking'])) 
            {
                // Your ticket booking logic here
                $Vehicle = $_POST['vehicletype'];
                $_SESSION["vtype"] = $Vehicle;

                $numberplate = $_POST['numberplate'];
                $_SESSION["numplate"] = $numberplate;

                $dateofbooking = $_POST['dateofbooking'];
                $Timein = $_POST['timein'];
                $Timeout = $_POST['timeout'];

                function isValidNumberPlate($numberplate) 
                {
                    // Define a regular expression pattern for a valid number plate
                    $patternTwoWheeler = '/^[A-Z]{2}\s\d{1,2}\s[A-Z]{1,2}\s\d{4}$/';
                    $patternFourWheeler = '/^[A-Z]{2}\s[A-Z0-9]{2}\s\d{1,2}\s\d{4}$/';
                
                    // Check if the number plate matches either pattern for two-wheelers or four-wheelers
                    return preg_match($patternTwoWheeler, strtoupper($numberplate)) === 1 ||
                           preg_match($patternFourWheeler, strtoupper($numberplate)) === 1;
                }                

                if (isValidNumberPlate($numberplate)) 
                {
                    // Check if username has already booked a ticket
                    $checknumberplatequery = "SELECT * FROM tickets where numberplate = '$numberplate'";
                    $checknumberplateresult = mysqli_query($con, $checknumberplatequery);

                    $row = mysqli_fetch_assoc($checknumberplateresult);

                    if (mysqli_num_rows($checknumberplateresult) > 0) 
                    {
                        echo "<script>alert('$username has already booked a ticket for the same vehicle number $numberplate!');</script>";
                    } 
                    else 
                    {
                        $sql = "insert into tickets(timein,timeout,dateofbooking,vehicletype,numberplate,userid) values ('$Timein','$Timeout','$dateofbooking', '$Vehicle','$numberplate','$id')";

                        if (mysqli_query($con, $sql)) 
                        {
                            echo "<script>alert('Ticket Successfully Created');</script>";
                            echo "<script>window.location='slotbooking.php';</script>";
                            exit();
                        } 
                        else 
                        {
                            echo "<script>alert('Ticket was Not Created!');</script>";
                        }
                    }
                } 
                else 
                {
                    echo "<script>alert('Invalid Number Plate format.');</script>";
                }
                mysqli_close($con);
            }
        ?>
    </div>
</body>
</html>