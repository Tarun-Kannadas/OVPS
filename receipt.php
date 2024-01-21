<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment Receipt</title>

    <link rel = "stylesheet" href = "Styles\receipt.css">
</head>

<body>

    <div class="receipt">
        <h2>Payment Receipt</h2>  
        <button onclick="ExitReceipt()" class=button2>Go Back</button>      


        <?php

        $conn = mysqli_connect("localhost", "root", "", "parkingsystem");

        if (!$conn) 
        {
            die("Connection failed" .mysqli_connect_error(die));
        }

        // $sql = "SELECT * FROM tickets ORDER BY id2 DESC LIMIT 1";
        $id = $_GET['id'];

        $sql = "SELECT
                    u.userid,
                    u.username,
                    s.slotnum ,
                    s.vehicletypeslot,
                    t.numberplate,
                    t.timein,
                    t.timeout,
                    t.dateofbooking,
                    t.extratime,
                    p.price,
                    p.paymentid,
                    p.extraprice
                FROM
                    users u
                JOIN
                    tickets t ON u.userid = t.userid
                JOIN
                    slot s ON t.ticketid = s.ticketid
                LEFT JOIN
                    payment p ON s.slotnum = p.slotnum
                where t.ticketid = $id";

        $result = mysqli_query($conn,$sql);

        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);

            $vtype = $row['vehicletypeslot'];

            // Display the values
            echo "<div class='details'>";
            echo "<p><strong>Username: </strong> " . $row['username'] . "</p>";
            echo "<p><strong>Ticket Number: </strong> " . '#'.$id . "</p>";
            echo "<p><strong>Time In: </strong> " . $row['timein'] . "</p>";
            echo "<p><strong>Time Out: </strong>" . $row['timeout'] . "</p>";
            echo "<p><strong>Extra Time: </strong>" . $row['extratime'].'hrs'. "</p>";

            // Display the system date as the booking date
            echo "<p><strong>Date of Booking: </strong> " . date('Y-m-d') . "</p>";
            // echo "<p><strong>Ticket's Date: </strong> " . $row['dateofbooking'] . "</p>";

            echo "<p><strong>Slot Number: </strong> " . '#'.$row['slotnum'] . "</p>";

            $vehicletype = [1 => 'Two Wheeler',2 => 'Four Wheeler',3 => 'Electric Two Wheeler',4 => 'Electric Two Wheeler'];
            $vehicletype2 = $vehicletype[$vtype];

            echo "<p><strong>Type Of Vehicle: </strong>" . $vehicletype2 . "</p>";

            // Assuming GST is 10% (adjust accordingly)
            // $gst = $row['price2'] * 0.1;
            // echo "<p><strong>GST (10%):</strong> $" . $gst . "</p>";
            // echo "</div>";

            // Total cost including GST
            // $totalCost = $row['price2'] + $gst;
            $totalCost = $row['price'] + $row['extraprice'];
            echo "<p class='total'><strong>Price Of Ticket:</strong> $" . $row['price'] . "</p>";
            echo "<p class='total'><strong>Extra Time Price:</strong> $" . $row['extraprice'] . "</p>";
            echo "<p class='total'><strong>Total:</strong> $" . $totalCost . "</p>";

        } 
        else 
        {
            echo "No results found";
        }

        $conn->close();
        ?>

        <button onclick="printReceipt()" class='button1'>Print Receipt</button>
        
    </div>

    <script>
        function printReceipt() 
        {
            window.print();
        }

        function ExitReceipt() 
        {
            window.location = "homepage.php";
        }
    </script>

</body>

</html>
