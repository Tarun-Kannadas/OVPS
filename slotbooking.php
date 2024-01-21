<html>
    <head> 
        <title>Slot Booking</title>
        <link rel = "stylesheet" href = "Styles\slots.css">
    </head>
    <body>
        <?php include 'menu.php'?>

        <?php
            $id = $_SESSION["id"];
            $username = $_SESSION["username"];
            $numberplate = $_SESSION["numplate"];
            
            $con = mysqli_connect("localhost", "root", "", "parkingsystem");
        
            if (!$con) 
            {
                die("Connection Failed!" . mysqli_connect_error(die));
            }
        
            $vtype = $_SESSION["vtype"];

            $sql1 = "SELECT
                            t.ticketid,
                            t.timein,
                            t.timeout,
                            u.username,
                            u.userid
                        FROM
                            tickets t
                        JOIN
                            users u ON t.userid = u.userid
                            where numberplate = '$numberplate';
                        ";
        
            $result1 = mysqli_query($con, $sql1);   

            if ($result1 && mysqli_num_rows($result1) > 0) 
            {
                $row = mysqli_fetch_assoc($result1);

                $ticketid = $row['ticketid'];
                $_SESSION["ticketnum"] = $ticketid;
                
                $time1 = $row['timein'];
                $time2 = $row['timeout'];

                $formattedtime1 = date("H:i:s", strtotime($time1));
                $formattedtime2 = date("H:i:s", strtotime($time2));

                echo "<div class = 'main'>";
                    echo "<div class='style2'>";
                        echo "<center><h1> Slot Booking </h1></center>";
                        echo "<center><label>Ticket Number:</label></center>";
                        echo "<center><input type='text' value='$ticketid' readonly></center>";
                        echo "<center><label>Username:</label></center>";
                        echo "<center><input type='text' value='$username' readonly></center>";
                        echo "<center><label><br>Vehicle Type:</label></center>";
                        if ($vtype == 1) 
                        {
                            echo "<center><input type='text' value='Two Wheeler' readonly></center>";
                        } 
                        else if ($vtype == 2) 
                        {
                            echo "<center><input type='text' value='Four Wheeler' readonly></center>";
                        } 
                        else if ($vtype == 3) 
                        {
                            echo "<center><input type='text' value='Electric Two Wheeler' readonly></center>";
                        } 
                        else 
                        {
                            echo "<center><input type='text' value='Electric Four Wheeler' readonly></center>";
                        }
                        echo "<center><label><br>Number Plate:</label></center>";
                        echo "<center><input type='text' value='$numberplate' readonly></center>";
                        echo "<center><label><br>Time In:</label></center>";
                        echo "<center><input type='time' value='$formattedtime1' readonly></center>";
                        echo "<center><label><br>Time Out:</label></center>";
                        echo "<center><input type='time' value='$formattedtime2' readonly></center>";

                        //  code for assigning the slot to the user automatically and displaying it

                        echo "<form action = '' method = 'post'>";
            
                            // Fetch the available slot for the specific vehicle type
                            $sql3 = "SELECT * FROM slot WHERE vehicletypeslot = $vtype AND status = 0 LIMIT 1";
                    
                            $result3 = mysqli_query($con, $sql3);
            
                            if(mysqli_num_rows($result3) > 0) 
                            {
                                $row = mysqli_fetch_assoc($result3);
                                $slotid = $row['slotnum'];
                
                                // Display the automatically assigned slot
                                echo "<center><br><label>Assigned Slot Number:</label></center>";
                                echo "<center><input type='text' value='$slotid' readonly></center>";
                            }
                            else 
                            {
                                echo "<label>No available slots for your vehicle type.</label>";
                            }
                            
                            echo "<br>";
                            echo "<center><input type='submit' class = 'confirm' name='confirm' value='Confirm Slot'></center>";
                            echo "<br>";
                            echo "<center><input type='submit' class = 'cancel' name='cancel' value='Cancel Slot'></center>";

                        echo "</form>";
            
                        if(isset($_POST['confirm'])) 
                        {
                            // Check if the slot is available (slotstatus = 0)
                            $checkSlotQuery = "SELECT status FROM slot WHERE slotnum = $slotid";
                            $checkSlotResult = mysqli_query($con, $checkSlotQuery);
                
                            if ($checkSlotResult) 
                            {
                                $slotData = mysqli_fetch_assoc($checkSlotResult);
                                $slotStatus = $slotData['status'];
                        
                                // If the slot is available, update the slot with user ID and set slotstatus to 1
                                if ($slotStatus == 0) 
                                {
                                    // Check if the entry with the given numberplate already exists in the database
                                    $checkDuplicateQuery = "SELECT * FROM slot WHERE ticketid = '$ticketid'";
                                    $checkDuplicateResult = mysqli_query($con, $checkDuplicateQuery);
                        
                                    if (mysqli_num_rows($checkDuplicateResult) == 0) 
                                    {
                                        $updateSlotQuery = "UPDATE slot SET ticketid = '$ticketid', status = 1 WHERE slotnum = $slotid";
                                        $updateSlotResult = mysqli_query($con, $updateSlotQuery);
                        
                                        if ($updateSlotResult) 
                                        {
                                            echo "<script>
                                                    alert('Slot $slotid has been successfully booked by $username.');
                                                    window.location.href = 'payment.php'; // Redirect to payment page after the alert is closed
                                                  </script>";
                                        } 
                                        else 
                                        {
                                            echo "<script>alert('Failed to book the slot.')</script>";
                                        }
                                    } 
                                    else 
                                    {
                                        echo "<script>alert('Vehicle with numberplate $numberplate is already booked.');</script>";
                                    }
                                } 
                                else 
                                {
                                    echo "<script>alert('Slot $slotid is already occupied by $username. Please choose another slot.');</script>";
                                }
                            } 
                            else 
                            {
                                echo "<script>alert('Failed to check slot availability.');</script>";
                            }
                        }
                        elseif (isset($_POST['cancel'])) 
                        {

                            $deleteTicketQuery = "delete from tickets where ticketid = $ticketid";
                            
                            $deleteTicketResult = mysqli_query($con, $deleteTicketQuery);

                            if ($deleteTicketResult) 
                            {
                                echo "<script>
                                    alert('The Slot $slotid has been Cancelled for booking for $username.');
                                    window.location.href = 'ticket.php'; // Redirect to ticket page after the alert is closed
                                </script>";
                            } 
                            else 
                            {
                                echo "<script>alert('Failed to cancel the booking.');</script>";
                            }
                        }

                    echo "</div>";
                echo "</div>";
            }
            else
            {
                echo "<script>alert('Sorry You Haven't Registered A Slot Yet.');</script>";
            }
        ?>
    </body>
</html>
