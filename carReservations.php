<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="reports.css">
</head>
<body>
<div>
<a style="color:White;" href="reports.php">Back</a>
	<center>
	<table border="1" cellspacing="5" bgcolor="white"
		height="100" width="500" cellpadding="5" id="TableScore">
		<caption><b><h1>Reservations</h1></b></caption>
		<tr>
            <th>Image</th>
            <th>Start Date</th>
            <th>Return Date</th>
            <th>Car Plate</th>
            <th>Model</th>
            <th>Model Year</th>
            <th>Color</th>
            <th>Payment</th>
            <th>Office ID</th>
            <th>Reservation Number</th>
			<th>Is Returned?</th>
            <th>Customer ID</th>
			<th>Name</th>
			<th>Email</th>
		</tr>
	
    <?php
    $start_date = $_POST['startdate'];
    $end_date = $_POST['enddate'];
    $car_plate = $_POST['car_plate'];
        $conn = new mysqli('localhost', 'root', '', 'car_rental');
        if ($conn->connect_error) {
            echo "$conn->connect_error";
            die("Connection Failed : " . $conn->connect_error);
        }
        else{
            $statement = $conn->prepare("select * from registration as r join car as c on r.car_plate=c.car_plate join customer as cust on r.cust_id=cust.cust_id  where r.start_date between ? AND ? AND r.car_plate =?") ;
            $statement->bind_param("sss",$start_date, $end_date, $car_plate);
            $statement->execute();
            $statement_result = $statement->get_result();
            $count= $statement_result->num_rows;
            $statement->close();
            if ($count != 0) {
                // Process all rows
                while ($row = mysqli_fetch_array($statement_result)) {
                    
                        echo "<tr>";
                        echo "<td><img width='100' height='100'  src='uploads/".$row['image']."'></td>";
                        echo "<td>" . $row['start_date'] . "</td>";
                        echo "<td>" . $row['return_date'] . "</td>";
                        echo "<td style='background-color:aliceblue;'>" . $row['car_plate'] . "</td>";
                        echo "<td style='background-color:aliceblue;'>" . $row['model'] . "</td>";
                        echo "<td style='background-color:aliceblue;'>" . $row['model_year'] . "</td>";
                        echo "<td style='background-color:aliceblue;'>" . $row['color'] . "</td>";
                        echo "<td style='background-color:aliceblue;'>" . $row['payment'] . "</td>";
                        echo "<td style='background-color:aliceblue;'>" . $row['office_id'] . "</td>";
                        echo "<td style='background-color:aliceblue;'>" . $row['register_no'] . "</td>";
                        if($row['is_returned']==1)
                        {echo "<td style='background-color:aliceblue;'> Yes </td>";}
                        else{echo "<td style='background-color:aliceblue;'> No </td>";}
                        echo "<td style='background-color:aliceblue;'>" . $row['cust_id'] . "</td>";
                        echo "<td style='background-color:aliceblue;'>" . $row['name'] . "</td>";
                        echo "<td style='background-color:aliceblue;'>" . $row['email'] . "</td>";
                        echo "</tr>";
                     
                    $count--;
                }
                echo "</table>"."</center>";
            } else {
                echo "Not Found";
            }
            $conn->close();

        }
     ?>
</div>
</body>
</html>