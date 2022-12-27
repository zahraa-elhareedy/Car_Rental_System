<!DOCTYPE html>
<html>
<head>
</head>
<body bgcolor="lightblue">
<a style="color:White;" href="reports.php">Back</a>
	<center>
	<table border="1" cellspacing="5" bgcolor="white"
		height="100" width="500" cellpadding="5" id="TableScore">
		<caption><b>Reservations</b></caption>
		<tr>
            <th>Image</th>
            <th>Car Plate</th>
            <th>Model</th>
            <th>Model Year</th>
            <th>Color</th>
            <th>Payment</th>
            <th>Office ID</th>
            <th>Reservation Number</th>
			<th>Start Date</th>
			<th>End Date</th>
            <th>Return Date</th>
            <th>Customer ID</th>
			<th>Name</th>
			<th>Email</th>
		</tr>
	
    <?php
        $cust_email = $_POST['cust_email'];
        $conn = new mysqli('localhost', 'root', '', 'car_rental');
        if ($conn->connect_error) {
            echo "$conn->connect_error";
            die("Connection Failed : " . $conn->connect_error);
        }
        else{
            $statement = $conn->prepare("select * from customer as cust join registration as r on cust.cust_id=r.cust_id join car as c on r.car_plate=c.car_plate  where cust.email = ?") ;
            $statement->bind_param("s",$cust_email);
            $statement->execute();
            $statement_result = $statement->get_result();
            $count= $statement_result->num_rows;
            $statement->close();
            if ($count != 0) {
                // Process all rows
                while ($row = mysqli_fetch_array($statement_result)) {
                    
                        echo "<tr>";
                        echo "<td><img width='100' height='100'  src='uploads/".$row['image']."'></td>";
                        echo "<td>" . $row['car_plate'] . "</td>";
                        echo "<td>" . $row['model'] . "</td>";
                        echo "<td>" . $row['model_year'] . "</td>";
                        echo "<td>" . $row['color'] . "</td>";
                        echo "<td>" . $row['payment'] . "</td>";
                        echo "<td>" . $row['office_id'] . "</td>";
                        echo "<td>" . $row['register_no'] . "</td>";
                        echo "<td>" . $row['start_date'] . "</td>";
                        echo "<td>" . $row['end_date'] . "</td>";
                        echo "<td>" . $row['return_date'] . "</td>";
                        echo "<td>" . $row['cust_id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
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
</body>
</html>