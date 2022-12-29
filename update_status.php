<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div>
    <div class="form">
        <form name="update_status" id="update_status"  method="post" action="" class= "update-status-form"  > 
            <h2>Update Status</h2> 
                <?php
                    echo "<h4 style='color:White;'>".'Car_plate '.$_POST['car_plate']."</h4>".'<br>';
                    $plate = $_POST['car_plate'];
                    $start_date=$_POST['startdate'];
                    $end_date=$_POST['enddate'];
                    $conn = new mysqli('localhost','root','','car_rental');
                    if($conn->connect_error){
                        echo "$conn->connect_error";
                        die("Connection Failed : ". $conn->connect_error);
                    } 
                    else {
                        $get_plate = "SELECT * FROM car_status WHERE car_plate = '$plate' order by start_date desc limit 1 ";
                        $result = $conn->query($get_plate);
                        $count = $result->num_rows;
                        if($count==0){
                            echo "<h4 style='color:White;'>"."car plate does not exists!"."</h4>".'<br>';
                        }
                        else{
                            $available="available";
                            $statement1 = $conn->prepare("SELECT * from car_status where car_plate = ? and status= ? and ((start_date < ? and start_date < ? and (end_date > ? or end_date is null)and (end_date > ? or end_date is null)))"); 
                            $statement1->bind_param("ssssss",$plate,$available,$start_date,$end_date,$start_date,$end_date);
                            $statement1->execute();
                            $cars = $statement1->get_result();
                            $statement1->close();
                            if($cars->num_rows == 0)
                            {
                                echo '<br>'."<h4 style='color:White;'>"."Cannot update, Car is not available."."</h4>";
    
                                echo $cars->num_rows ;
                            }else{
                                echo '<br>'."<h4 style='color:White;'>"."Car Status is Available"."</h4>";
                                ?>
                            
            <input type="hidden" id="car_plate" name="car_plate" value="<?php echo $_POST['car_plate']; ?>">
            <input type="hidden" id="startdate" name="startdate" value="<?php echo $_POST['startdate']; ?>">
            <input type="hidden" id="enddate" name="enddate" value="<?php echo $_POST['enddate']; ?>">
            <button type="submit" id="submit" name="submit">Confirm Out of Service</button>
            <br><span id="message" style='color:White;'></span>
            <?php
                    
                }
            }
            echo '<br>'.'<a href="admin_main.php">Back</a>';
                $conn->close(); 
            }
            ?>
        </form>
    </div>
        </div>
    <?php
        if(isset($_POST['submit']))
        {
            $status = 'inactive';
                
            $state="available";
            
            $plate = $_POST['car_plate'];
            $start_date = $_POST['startdate'];
            $end_date = $_POST['enddate'];
            $conn = new mysqli('localhost','root','','car_rental');
            if($conn->connect_error){
                echo "$conn->connect_error";
                die("Connection Failed : ". $conn->connect_error);
            }else{
                $date=date_create($start_date);
                date_sub($date,date_interval_create_from_date_string("1 day"));
                $prev_date=date_format($date,"Y-m-d");
                $statement = $conn->prepare("update car_status SET end_date = ? where car_plate = ? AND status = ? and start_date <= ? order by start_date desc limit 1");
                $statement->bind_param("ssss",$prev_date, $plate,$state,$start_date);//update end of available
                $execval = $statement->execute();
                $statement->close();
                $statement = $conn->prepare("insert into car_status (car_plate,status,start_date,end_date) values(?, ?, ?,?)");
                $statement->bind_param("ssss", $plate,$status, $start_date,$end_date);//insert inactive
                $execval = $statement->execute();
                $statement->close();
                
                $date=date_create($end_date);
                date_add($date,date_interval_create_from_date_string("1 day"));
                $next_date=date_format($date,"Y-m-d");
                $statement = $conn->prepare("insert into car_status (car_plate,status,start_date) values(?, ?, ?)");
                $statement->bind_param("sss", $plate,$state, $next_date);//insert new available
                $execval = $statement->execute();
                $statement->close();
                $conn->close();
                echo'<script>
                alert("Car Status Update Done");
                window.location = "admin_main.php";
                </script>';
            }              
        }
    ?> 
</body>
<html>