

<?php
    require("Utils\Connection.php");    
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <?php include 'Links/links.php' ?>
    <style>
        .sidebar{
            position: fixed;
            
            overflow: auto;
            height: auto;
            
        }
        .mainContent{
            height: 100%;
            overflow: auto;
            padding: 2rem;
        }
        .productCard{
            display: flex;
            flex-direction: row;
            gap: 3rem;
            margin: 0.5rem 3rem;
            padding: 1rem 1.7rem;
            border: 1px solid rgb(203, 203, 203);
            background-color: rgb(218, 218, 218);

        }
        .image{

            width: 10rem;
            height: 10rem;
            border-radius: 50%;
        }
        .details{
            display: flex;
            flex-direction: column;
            gap : 0.7rem;

        }
        .title{
            color:  #EDA43D;
        }

        .content{

            display: grid;
            grid-template-columns: 1fr 1fr;
            row-gap: 0.4rem;
        }
    </style>
</head>

<body>
    <?php
        require('Utils\Navbar.php');
        $uId = $_SESSION['uId'];
        
        $sql = "SELECT `oId`, `oName`, `uId`, `price`, `photo`, `number`, `deliveryDate`, `status`, `pPrice`, `pQuantity` FROM `orders` WHERE `uId` = '$uId' AND `status` = 'successfull'";

        $result = mysqli_query($conn, $sql);
       
        if(!$result){
            echo '
                <script>
                    alert("Error occured while fetching data");
                </script>
            ';
        }
        

    ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 text-light" style="background-color :  #EDA43D; color:white; height:92vh;">
                <ul class="nav flex-column align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.php" style="color:white; ">Profile</a>
                    </li>
                    <?php
                        if(isset($_SESSION) && $_SESSION['role'] == 'customer'){
                            echo '
                                <li class="nav-item">
                                    <a class="nav-link" href="History.php" style="color:white; font-weight:bold;">History</a>
                                </li>
                            ';
                        }
                        else{
                            echo '
                                <li class="nav-item">
                                    <a class="nav-link" href="HistoryAdmin.php" style="color:white; font-weight:bold;">History</a>
                                </li>
                            ';

                        }
                    ?>

                    
                    <li class="nav-item">
                        <a class="nav-link" href="OrdersUsers.php" style="color:white">Orders</a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 h-1000">
                <h1 class="" style="color:#EDA43D; margin-top:2%; margin-left:3.5%;">History</h1>
                <div class="container d-flex" style="flex-direction:column; gap:0.5rem; margin-top: 2rem;">
                    <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $dateString = $row['deliveryDate']; // Date-time string from the database
                            $timestamp = strtotime($dateString);

                            if ($timestamp !== false) {
                                $formattedDate = date('j F, Y', $timestamp);
                            }
                            echo '
                                <div class="productCard rounded">
                                <div>
                                    <img src="data:image/jpeg;base64,'.base64_encode($row['photo']).'" class="image">
                                </div>
                                
                                <div class="details">
                                    <h4 class="title">'.$row['oName'].'</h4>
                                    <div class="content">
                                        <div> Price : '.$row['pPrice'].' ₹</div>
                                        <div>Delivery Date : '.$formattedDate.'</div>
                                        <div>Quantity : '.$row['pQuantity'].'</div>
                                        <div>No. of Packets : '.$row['number'].'</div>
                                        <div>Total Price : '.$row['price'].'</div>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                    ?>
                   
                </div>
            </div>
        </div>
    </div>


   

</body>

</html>
