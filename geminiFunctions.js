var REID = null;
var shadePrice = 0;
var lineItem = 1;
//Length and Width
var width = null;
var length = null;

//Standards Width Adjustments
var mWidth = null;

//Guidance and Warnings
// var guidance = document.getElementsByClassName('guidance')[0];
    
// var warning = document.getElementsByClassName('warning')[0];
// var warningFraction = document.getElementsByClassName('warning')[1];

//Price Group
var price_group = null;
var back_price_group = null;

var system_torque;
var ultra_torque;

var ultra_lam;
var r24_lam;

var color_power = document.getElementById("color_power");
var motorClutch_div= document.getElementById("mc_Label");
var control_div = document.getElementById("drive_optional_div");

var back_color_power = document.getElementById("back_color_power");
var back_motorClutch_div= document.getElementById("back_mc_Label");
var back_control_div = document.getElementById("back_drive_optional_div");

var currentClutch_I = null;

//Checking Previous system to see if we have to reset controller and motor
var previousSystem;
var selectedClutch = null;

var back_previousSystem;
var back_selectedClutch = null;

var shade = document.getElementById('title').innerText;

//Variables Setup For Live Page
var selectedFabric = null;
var back_selectedFabric = null;

var selectedHem = null;
var back_selectedHem = null;


var selectedValance = '5" Fascia"';
var selectedMount = null;
var selectedRoll = "Regular";

var back_selectedRoll = "Regular";

var δ = getDeflection();
var selectedTrim = null;
var selectedPull = null;

var selectedSafety = "P-Clip";
var back_selectedSafety = "P-Clip";

var selectedSCMount = null;

var selectedMotor = null;
var back_selectedMotor = null;
//?

// Fabric Length
var rollWidth = 1;
var selectedRailroad = false;

var visitedAdd = false;

//Getters
function getFabric(code){
    selectedFabric = code;
}

function back_getFabric(code){
    back_selectedFabric = code;
}

function getHem(code){
    selectedHem = code;
}

function back_getHem(code){
    back_selectedHem = code;
}

function getValance(code){
    selectedValance = code;
}

function getMount(code){
    selectedMount = code;
}

function getRoll(code){
    selectedRoll = code;
}

function back_getRoll(code){
    back_selectedRoll = code;
}

function getTrim(code){
    selectedTrim = code;
}

function getPull(code){
    selectedPull = code;
}

function getSafety(code){
    selectedSafety = code;
}

function back_getSafety(code){
    back_selectedSafety = code;
}

function getSCMount(code){
    selectedSCMount = code;
}

function getDeflection(){
    δ = document.getElementById('δ');
    if(δ != null){
        return  δ.value;
    }
    else if(shade.toUpperCase() == "Roller Shade".toUpperCase() || shade.toUpperCase() == "Fixed Shade".toUpperCase()){
        return 3.5;
    }
    else{
        return 2.5;
    }
}

//PROCSSING FUNCTIONS FOR DROPDOWNS
function runMeasure(){
    mesaurementStandards(); 
    unlockFabric(); 
    lateral();
}

function runFabric(){
    if(selectedRailroad){
        getRollWidth();
        if(rollWidth < length){
            show_seam();
        }
    }
    controlSystem();
    // unlockHem();
    priceGroup();
    getPrice();
    setFabric();
}


function getRollWidth(){
    var dataString = {fabric: selectedFabric};

    $.ajax({
        type: "POST",
        url: "fabricData.php",
        dataType: "json",
        data: dataString,
        success : function(data) {
            rollWidth = data;
            }
       , error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
    });
}

function back_runFabric(){
    back_controlSystem();
    back_priceGroup();
    getPrice();
    back_setFabric();
}

function runHem(){
    hemCaps();
    stitchedHem();
    hemFinish();
}

function back_runHem(){
    back_hemCaps();
    back_stitchedHem();
    back_hemFinish();
}

function runiHem(){
    hemFinish();
    unlockHemFinish();
    unlockControlPosition();
    unlockControlType();
}

function runDriveSystem(){
    var control_system = document.getElementById("control_system").value;

    console.log("In Drive System");
    systemSetup();
    system_advanced();
    showMotorOptions();
    displayOverride();

    // //if chain or motor vs if true
    // if(control_system == "Chain"){
    //     clutchOverride();
    // }
}

function back_runDriveSystem(){
    var control_system = document.getElementById("back_control_system").value;

    console.log("In Drive System");
    back_systemSetup();
    back_system_advanced();
    back_showMotorOptions();
    back_displayOverride();

    // //if chain or motor vs if true
    // if(control_system == "Chain"){
    //     clutchOverride();
    // }
}

function runDriveFinal(){
    var control_system = document.getElementById("control_system").value;
    var motor = document.getElementById('motor_clutch').value;
    
    console.log("In Drive Final");
        
    if(control_system != 'Neo'){
            valanceFilter();
            // unlockValanceType();
            clutchColor();
            clutchBracket();
            console.log("In NOT Neos");
    }
    
    if(controlSystem == 'Chain'){
        lam();
    }

    if(!sg_edit){
        // if(control_system == 'Motor' && selectedMotor != motor){
        //     show_motor();
        //     selectedMotor = document.getElementById('motor_clutch').value;
        // }
    }


    getPrice();
    
    /*else if(control_system == 'Neo'){
        console.log("In Neos");
    }*/


}

function back_runDriveFinal(){
    var control_system = document.getElementById("back_control_system").value;
    var motor = document.getElementById('back_motor_clutch').value;
    
    console.log("In Drive Final");
        
    if(control_system != 'Neo'){
        back_clutchColor();
        back_clutchBracket();

    }


    if(!sg_edit){
        // if(control_system == 'Motor' && back_selectedMotor != motor){
        //     show_motor();
        //     back_selectedMotor = document.getElementById('motor_clutch').value;
        // }
    }


    getPrice();
    
    /*else if(control_system == 'Neo'){
        console.log("In Neos");
    }*/


}

function runValance(){
    var control = document.getElementById("control_system").value;

    valanceFinish();
    valCaps();
    clutchBracket();
    vReturns();
    bracketCovers();
    // unlockValanceFinish();
    rollType();
    sideChannels();
    getPrice();
}

function runiValance(){
    valanceFinish();
    valCaps();
    // unlockValanceFinish();
    getPrice();
    bracketCovers();
}

//*********************************************

function processWidth(){

    var widthInput = parseFloat(document.getElementById('sWidth').value);
    
    //Setting Width
    width = widthInput;

    //Setting Fraction
    var sWFraction = (document.getElementById('sWFraction'));
    var wFractionInput;
    var simplifiedFraction;

    if(sWFraction.value != ""){

        //Simplifying user input
        try{
            simplifiedFraction = evalualteAndSimplify(sWFraction.value);

            $( "#sWFraction" ).on( "blur", function() {
                $( this ).val(evalualteAndSimplify((sWFraction.value)));
            });
            
            wFractionInput = parseFloat(eval(sWFraction.value));
        }
        catch(error) {
            console.error(error);
        }

        //Validating user input is one of the desired fractions
        validateFraction(simplifiedFraction);
        
        //Adding Fraction to Width
        if(!isNaN(wFractionInput)){
            width = widthInput + wFractionInput; 
        }

    }
    //---------------------CHECKING L/W RATIO------------------------//
    checkRatio(width, length)
}

function processLength(){

    var lengthInput = parseFloat(document.getElementById('sLength').value);

    
    //Setting Length
    length = lengthInput;

    var sLFraction = document.getElementById('sLFraction');
    var lFractionInput;
    var simplifiedFraction;
    
    if(sLFraction.value != "")
    {
        //Checking if a number is put in and simplifying it.
        try{
            simplifiedFraction = evalualteAndSimplify(sLFraction.value);

            $( "#sLFraction" ).on( "blur", function() {
                $( this ).val(evalualteAndSimplify((sLFraction.value)));
            });
            
            lFractionInput = parseFloat(eval(sLFraction.value));
        }
        catch(error) {
            console.error(error);
        }

        //Validating user input is one of the desired fractions
        validateFraction(simplifiedFraction);

    
        //Adding Fraction to Length
        if(!isNaN(lFractionInput)){
            length = lengthInput + lFractionInput;
        }

    }

    //---------------------CHECKING L/W RATIO------------------------//
    checkRatio(width, length)

}

function checkRatio(width, length){

    if(!(isNaN(width)) && !(isNaN(length))){
        
        if( length/width > 2.5 )
        {
            //guidance.innerHTML = "See Error";
            //warning.innerHTML = "Length is 2.5 times width!";
        }
        else if(length!=null && width!= null){
            console.log("Width: " +width +" Lenght: " +length);
            //guidance.innerHTML = "Select Measure";
            //warning.innerHTML = "";
            // unlockMeasure();
        }
    }

    var measure = document.getElementById('measure').value;

    if(measure != "Select Your Measure"){
        runMeasure();
    }
    
}

function evalualteAndSimplify(fraction){
    switch (eval(fraction)){
        case 0.0625: return '1/16'; 
        case 0.125: return '1/8';  
        case 0.1875: return '3/16'; 
        case 0.25: return '1/4';  
        case 0.3125: return '5/16'; 
        case 0.375: return '3/8'; 
        case 0.4375: return '7/16'; 
        case 0.5: return '1/2'; 
        case 0.5625: return '9/16'; 
        case 0.625: return '5/8'; 
        case 0.6875: return '11/16'; 
        case 0.75: return '3/4'; 
        case 0.8125: return '13/16'; 
        case 0.875: return '7/8'; 
        case 0.9375: return '15/16'; 
    default:
    return "";
}
}

function validateFraction(userInput){

    console.log("In Validation");

//Load Options into array
fractionArray = [];
//WORK HERE

var fractionValues = document.getElementById("fraction");

//console.log("fractionValue is" +fractionValues);

for (var i=0, n=fractionValues.options.length; i<n; i++) 
{
  if (fractionValues.options[i].value) 
    {
    
     // console.log(fractionValues.options[i].value);
      fractionArray.push(fractionValues.options[i].value);
    }
    //console.log(fractionArray[i]);
}

//TODO: DEAL WITH WARNING FRACTIONS

for (var i=0, n=fractionArray.length; i<n; i++)
{
    if( userInput == fractionArray[i]){
        //guidance.innerHTML = "Set Length and Width";
        ////alert("WE good");
        //warningFraction.innerHTML ="";
        break;
    }
    else{
        //guidance.innerHTML = "See Error";
        //warningFraction.innerHTML = "Please Input a valid Fraction following this format \"1/16\"";
    }
}
}

