<!-- Pasted into Html directly, no ajax needed -->

<?php 
                            
    $hTypeResult = $mysqli->query("SELECT distinct hem_type, image  FROM _hem_type where hem_type != 'Interlude' AND hem_type != 'Illusion';");
    
    while($rows = $hTypeResult->fetch_assoc())
    {

    $hemName = $rows['hem_type'];
    $hemImage = $rows['image'];

    echo("
        <div class='sg-box'>
            <label for='$hemName'> 
                <img class='sg-box-image' src='$hemImage' alt='$hemName'>
            </label>
            <label class='sg-swatch-label'>
                    <input type='radio' class='hemRadio' name='hem' onclick='getHem(this.value)' id='$hemName' value='$hemName'>
                    <span class='check-text'>$hemName</span>                                
                    <span class='sg-check'></span>
            </label>
        </div>
    ");
    
    }
    
?>

