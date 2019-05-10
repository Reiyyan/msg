<?php
    // session_start();
    $role = $_SESSION['role'];
    $hide = $_SESSION['hide'];
?>
<div class="price-button-container">
    <div class="price-container">
        <p>TOTAL</p>
        <p>MSRP :
        <span id="price" class="price"> $ 0.00 </span> </p>
        <?php
        if($role == 'Manager' && $hide == 'false'){
        ?>
        <p>DEALER :
        <span id="d_price" class="price"> $ 0.00 </span> </p>
        <?php
        }
        ?>
    </div>
    <div class="button-container">

        <?php
        if( isset($_SESSION['orderName']) && isset($_SESSION['discount']) ){
            echo('<button id="atc" class="add-button" disabled onclick="runMotorATC();">ADD TO CART</button>');
        }
        else{
            echo(' <button class="add-button" disabled>LOGIN TO ADD TO CART</button>');
        }
        ?>
    </div>
</div>