function mesaurementStandards(){
    var measure = document.getElementById('measure').value;
    switch(measure){
        case('Tight'):
        mWidth=width-.0125;
            break;
        case('Finish'):
        mWidth=width;
            break;
        case('Cloth'):
        mWidth=width+1;
        break;
        default:
            console.log("Select a Measure");
            //warningwarning.innerHTML = "Please Select a Measure";
        break;
    }
    fabricGroupFilter();
    back_fabricGroupFilter();

}

function fabricGroupFilter(){
    var fabricWidth = mWidth;
    var railroad = document.getElementById('railroad');
    
    if(railroad){
        railroad = railroad.checked;
    }
    else{
        railroad = null;
    }

    var dataString = {fabric_width: fabricWidth, shade:shade, railroad: railroad};
    console.log('In group filter');
    var targetElement = document.getElementById("fabric_group");
    var previousOption = targetElement.value;

    $.ajax({
        type: "POST",
        url: "fabric_group.php",
        data: dataString,
    
        success: function(html){
            $("#fabric_group").html(html);
        }
        ,error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
    
    }).done(function(){findAndSetOption(targetElement, previousOption);
        $('#fabric_group').trigger('change');    
    });

}

function back_fabricGroupFilter(){
    var fabricWidth = mWidth;
    var railroad = document.getElementById('railroad');
    
    if(railroad){
        railroad = railroad.checked;
    }
    else{
        railroad = null;
    }

    var dataString = {fabric_width: fabricWidth, shade:shade, railroad: railroad};
    console.log('In group filter');
    var targetElement = document.getElementById("fabric_group");
    var previousOption = targetElement.value;

    $.ajax({
        type: "POST",
        url: "fabric_group.php",
        data: dataString,
    
        success: function(html){
            $("#back_fabric_group").html(html);
        }
        ,error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
    
    }).done(function(){findAndSetOption(targetElement, previousOption);
        $('#back_fabric_group').trigger('change');    
    });
}

function fabricSeriesFilter(){
    var fabricWidth = mWidth;
    var railroad = document.getElementById('railroad');
    var group = document.getElementById('fabric_group').value;
    
    if(railroad){
        railroad = railroad.checked;
    }
    else{
        railroad = null;
    }

    var dataString = {fabric_width: fabricWidth, shade:shade, railroad: railroad, group: group};
    console.log('In series filter');
    var targetElement = document.getElementById("fabric_series");
    var previousOption = targetElement.value;

    $.ajax({
        type: "POST",
        url: "fabric_series.php",
        data: dataString,
    
        success: function(html){
            $("#fabric_series").html(html);
        }
        ,error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
    
    }).done(function(){
        findAndSetOption(targetElement, previousOption);
        $('#fabric_series').trigger('change');            
    });
}

function back_fabricSeriesFilter(){
    var fabricWidth = mWidth;
    var railroad = document.getElementById('railroad');
    var group = document.getElementById('back_fabric_group').value;
    
    if(railroad){
        railroad = railroad.checked;
    }
    else{
        railroad = null;
    }

    var dataString = {fabric_width: fabricWidth, shade:shade, railroad: railroad, group: group};
    // console.log('In series filter');
    var targetElement = document.getElementById("back_fabric_series");
    var previousOption = targetElement.value;

    $.ajax({
        type: "POST",
        url: "fabric_series.php",
        data: dataString,
    
        success: function(html){
            $("#back_fabric_series").html(html);
        }
        ,error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
    
    }).done(function(){
        findAndSetOption(targetElement, previousOption);
        $('#back_fabric_series').trigger('change');            
    });
}

function fabricFilter(){
    console.log('REI WE GOT TRIGGERED In Fabric Filter');
    var fabricWidth = mWidth;
    var series = document.getElementById('fabric_series').value;
    var railroad = document.getElementById('railroad');
    var group = document.getElementById('fabric_group').value;
    if(railroad){
        railroad = railroad.checked;
    }
    else{
        railroad = null;
    }

    var dataString = {fabric_width: fabricWidth, series:series, shade:shade, railroad: railroad, group: group};
    //console.log(dataString);
    //TO DO
    //var targetElement = document.getElementById("fabric");
    //var previousOption = targetElement.value;

    $.ajax({
        type: "POST",
        url: "fabric_filter.php",
        data: dataString,
    
        success: function(html){
            $("#fabric").html(html);
        }
        ,error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
    
    }).done(function(){
        //Checks if previous option is still in list, if it is, then set's it, otherwise sets selectedfabric to null?
        var previousOption = document.getElementById(selectedFabric);
        if(document.getElementById(selectedFabric) != null){
            previousOption.checked = true;
            runFabric();
        }
        else{
            setFabric();
        }
    });
}

function back_fabricFilter(){
    // console.log('REI WE GOT TRIGGERED In Fabric Filter');
    var fabricWidth = mWidth;
    var series = document.getElementById('back_fabric_series').value;
    var railroad = document.getElementById('back_railroad');
    var group = document.getElementById('back_fabric_group').value;
    if(railroad){
        railroad = railroad.checked;
    }
    else{
        railroad = null;
    }

    var dataString = {fabric_width: fabricWidth, series:series, shade:shade, railroad: railroad, group: group};
    // console.log(dataString);

    $.ajax({
        type: "POST",
        url: "back_fabric_filter.php",
        data: dataString,
    
        success: function(html){
            $("#back_fabric").html(html);
        }
        ,error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
    
    }).done(function(){
        //Checks if previous option is still in list, if it is, then set's it, otherwise sets selectedfabric to null?
        var previousOption = document.getElementById(selectedFabric);
        if(document.getElementById(selectedFabric) != null){
            previousOption.checked = true;
            back_runFabric();
        }
        else{
            back_setFabric();
        }
    });
}

//Json
function priceGroup(){
    var dataString = {fabric_name: selectedFabric};

    $.ajax({
        async: false,
        type: "POST",
        url: "pricegroup.php",
        dataType: "json",
        data: dataString,
        success : function(data) {
            price_group = data;
            }
       , error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
      });

}

function back_priceGroup(){
    var dataString = {fabric_name: back_selectedFabric};
    
    $.ajax({
        async: false,
        type: "POST",
        url: "pricegroup.php",
        dataType: "json",
        data: dataString,
        success : function(data) {
            back_price_group = data;
            }
       , error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
      });

}

function hemFinish(){
    
    var dataString = {hem: selectedHem};

    var targetElement = document.getElementById("hem_finish");
    var previousOption = targetElement.value;
    
    $.ajax({
        type: "POST",
        url: "hem_finish.php",
        data: dataString,
    
        success: function(html){
            $("#hem_finish").html(html);
        }
    
    }).done(function(){findAndSetOption(targetElement, previousOption);});

}

function back_hemFinish(){
    
    var dataString = {hem: back_selectedHem};

    var targetElement = document.getElementById("back_hem_finish");
    var previousOption = targetElement.value;
    
    $.ajax({
        type: "POST",
        url: "hem_finish.php",
        data: dataString,
    
        success: function(html){
            $("#back_hem_finish").html(html);
        }
    
    }).done(function(){findAndSetOption(targetElement, previousOption);});

}

function stitchedHem(){
    var stitched_box = document.getElementById('stitched_box');
    var hem = selectedHem;

    if((hem == 'Plain Hem') || (hem == 'Plain Hem w/ Gimp')){
        stitched_box.style.display = '';
    }
    else{
        stitched_box.style.display = 'none';
        document.getElementById('stitched').checked =false;
    }
}

function back_stitchedHem(){
    var stitched_box = document.getElementById('back_stitched_box');
    var hem = back_selectedHem;

    if((hem == 'Plain Hem') || (hem == 'Plain Hem w/ Gimp')){
        stitched_box.style.display = '';
    }
    else{
        stitched_box.style.display = 'none';
        document.getElementById('back_stitched').checked =false;
    }
}

function hemCaps(){

    var hem = selectedHem;
    var div = document.getElementById('hem_caps_div');

    var targetElement = document.getElementById("hem_caps");
    var previousOption = targetElement.value;

    if(hem == 'Accubar' || hem == 'Accurail' || hem == 'Slim Bar' || hem == 'Front Wrapped Accubar'  ){
        var dataString = {hem:hem};
        
        $.ajax({
            type: "POST",
            url: "hem_caps.php",
            data: dataString,
        
            success: function(html){
                $("#hem_caps").html(html);
            }
        }).done(function(){findAndSetOption(targetElement, previousOption);});
        div.style.display = '';
    }
    else{
        div.style.display = 'none';
        targetElement.selectedIndex = 0;
    }
    

}

function back_hemCaps(){

    var hem = back_selectedHem;
    var div = document.getElementById('back_hem_caps_div');

    var targetElement = document.getElementById("back_hem_caps");
    var previousOption = targetElement.value;

    if(hem == 'Accubar' || hem == 'Accurail' || hem == 'Slim Bar' || hem == 'Front Wrapped Accubar'  ){
        var dataString = {hem:hem};
        
        $.ajax({
            type: "POST",
            url: "hem_caps.php",
            data: dataString,
        
            success: function(html){
                $("#back_hem_caps").html(html);
            }
        }).done(function(){findAndSetOption(targetElement, previousOption);});
        div.style.display = '';
    }
    else{
        div.style.display = 'none';
        targetElement.selectedIndex = 0;
    }
    

}

function controlSystem(){

        var dataString = {
            δ: δ, 
            fabric_width: mWidth, 
            fabric_length: length,
            fabric_name: selectedFabric, 
            hem_name:selectedHem,  
            valance_type:selectedValance, 
            shade: shade};
    
        var targetElement = document.getElementById("control_system");
        var previousOption = targetElement.value;
        
        $.ajax({
            type: "POST",
            url: "control_system_math.php",
            data: dataString,
        
            success: function(html){
                $("#control_system").html(html);
            }
        
        }).done(function(){findAndSetOption(targetElement, previousOption);});
    
}

function back_controlSystem(){

    var dataString = {
        δ: δ, 
        fabric_width: mWidth, 
        fabric_length: length,
        fabric_name: back_selectedFabric, 
        hem_name: back_selectedHem,  
        valance_type:selectedValance, 
        shade: shade};

    var targetElement = document.getElementById("back_control_system");
    var previousOption = targetElement.value;
    
    $.ajax({
        type: "POST",
        url: "control_system_math.php",
        data: dataString,
    
        success: function(html){
            $("#back_control_system").html(html);
        }
    
    }).done(function(){findAndSetOption(targetElement, previousOption);});

}

