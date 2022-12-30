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
		<caption><b><h1>Car Status</h1></b></caption>
		<tr>
            <th>Image</th>
            <th>Plate ID</th>
            <th>Model</th>
            <th>Model Year</th>
            <th>Color</th>
            <th>Status</th>
            <th>Office ID</th>
		</tr>
	
    <?php
        $today = $_POST['today'];
        $conn = new mysqli('localhost', 'root', '', 'car_rental');
        if ($conn->connect_error) {
            echo "$conn->connect_error";
            die("Connection Failed : " . $conn->connect_error);
        }
        else{
            $statement = $conn->prepare("select distinct * from car as c left join car_status as s on c.car_plate=s.car_plate where  s.start_date<= ? AND (s.end_date>= ? or s.end_date is null)") ;
            $statement->bind_param("ss",$today,$today);
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
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['office_id'] . "</td>";
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