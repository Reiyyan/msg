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
    include 'sg-header.php';
?>
</header>

<body>
    <!-- Content here -->

    <!-- Wrapper -->
    <div class="wrapper">

        <section class="heading">
            <h1 id="title">YOUR TEMPLATE</h1>

            <hr class="splitter">

        </section>


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