function systemSetup(){

    var control_system = document.getElementById("control_system").value;
    
    var drop_div = document.getElementById("chain_drop_div");


    if (typeof (previousSystem) == 'undefined'){
        previousSystem = control_system;
    }

    if(control_system == 'Chain'){
        control_div.style.display = '';
        color_power.innerText = "Color: ";
        motorClutch_div.innerText = "Clutch: ";
            if(previousSystem != 'Chain'){
                resetBox('control_controller');
                resetBox('motor_clutch');
                previousSystem = control_system;
            }
        chainColor();
        drop_div.style.display = '';
    }
    else if(control_system == 'Motor'){
        control_div.style.display = '';
        color_power.innerText = "Power: ";
        motorClutch_div.innerText = "Motor: ";
        if(previousSystem != 'Motor'){
            resetBox('control_controller');
            resetBox('motor_clutch');
            previousSystem = control_system;
        }
        powerFilter();
        drop_div.style.display = "none";
    }
    else if(control_system == 'Neo'){
        control_div.style.display = "none";
        drop_div.style.display = "none";
        neoFilter();
    }
    else if(control_system == 'Vision'){
        control_div.style.display = '';
        color_power.innerText = "Color: ";
        motorClutch_div.innerText = "Clutch: ";
            if(previousSystem != 'Vision'){
                resetBox('control_controller');
                resetBox('motor_clutch');
                previousSystem = control_system;
            }
        chainColor();
        drop_div.style.display = '';
    }
}

function back_systemSetup(){

    var control_system = document.getElementById("back_control_system").value;
    
    var drop_div = document.getElementById("back_chain_drop_div");


    if (typeof (back_previousSystem) == 'undefined'){
        back_previousSystem = control_system;
    }

    if(control_system == 'Chain'){
        back_control_div.style.display = '';
        back_color_power.innerText = "Color: ";
        back_motorClutch_div.innerText = "Clutch: ";
            if(back_previousSystem != 'Chain'){
                resetBox('back_control_controller');
                resetBox('back_motor_clutch');
                back_previousSystem = control_system;
            }
        back_chainColor();
        drop_div.style.display = '';
    }
    else if(control_system == 'Motor'){
        back_control_div.style.display = '';
        back_color_power.innerText = "Power: ";
        back_motorClutch_div.innerText = "Motor: ";
        if(back_previousSystem != 'Motor'){
            resetBox('back_control_controller');
            resetBox('back_motor_clutch');
            back_previousSystem = control_system;
        }
        back_powerFilter();
        drop_div.style.display = "none";
    }
}

