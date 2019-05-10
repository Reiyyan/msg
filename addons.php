<!DOCTYPE html>
<html>
<head>
<title>Style Template</title>

<link rel="stylesheet" href="normalize.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="styles.css">
<!--R-->
<!--e-->
<!--i-->
<?php
    session_start();

    if(!isset($_SESSION['discount'])){
        header("Location: login.php");
    }
    
    require 'config.php';
    

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
?>

</head>

<header>
    <!-- Header -->
<?php
    include 'sg-header.php';
?>
</header>

<body>
    <!-- Content here -->
    <?php
        if(isset($_GET["tab"])){
            $tab = $_GET["tab"];
    ?>
    <div class='side-nav' onclick='returnOrder();'>
        <img src='image/return.png'>
        RETURN TO ORDER
    </div>
    <?php
        }
    ?>

    <?php
        if(isset($_GET["order"])){
            $goToOrder = $_GET["order"];
    ?>
    <div class='r-side-nav' onclick='goToOrder();'>
        <img src='image/goTo.png'>
        GO TO ORDER
    </div>
    <?php
        }
    ?>

    <!-- Wrapper -->
    <div class="wrapper">

        <section class="heading">
            <h1 id="title">ADD ONS</h1>
            <hr class="ord-splitter">
        </section>
        <br>
        <br>

        <a href='addons.php#sg-auto'> <img class='logo' src="image/sgr-logo.png"> </a>
        <a href='addons.php#somfy-auto'> <img class='logo' src="image/somfy-logo.png"> </a>

        <hr class='adv-spliiter'>

        <section class='add-section'>
                <!-- <h2>SG Automation</h2>
            <hr class="ord-splitter"> -->

        <section id='sg-auto'>
            <h1 id="" class='title-tag'>Sun Glow</h1>
            <hr class="adv-splitter">
            
            <h2 id="">Controllers</h2>

            <?php
            
            if(isset($_SESSION['discount'])){
               
                $query = ("SELECT * FROM _add_ons where company = 'sunglow' AND type = 'Controllers'");
                
                $result = $conn->query($query);

                while($rows = $result->fetch_assoc())
                {
                    //$myorder = "'" .$rows['orderTag'] ."'" ;
                    $product = $rows['product'];
                    $finish = $rows['finish'];
                    $price = number_format($rows['price'], 2, '.', '');
                    $image = $rows['image'];
                    $code = $rows['code'];

            ?>
            
            <div class="auto-box">
                <img class="prod-img" src="image/addons/<?php echo(strtolower($code));?>.jpg">
                <!-- <form action="include/order_adds.php" method="post">      -->
                <div>       
                    <h4>
                        <?php echo($product);?> –
                        <?php echo($finish);?> –
                        <?php echo($code);?> –
                        $<?php echo($price);?>
                    </h4>
                    <span>Quantity: </span>
                    <input id='<?php echo($code);?> Info' class='temp-details' name='product' value='<?php echo($product);?> - <?php echo($finish);?>'>
                    <input id='<?php echo($code);?> Price' class='temp-details' name='price' value='<?php echo($price);?>'>
                    <input id='<?php echo($code);?> Quantity' class='add-quantity' min=0 step=1  min=0 step=1 type=number name='quantity'>
                        <!-- <button class='sg-next' type="submit" name="order_extra">ADD</button> -->
                        <br><br>
                    <button class='sg-next' id='<?php echo($product);?>' value='<?php echo($code);?>' onclick='addon(this.id, this.value)'>ADD</button>
                </div>
            </div>

            <?php
                }
            }
            ?>

            <hr class="adv-splitter">


            <h2 id="">Power Supply</h2>

            <?php

            if(isset($_SESSION['discount'])){
            
                $query = ("SELECT * FROM _add_ons where company = 'sunglow' AND type = 'Power Supply'");
                
                $result = $conn->query($query);

                while($rows = $result->fetch_assoc())
                {
                    //$myorder = "'" .$rows['orderTag'] ."'" ;
                    $product = $rows['product'];
                    $finish = $rows['finish'];
                    $price = number_format($rows['price'], 2, '.', '');
                    $image = $rows['image'];
                    $code = $rows['code'];

            ?>

            <div class="auto-box">
                <img class="prod-img" src="image/addons/<?php echo(strtolower($code));?>.jpg">
                <!-- <form action="include/order_adds.php" method="post">      -->
                <div>       
                    <h4>
                        <?php echo($product);?> –
                        <?php echo($finish);?> –
                        <?php echo($code);?> –
                        $<?php echo($price);?>
                    </h4>
                    <span>Quantity: </span>
                    <input id='<?php echo($code);?> Info' class='temp-details' name='product' value='<?php echo($product);?> - <?php echo($finish);?>'>
                    <input id='<?php echo($code);?> Price' class='temp-details' name='price' value='<?php echo($price);?>'>
                    <input id='<?php echo($code);?> Quantity' class='add-quantity' min=0 step=1  type=number name='quantity'>
                        <!-- <button class='sg-next' type="submit" name="order_extra">ADD</button> -->
                        <br><br>
                    <button class='sg-next' id='<?php echo($product);?>' value='<?php echo($code);?>'onclick='addon(this.id, this.value)'>ADD</button>
                </div>
            </div>

            <?php
                }
            }
            ?>


            <hr class="adv-splitter">


            <h2 id="">Smart Hubs</h2>

            <?php

            if(isset($_SESSION['discount'])){
            
                $query = ("SELECT * FROM _add_ons where company = 'sunglow' AND type = 'Smart Hubs'");
                
                $result = $conn->query($query);

                while($rows = $result->fetch_assoc())
                {
                    //$myorder = "'" .$rows['orderTag'] ."'" ;
                    $product = $rows['product'];
                    $finish = $rows['finish'];
                    $price = number_format($rows['price'], 2, '.', '');
                    $image = $rows['image'];
                    $code = $rows['code'];

            ?>

            <div class="auto-box">
                <img class="prod-img" src="image/addons/<?php echo(strtolower($code));?>.jpg">
                <!-- <form action="include/order_adds.php" method="post">      -->
                <div>       
                    <h4>
                        <?php echo($product);?> –
                        <?php echo($finish);?> –
                        <?php echo($code);?> –
                        $<?php echo($price);?>
                    </h4>
                    <span>Quantity: </span>
                    <input id='<?php echo($code);?> Info' class='temp-details' name='product' value='<?php echo($product);?> - <?php echo($finish);?>'>
                    <input id='<?php echo($code);?> Price' class='temp-details' name='price' value='<?php echo($price);?>'>
                    <input id='<?php echo($code);?> Quantity' class='add-quantity' min=0 step=1  type=number name='quantity'>
                        <!-- <button class='sg-next' type="submit" name="order_extra">ADD</button> -->
                        <br><br>
                    <button class='sg-next' id='<?php echo($product);?>' value='<?php echo($code);?>'onclick='addon(this.id, this.value)'>ADD</button>
                </div>
            </div>

            <?php
                }
            }
            ?>

        </section>

        <hr class='adv-spliiter'>
            <br>

        <section id='somfy-auto'>
            <h1 id="" class='title-tag'>Somfy</h1>
        <hr class="adv-splitter">
                    
                    <h2 id="">Controllers</h2>

                    <?php
                    
                    if(isset($_SESSION['discount'])){
                    
                        $query = ("SELECT * FROM _add_ons where company = 'Somfy' AND type = 'Controllers'");
                        
                        $result = $conn->query($query);

                        while($rows = $result->fetch_assoc())
                        {
                            //$myorder = "'" .$rows['orderTag'] ."'" ;
                            $product = $rows['product'];
                            $finish = $rows['finish'];
                            $price = number_format($rows['price'], 2, '.', '');
                            $image = $rows['image'];
                            $code = $rows['code'];

                    ?>
                    
                    <div class="auto-box">
                        <img class="prod-img" src="image/addons/<?php echo(strtolower($code));?>.jpg">
                        <!-- <form action="include/order_adds.php" method="post">      -->
                        <div>       
                            <h4>
                                <?php echo($product);?> –
                                <?php echo($finish);?> –
                                <?php echo($code);?> –
                                $<?php echo($price);?>
                            </h4>
                            <span>Quantity: </span>
                            <input id='<?php echo($code);?> Info' class='temp-details' name='product' value='<?php echo($product);?> - <?php echo($finish);?>'>
                            <input id='<?php echo($code);?> Price' class='temp-details' name='price' value='<?php echo($price);?>'>
                            <input id='<?php echo($code);?> Quantity' class='add-quantity' min=0 step=1  type=number name='quantity'>
                                <!-- <button class='sg-next' type="submit" name="order_extra">ADD</button> -->
                                <br><br>
                            <button class='sg-next' id='<?php echo($product);?>' value='<?php echo($code);?>'onclick='addon(this.id, this.value)'>ADD</button>
                        </div>
                    </div>

                    <?php
                        }
                    }
                    ?>

        <hr class="adv-splitter">


                    <h2 id="">Power Supply</h2>

                    <?php

                    if(isset($_SESSION['discount'])){
                    
                        $query = ("SELECT * FROM _add_ons where company = 'Somfy' AND type = 'Power Supply'");
                        
                        $result = $conn->query($query);

                        while($rows = $result->fetch_assoc())
                        {
                            //$myorder = "'" .$rows['orderTag'] ."'" ;
                            $product = $rows['product'];
                            $finish = $rows['finish'];
                            $price = number_format($rows['price'], 2, '.', '');
                            $image = $rows['image'];
                            $code = $rows['code'];
                            
                    ?>

                    <div class="auto-box">
                        <img class="prod-img" src="image/addons/<?php echo(strtolower($code));?>.jpg">
                        <!-- <form action="include/order_adds.php" method="post">      -->
                        <div>       
                            <h4>
                                <?php echo($product);?> –
                                <?php echo($finish);?> –
                                <?php echo($code);?> –
                                $<?php echo($price);?>
                            </h4>
                            <span>Quantity: </span>
                            <input id='<?php echo($code);?> Info' class='temp-details' name='product' value='<?php echo($product);?> - <?php echo($finish);?>'>
                            <input id='<?php echo($code);?> Price' class='temp-details' name='price' value='<?php echo($price);?>'>
                            <input id='<?php echo($code);?> Quantity' class='add-quantity' min=0 step=1  type=number name='quantity'>
                                <!-- <button class='sg-next' type="submit" name="order_extra">ADD</button> -->
                                <br><br>
                            <button class='sg-next' id='<?php echo($product);?>' value='<?php echo($code);?>'onclick='addon(this.id, this.value)'>ADD</button>
                        </div>
                    </div>

                    <?php
                        }
                    }
                    ?>


        <hr class="adv-splitter">

            <h2 id="">Cables</h2>

            <?php

            if(isset($_SESSION['discount'])){

                $query = ("SELECT * FROM _add_ons where company = 'Somfy' AND type = 'cable'");
                
                $result = $conn->query($query);

                while($rows = $result->fetch_assoc())
                {
                    //$myorder = "'" .$rows['orderTag'] ."'" ;
                    $product = $rows['product'];
                    $finish = $rows['finish'];
                    $price = number_format($rows['price'], 2, '.', '');
                    $image = $rows['image'];
                    $code = $rows['code'];

            ?>

            <div class="auto-box">
                <img class="prod-img" src="image/addons/<?php echo(strtolower($code));?>.jpg">
                <!-- <form action="include/order_adds.php" method="post">      -->
                <div>       
                    <h4>
                        <?php echo($product);?> –
                        <?php echo($finish);?> –
                        <?php echo($code);?> –
                        $<?php echo($price);?>
                    </h4>
                    <span>Quantity: </span>
                    <input id='<?php echo($code);?> Info' class='temp-details' name='product' value='<?php echo($product);?> - <?php echo($finish);?>'>
                    <input id='<?php echo($code);?> Price' class='temp-details' name='price' value='<?php echo($price);?>'>
                    <input id='<?php echo($code);?> Quantity' class='add-quantity' min=0 step=1  type=number name='quantity'>
                        <!-- <button class='sg-next' type="submit" name="order_extra">ADD</button> -->
                        <br><br>
                    <button class='sg-next' id='<?php echo($product);?>' value='<?php echo($code);?>'onclick='addon(this.id, this.value)'>ADD</button>
                </div>
            </div>

            <?php
                }
            }
            ?>

        
        
        <hr class="adv-splitter">


                    <h2 id="">Smart Hubs</h2>

                    <?php

                    if(isset($_SESSION['discount'])){
                    
                        $query = ("SELECT * FROM _add_ons where company = 'Somfy' AND type = 'Smart Hubs'");
                        
                        $result = $conn->query($query);

                        while($rows = $result->fetch_assoc())
                        {
                            //$myorder = "'" .$rows['orderTag'] ."'" ;
                            $product = $rows['product'];
                            $finish = $rows['finish'];
                            $price = number_format($rows['price'], 2, '.', '');
                            $image = $rows['image'];
                            $code = $rows['code'];

                    ?>

                    <div class="auto-box">
                        <img class="prod-img" src="image/addons/<?php echo(strtolower($code));?>.jpg">
                        <!-- <form action="include/order_adds.php" method="post">      -->
                        <div>       
                            <h4>
                                <?php echo($product);?> –
                                <?php echo($finish);?> –
                                <?php echo($code);?> –
                                $<?php echo($price);?>
                            </h4>
                            <span>Quantity: </span>
                            <input id='<?php echo($code);?> Info' class='temp-details' name='product' value='<?php echo($product);?> - <?php echo($finish);?>'>
                            <input id='<?php echo($code);?> Price' class='temp-details' name='price' value='<?php echo($price);?>'>
                            <input id='<?php echo($code);?> Quantity' class='add-quantity' min=0 step=1  type=number name='quantity'>
                                <!-- <button class='sg-next' type="submit" name="order_extra">ADD</button> -->
                                <br><br>
                            <button class='sg-next' id='<?php echo($product);?>' value='<?php echo($code);?>'onclick='addon(this.id, this.value)'>ADD</button>
                        </div>
                    </div>

                    <?php
                        }
                    }
                    ?>

        <hr class="adv-splitter">

                <h2 id="">Sensors & Timers</h2>

                <?php

                if(isset($_SESSION['discount'])){
                
                    $query = ("SELECT * FROM _add_ons where company = 'Somfy' AND type = 'Sensors & Timers'");
                    
                    $result = $conn->query($query);

                    while($rows = $result->fetch_assoc())
                    {
                        //$myorder = "'" .$rows['orderTag'] ."'" ;
                        $product = $rows['product'];
                        $finish = $rows['finish'];
                        $price = number_format($rows['price'], 2, '.', '');
                        $image = $rows['image'];
                        $code = $rows['code'];
                        
                ?>

                <div class="auto-box">
                    <img class="prod-img" src="image/addons/<?php echo(strtolower($code));?>.jpg">
                    <!-- <form action="include/order_adds.php" method="post">      -->
                    <div>       
                        <h4>
                            <?php echo($product);?> –
                            <?php echo($finish);?> –
                            <?php echo($code);?> –
                            $<?php echo($price);?>
                        </h4>
                        <span>Quantity: </span>
                        <input id='<?php echo($code);?> Info' class='temp-details' name='product' value='<?php echo($product);?> - <?php echo($finish);?>'>
                        <input id='<?php echo($code);?> Price' class='temp-details' name='price' value='<?php echo($price);?>'>
                        <input id='<?php echo($code);?> Quantity' class='add-quantity' min=0 step=1  type=number name='quantity'>
                            <!-- <button class='sg-next' type="submit" name="order_extra">ADD</button> -->
                            <br><br>
                        <button class='sg-next' id='<?php echo($product);?>' value='<?php echo($code);?>'onclick='addon(this.id, this.value)'>ADD</button>
                    </div>
                </div>

                <?php
                    }
                }
                    ?>

        <hr class="adv-splitter">

            <h2 id="">Interfaces</h2>

            <?php

            if(isset($_SESSION['discount'])){
            
                $query = ("SELECT * FROM _add_ons where company = 'Somfy' AND type = 'Interfaces'");
                
                $result = $conn->query($query);

                while($rows = $result->fetch_assoc())
                {
                    //$myorder = "'" .$rows['orderTag'] ."'" ;
                    $product = $rows['product'];
                    $finish = $rows['finish'];
                    $price = number_format($rows['price'], 2, '.', '');
                    $image = $rows['image'];
                    $code = $rows['code'];

            ?>

            <div class="auto-box">
                <img class="prod-img" src="image/addons/<?php echo(strtolower($code));?>.jpg">
                <!-- <form action="include/order_adds.php" method="post">      -->
                <div>       
                    <h4>
                        <?php echo($product);?> –
                        <?php echo($finish);?> –
                        <?php echo($code);?> –
                        $<?php echo($price);?>
                    </h4>
                    <span>Quantity: </span>
                    <input id='<?php echo($code);?> Info' class='temp-details' name='product' value='<?php echo($product);?> - <?php echo($finish);?>'>
                    <input id='<?php echo($code);?> Price' class='temp-details' name='price' value='<?php echo($price);?>'>
                    <input id='<?php echo($code);?> Quantity' class='add-quantity' min=0 step=1  type=number name='quantity'>
                        <!-- <button class='sg-next' type="submit" name="order_extra">ADD</button> -->
                        <br><br>
                    <button class='sg-next' id='<?php echo($product);?>' value='<?php echo($code);?>'onclick='addon(this.id, this.value)'>ADD</button>
                </div>
            </div>

            <?php
                }
            }
            ?>

        </section>

        </section>

    <!-- <div id='result'>
    </div> -->


    <div class="notify" style="display:none;">
        <h2>Added to Order.</h2>
    </div>



    </div>
    <!-- Footer -->
    <?php
        include 'sg-footer.php';
    ?>

</body>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="rei_edit.js"></script>
<script src="reiFunctions.js"></script>
<script src="rei_animations.js"></script>
<script src="rei_orders.js"></script>

<!-- <script src="submit.js"></script> -->

</html>