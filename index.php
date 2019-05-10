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
?>

</head>

<header>
    <!-- Header -->
<?php
    if(!isset($_SESSION['discount'])){
        header("Location: login.php");
    }
    include 'sg-header.php';
?>
</header>

<body>
    <!-- Content here -->

    <!-- Wrapper -->
    <div class="wrapper">

        <section class="heading">
            <h1 id="title">WELCOME TO SUNGLOW</h1>
            <h3 class="sub-title">DESIGN YOUR SHADE TODAY</h3>
        </section>


        <div id="">
        <p class="title-tag"> Order Tag: 
                <?php
                if(isset($_SESSION['orderName'])){
                    echo($_SESSION['orderName']);
                }
                ?>
                –
                P/O #:
                <?php
                if(isset($_SESSION['purchaseOrder'])){
                    echo($_SESSION['purchaseOrder']);
                }
                ?>
        </p>
        <hr class="ord-splitter">
        
            <a href="roller.html">
                <div class="sg-box">
                    <img class='new-img' src="image/placeholder/roller.jpg">
                    <p>Roller</p>
                </div>
            </a>

            <a href="interlude.html">
                <div class="sg-box">
                    <img class='new-img' src="image/placeholder/interlude.jpg">
                    <p>Interlude</p>
                </div>
            </a>

            <a href="illusion.html">
                <div class="sg-box">
                    <img class='new-img' src="image/placeholder/illusion.jpg">
                    <p>Illusion</p>
                </div>
            </a>
            <br>

            <a href="gemini.html">
                <div class="sg-box">
                    <img class='new-img' src="image/placeholder/gemini.jpg">
                    <p>Gemini</p>
                </div>
            </a>

            <a href="vision.html">
                <div class="sg-box">
                    <img class='new-img' src="image/placeholder/vision2.jpg">
                    <p>Vision</p>
                </div>
            </a>

            <a href="panel.html">
                <div class="sg-box">
                    <img class='new-img' src="image/placeholder/panel_track.jpg">
                    <p>Panel</p>
                </div>
            </a>

            <br>

            <a href="roman.html">
                <div class="sg-box">
                    <img class='new-img' src="image/placeholder/roman.jpg">
                    <p>Roman</p>
                </div>
            </a>

            <a href="fixed.html">
                <div class="sg-box">
                    <img class='new-img' src="image/placeholder/fixed.jpg">
                    <p>Fixed</p>
                </div>
            </a>

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
<script src="reiFunctions.js"></script>
<script src="rei_animations.js"></script>
<script src="rei_orders.js"></script>

<!-- <script src="submit.js"></script> -->

</html>