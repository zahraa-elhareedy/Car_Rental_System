<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="form">
        <form name="update_status" id="update_status"  method="post" action="" class= "update-status-form"  > 
            <h2>Update Status</h2> 
                <?php
                    echo "<h4 style='color:White;'>".'Car_plate '.$_POST['car_plate']."</h4>".'<br>';
                    $plate = $_POST['car_plate'];
                    $conn = new mysqli('localhost','root','','car_rental');
                    if($conn->connect_error){
                        echo "$conn->connect_error";
                        die("Connection Failed : ". $conn->connect_error);
                    } 
                    else {
                        $get_plate = "SELECT `status`,car_plate FROM car WHERE car_plate = '$plate' ";
                        $result = $conn->query($get_plate);
                        $count = $result->num_rows;
                        if($count==0){
                            echo "<h4 style='color:White;'>"."car plate does not exists!"."</h4>".'<br>'.'<a href="admin_main.php">Back</a>';
                            return False;
                        }
                        else{
                            $row = $result->fetch_assoc();
                            echo "<h4 style='color:White;'>"."Current Status is: ".$row["status"]."</h4>";
                            
                            if($row["status"] == "rented")
                            {
                            echo '<br>'."<h4 style='color:White;'>"."Cannot update"."</h4>".'<br>'.'<a href="admin_main.php">Back</a>';
                            
                            }else{
                                ?>
                            
            <input type="hidden" id="car_plate" name="car_plate" value="<?php echo $_POST['car_plate']; ?>">
            <input type="text" id="status" name="status" class="input-box" placeholder="New Status" required >
            <button type="submit" id="submit" name="submit">Update status</button>
            <br><span id="message"></span>
            <?php
                    
                }}
                $conn->close(); 
            }
            ?>
        </form>
    </div>
    <?php
        if(isset($_POST['submit']))
        {
            $status = $_POST['status'];
            if($status != "rented"){
                $plate = $_POST['car_plate'];
                $start_date = date("Y-m-d");
                $date = date_create(date("Y-m-d"));
                date_add($date,date_interval_create_from_date_string("4 years"));
                $end_date = date_format($date,"Y-m-d");
                $conn = new mysqli('localhost','root','','car_rental');
                if($conn->connect_error){
                    echo "$conn->connect_error";
                    die("Connection Failed : ". $conn->connect_error);
                }else{
                    $statement = $conn->prepare("insert into car_status (car_plate,status,start_date,end_date) values(?, ?, ?,?)");
                    $statement->bind_param("ssss", $plate,$status, $start_date, $end_date);
                    $execval = $statement->execute();
                    $statement->close();
                    $statement = $conn->prepare("update car SET `status` = ? where car_plate = ?");
                    $statement->bind_param("ss",$status, $plate);
                    $execval = $statement->execute();
                    $statement->close();
                    $conn->close();
                    header('location:admin_main.php');
                }  
            }else
            {echo '<script>
                var e=document.getElementById("message");
                message.innerHTML = ("Cannot update.");
                </script>';}
        }
    ?> 
</body>
<html>