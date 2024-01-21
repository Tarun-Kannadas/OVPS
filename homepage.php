<html>
<head>
    <title>Homepage</title>
    <link rel = "stylesheet" href = "Styles\webpagestyle.css">
</head>
<body> 
    <?php include 'menu.php'?>
    <br>
    <?php 
        echo "<div class = textbox2>";
            echo "<center><h1>Welcome $username To Our Online Vehicle Parking System</h1></center>";
        echo "</div>";

    ?>
    <br>
    <div class = textbox>
        <h1>About the System</h1>
        <p class = "div1">
            The Online Vehicle Parking System (OVPS) is a system that enables customers/drivers to book a parking space slot. It also allows the customers/drivers to view the parking status at Lulu Mall. 
            It was developed because the congestion and collision of the vehicles around Edappally all the time, the system was developed for Lulu Mall located in Edappally. 
            Therefore the project aimed at solving such problems by designing a web based system that will enable the customers/drivers to make a book slots of available parking space automatically choosing a lot for people at Lulu Mall.
        </p>
    </div>

    <!-- Table Format -->

    <table class="styled-table">

    <br>
    <br>

    <?php
        // Display Slot/Ticket Details

        $con = mysqli_connect("localhost", "root", "", "parkingsystem");

        $id = $_SESSION["id"];

       $sql="SELECT
                t.ticketid,
                t.timein,
                t.timeout,
                t.extratime,
                t.dateofbooking,
                u.username,
                t.vehicletype,
                t.numberplate,
                u.phonenumber,
                s.slotnum,
                p.price
            FROM
                tickets t
            JOIN
                users u ON t.userid = u.userid
            JOIN
                slot s ON t.ticketid = s.ticketid
            LEFT JOIN
                payment p ON s.slotnum = p.slotnum
                where u.userid=$id;";

        $result = mysqli_query($con, $sql);

        if (!mysqli_num_rows($result))
        {
            echo "<p class = 'notickets'>No Tickets has been booked yet by $username &nbsp;<a href='ticket.php' class = 'click'>Click Here!</a></p>";
        }
        else
        {   
            echo "<div class = textbox3>Check Below for your ticket booked details.</div>";
            echo "<tr>";
            echo "<th>Ticket Number</th>";
            echo "<th>Slot Number</th>";
            echo "<th>Username</th>";
            echo "<th>Vehicle Type</th>";
            echo "<th>Vehicle Number Plate</th>";
            // echo "<th>Price</th>";
            echo "<th>Time In</th>";
            echo "<th>Time Out</th>";
            echo "<th>Extra Time</th>";
            echo "<th>Options</th>";
            echo "</tr>";

            if(mysqli_num_rows($result) > 0)
            {
                while (($row = mysqli_fetch_assoc($result))) 
                {
                    $slotid = $row['slotnum'];
                    $price = $row['price'];
                    $ticketid = $row['ticketid'];
                    $time1 = $row['timein'];
                    $time2 = $row['timeout'];
                    $numberplate = $row['numberplate'];
                    $vtype = $row["vehicletype"];
                    $vehicletype = [1 => 'Two Wheeler', 2 => 'Four Wheeler', 3 => 'Electric Two Wheeler', 4 => 'Electric Two Wheeler'];
                    $vehicletype2 = $vehicletype[$vtype];
                    $extratime = $row['extratime'];
                    $dateofbooking = $row['dateofbooking'];
                            
                    echo "<tr>";
                    echo "<td>$ticketid</td>";
                    echo "<td>$slotid</td>";
                    echo "<td>$username</td>";
                    echo "<td>$vehicletype2</td>";
                    echo "<td>$numberplate</td>";
                    // echo "<td>$price</td>";
                    echo "<td>$time1</td>";
                    echo "<td>$time2</td>";
                    echo "<td>$extratime hrs</td>";
                    echo "<td>
                            <form action='' method='post'>
                                <input type='text' value = '$ticketid' name = 'ticketnum' hidden>
                                <input type='submit' class='delete' name='delete' value='Delete Ticket'>
                                <input type='submit' class='print' name='print' value='Print Ticket'>
                                <input type='submit' class='addtime' name='addtime' value='Extra Time'>
                            </form>
                        </td>";
                    echo "</tr>";
                }
            }
        }

        if (isset($_POST['delete'])) 
        {
            $id = $_POST['ticketnum'];

            $delpay="DELETE FROM payment WHERE slotnum IN (SELECT slotnum FROM slot WHERE ticketid =$id)";
            $delslot="UPDATE `slot` SET `status`=0,`ticketid`=null WHERE ticketid =$id";
            $delticket="DELETE FROM tickets WHERE ticketid =$id" ;
            $data=mysqli_query($con,$delpay);
            $data1=mysqli_query($con,$delslot);
            $data3=mysqli_query($con,$delticket);
            if($data&&$data1&&$data3)
            {
                echo"<script>
                    alert('Ticket $id has been successfully deleted.');
                    window.location.href = 'homepage.php'; // Reload the page
                    </script>";
            }
        }
        if (isset($_POST['print']))
        {
            $id = $_POST['ticketnum'];

            echo "<script>window.location.href = 'receipt.php?id=$id'</script>";
        } 

        if (isset($_POST['addtime']))
        {
            $id = $_POST['ticketnum'];

            echo "<script>window.location.href = 'extratime.php?id=$id'</script>";
        }
    ?>
    </table>
</body>
</html>