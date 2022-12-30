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
            <th>Start Date</th>
			<th>End Date</th>
            <th>Return Date</th>
            <th>Reservation Number</th>
            <th>Is Returned?</th>
            <th>Customer ID</th>
			<th>Name</th>
			<th>Email</th>
            <th>Car Plate</th>
            <th>Model</th>
            <th>Model Year</th>
            <th>Color</th>
            <th>Daily Payment</th>
            <th>Office ID</th>
            <th>Image</th>
         
			
		</tr>
	
    <?php
    $start_date = $_POST['startdate'];
    $end_date = $_POST['enddate'];
        $conn = new mysqli('localhost', 'root', '', 'car_rental');
        if ($conn->connect_error) {
            echo "$conn->connect_error";
            die("Connection Failed : " . $conn->connect_error);
        }
        else{
            $statement = $conn->prepare("select * from registration as r join car as c on r.car_plate=c.car_plate join customer as cust on r.cust_id=cust.cust_id  where r.start_date between ? AND ? order by start_date ") ;
            $statement->bind_param("ss",$start_date, $end_date);
            $statement->execute();
            $statement_result = $statement->get_result();
            $count= $statement_result->num_rows;
            $statement->close();
            if ($count != 0) {
                // Process all rows
                while ($row = mysqli_fetch_array($statement_result)) {
                    
                    
                        echo "<tr>";
                        echo "<td>" . $row['start_date'] . "</td>";
                        echo "<td>" . $row['end_date'] . "</td>";
                        echo "<td>" . $row['return_date'] . "</td>";
                        echo "<td>" . $row['register_no'] . "</td>";
                        if($row['is_returned']==1)
                        {echo "<td style='background-color:aliceblue;'> Yes </td>";}
                        else{echo "<td style='background-color:aliceblue;'> No </td>";}
                        echo "<td>" . $row['cust_id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['car_plate'] . "</td>";
                        echo "<td>" . $row['model'] . "</td>";
                        echo "<td>" . $row['model_year'] . "</td>";
                        echo "<td>" . $row['color'] . "</td>";
                        echo "<td>" . $row['daily_price'] . "</td>";
                        echo "<td>" . $row['office_id'] . "</td>";
                        echo "<td><img width='100' height='100'  src='uploads/".$row['image']."'></td>";
                        
                       
                        
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