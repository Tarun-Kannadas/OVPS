<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment Receipt</title>

    <style> 
        body 
        {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .receipt 
        {
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
            text-align: left;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        h2 
        {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.5em;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .details 
        {
            margin-bottom: 20px;
        }

        .details p 
        {
            margin: 10px 0;
            font-size: 1.1em;
            color: #555;
        }

        .total 
        {
            font-weight: bold;
            margin-top: 20px;
            font-size: 1.3em;
            color: #333;
        }

        .button1
        {
            background-color: #ff7f50;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            font-size: 1.2em;
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        .button2
        {
            background-color: #ff7f50;
            color: #fff;
            padding: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            font-size: 1em;
            position: absolute;
            top: 48px;
            right: 20px;
        }

        .button1:hover
        {
            background-color: #e57373;
        }

        .button2:hover 
        {    
        background-color: #e57373;
        }

    </style>
</head>

<body>

    <div class="receipt">
        <h2>Report</h2>  
        <button onclick="ExitReceipt()" class=button2>Go Back</button>      


        <?php

        $conn = mysqli_connect("localhost", "root", "", "parkingsystem");

        if (!$conn) 
        {
            die("Connection failed" .mysqli_connect_error(die));
        }

        // $sql = "SELECT * FROM tickets ORDER BY id2 DESC LIMIT 1";
        $ticketid = $_GET['ticketid'];

        $sql = "SELECT
                    u.userid,
                    u.username,
                    u.phonenumber,
                    s.slotnum ,
                    s.vehicletypeslot,
                    t.numberplate,
                    t.ticketid,
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
                where t.ticketid = $ticketid";

        $result = mysqli_query($conn,$sql);

        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);

            $vtype = $row['vehicletypeslot'];

            // Display the values
            echo "<div class='details'>";
            echo "<p><strong>Username: </strong> " . $row['username'] . "</p>";
            echo "<p><strong>Phone Number: </strong>" . $row['phonenumber'] . "</p>";
            echo "<p><strong>Ticket Number: </strong> " . '#'.$ticketid . "</p>";
            echo "<p><strong>Time In: </strong> " . $row['timein'] . "</p>";
            echo "<p><strong>Time Out: </strong>" . $row['timeout'] . "</p>";

            // Display the system date as the booking date
            // echo "<p><strong>Date of Booking: </strong> " . date('Y-m-d') . "</p>";
            echo "<p><strong>Ticket's Date: </strong> " . $row['dateofbooking'] . "</p>";

            echo "<p><strong>Slot Number: </strong> " . '#'.$row['slotnum'] . "</p>";

            $vehicletype = [1 => 'Two Wheeler',2 => 'Four Wheeler',3 => 'Electric Two Wheeler',4 => 'Electric Two Wheeler'];
            $vehicletype2 = $vehicletype[$vtype];

            echo "<p><strong>Type Of Vehicle: </strong>" . $vehicletype2 . "</p>";
            echo "<p><strong>Ticket Number: </strong>" . '#'.$row['ticketid'] . "</p>";

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

        <button onclick="printReceipt()" class='button1'>Print Report</button>
        
    </div>

    <script>
        function printReceipt() 
        {
            window.print();
        }

        function ExitReceipt() 
        {
            window.location.href = "income.php";
        }
    </script>

</body>

</html>
