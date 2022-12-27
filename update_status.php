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
                    $conn = new mysqli('localhost','root','','car_rental');
                    if($conn->connect_error){
                        echo "$conn->connect_error";
                        die("Connection Failed : ". $conn->connect_error);
                    } 
                    else {
                        $get_plate = "SELECT * FROM car_status WHERE car_plate = '$plate'  order by start_date desc limit 1 ";
                        $result = $conn->query($get_plate);
                        $count = $result->num_rows;
                        if($count==0){
                            echo "<h4 style='color:White;'>"."car plate does not exists!"."</h4>".'<br>';
                        }
                        else{
                            $row = $result->fetch_assoc();
                            echo "<h4 style='color:White;'>"."Current Status is: ".$row["status"]."</h4>";
                            if($start_date<=$row['start_date']){
                                echo "<h4 style='color:White;'>"."Date Doesn't Cover Last Updated Status"."</h4>";

                            }elseif($row["status"] == "rented")
                            {
                            echo '<br>'."<h4 style='color:White;'>"."Cannot update"."</h4>";
                            
                            }else{
                                ?>
                            
            <input type="hidden" id="car_plate" name="car_plate" value="<?php echo $_POST['car_plate']; ?>">
            <input type="hidden" id="startdate" name="startdate" value="<?php echo $_POST['startdate']; ?>">
            <input type="text" id="status" name="status" class="input-box" placeholder="New Status" required >
            <button type="submit" id="submit" name="submit">Update status</button>
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
            $status = $_POST['status'];
            if($status != "rented"){
                if($status == "available")
                {
                    $state="inactive";
                }else{
                    $state="available";
                }
                $plate = $_POST['car_plate'];
                $start_date = $_POST['startdate'];
                $conn = new mysqli('localhost','root','','car_rental');
                if($conn->connect_error){
                    echo "$conn->connect_error";
                    die("Connection Failed : ". $conn->connect_error);
                }else{
                    $statement = $conn->prepare("insert into car_status (car_plate,status,start_date) values(?, ?, ?)");
                    $statement->bind_param("sss", $plate,$status, $start_date);
                    $execval = $statement->execute();
                    $statement->close();
                    $statement = $conn->prepare("update car_status SET end_date = ? where car_plate = ? AND status = ? order by start_date desc limit 1");
                    $statement->bind_param("sss",$start_date, $plate,$state);
                    $execval = $statement->execute();
                    $statement->close();
                    $statement = $conn->prepare("update car SET status = ? where car_plate = ?");
                    $statement->bind_param("ss",$status, $plate);
                    $execval = $statement->execute();
                    $statement->close();
                    $conn->close();
                    echo'<script>
                    alert("Car Status Update Done");
                    window.location = "admin_main.php";
                    </script>';
                }  
            }else
            {echo '<script>
                var e=document.getElementById("message");
                message.innerHTML = ("Cannot update. Only use available/inactive");
                </script>';}
        }
    ?> 
</body>
<html>