function powerFilter(){

    console.log("RUNNING POWER FILTERS");

    var dataString = {
        fabric_width: mWidth, 
        control_system:document.getElementById("control_system").value
    };

    var targetElement = document.getElementById("control_power");
    var previousOption = targetElement.value;
    
    $.ajax({
        type: "POST",
        url: "control_power.php",
        data: dataString,
    
        success: function(html){
            $("#control_power").html(html);
        },
        error:function(XMLHttpRequest, textStatus, errorThrown) {
            //alert(XMLHttpRequest);
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
    
    }).done(function(){findAndSetOption(targetElement, previousOption);});
}

function back_powerFilter(){

    // console.log("RUNNING POWER FILTERS");

    var dataString = {
        fabric_width: mWidth, 
        control_system:document.getElementById("back_control_system").value
    };

    var targetElement = document.getElementById("back_control_power");
    var previousOption = targetElement.value;
    
    $.ajax({
        type: "POST",
        url: "control_power.php",
        data: dataString,
    
        success: function(html){
            $("#back_control_power").html(html);
        },
        error:function(XMLHttpRequest, textStatus, errorThrown) {
            //alert(XMLHttpRequest);
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
    
    }).done(function(){findAndSetOption(targetElement, previousOption);});



}

function neoFilter(){
    var control_system = document.getElementById("control_system").value;

    var targetElement = document.getElementById("valance_type");
    var previousOption = targetElement.value;

    var dataString = {
        δ: δ, 
        fabric_width: mWidth, 
        fabric_length: length,
        fabric_name: selectedFabric,
        hem_name:selectedHem, 
        control_system: control_system, 
        valance_type:selectedValance,
        shade: shade}

    
    $.ajax({
        type: "POST",
        url: "control_neo.php",
        data: dataString,
    
        success: function(html){
            $("#valance_type").html(html);
        }
    
    }).done(function(){
        //findAndSetOption(targetElement, previousOption);
        var previousOption = document.getElementById(selectedValance);
        if(document.getElementById(selectedValance) != null){
            previousOption.checked = true;
            runValance();
        }
    });

    // unlockValanceType();

}

function chainColor(){

var targetElement = document.getElementById("control_power");
var previousOption = targetElement.value;

    $.ajax({
        type: "POST",
        url: "chain_color.php",
    
        success: function(html){
            $("#control_power").html(html);
        },
        error:function(XMLHttpRequest, textStatus, errorThrown) {
            //alert(XMLHttpRequest);
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
         }
    
    }).done(function(){findAndSetOption(targetElement, previousOption);});
}

function back_chainColor(){

    var targetElement = document.getElementById("back_control_power");
    var previousOption = targetElement.value;
    
        $.ajax({
            type: "POST",
            url: "chain_color.php",
        
            success: function(html){
                $("#back_control_power").html(html);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
                //alert(XMLHttpRequest);
                console.log(XMLHttpRequest);
                console.log(textStatus);
                console.log(errorThrown); 
             }
        
        }).done(function(){findAndSetOption(targetElement, previousOption);});
}

function control_OptionsFilter(){

    var targetElement = document.getElementById("control_controller");
    var previousOption = targetElement.value;

    var dataString = {
        shade: document.getElementById('title').innerText,

        fabric_width: mWidth, 
        control_system:document.getElementById("control_system").value,
        power:document.getElementById("control_power").value
    };

    $.ajax({
        type: "POST",
        url: "control_options.php",
        data: dataString,
    
        success: function(html){
            $("#control_controller").html(html);
        }
    
    }).done(function(){
        findAndSetOption(targetElement, previousOption);
        if(document.getElementById("control_system").value == 'Chain' || document.getElementById("control_system").value == 'Vision'){$('#control_controller').trigger('change');}
    });

}

function back_control_OptionsFilter(){

    var targetElement = document.getElementById("back_control_controller");
    var previousOption = targetElement.value;

    var dataString = {
        shade: document.getElementById('title').innerText,

        fabric_width: mWidth, 
        control_system:document.getElementById("back_control_system").value,
        power:document.getElementById("back_control_power").value
    };

    $.ajax({
        type: "POST",
        url: "control_options.php",
        data: dataString,
    
        success: function(html){
            $("#back_control_controller").html(html);
        }
    
    }).done(function(){
        findAndSetOption(targetElement, previousOption);
        if(document.getElementById("back_control_system").value == 'Chain' || document.getElementById("back_control_system").value == 'Vision'){$('#back_control_controller').trigger('change');}
    });

}

function motorClutchFilter(){
    
    var control_controller = document.getElementById('control_controller').value;
    var control_system = document.getElementById("control_system").value;
     

    var targetElement = document.getElementById("motor_clutch");
    var previousOption = targetElement.value;

    var dataString = {
        δ: δ,
        fabric_width: mWidth, 
        fabric_length: length,
        fabric_name: selectedFabric, 
        hem_name:selectedHem, 
        control_system:control_system, 
        control_power:document.getElementById("control_power").value,
        control_controller:control_controller, 
        valance_type:selectedValance,
        shade: shade
    };

    $.ajax({
        type: "POST",
        url: "motor_clutch.php",
        data: dataString,
    
        success: function(html){
            $("#motor_clutch").html(html);
        }
    
    }).done(function(){
        if(document.getElementById('control_system').value == 'Chain' || document.getElementById("control_system").value == 'Vision')
        {
            $('#motor_clutch').trigger('change');
        }

        //If user isn't overriding Clutch, then we set clutch back to default (to avoid Find and Set to previous option)
        var x = document.getElementById('adv_check').checked;
        if((control_system == 'Chain') && (x == false)){
            targetElement.selectedIndex = 0; //Clutch Index
            //$('#control_controller').trigger('change');
        }
        else{
            findAndSetOption(targetElement, previousOption);
        }
    });

}

function back_motorClutchFilter(){
    
    var control_controller = document.getElementById('back_control_controller').value;
    var control_system = document.getElementById("back_control_system").value;
     

    var targetElement = document.getElementById("back_motor_clutch");
    var previousOption = targetElement.value;

    var dataString = {
        δ: δ,
        fabric_width: mWidth, 
        fabric_length: length,
        fabric_name: selectedFabric, 
        hem_name:selectedHem, 
        control_system:control_system, 
        control_power:document.getElementById("back_control_power").value,
        control_controller:control_controller, 
        valance_type:selectedValance,
        shade: shade
    };

    $.ajax({
        type: "POST",
        url: "motor_clutch.php",
        data: dataString,
    
        success: function(html){
            $("#back_motor_clutch").html(html);
        }
    
    }).done(function(){
        if(document.getElementById('back_control_system').value == 'Chain')
        {
            $('#back_motor_clutch').trigger('change');
        }

        //If user isn't overriding Clutch, then we set clutch back to default (to avoid Find and Set to previous option)
        var x = document.getElementById('back_adv_check').checked;
        if((control_system == 'Chain') && (x == false)){
            targetElement.selectedIndex = 0; //Clutch Index
            //$('#control_controller').trigger('change');
        }
        else{
            //findAndSetOption(targetElement, previousOption);
        }
    });

}

function clutchBracket(){
    var clutch = document.getElementById("motor_clutch").value;

    var bracket = document.getElementById('clutch_bracket_div');

    var check = document.getElementById('c_bracket');
    var color = document.getElementById('clutch_bracket_color');

    var valance = selectedValance;

    if(!(valance == 'Decora 8' || valance == 'Decora 12' || valance == 'Decora 16' || valance == 'CBX')){
        if(clutch == 'R8' || clutch == 'SL10' || clutch == 'SL20' || clutch == 'SL30'){
            bracket.style.display = '';//REI TO DO REMOVED INITIAL IDK IF ITS OKAY
        }
        else{
            check.checked = false;
            bracket.style.display = 'none';
            color.style.display = 'none';
            color.selectedIndex = 0;
        }
    }
    else{
        check.checked = false;
        bracket.style.display = 'none';
        color.style.display = 'none';
        color.selectedIndex = 0;
    }
}

function back_clutchBracket(){
    var clutch = document.getElementById("back_motor_clutch").value;

    var bracket = document.getElementById('back_clutch_bracket_div');

    var check = document.getElementById('back_c_bracket');
    var color = document.getElementById('back_clutch_bracket_color');

    var valance = selectedValance;

    if(!(valance == 'Decora 8' || valance == 'Decora 12' || valance == 'Decora 16' || valance == 'CBX')){
        if(clutch == 'R8' || clutch == 'SL10' || clutch == 'SL20' || clutch == 'SL30'){
            bracket.style.display = '';
        }
        else{
            check.checked = false;
            bracket.style.display = 'none';
            color.style.display = 'none';
            color.selectedIndex = 0;
        }
    }
    else{
        check.checked = false;
        bracket.style.display = 'none';
        color.style.display = 'none';
        color.selectedIndex = 0;
    }
}

function bracketColor(){
    var checkbox = document.getElementById("c_bracket");

    var color = document.getElementById('clutch_bracket_color');

    if(checkbox.checked == true){
        color.style.display = '';
    }
    else{
        color.selectedIndex = 0;
        color.style.display = 'none';
    }
}

function valanceFilter(){

    
    var dataString = {
        shade: document.getElementById('title').innerText,
        δ: δ,
        control_system:document.getElementById('control_system').value, 
        control_controller:document.getElementById('control_controller').value, 
        motor_clutch:document.getElementById("motor_clutch").value, 
        fabric_width: mWidth, 
        fabric_length: length,
        fabric_name: selectedFabric, 
        hem_name:selectedHem, 
        valance_type:selectedValance,
        shade: shade};

 
    var targetElement = document.getElementById("valance_type");
    var previousOption = targetElement.value;
    

    $.ajax({
        type: "POST",
        url: "valance.php",
        data: dataString,

        success: function(html){
            $("#valance_type").html(html);
        }
    
    }).done(function(){
        //findAndSetOption(targetElement, previousOption);
        var previousOption = document.getElementById(selectedValance);
        if(document.getElementById(selectedValance) != null){
            previousOption.checked = true;
            runValance();
        }
    });

}

function valanceFinish(){
    
    var targetElement = document.getElementById("valance_finish");
    var previousOption = targetElement.value;

    var dataString = {valance_type:selectedValance};
    
    $.ajax({
        type: "POST",
        url: "valance_finishes.php",
        data: dataString,
        
        success: function(html){
            $("#valance_finish").html(html);
        }
        
    }).done(function(){findAndSetOption(targetElement, previousOption);});
}

function railroad(selected){
    // alert(selected)
    selectedRailroad = selected;
    //TODO GOTTA FIX CHANGE THIS
    fabricGroupFilter();
    //fabricFilter();
}

function lateral(){
    var measure = document.getElementById("measure").value;
    var lmount = document.getElementById("l_mount");

    if(lmount){
        if(measure == 'Finish' || measure == 'Tight'){
            lmount.disabled = false;
        }
        else{
            lmount.disabled = true;
            lmount.checked = false;
        }
    }
}

function vReturns(){
    var valance_type = selectedValance;
    let rSection = document.getElementById("valance_return_section");
    var vReturn = document.getElementById('return_value');
    
   
    if(valance_type == 'Fabric Valance'){
        rSection.style.display = '';
        vReturn.value = 3.5;
    }
    else if (valance_type == 'PVC Valance'){
        rSection.style.display = '';
        vReturn.value = 5.0;
    }
    else{
        rSection.style.display = 'none';
        vReturn.value = 0;
    }
}

function bracketCovers(){
    var valance = selectedValance;

    var bracketSpan = document.getElementById('valance_bracket_span');
    var bracket = document.getElementById('valance_bracket');

    if(valance == '3" Fascia' || valance ==  '4" Fascia' || valance == '5" Fascia' ){
        bracketSpan.style.display = 'none';
    }
    else{
        bracketSpan.style.display = 'none';
        bracket.checked = false;
    }
    

}

function valCaps(){

    var valance = selectedValance;
    var div = document.getElementById('valance_caps_span');

    var targetElement = document.getElementById("val_cap");
    var previousOption = targetElement.value;

    switch(valance){
        case ('3" Fascia'):
        case ('4" Fascia'):
        valance = 'SF';
        break;

        case ('5" Fascia'):
        valance = 'SF5';
        break;

        case ('Decora 8'):
        case ('Decora 12'):
        case ('Decora 16'):
        valance = 'Decora';
        break;
        
        case ('Hanger & Closure w/Brush 4"-5"'):
        case ('Hanger & Closure w/Cover & Brush 4"-5"'):
        case ('Hanger & Closure > 5"'):
        case ('Hanger & Closure w/Cover > 5"'):

        valance = 'Hanger';
        break;

        case ('V84 Front Fascia'):
        case ('V84 Front & Return Fascia'):
        case ('V84 Front, Return & Back Fascia'):

        case ('V102 Front Fascia'):
        case ('V102 Front & Return Fascia'):
        case ('V102 Front, Return & Back Fascia'):
        valance = 'Vision';

        default:
        break;
    }

    if(valance == 'CBX' || valance == 'SF' || valance == 'SF5' || valance == 'Decora' || valance == 'Hanger' || valance == 'Vision'){
        var dataString = {valance:valance};
        
        $.ajax({
            type: "POST",
            url: "val_caps.php",
            data: dataString,
        
            success: function(html){
                $("#val_cap").html(html);
            }
        }).done(function(){findAndSetOption(targetElement, previousOption);});
        div.style.display = '';
    }
    else{
        div.style.display = 'none';
        targetElement.selectedIndex = 0;
    }
    

}

/*---------------------------------------------------------------------------------------------------*/
//UNLOCK FUNCTIONS
{
    function unlockATC(){document.getElementById("atc").disabled=false;}

    function unlockFabric(){document.getElementsByClassName("fabric-draw")[0].disabled=false;}

    function unlockHem(){document.getElementsByClassName("hem-draw")[0].disabled=false;}

    function unlockDrive(){document.getElementsByClassName("drive-draw")[0].disabled=false;}

    function unlockValance(){document.getElementsByClassName("valance-draw")[0].disabled=false;}

    function unlockMount(){document.getElementsByClassName("mount-draw")[0].disabled=false;}

    function unlockAdv(){document.getElementsByClassName("adv-draw")[0].disabled=false;}

    function unlockone(){document.getElementsByClassName("next_1")[0].disabled=false;}

    function unlocktwo(){document.getElementsByClassName("next_2")[0].disabled=false;}

    function unlockthree(){document.getElementsByClassName("next_3")[0].disabled=false;}

    function unlockfour(){document.getElementsByClassName("next_4")[0].disabled=false;}

    function unlockfive(){document.getElementsByClassName("next_5")[0].disabled=false;}

    function unlocksix(){document.getElementsByClassName("next_6")[0].disabled=false;}

    function unlockseven(){document.getElementsByClassName("next_7")[0].disabled=false;}

    function unlockeight(){document.getElementsByClassName("next_8")[0].disabled=false;}

    function unlocknine(){document.getElementsByClassName("next_9")[0].disabled=false;}

    function unlockten(){document.getElementsByClassName("next_10")[0].disabled=false;}

    function unlockBFabric(){document.getElementsByClassName("back_fabric-draw")[0].disabled=false;}

    function unlockBHem(){document.getElementsByClassName("back_hem-draw")[0].disabled=false;}

    function unlockBDrive(){document.getElementsByClassName("back_drive-draw")[0].disabled=false;}

    function unlockBAdv(){document.getElementsByClassName("back_adv-draw")[0].disabled=false;}
    

    function unlockAll(){
        
        if(document.getElementsByClassName('fabric-draw')[0]){
            unlockFabric();
        }
        if(document.getElementsByClassName('hem-draw')[0]){
            unlockHem();
        }
        if(document.getElementsByClassName('drive-draw')[0]){
            unlockDrive();
        }
        if(document.getElementsByClassName('valance-draw')[0]){
            unlockValance();
        }
        if(document.getElementsByClassName('mount-draw')[0]){
            unlockMount();
        }
        if(document.getElementsByClassName('adv-draw')[0]){
            unlockAdv();
        }

        //back
        if(document.getElementsByClassName('back_fabric-draw')[0]){
            unlockBFabric();
        }
        if(document.getElementsByClassName('back_hem-draw')[0]){
            unlockBHem();
        }
        if(document.getElementsByClassName('back_drive-draw')[0]){
            unlockBDrive();
        }
        if(document.getElementsByClassName('back_adv-draw')[0]){
            unlockBAdv();
        }
        
        //next
        if(document.getElementsByClassName('next_1')[0]){
            unlockone();
        }

        if(document.getElementsByClassName('next_2')[0]){
            unlocktwo();
        }

        if(document.getElementsByClassName('next_3')[0]){
            unlockthree();
        }

        if(document.getElementsByClassName('next_4')[0]){
            unlockfour();
        }

        if(document.getElementsByClassName('next_5')[0]){
            unlockfive();
        }

        if(document.getElementsByClassName('next_6')[0]){
            unlocksix();
        }

        if(document.getElementsByClassName('next_7')[0]){
            unlockseven();
        }

        if(document.getElementsByClassName('next_8')[0]){
            unlockeight();
        }
        if(document.getElementsByClassName('next_9')[0]){
            unlocknine();
        }
        if(document.getElementsByClassName('next_10')[0]){
            unlockten();
        }
    }

}
//

// function displayValance(){
//     var control = document.getElementById("control_system");
//     var valance = document.getElementById("valance_div");
    
//     if (control.value != 'Neo'){
//         console.log ("IN NOT NEO");
//         valance.style.display = "block";
//         //unlockControlOptions(); 
//     }

//     else if(control.value == 'Neo'){
//         console.log ("IN NEO");
//         valance.style.display = "none";
//     }
// }


/*---------------------------------------------------------------------------------------------------*/
//Reset Functions
    function resetBox(id){document.getElementById(id).selectedIndex = 0;}

    function show_hide(){

        var advanced = document.getElementById("advanced");
        var toggler = document.getElementById("toggler");

        if (advanced.style.display != "none") {
            advanced.style.display = "none";
            toggler.innerHTML = "Show";
        } 
        else {
            advanced.style.display = "block";
            toggler.innerHTML = "Hide";
        }

    }


/*---------------------------------------------------------------------------------------------------*/

//Advanced Section Functions

//Chain
function chainDrop(){
    var chain = document.getElementById('chain_length').value;
    var custom = document.getElementById('custom_drop');
    var drop = document.getElementById('drop');
    if(chain == 'Custom'){
        custom.style.display = '';
    }
    else{
        custom.style.display = 'none';
        drop.value = '';
    }
}

function back_chainDrop(){
    var chain = document.getElementById('back_chain_length').value;
    var custom = document.getElementById('back_custom_drop');
    var drop = document.getElementById('back_drop');
    if(chain == 'Custom'){
        custom.style.display = '';
    }
    else{
        custom.style.display = 'none';
        drop.value = '';
    }
}

function reiTest(){
    var dataString = {
        δ: δ, 
        control_system:document.getElementById('control_system').value, 
        control_controller:document.getElementById('control_controller').value, 
        motor_clutch:document.getElementById("motor_clutch").value, 
        fabric_width: mWidth, 
        fabric_length: length,
        fabric_name: selectedFabric, 
        hem_name:selectedHem, 
        valance_type:selectedValance, 
        shade: shade};


    $.ajax({
        type: "POST",
        url: "lamSetup.php",
        data: dataString,
        
        success: function(html){
            $("#Rei").html(html);
        }
      });
}

//Chain
function clutchColor(){
    var dataString = {clutch_system:document.getElementById('control_controller').value};

    $.ajax({
        type: "POST",
        url: "clutch_color.php",
        data: dataString,
        
        success: function(html){
            $("#clutch_colour").html(html);
        }
    });
}

function back_clutchColor(){
    var dataString = {clutch_system:document.getElementById('back_control_controller').value};

    $.ajax({
        type: "POST",
        url: "clutch_color.php",
        data: dataString,
        
        success: function(html){
            $("#back_clutch_colour").html(html);
        }
    });
}

//Chain
function lamValance(){
    var valance = selectedValance;
    if (!(valance == "Decora 8" || valance ==  "Decora 12" || valance ==  "CBX")){
        return true;
    }
    else
    return false;
}

//Chain
function springValance(){
    var valance = selectedValance;
    if (!(valance == "Decora 8" || valance ==  "Decora 12" || valance ==  "Decora 16" || valance ==  '3" Fascia' || valance ==  "CBX")){
        return true;
    }
    else
    return false;
}

//valance
function rollType(){

    console.log("IN Roll Type");

    var valance = selectedValance;

    var roll_type = document.getElementById("roll_type");
    if(roll_type){
        if (valance == 'Open Roll' || valance == 'Fabric Valance' || valance == 'PVC Valance' || valance == 'Hanger & Closure w/Brush 4"-5"' || valance == 'Hanger & Closure w/Cover & Brush 4"-5"' || valance == 'Hanger & Closure > 5"' || valance == 'Hanger & Closure w/Cover > 5"' || valance == '5" Fascia' ){

            roll_type.style.display = "Block";

        }
        else
        roll_type.style.display = "None";
    }
}

//motor
// function multiband(){

// var multiband = document.getElementById("multiband_toggle").checked;

// var position = document.getElementById("multiband_pos");
// var sideChannels_div = document.getElementById("sc_div");
// var sideChannels = document.getElementById("side_channels")

// if(multiband){
//     position.style.display = '';
//     sideChannels_div.style.display = 'none';
//     sideChannels.selectedIndex = 0;
// }
// else{
//     position.style.display = 'none';
//     sideChannels_div.style.display = '';
// }

// }

//valance
function sideChannels(){

    var valance = selectedValance;

    var sideChannels_div = document.getElementById("sc_div");

    var sideChannels = document.getElementById("side_channels");

    var sideChannelsOptions = document.getElementById("sc_options");

    //var multiband = document.getElementById("multiband")

    if(sideChannels){
        if (valance == 'CBX' || valance == '3" Fascia' || valance == '4" Fascia' || valance == '5" Fascia' ){

            sideChannels_div.style.display = '';

        }
        else{
            sideChannels_div.style.display = "None";
        }

        if(sideChannels.value == "Side Channels" || sideChannels.value == "Side & Bottom Channels"){
            sideChannelsOptions.style.display = '';
            //multiband.style.display = "none";
            //multiband.checked = false;
        }
        else{
            sideChannelsOptions.style.display = "none";
            //multiband.style.display = '';
        }

    }
}

//Hem
function holdDowns(){
    var hem = selectedHem;
    var control_system = document.getElementById('control_system').value;
    var hold_down = document.getElementById("hold_down");

    if((control_system == "Chain") && (hem == "Accubar" || hem == "Front Wrapped Accubar" || hem == "Accurail" || hem == "Interlude")){
        hold_down.style.display = '';
        hold_down.checked = false;
    }
    else{
        hold_down.style.display = "None";
        hold_down.checked = false;
    }
}
//TESTS

function system_advanced(){

    var system = document.getElementById("control_system").value;

    var cColor = document.getElementById("clutch_div");
    var cSafety = document.getElementById("child_safety");
    
    if(system == "Chain"){

        cColor.style.display = '';
        cSafety.style.display = '';

    }
    else if(system == "Motor"){
        cColor.style.display = 'none';
        cSafety.style.display = 'none';
    }


}

function back_system_advanced(){

    var system = document.getElementById("back_control_system").value;

    var cColor = document.getElementById("back_clutch_div");
    var cSafety = document.getElementById("back_child_safety");
    
    if(system == "Chain"){

        cColor.style.display = '';
        cSafety.style.display = '';

    }
    else if(system == "Motor"){
        cColor.style.display = 'none';
        cSafety.style.display = 'none';
    }


}

function onTest(){

    var dataString = {fabric_width: mWidth, fabric_length: length,fabric_name: selectedFabric, hem_name:selectedHem, control_system:document.getElementById("control_system").value, valance_type:selectedValance, shade: shade};


    $.ajax({
        type: "POST",
        url: "control_options_math.php",
        data: dataString,
    
        success: function(html){
            $("#Rei").html(html);
        }
    
    });

}


// FUNCTION TO GO FIND PREVIOUS OPTION IN CURRENT MENU, SELECT IT AND THEN TRIGGER THE CHANGE TO CASCADE EVENTS, ONLY IF PREVIOUS OPTION IS STILL AVAILABLE.

function findAndSetOption(selectBox, optionText) {
    for (var i = 0; i < selectBox.length; i++) {
        if (selectBox.options[i].text == String(optionText)) {
            selectBox.options[i].selected = true;
            $(selectBox).trigger('change');
        }
    }
}

/*
function findAndSetRadio(target){
    var previousOption = document.getElementById(target);
    if(document.getElementById(target) != null){
        previousOption.checked = true;
    }
}
*/

//DECIMALS NOT WORKING HERE IDK WHY ITS STUPID
//Pricing functions
function lPriceRound(x){
    x = Math.floor(x);
    if(x < 36){
        return 36;
    }
    else if(36 < x <= 192){
        while(x%6 != 0){
           x++;
        }
        return x;
    }
    else{
        x = 192;
        return x;
    }
}

//Rounding Width for Pricing
function wPriceRound(x){
    Math.floor(x);
    switch(true){
        case (x <= 30):
            x = 30;
            return x;
        case (x <= 36):
            x = 36;
            return x;
        case (x <= 42):
            x = 42;
            return x;
        case (x <= 48):
            x = 48;
            return x;
        case (x <= 54):
            x = 54;
            return x;
        case (x <= 60):
            x = 60;
            return x;
        case (x <= 72):
            x = 72;
            return x;
        case (x <= 78):
            x = 78;
            return x;
        case (x <= 84):
            x = 84;
            return x;
        case (x <= 90):
            x = 90;
            return x;
        case (x <= 96):
            x = 96;
            return x;
        case (x <= 108):
            x = 108;
            return x;
        case (x <= 120):
            x = 120;
            return x;
        case (x <= 132):
            x = 132;
            return x;
        case (x <= 144):
            x = 144;
            return x;
        case (x <= 156):
            x = 156;
            return x;
        case (x <= 168):
            x = 168;
            return x;
        case (x <= 180):
            x = 180;
            return x;
        case (x <= 192):
            x = 192;
            return x;
        case (x <= 204):
            x = 204;
            return x;
        case (x <= 216):
            x = 216;
            return x;
        case (x <= 228):
            x = 228;
            return x;
    }
}

function trimRound(x){
    Math.floor(x);
    switch(true){
        case (x <= 36):
            x = 36;
            return x;
        case (x <= 48):
            x = 48;
            return x;
        case (x <= 60):
            x = 60;
            return x;
        case (x <= 72):
            x = 72;
            return x;
        case (x <= 84):
            x = 84;
            return x;
        case (x <= 96):
            x = 96;
            return x;
        case (x <= 108):
            x = 108;
            return x;
        case (x <= 120):
            x = 120;
            return x;
        case (x <= 132):
            x = 132;
            return x;
        case (x <= 144):
            x = 144;
            return x;
        case (x <= 156):
            x = 156;
            return x;
        case (x <= 168):
            x = 168;
            return x;
        case (x <= 180):
            x = 180;
            return x;
        case (x <= 192):
            x = 192;
            return x;
        case (x <= 204):
            x = 204;
            return x;
        default:
            x = 204;
            return x;
    }
}

function trimColor(){

    var dataString = {trim:document.getElementById('trim').value};

    $.ajax({
        type: "POST",
        url: "trim_color.php",
        data: dataString,
        
        success: function(html){
            $("#trim_colors").html(html);
        }
        
    });
}

function pullColor(){

    var dataString = {pull:document.getElementById('pull').value};

    $.ajax({
        type: "POST",
        url: "pull_color.php",
        data: dataString,
        
        success: function(html){
            $("#p_colors").html(html);
        }
        
    });
}

function getPrice(){
    var price;

    var drive;
    var back_drive;

    var trim = document.getElementById('trim');
    var pull = document.getElementById('pull');

    if (document.getElementById("motor_clutch") != null){
        drive = document.getElementById("motor_clutch").value;
    }
    else{
        drive = null;
    }

    if (document.getElementById("back_motor_clutch") != null){
        back_drive = document.getElementById("back_motor_clutch").value;
    }
    else{
        back_drive = null;
    }

/*
    var lift_assist;
    var lam = document.getElementById("lam");
    
    if (lam){
        lam = lam.checked;
    }

    if(lam && ultra_lam){
        lift_assist = 'Ultra Lite';
    }
    else if(lam && r24_lam){
        lift_assist = 'Spring Assist';
    }
    else{
        lift_assist = null;
    }
*/
    

    var sideChannels = document.getElementById('side_channels');
    if(sideChannels){
        sideChannels = sideChannels.value;
    }

    if(document.getElementById('trim')){
        trim = trim.value;
        pull = pull.value;
    }


    var dataString = {

        shade: document.getElementById('title').innerText,
        
        fabric_width: wPriceRound(width), 
        fabric_length: lPriceRound(length),
        i_width: iWRound(width),

        fabric_name: selectedFabric,
        price_group: price_group, 

        back_fabric_name: back_selectedFabric,
        back_price_group: back_price_group,

        control_system:document.getElementById('control_system').value, 
        control_controller:document.getElementById('control_controller').value, 
        motor_clutch:drive, 

        back_control_system:document.getElementById('back_control_system').value, 
        back_control_controller:document.getElementById('back_control_controller').value, 
        back_motor_clutch: back_drive, 



        valance_type:selectedValance,

        trim_w: trimRound(width),
        trim: trim,
        pull: pull,

        lift_assist: null,

        channels:sideChannels
    };

    $.ajax({
        async: false,
        type: "POST",
        url: "geminiPrice.php",
        dataType: "json",
        data: dataString,
        
        success : function(data) {
            discount = data['discount'];
            price = data['total'];
            console.log("Price Data: ");
            console.log(data);
            console.log(price);
            console.log(discount);
            
        },
        error:function(XMLHttpRequest, textStatus, errorThrown) {
            ////alert(XMLHttpRequest);
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
        }
        
    });
    if(price != null){
        shadePrice = price.toFixed(2);
        setPrice(price, discount);
    }
}

function setPrice(price, discount){
    discount_a = 50;
    discount_b = discount*100/discount_a-100;
    
    if (document.getElementById('logged_in') != null){
        //Need the logged in and out div for this, PHP'd the div in the footer.

        //document.getElementById('discount').innerHTML =  discount_a +" / " +discount_b;
        document.getElementById('price').innerHTML = "$ " +price.toFixed(2);
        if(document.getElementById('d_price')){
            document.getElementById('d_price').innerHTML = "$ " +(price*(100-discount)/100).toFixed(2);
        }
    }
}

//TECH FUNCTIONS
function techDetails(){
    console.log("In Tech Debug");
    var dataString = {
        δ: δ,
        control_system:document.getElementById('control_system').value, 
        control_controller:document.getElementById('control_controller').value, 
        motor_clutch:document.getElementById("motor_clutch").value, 
        fabric_width: mWidth, 
        fabric_length: length,
        fabric_name: selectedFabric, 
        hem_name:selectedHem, 
        valance_type:selectedValance,
        shade: shade
    };
 

    $.ajax({
        type: "POST",
        url: "tech_debug.php",
        data: dataString,

        success: function(html){
            $("#Tech").html(html);
        }
    
    });
}

function r8ToR16(){
    var valance = selectedValance;
    var clutch = document.getElementById("motor_clutch");

    if (selectedClutch == null){
        selectedClutch = clutch.selectedIndex;
    }

    if((valance == '3" Fascia' || valance ==  '4" Fascia' || valance == 'CBX') && (clutch.value == 'R8' || clutch.value == 'R16')){
        pickByValue(clutch, 'R16');
    }
    else{
        clutch.selectedIndex = selectedClutch;
        selectedClutch = null;
    }

}

function pickByValue(target, value){

    for(var i=0; i < target.options.length; i++)
    {
      if(target.options[i].value == value)
      target.selectedIndex = i;
    }
}

function cloneValue(calling, currentID, targetID){

    var current = document.getElementById(currentID).value;

    if(current == 'Light Bronze'){
        current = 'Dark Bronze';
    }

    if(current == 'Anodized'){
        current = 'Grey';
    }

    //Hardcode for Accurail
    //CALLING HEM OR VALANCE
    // ONLY GO IN SWITCH IF CALLING IS HEM
    var hem = selectedHem;
    if(hem == 'Accurail' && calling == 'hem'){
        switch(current){
            case ('white'):
            case ('linen'):
            current = 'Translucent White';
            break;

            case ('Dark Bronze'):
            case ('Light Bronze'):
            case ('Black'):
            current = 'Black';
            break;

            default:
            current = 'Translucent White';
            break;
        }
    }

    var target = document.getElementById(targetID);

    pickByValue(target, current);
}

function back_cloneValue(calling, currentID, targetID){

    var current = document.getElementById(currentID).value;

    if(current == 'Light Bronze'){
        current = 'Dark Bronze';
    }

    //Hardcode for Accurail
    //CALLING HEM OR VALANCE
    // ONLY GO IN SWITCH IF CALLING IS HEM
    var hem = back_selectedHem;
    if(hem == 'Accurail' && calling == 'hem'){
        switch(current){
            case ('white'):
            case ('linen'):
            current = 'Translucent White';
            break;

            case ('Dark Bronze'):
            case ('Light Bronze'):
            case ('Black'):
            current = 'Black';
            break;

            default:
            current = 'Translucent White';
            break;
        }
    }

    var target = document.getElementById(targetID);

    pickByValue(target, current);
}

function showMotorOptions(){
    // console.log("showing more");
    var system = document.getElementById("control_system").value;

    var ops = document.getElementById('drive_control_div');
    var fDrive = document.getElementById('drive_final_div');

    if(document.getElementById('motor-guide')){
        var mGuide = document.getElementById('motor-guide');
    }

    if(system == "Motor"){
        ops.style.display = '';
        fDrive.style.display = '';
        if(mGuide){
            mGuide.style.display = '';
        }
    }
    else{
        ops.style.display = 'none';
        fDrive.style.display = 'none';
        if(mGuide){
            mGuide.style.display = 'none';
        }
    }
}

function back_showMotorOptions(){
    // console.log("showing more");
    var system = document.getElementById("back_control_system").value;

    var ops = document.getElementById('back_drive_control_div');
    var fDrive = document.getElementById('back_drive_final_div');
    
    if(document.getElementById('motor-guide')){
        var mGuide = document.getElementById('back_motor-guide');
    }

    if(system == "Motor"){
        ops.style.display = '';
        fDrive.style.display = '';
        if(mGuide){
            mGuide.style.display = '';
        }
    }
    else{
        ops.style.display = 'none';
        fDrive.style.display = 'none';
        if(mGuide){
            mGuide.style.display = 'none';
        }
    }
}

function displayOverride(){
    
    var system = document.getElementById("control_system").value;
    var overRide = document.getElementById("override_div");

    //TO DO REMOVE VISION FROM HERE
    if(system == 'Chain'){
        overRide.style.display = 'inline';
        clutchOverride();
    }
    else{
        overRide.style.display = 'none';
    }
}

function back_displayOverride(){
    
    var system = document.getElementById("back_control_system").value;
    var overRide = document.getElementById("back_override_div");

    //TO DO REMOVE VISION FROM HERE
    if(system == 'Chain'){
        overRide.style.display = 'inline';
        back_clutchOverride();
    }
    else{
        overRide.style.display = 'none';
    }
}

function clutchOverride(){
    //var system = document.getElementById("control_system").value;

    var ops = document.getElementById('drive_control_div');
    var fDrive = document.getElementById('drive_final_div');
    
    var series = document.getElementById('control_controller');
    var clutch = document.getElementById('motor_clutch');

    var check = document.getElementById('adv_check');

    if((check.checked)){
        ops.style.display = '';
        fDrive.style.display = '';
    }
    else{
        series.selectedIndex = 1;
        $('#control_power').trigger('change');

        ops.style.display = 'none';
        fDrive.style.display = 'none';
        clutch.selectedIndex = 0;
        //Have to set clutch back to original, this is done in motor motorClutchFilter()
    }
    
}

function back_clutchOverride(){
    //var system = document.getElementById("control_system").value;

    var ops = document.getElementById('back_drive_control_div');
    var fDrive = document.getElementById('back_drive_final_div');
    
    var series = document.getElementById('back_control_controller');
    var clutch = document.getElementById('back_motor_clutch');

    var check = document.getElementById('back_adv_check');

    if((check.checked)){
        ops.style.display = '';
        fDrive.style.display = '';
    }
    else{
        series.selectedIndex = 1;
        $('#back_control_power').trigger('change');

        ops.style.display = 'none';
        fDrive.style.display = 'none';
        clutch.selectedIndex = 0;
        //Have to set clutch back to original, this is done in motor motorClutchFilter()
    }
    
}

function deflection(){
    $('#sWidth').trigger('change');
    techDetails();
}

//JQUERY FUNCTIONS
$('#sWidth').keypress(function(e) {
    if (e.which == 46) {
        $(this).next('input').focus();
        e.preventDefault();
        $(this).next('input').val('.');
    }
});

$('#sLength').keypress(function(e) {
    if (e.which == 46) {
        $(this).next('input').focus();
        e.preventDefault();
        $(this).next('input').val('.');
    }
});

$('input').keypress(function(e) {
    if (e.which == 13) {
        $(this).next('input').focus();
        e.preventDefault();
    }
});

//Fixed Rod Functions

var rod = ["2", "3", "4"];
var velcro = ['Velcro Tape', 'Velcro L Angle'];

function fixSystem() {

    var sys = document.getElementById('fixed_system');
    var details = document.getElementById('fix_details');
    var hemDiv = document.getElementById('hem_div');
    var hem = document.getElementById('hem');

    if (sys.value == 'Tension Rod') {
        details.style.display = '';
        hemDiv.style.display = 'none';
        hem.selectedIndex = 0;

        var myString = null;
        for (var index in rod) {
            myString += '<option value="' + rod[index] + '">' + rod[index] + '</option>';
        }
        details.innerHTML = myString;
    }

    else if (sys.value == 'Velcro Panel') {
        details.style.display = '';
        hemDiv.style.display = 'none';
        hem.selectedIndex = 0;

        var myString = null;
            for (var index in velcro) {
                myString += '<option value="' + velcro[index] + '">' + velcro[index] + '</option>';
            }
        details.innerHTML = myString;
    }

    else {
        details.style.display = 'none';
        details.selectedIndex = 0;
        hemDiv.style.display = '';
    }
}

function template(){

    var check = document.getElementById("shape");
    var template = document.getElementById("template_div");

    if(check.checked){
        template.style.display = 'none';
    }
    else{
        template.style.display = '';
    }


}

function fixPrice(){
    var price;

    var dataString = {

        fabric_width: wfixRound(width), 
        fabric_length: lfixRound(length),
        fabric_name: selectedFabric,
        price_group: price_group, 

        trim_w: trimRound(width),
        trim:document.getElementById('trim').value,
        pull:document.getElementById('pull').value,

    };

    $.ajax({
        async: false,
        type: "POST",
        url: "fixedPrice.php",
        dataType: "json",
        data: dataString,
        
        success : function(data) {
            discount = data['discount'];
            price = data['total'];
            console.log(data);
            console.log(price);
            console.log(discount);
            
        },
        error:function(XMLHttpRequest, textStatus, errorThrown) {
            //alert(XMLHttpRequest);
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown); 
        }
        
    });
    if(price != null){
        setPrice(price, discount);
    }
}

function wfixRound(x){
    Math.floor(x);
    switch(true){
        case (x <= 24):
        x = 24;
        return x;
        case (x <= 36):
            x = 36;
            return x;
        case (x <= 48):
            x = 48;
            return x;
        case (x <= 60):
            x = 60;
            return x;
        case (x <= 72):
            x = 72;
            return x;
        case (x <= 84):
            x = 84;
            return x;
        case (x <= 96):
            x = 96;
            return x;
        case (x <= 108):
            x = 108;
            return x;
        case (x <= 120):
            x = 120;
            return x;
        case (x <= 132):
            x = 132;
            return x;
        case (x <= 144):
            x = 144;
            return x;
        case (x <= 156):
            x = 156;
            return x;
        case (x <= 168):
            x = 168;
            return x;
        default:
            x = 168;
            return x;
    }
}

function lfixRound(x){
    Math.floor(x);
    switch(true){
        case (x <= 36):
            x = 36;
            return x;
        case (x <= 48):
            x = 48;
            return x;
        case (x <= 60):
            x = 60;
            return x;
        case (x <= 72):
            x = 72;
            return x;
        case (x <= 84):
            x = 84;
            return x;
        case (x <= 96):
            x = 96;
            return x;
        case (x <= 108):
            x = 108;
            return x;
        case (x <= 120):
            x = 120;
            return x;
        case (x <= 132):
            x = 132;
            return x;
        case (x <= 144):
            x = 144;
            return x;
        case (x <= 156):
            x = 156;
            return x;
        case (x <= 168):
            x = 168;
            return x;
        default:
            x = 168;
            return x;
    }
}

//Interlude & Illusion
function iWRound(x){

    Math.floor(x);
    switch(true){
        case (x <= 30):
            x = 30;
            return x;
        case (x <= 36):
            x = 36;
            return x;
        case (x <= 42):
            x = 42;
            return x;
        case (x <= 48):
            x = 48;
            return x;
        case (x <= 54):
            x = 54;
            return x;
        case (x <= 60):
            x = 60;
            return x;
        case (x <= 72):
            x = 72;
            return x;
        case (x <= 78):
            x = 78;
            return x;
        case (x <= 84):
            x = 84;
            return x;
        case (x <= 90):
            x = 90;
            return x;
        case (x <= 96):
            x = 96;
            return x;
        case (x <= 102):
            x = 102;
            return x;
        case (x <= 108):
            x = 108;
            return x;
        default:
            x=108;
            return x;
        }

}

//Summary label
//Details
var s_name;
var s_quantity;
var s_width;
var s_wFraction;
var s_length;
var s_lFraction;
var s_measure;

//Bottom Bar
var s_hFinish;
var s_hCaps;

//Drive
var s_dPosition;
var s_dSystem;
var s_dColorPower;
var s_dController;
var s_dClutchMotor;

//Valance
var s_vFinish;
var s_vCaps;
var s_return;

//Mount
var s_mount;

function setDetails(){
    var s_name = document.getElementById('room').value;
    var s_quantity = document.getElementById('quantity').value;
    var s_width = document.getElementById('sWidth').value ;
    var s_wFraction = document.getElementById('sWFraction').value;
    var s_length = document.getElementById('sLength').value;
    var s_lFraction = document.getElementById('sLFraction').value;
    var s_measure = document.getElementById('measure').value;

    var target = document.getElementById('detail-summary');

    s_name = formatInput(s_name);
    s_quantity = formatInput(s_quantity);
    s_width = formatInches(s_width, s_wFraction);
    s_length = formatInches(s_length, s_lFraction);
    s_measure = formatEnd(s_measure);

    target.innerText = s_name + s_quantity + s_width +s_length +s_measure;
}

function setFabric(){
    var target = document.getElementById('fabric-summary');

    var x;
    if(document.getElementById(selectedFabric) != null){
        x = selectedFabric
    }
    else{
        x = "";
    }

    target.innerText = x;
}

function back_setFabric(){
    var target = document.getElementById('back_fabric-summary');

    var x;
    if((back_selectedFabric) != null){
        x = back_selectedFabric
    }
    else{
        x = "";
    }

    target.innerText = x;
}

function setBottomBar(){
    var target = document.getElementById('hem-summary');

    s_hFinish = document.getElementById('hem_finish').value;
    s_hCaps = document.getElementById('hem_caps').value;

    s_hFinish = formatInput(s_hFinish);
    s_hCaps = formatEnd(s_hCaps);


    target.innerText = selectedHem +", " +s_hFinish +s_hCaps;
}

function back_setBottomBar(){
    var target = document.getElementById('back_hem-summary');

    s_hFinish = document.getElementById('back_hem_finish').value;
    s_hCaps = document.getElementById('back_hem_caps').value;

    s_hFinish = formatInput(s_hFinish);
    s_hCaps = formatEnd(s_hCaps);


    target.innerText = back_selectedHem +", " +s_hFinish +s_hCaps;
}

function setDrive(){
    var target = document.getElementById('drive-summary');

    s_dPosition = document.getElementById('control_position').value;
    s_dSystem = document.getElementById('control_system').value;
    s_dColorPower = document.getElementById('control_power').value;
    s_dController = document.getElementById('control_controller').value;
    s_dClutchMotor = document.getElementById('motor_clutch').value;

    ////alert(s_dSystem);

    if(s_dSystem == 'Neo'){
        target.innerText = s_dSystem;
    }
    else if(s_dSystem == 'Chain'){
        s_dPosition = formatInput(s_dPosition);
        s_dSystem = formatInput(s_dSystem);
        s_dColorPower = formatEnd(s_dColorPower);

        target.innerText = s_dPosition +s_dSystem + s_dColorPower;
    }
    else if(s_dSystem == 'Motor'){
        s_dPosition = formatInput(s_dPosition);
        s_dSystem = formatInput(s_dSystem);
        s_dColorPower = formatInput(s_dColorPower);
        s_dController = formatInput(s_dController);
        s_dClutchMotor = formatEnd(s_dClutchMotor);

        target.innerText = s_dPosition +s_dSystem + s_dColorPower +s_dController + s_dClutchMotor;
    }
    else{
        s_dPosition = formatInput(s_dPosition);
        s_dSystem = formatInput(s_dSystem);
        s_dColorPower = formatInput(s_dColorPower);
        s_dController = formatInput(s_dController);
        s_dClutchMotor = formatEnd(s_dClutchMotor);
        
        target.innerText = s_dPosition +s_dSystem + s_dColorPower +s_dController + s_dClutchMotor;
    }




}

function back_setDrive(){
    var target = document.getElementById('back_drive-summary');

    s_dPosition = document.getElementById('back_control_position').value;
    s_dSystem = document.getElementById('back_control_system').value;
    s_dColorPower = document.getElementById('back_control_power').value;
    s_dController = document.getElementById('back_control_controller').value;
    s_dClutchMotor = document.getElementById('back_motor_clutch').value;

    ////alert(s_dSystem);

    if(s_dSystem == 'Neo'){
        target.innerText = s_dSystem;
    }
    else if(s_dSystem == 'Chain'){
        s_dPosition = formatInput(s_dPosition);
        s_dSystem = formatInput(s_dSystem);
        s_dColorPower = formatEnd(s_dColorPower);

        target.innerText = s_dPosition +s_dSystem + s_dColorPower;
    }
    else if(s_dSystem == 'Motor'){
        s_dPosition = formatInput(s_dPosition);
        s_dSystem = formatInput(s_dSystem);
        s_dColorPower = formatInput(s_dColorPower);
        s_dController = formatInput(s_dController);
        s_dClutchMotor = formatEnd(s_dClutchMotor);

        target.innerText = s_dPosition +s_dSystem + s_dColorPower +s_dController + s_dClutchMotor;
    }
    else{
        s_dPosition = formatInput(s_dPosition);
        s_dSystem = formatInput(s_dSystem);
        s_dColorPower = formatInput(s_dColorPower);
        s_dController = formatInput(s_dController);
        s_dClutchMotor = formatEnd(s_dClutchMotor);
        
        target.innerText = s_dPosition +s_dSystem + s_dColorPower +s_dController + s_dClutchMotor;
    }
}


function setValance(){
    var target = document.getElementById('valance-summary');

    s_vFinish = document.getElementById('valance_finish').value;
    s_Return  = document.getElementById('return_value').value;
    s_vCaps = document.getElementById('val_cap').value;

    s_vFinish = formatInput(s_vFinish);
    if(s_Return == 0){
        s_Return = "";
    }
    else{
        s_Return = formatInput(s_Return);
    }
    s_vCaps = formatEnd(s_vCaps);

    target.innerText = selectedValance +", " +s_vFinish +s_Return +s_vCaps;
}

function setMount(){
    var target = document.getElementById('mount-summary');

    if(document.getElementById('c_mount').checked){
        s_mount = "Ceiling";
    }
    else if(document.getElementById('w_mount').checked){
        s_mount = "Wall";
    }
    else if(document.getElementById('l_mount').checked){
        s_mount = "Lateral";
    }
    else{
        s_mount = "";
    }

    target.innerText = s_mount;
}

function setAdvanced(){
    var target = document.getElementById('adv-summary');

    target.innerText = "Advanced Options Set"
}

function back_setAdvanced(){
    var target = document.getElementById('back_adv-summary');

    target.innerText = "Advanced Options Set"
}

function setTest(){
    setDetails();
    setFabric();
    setBottomBar();
    setDrive();
    setValance();
    setMount();
}

function formatInput(detail){
    if(detail == "" || detail == "N/A"){  
        return "";
    }
    else{
        detail = detail +", ";
        return detail;
    }
}

function formatEnd(detail){
    if(detail == "" || detail == "N/A"){  
        return "";
    }
    else{
        return detail;
    }
}

function formatInches(whole, fraction){
    if(whole != "" && fraction != ""){
        whole = whole +" " +fraction +"\", ";
        return whole;
    }
    else if(whole != ""){
        whole = whole + "\", "
        return whole;
    }
    else{
        return "";
    }
}

//SUBMISSION LOGIC
var form = document.getElementById("sg-formtag");

// $(document).ready(function() {
// 	$("#clicky").click(function() {
// 		//form.submit();
//         //alert("submitting");

function sendData(){	
        
        var dataRei = {
            "reid": REID,
            "shadeID": document.getElementById('room').value,
            "orderTag": document.getElementById('orderName').innerText,
            "shadeID": document.getElementById('room').value,
            "quantity": document.getElementById('quantity').value,
            "width": width,
            "length": length,
            "measure": document.getElementById('measure').value,
            "group": document.getElementById('fabric_group').value,
            "series": document.getElementById('fabric_series').value,
            "fabric": selectedFabric,
            "hem": selectedHem,
            "hemColor": document.getElementById('hem_finish').value,
            "hemCaps": document.getElementById('hem_caps').value,
            "stitched": document.getElementById('stitched').checked,
            "controlPosition": document.getElementById('control_position').value,
            "controlSystem": document.getElementById('control_system').value,
            "controlColorPower": document.getElementById('control_power').value,
            "controlController": document.getElementById('control_controller').value,
            "controlClutchMotor": document.getElementById('motor_clutch').value,
            "clutchCover": document.getElementById('c_bracket').checked,
            "valance": selectedValance,
            "valanceFinish": document.getElementById('valance_finish').value,
            "valanceCaps": document.getElementById('val_cap').value,
            "mount": selectedMount,
            "chainDrop": document.getElementById('chain_length').value,
            "chainDropLength": document.getElementById('drop').value,
            "clutchColor": document.getElementById('clutch_colour').value,
            "childSafety":selectedSafety,
            "sideChannels": document.getElementById('side_channels').value,
            "sideChannelMount": selectedSCMount,
            "sideChannelFinish": document.getElementById('sc_finish').value,
            "rollType": selectedRoll,            
            "back_group": document.getElementById('back_fabric_group').value,
            "back_series": document.getElementById('back_fabric_series').value,
            "back_fabric": back_selectedFabric,
            "back_hem": back_selectedHem,
            "back_hemColor": document.getElementById('back_hem_finish').value,
            "back_hemCaps": document.getElementById('back_hem_caps').value,
            "back_stitched": document.getElementById('back_stitched').checked,
            "back_controlPosition": document.getElementById('back_control_position').value,
            "back_controlSystem": document.getElementById('back_control_system').value,
            "back_controlColorPower": document.getElementById('back_control_power').value,
            "back_controlController": document.getElementById('back_control_controller').value,
            "back_controlClutchMotor": document.getElementById('back_motor_clutch').value,
            "back_clutchCover": document.getElementById('back_c_bracket').checked,
            "back_chainDrop": document.getElementById('back_chain_length').value,
            "back_chainDropCustom": document.getElementById('back_drop').value,
            "back_clutchColor": document.getElementById('back_clutch_colour').value,
            "back_childSafety": back_selectedSafety,
            "back_rollType": back_selectedRoll,
            "shade": shade,
            "price": shadePrice
        };
        console.log(JSON.stringify(dataRei));
        
        console.log(dataRei);



        // type: "POST",
        // url: "valance.php",
        // data: dataString,

        // success: function(html){
        //     $("#valance_type").html(html);
        // }


        // let dataString = {
        //     shadeID: document.getElementById('room').value,
        //     quantity: document.getElementById('quantity').value,
        //     width: width,
        //     length: length,
        //     measure: document.getElementById('measure').value,
        //     group: document.getElementById('fabric_group').value,
        //     series: document.getElementById('fabric_series').value,
        //     fabric: selectedFabric,
        //     hem: selectedHem,
        //     hemColor: document.getElementById('hem_finish').value,
        //     hemCaps: document.getElementById('hem_caps').value,
        //     controlPosition: document.getElementById('control_position').value,
        //     controlSystem: document.getElementById('control_system').value,
        //     controlColorPower: document.getElementById('control_power').value,
        //     controlController: document.getElementById('control_controller').value,
        //     controlClutchMotor: document.getElementById('motor_clutch').value,
        //     clutchCover: document.getElementById('c_bracket').checked,
        //     valance: selectedValance,
        //     valanceFinish: document.getElementById('valance_finish').value,
        //     valanceCaps: document.getElementById('val_cap').value,
        //     valanceReturn: document.getElementById('return_value').value,
        //     mount: selectedMount,
        //     trim: document.getElementById('trim').value,
        //     trimColor: selectedTrim,
        //     pull: document.getElementById('pull').value,
        //     pullColor: selectedPull,
        //     chainDrop: document.getElementById('chain_length').value,
        //     chainDropCustom: document.getElementById('drop').value,
        //     liftAssist: document.getElementById('lam').value,
        //     ultraLite: ultra_lam,
        //     springAssist: r24_lam,
        //     clutchColor: document.getElementById('clutch_colour').value,
        //     childSafety:selectedSafety,
        //     sideChannels: document.getElementById('side_channels').value,
        //     sideChannelMount: selectedSCMount,
        //     sideChannelFinish: document.getElementById('sc_finish').value,
        // }


		$.ajax({
			type: "POST",
            url: 'ordersDB/gemini_order.php',
			data: dataRei,
			success: function (html) {	
                //alert(html);
				// Inserting html into the result div on success
				$('#result').html(html);
			},
			error: function(jqXHR, text, error){
            // Displaying if there are any errors
            //alert(error);
            	$('#result').html(error);           
        }
    });
		// return false;
}

function delete_shade(code){
   
    dataString = {
        reid:code
    }

    $.ajax({
        type: "POST",
        url: 'ordersDB/delete_shade.php',
        data: dataString,
        success: function (html) {
            // Inserting html into the result div on success
            // $('#result').html(html);
        },
        error: function(jqXHR, text, error){
        // Displaying if there are any errors
            $('#result').html(error);           
    }
    }).then(setTimeout(function () {
        location.reload()
    }, 500));


}

function duplicate_shade(code){
    makeReid();

    dataString = {
        reid:code,
        nreid: REID
    }

    $.ajax({
        type: "POST",
        url: 'ordersDB/duplicate_row.php',
        data: dataString,
        success: function (html) {
            // Inserting html into the result div on success
            $('#result').html(html);
        },
        error: function(jqXHR, text, error){
        // Displaying if there are any errors
            $('#result').html(error);           
    }
    }).then(setTimeout(function () {
        location.reload()
    }, 500));
}

function edit_shade(code, type){
    if(type == "roller shade"){
        location.href = "../msg/roller.html?edit=true&reid="+code;
    }
    else if(type == "interlude shade"){
        location.href = "../msg/interlude.html?edit=true&reid="+code;
    }
    else if(type == "illusion shade"){
        location.href = "../msg/illusion.html?edit=true&reid="+code;
    }
    else if(type == "gemini dual shade"){
        location.href = "../msg/gemini.html?edit=true&reid="+code;
    }
    else if(type == "vision shade"){
        location.href = "../msg/vision.html?edit=true&reid="+code;
    }
    else if(type == "panel track"){
        location.href = "../msg/panel.html?edit=true&reid="+code;
    }
    else if(type == "roman shade"){
        location.href = "../msg/roman.html?edit=true&reid="+code;
    }
    else if(type == "fixed shade"){
        location.href = "../msg/fixed.html?edit=true&reid="+code;
    }
}

//Add to Cart & Modals

function addToCart(){
    $('#modal').fadeIn(400);
    $('#overlay').fadeIn(400);
}

function close_modal(){
    $('#modal').fadeOut(400);
    $('#overlay').fadeOut(400);
    $('#new-shade').fadeOut(400);
    // $('#duplicated-shade').fadeOut(400);
}

function add_new(){
    $('#new-shade').fadeIn(400);
    $('#modal').fadeOut(400);
}

function close_new(){
    $('#new-shade').fadeOut(400);
    $('#modal').fadeIn(400);
}

function notify_duplicate(){
    $('#duplicated-shade').fadeIn(400);
    // $('#overlay').fadeIn(400);
}

function close_duplicate(){
    $('#duplicated-shade').fadeOut(400);
    // $('#overlay').fadeOut(400);
    changeDraw('#details_1', '.detail-draw');
}

function show_seam(){
    $('#seam-overlay').fadeIn(400);
    $('#seam-modal').fadeIn(400);
}

function close_seam(){
    $('#seam-modal').fadeOut(400);
    $('#seam-overlay').fadeOut(400);
}

function show_motor(){
    $('#motor-overlay').fadeIn(400);
    $('#motor-modal').fadeIn(400);
}

function close_motor(){
    $('#motor-modal').fadeOut(400);
    $('#motor-overlay').fadeOut(400);
}

function show_schems(){
    $('#motor-overlay').fadeIn(400);
    $('#sc-modal').fadeIn(400);
}

function close_schems(){
    $('#sc-modal').fadeOut(400);
    $('#motor-overlay').fadeOut(400);
}

// REGISTERED ENTRY IDENTIFICATION
function REIDGenerator() {
	 
    this.length = 12;
    this.timestamp = +new Date;

    var _getRandomInt = function( min, max ) {
       return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
    }
    
    this.generate = function() {
        var ts = this.timestamp.toString();
        var parts = ts.split( "" ).reverse();
        var id = "";
        
        for( var i = 0; i < this.length; ++i ) {
           var index = _getRandomInt( 0, parts.length - 1 );
           id += parts[index];	 
        }
        id = "REID" +id

        return id;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    sg_edit = checkEdit();
    if(!sg_edit){
        makeReid();
        lineItems();
    }
    else{
        unlockAll();
    }
},false);

function makeReid(){
    var generator = new REIDGenerator();
    REID = generator.generate();
}

function saveOrderName(){
    
}

function lineItems(){
    Array.from(document.getElementsByClassName('line_item')).forEach(v=>{
        v.innerText = "Line #" +lineItem;
        lineItem+=1;
    });
}

function setTotal(){
    totalPrice = 0.00;
    var x = document.querySelectorAll("[class='item-price']");
    for (var i=0;i<x.length;i++) {
        value = x[i].innerText.replace("$", "");
        // //alert(value);
        totalPrice += parseFloat(value);
    }
    document.getElementById('price').innerText = totalPrice.toFixed(2);
    // //alert(totalPrice);
}

function manageRolls(){

    backRev = document.getElementById('back_reverse');

    if(selectedRoll == 'Regular'){
        backRev.style.display = 'None';
        back_selectedRoll = 'Regular';
    }
    else{
        backRev.style.display = '';
    }

}

function runMotorATC(){
    motor = document.getElementById("motor_clutch").value;
    back_selectedMotor = document.getElementById("back_motor_clutch").value;
   
    control_system = document.getElementById("control_system").value;
    back_control_system = document.getElementById("back_control_system").value;


    if((control_system == 'Motor' || back_control_system == 'Motor') && (selectedMotor != motor && back_selectedMotor != backMotor) && visitedAdd == false){
        show_motor();
        selectedMotor = document.getElementById('motor_clutch').value;
        back_selectedMotor = document.getElementById('back_motor_clutch').value;
    }
    else{
        addToCart();
    }
}

function goToAdds(){
    sendData();
    setTimeout(function(){ location.href='addons.php'  }, 1500);
}