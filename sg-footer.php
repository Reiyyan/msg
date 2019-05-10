<footer>

<div class="footer-links">
        
        <div class="footer-menu">  

        </div>

        <!-- <div class="footer-logo">  
            <img class="logo-white" src="image/Sun Glow Logo white.png">

        </div>

        <div class="footer-menu">  
            <ul>
                <h2>Links </h2>
                    <hr>            
                    <li><a href="#">Something1</a></li>
                    <li><a href="#">Something2</a></li>
                    <li><a href="#">Something3</a></li>
                    <li><a href="#">Something4</a></li>
            </ul>
        </div>

        <div class="footer-menu">  
            <ul>
                <h2>Links </h2>
                    <hr>            
                    <li><a href="#">Something1</a></li>
                    <li><a href="#">Something2</a></li>
                    <li><a href="#">Something3</a></li>
                    <li><a href="#">Something4</a></li>
            </ul>
        </div>

        <div class="footer-menu">  
            <ul>
                <h2>Links </h2>
                    <hr>            
                    <li><a href="#"><img style="width: 10%;" src="image/flogo-HexRBG-Wht-100.png"></a></li>
                    <li><a href="#"><img style="width: 10%;" src="image/flogo-HexRBG-Wht-100.png"></a></li>
                    <li><a href="#"><img style="width: 10%;" src="image/flogo-HexRBG-Wht-100.png"></a></li>
            </ul>
        </div>
        
        <div class="footer-menu">  

        </div> -->
</div>

<?php
    if(isset($_SESSION['discount'])){
        echo ('<div id="logged_in"> </div>');
    }
    else{
        echo ('<div id="logged_out"></div>');
    }
?>

<div class="loader-overlay">
    <div class="loader"></div>
</div>

</footer>