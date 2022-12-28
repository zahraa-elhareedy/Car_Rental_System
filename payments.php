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
		<caption><b><h1>Payments</h1></b></caption>
		<tr>
            <th style="background-color:gainsboro;">Day</th>
			<th style="background-color:gainsboro;">Total Payments</th>
			<th style="background-color:gainsboro;">Total Penalties Recieved</th>
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
            $statement = $conn->prepare("select start_date, sum(payment) from registration where start_date between ? AND ? group by start_date ") ;
            $statement->bind_param("ss",$start_date, $end_date);
            $statement->execute();
            $statement_result1 = $statement->get_result();
            $count1= $statement_result1->num_rows;
            $statement = $conn->prepare("select return_date, sum(penalty) from registration where return_date between ? AND ? group by return_date ") ;
            $statement->bind_param("ss",$start_date, $end_date);
            $statement->execute();
            $statement_result2 = $statement->get_result();
            $count2= $statement_result2->num_rows;
            $statement->close();
            $count_date=$start_date;
            if ($count1 != 0 || $count2!=0) {
                // Process all rows
                $row_payment = mysqli_fetch_array($statement_result1);
                    $row_penalty = mysqli_fetch_array($statement_result2);
                while ($count_date <= $end_date) {
                    
                        echo "<tr>";
                        echo "<td style='background-color:gainsboro;'>" . $count_date . "</td>";
                        if($count1 != 0){
                        if($row_payment['start_date']==$count_date )
                        {echo "<td style='background-color:aliceblue;'>" . $row_payment['sum(payment)'] . "</td>";
                            $row_payment = mysqli_fetch_array($statement_result1);
                            $count1--;}
                            else{echo "<td style='background-color:aliceblue;'> 0.00 </td>"; }}
                        else{echo "<td style='background-color:aliceblue;'> 0.00 </td>"; }
                        if($count2 !=0)
                        {if($row_penalty['return_date']==$count_date && $count2 != 0)
                        {
                            echo "<td style='background-color:aliceblue;'>" . $row_penalty['sum(penalty)'] . "</td>";
                            $row_penalty = mysqli_fetch_array($statement_result2);
                            $count2--;
                        }
                        else{echo "<td style='background-color:aliceblue;'> 0.00 </td>"; }}
                            else{echo "<td style='background-color:aliceblue;'> 0.00 </td>"; }
                        echo "</tr>";
                        $count_date=date_create($count_date);
                        date_add($count_date,date_interval_create_from_date_string("1 day"));
                        $count_date=date_format($count_date,"Y-m-d");
                     
                 
                   
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