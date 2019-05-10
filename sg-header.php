<nav class="sticky-top sg-nav">

<div class="upper-nav">
        <a href="https://mysunglow.com/"><button class="top-button"> Home </button></a>
        <a href="index.php"><button class="top-button"> Dealer </button></a>
        <!-- <a href="#"><button class="top-button"> Wholesale </button></a> -->
        <!-- <a href="#"><button class="top-button"> Architects </button></a> -->
</div>
<nav class="sg-sub-nav">
        <div class="left-nav">
            <span class="helper"></span>
            <img class="sg-logo" src="image/Sun Glow Logo.png">
        </div> 
        <div class="right-nav">
            <span class="helper">
            </span>
            <span class="mid-container">
                <div class="sg-dropdown">
                    <button class="sg-dbtn">New Shade <i class="fas fa-angle-down"></i></button>   
                    <div class="sg-dropdown-content">
                      <a href="roller.html">Roller</a>
                      <a href="interlude.html">Interlude</a>
                      <a href="illusion.html">Illusion</a>
                      <a href="gemini.html">Gemini</a>
                      <a href="vision.html">Vision</a>
                      <a href="panel.html">Panel</a>
                      <a href="roman.html">Roman</a>
                      <a href="fixed.html">Fixed</a>
                    </div>
                </div>
                <div class="sg-dropdown">
                    <a href=orders.html> <button class="sg-dbtn">Orders</button>   </a>
                </div>
                <div class="sg-dropdown">
                <a href=profile.php>  <button class="sg-dbtn">Profile</button>    </a>
                </div>
                <div class="sg-dropdown">
                <a href=addons.php>  <button class="sg-dbtn">Add Ons</button>    </a>
                </div>
            </span>
            <span class="right-container">
                <div class="sg-dropdown">
                    <span class="">416-266-3501</span>
                    <!-- <span class=""> | </span>   -->
                    <!-- <span class="">eMail</span>    -->
                         <span class=""> | </span>
                    <span class="">Contact Us</span> 
                </div>
            </span>
            <span class="cart-container">
                <div class="sg-dropdown">
                    <a href="summary.html"> <button><span></span><i class="fas fa-shopping-cart"></i></button> </a>   
                </div>
            </span>
            <span class="signing-container">
                    <?php
                        if(isset($_SESSION['discount'])){
                    ?>
                         <span class="sg-dropdown">
                            <form action="include/i_logout.php" method="post">
                            <button class="sg-dbtn" type="submit" name="submit_logout"> LOG OUT </button>
                            </form>
                         </span>
                    <?php    
                        }
                        else{
                    ?>
                            <a href="login.php">
                            <span class="sg-dropdown">
                            <button class="sg-dbtn" type="submit" name="submit_login"> LOG IN </button>
                            </span>
                        </a>
                    <?php
                        }
                    ?>
            </span>
        </div>

</nav>
</nav>