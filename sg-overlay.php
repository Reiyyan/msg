<div id="overlay" style="display: none;" onclick="close_modal();"></div>

<div id="modal" style="display: none;">
    <div class="close-box"> 
        <button class='btn-reset' onclick="close_modal();"><i class="far fa-times-circle"></i></button>
    </div>
    <h5>ADD TO CART AND:</h5>

    <!-- Checkout -->
    <div class="button-container">
        <a href="summary.html">
            <button class="and-buttons add-button" onclick="sendData();">CHECKOUT</button>
        </a>
    </div>
    
    <!-- Duplicate -->
    <div class="button-container">
            <button class="add-button and-buttons" onclick="sendData(); makeReid(); close_modal(); changeDraw('#details_1', '.detail-draw');">DUPLICATE SHADE</button>
    </div>
    
    
    <!-- New Shade -->
    <div class="button-container">
            <button class="add-button and-buttons" onclick="sendData(); add_new();">DESIGN NEW SHADE</button>
    </div>

    <hr>

    <button class="sg-next sg-return" onclick="close_modal();">CANCEL</button>
    
</div>

<div id="new-shade" style="display: none;">
    <div class="close-box"> 
            <button class='btn-reset' onclick="close_new();"><i class="far fa-times-circle"></i></button>
    </div>
    <h5>PICK YOUR SHADE</h5>

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

<?php
if( (!isset($_SESSION['orderName'])) && isset($_SESSION['discount'])){
echo('
<div id="overlay" style="display: \' \';" onclick="close_modal();"></div>
<div id="order-name";>
    <h4>Please Enter an Order Tag and P/O #</h4>
    <form action="include/order_name.php" method="post">
        <input required type="text" name="orderName" placeholder="Order Tag">
        <input type="text" name="purchaseOrder" placeholder="Purchase Order">
        <br>
        <hr>
        <button class="sg-login sg-return" type="submit" name="orderNameSave"> Save </button>
    </form>
    <button class="sg-logout sg-return" onclick="home();"> Cancel </button>

</div>
');
}
else if( isset($_SESSION['orderName']) && isset($_SESSION['discount']) ){
    echo('<div id="orderName" style="display:none;">');
    echo $_SESSION['orderName'] ;
    echo ('</div>');
}
?>


<div id="seam-overlay" style="display: none;" onclick=""></div>

<div id="seam-modal" style="display: none;">
    <h5>Due to the length of your shade exceeding the possible fabric length, your blind will be seamed.</h5>
    <!-- Duplicate -->
    <div class="button-container">
            <button class="sg-login" onclick="close_seam();">I Acknowledge</button>
    </div>
    
</div>

<div id="motor-overlay" style="display: none;" onclick=""></div>

<div id="motor-modal" style="display: none;">
    <h5>You have selected a Motor, please make sure you purchase the required accessories for your selected product on the Add Ons Page.(Your progress for this blind will be saved.)</h5>
    <!-- Open in New Tab -->
    <div class="button-container">
    <!-- <a href="addons.php" target="_blank"><button class="sg-login" onclick="close_motor();">Add Ons (New Tab)</button></a> -->
    <button class="sg-login" onclick="goToAdds();">GO TO ADD ONS</button>
    <button class="sg-login" onclick="close_motor(); addToCart();">CONTIUNE TO CHECKOUT</button>
    </div> 
</div>

<!-- <div id="motor-overlay" style="display: none;" onclick=""></div> -->

<div id="sc-modal" style="display: none;">
    <h5>You have selected side channels with an incompatible bottom bar. Please select one of the following Bottom Bars.</h5>
    <!-- Open in New Tab -->
    <div class="button-container">
    <button class="sg-login" value='Plain Hem' onclick="getHem(this.value); setBottomBar(); close_schems(); $(`input[name=hem][value='Plain Hem']`).attr('checked', 'checked');">Plain Hem</button>
    <button class="sg-logout" value='Slim Bar' onclick="getHem(this.value); setBottomBar(); close_schems(); $(`input[name=hem][value='Slim Bar']`).attr('checked', 'checked');">Slim Bar</button>
    </div> 
</div>

<div id="intill-modal" style="display: none;">
    <h5>Your fabric exceeds the limitations for this shade system. Please contact us for more support with this system.</h5>
    <!-- Open in New Tab -->
    <div class="button-container">
    <button class="sg-login" onclick="close_intill();">I Understand</button>
    </div> 
</div>

<div id="rt-modal" style="display: none;">
    <span class="details-span">Roll Type</span><br><br>
        <p>Roll Types only available with the follow Valance Types:</p><br>
        <strong>Open Roll</strong><br>
        <strong>PVC Valance</strong><br>
        <strong>Fabric Valance</strong><br><br>
        <p>Please return to step 5 to change your valance if possible.</p><br>
        <div class="button-container">
            <button class="sg-login" onclick="close_rt();">I Understand</button>
        </div> 
</div>

<div id="scv-modal" style="display: none;">
        <span class="details-span">Side Channels</span><br><br>
            <p>Side Channels Only Available with the follow Valance Types:</p><br>
            <strong>Fascia</strong><br>
            <strong>CBX</strong><br><br>
            <p>Please return to step 5 to change your valance if possible.</p>
            <hr class="adv-splitter">
        <div class="button-container">
            <button class="sg-login" onclick="close_scv();">I Understand</button>
        </div> 
</div>