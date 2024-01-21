<!DOCTYPE html>
<html lang="en">
<head>
  <style>
    body
    {
      color:black;
      font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
      background: rgb(49, 49, 49);
    }
    
    .slots
    {
      font-size: 45px;
      border: 2px solid white;
      padding: 20px;
    }

    .slotsinsert
    {
      font-size: 25px;
      border: 2px solid white;
      padding: 20px;
    }
  </style>
</head>
<body>
  <?php
  
  $con = mysqli_connect("localhost", "root", "", "parkingsystem");
  if ($con->connect_error) 
  {
      die("Connection failed: " . $con->connect_error);
  }
  $sql = "SELECT slotnum FROM slot";
  $result = mysqli_query($con, $sql);
  $numRows = mysqli_num_rows($result);
  echo "<div class='slots'>";
  echo "Total Slots Added: " . $numRows;
  echo "</div>";

  echo "<div class='slotsinsert'>";
  echo "Want to Add more Slots Added?";
  echo"<form action='' method=post>
        <input type=number name=slots class=slotins>
        <select id='vehicletype' name='vehicletype'>
        <option value='1' >Two Wheelers</option>
        <option value='2'>Four Wheelers</option>
        <option value='3'>Electric Two Wheelers</option>
        <option value='4'>Electric Four Wheelers</option>
    </select>
        <input type=submit name=insert value=ADD class=slotins>
      </form>";
  echo "</div>";
  if (isset($_POST['insert']))
  {
    $slots=$_POST['slots'];
    $vehicle=$_POST['vehicletype'];
    
    for ($i = 0; $i <$slots; $i++)
    {
    $sql2="insert into slot(vehicletypeslot,status) values('$vehicle',0)";
    $data=mysqli_query($con,$sql2);
    if($data)
    {
      echo"<script>
            alert('$slots slots has been successfully added!');
            window.location.href = 'slots.php'; // Reload the page
            </script>";
    }
    }
  }
  mysqli_close($con);
  ?>
</body>
</html>