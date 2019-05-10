// console.log('before');
// wait(1000);  //7 seconds in milliseconds
// console.log('after');
editData = null;

function wait(ms){
    var start = new Date().getTime();
    var end = start;
    while(end < start + ms) {
      end = new Date().getTime();
   }
}

// URL GET PARAMS
var url = new URL(document.URL);

var query_string = url.search;

var search_params = new URLSearchParams(query_string); 

var edit = search_params.get('edit');
var editID = search_params.get('reid');

function checkEdit(){
    if(edit == null && editID == null){
        console.log("Load new page");
        return false
    }
    else if(edit && editID == null){
        alert("Error: Please try again.");
        return false
    }
    else if(edit == 'true' && editID != null){
        // alert("Editing Now");
        // Manage the Fader somehow.
        $('.loader-overlay').show();
        $('.loader-overlay').fadeOut(4000);


        document.getElementById('atc').disabled = false;

        dataString = {
            reid: editID
        }

        $.ajax({
            type: "POST",
            url: "editBlind.php",
            dataType: "json",
            data: dataString,
            
            success : function(data) {
                console.log("SUCCESS rei");
                console.log(data);
                editData = data;
                if(editData["shade"] == "FIXED SHADE"){
                    loadFixed();
                }
                else if(editData["shade"] == "GEMINI DUAL SHADE"){
                    loadGemini();
                }
                else if(editData["shade"] == "PANEL TRACK"){
                    loadGemini();
                }
                else{
                    loadDetails();
                }
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
                console.log(XMLHttpRequest);
                console.log(textStatus);
                console.log(errorThrown); 
                console.log("FAIL rei");
            }        
        });
        
        return true
    }
}

function loadDetails(){

    /*---------------------------------------------------------------------------------------------------*/
    // Details
        $('#room').val(editData['shadeID']);

        $('#Quantity').val(editData["quantity"]);

        editWidth = Math.floor(editData["width"]);
        editWFraction = (editData["width"]) - editWidth;

        $('#sWidth').val(editWidth);
        if(editWFraction != 0 && editWFraction != NaN){
            $('#sWFraction').val(editWFraction);
        }

        editLength = Math.floor(editData["length"]);
        editLFraction = (editData["length"]) - editLength;
        $('#sLength').val(editLength);

       if(editLFraction != 0 && editLFraction != NaN){
           $('#sLFraction').val(editLFraction);
       }

        $('#measure').val(editData["measure"]);

    /*---------------------------------------------------------------------------------------------------*/
    //Fabric

        $('#fabric_group').val(editData["group"]);

        $("#fabric_series").append(new Option(editData["series"], editData["series"]));
        // $('#fabric_series').append($('<glow>', {value:glow, text:'glow'}));
        $('#fabric_series').val(editData["series"]);
        
        // $(fabric).prop("checked", true);
        selectedFabric =  editData["fabric"];
        // runFabric();
        //Do both to check box
    
    /*---------------------------------------------------------------------------------------------------*/
    //Hem
        selectedHem = editData["hem"];
        // $('input:radio[name=hem]')[4].checked = true;
        $("input[name=hem][value='"+selectedHem +"']").attr('checked', 'checked');
        // $("input[name=mygroup][value=" + value + "]").attr('checked', 'checked');

        if(editData["hemColor"] != null){
            $("#hem_finish").append(new Option(editData["hemColor"], editData["hemColor"]));
            $('#hem_finish').val(editData["hemColor"]);
        }
        //gotta runHem()

        if(editData["hemCaps"] != null){
            $("#hem_caps").append(new Option(editData["hemCaps"], editData["hemCaps"]));
            $('#hem_caps').val(editData["hemCaps"]);
        }

        $('#sWidth').trigger('change');
        $('#sLength').trigger('change');
        const wait = time => new Promise((resolve) => setTimeout(resolve, time));

        wait(3000).then( function(){

            $('#motor_clutch').val(editData["controlClutchMotor"])
            $('#motor_clutch').trigger('change');
            if(editData["liftAssist"] == 'true'){
                $('#lam').prop("checked", true);
            }
        });

        runHem();
        setBottomBar();
    /*---------------------------------------------------------------------------------------------------*/
    //Drive

        $('#control_position').val(editData["controlPosition"]);

        $("#control_system").append(new Option(editData["controlSystem"], editData["controlSystem"]));
        $('#control_system').val(editData["controlSystem"]);

        $("#control_power").append(new Option(editData["controlColorPower"], editData["controlColorPower"]));
        $('#control_power').val(editData["controlColorPower"]);

        $("#control_controller").append(new Option(editData["controlController"], editData["controlController"]));
        $('#control_controller').val(editData["controlController"]);

        $("#motor_clutch").append(new Option(editData["controlClutchMotor"], editData["controlClutchMotor"]));
        $('#motor_clutch').val(editData["controlClutchMotor"]);

        // $("#fabric_series").append(new Option("glow", "glow"));
        if(editData["controlclutchCover"] == 'true'){
            $('#c_bracket').val(true);
        }
        // motor_clutch
        // $('#sWidth').trigger('change');
        // $('#sLength').trigger('change');

    /*---------------------------------------------------------------------------------------------------*/
    //Valance

        selectedValance = editData["valance"];

        $("#valance_finish").append(new Option(editData["valanceFinish"], editData["valanceFinish"]));
        $('#valance_finish').val(editData["valanceFinish"]);
        
        if(editData["valanceCaps"] != null){
            $("#val_cap").append(new Option(editData["valanceCaps"], editData["valanceCaps"]));
            $('#val_cap').val(editData["valanceCaps"]);
        }   

        if(editData["valanceReturn"] != null){
            $("#return_value").append(new Option(editData["valanceReturn"], editData["valanceReturn"]));
            $('#return_value').val(editData["valanceReturn"]);
        }     

    /*---------------------------------------------------------------------------------------------------*/
    //Mount

        if(editData["mount"] == 'Ceiling'){
            $('#c_mount').prop("checked", true);
        }    
        else if(editData["mount"] == 'Wall'){
            $('#w_mount').prop("checked", true);
        }    
        else if(editData["mount"] == 'Lateral'){
            $('#l_mount').prop("checked", true);
        }

    /*---------------------------------------------------------------------------------------------------*/
    //Advanced

    $('#trim').val(editData["trim"]);
    $('#trim').trigger('change');
    selectedTrim = editData["trimColor"];

    //works if called Manually
    if(selectedTrim != null && selectedTrim != ""){
        $("input[name=trim][value="+selectedTrim +"]").attr('checked', 'checked');
    }

    $('#pull').val(editData["pull"]);
    $('#pull').trigger('change');
    selectedPull = editData["pullColor"];

    if(selectedPull != null && selectedPull != ""){
        $("input[name=pull][value="+selectedPull +"]").attr('checked', 'checked');
    }

    $('#chain_length').val(editData["chainDrop"]);
    if(editData["chainDrop"] == "Custom"){
        $('#drop').val(editData["chainDropLength"]);
    }

    if(editData["liftAssist"] == 'true'){
        $('#lam').prop("checked", true);
    }

    ultra_lam = editData["ultraLite"];
    r24_lam = editData["springAssist"];

    $("#clutch_colour").append(new Option(editData["clutchColor"], editData["clutchColor"]));
    $('#clutch_colour').val(editData["clutchColor"]);


    if(editData["childSafety"] == 'P-Clip'){
        $('input:radio[name=Safety]')[0].checked = true;
    }
    else if(editData["childSafety"] == 'Safety Hold Down'){
        $('input:radio[name=Safety]')[1].checked = true;
    }

    if(editData["holdDownBrackets"] == 'true'){
        $('#hold').prop("checked", true);
    }


    // if(editData["sideChannelMount"] == 'Lateral')
    $('#side_channels').val(editData["sideChannel"]);
    // $('#sc_mount').prop("checked", true);
    // $('#sc_mount').val('Lateral');
    
    //0 is lateral
    //1 is face
    if(editData["sideChannelMount"] == 'lateral'){
        $('input:radio[name=sc_mount]')[0].checked = true;
    }
    else if(editData["sideChannelMount"] == 'face'){
        $('input:radio[name=sc_mount]')[1].checked = true;
    }

    $('#sc_finish').val(editData["sideChannelFinish"]);

    //Gotta do both.
    selectedRoll = editData["rollType"];
    $('#'+editData["rollType"]).prop("checked", true);


    // runDriveSystem();
    $('#motor_clutch').val(editData["controlClutchMotor"]);
    setValance();
    runHem();
    setMount();
    /*---------------------------------------------------------------------------------------------------*/
    REID = editID;
}

function loadPanel(){

    /*---------------------------------------------------------------------------------------------------*/
    // Details
        $('#room').val(editData['shadeID']);

        $('#Quantity').val(editData["quantity"]);

        editWidth = Math.floor(editData["width"]);
        editWFraction = (editData["width"]) - editWidth;

        $('#sWidth').val(editWidth);
        if(editWFraction != 0 && editWFraction != NaN){
            $('#sWFraction').val(editWFraction);
        }

        editLength = Math.floor(editData["length"]);
        editLFraction = (editData["length"]) - editLength;
        $('#sLength').val(editLength);

       if(editLFraction != 0 && editLFraction != NaN){
           $('#sLFraction').val(editLFraction);
       }

        $('#measure').val(editData["measure"]);

        $('#panel').val(editData["panel"]);

        $('#open').val(editData["open"]);

        $('#channel').val(editData["channel"]);


    /*---------------------------------------------------------------------------------------------------*/
    //Fabric

        $('#fabric_group').val(editData["group"]);

        $("#fabric_series").append(new Option(editData["series"], editData["series"]));
        // $('#fabric_series').append($('<glow>', {value:glow, text:'glow'}));
        $('#fabric_series').val(editData["series"]);
        
        // $(fabric).prop("checked", true);
        selectedFabric =  editData["fabric"];
        // runFabric();
        //Do both to check box
    
    /*---------------------------------------------------------------------------------------------------*/
    //Hem
        selectedHem = editData["hem"];
        // $('input:radio[name=hem]')[4].checked = true;
        $("input[name=hem][value='"+selectedHem +"']").attr('checked', 'checked');
        // $("input[name=mygroup][value=" + value + "]").attr('checked', 'checked');

        if(editData["hemColor"] != null){
            $("#hem_finish").append(new Option(editData["hemColor"], editData["hemColor"]));
            $('#hem_finish').val(editData["hemColor"]);
        }
        //gotta runHem()

        if(editData["hemCaps"] != null){
            $("#hem_caps").append(new Option(editData["hemCaps"], editData["hemCaps"]));
            $('#hem_caps').val(editData["hemCaps"]);
        }

        $('#sWidth').trigger('change');
        $('#sLength').trigger('change');
        const wait = time => new Promise((resolve) => setTimeout(resolve, time));

        wait(2000).then( function(){

            $('#motor_clutch').val(editData["controlClutchMotor"])
            $('#motor_clutch').trigger('change');

        });

        runHem();
        setBottomBar();
    /*---------------------------------------------------------------------------------------------------*/
    //Drive

        $('#control_position').val(editData["controlPosition"]);

        $("#control_system").append(new Option(editData["controlSystem"], editData["controlSystem"]));
        $('#control_system').val(editData["controlSystem"]);

        $("#control_power").append(new Option(editData["controlColorPower"], editData["controlColorPower"]));
        $('#control_power').val(editData["controlColorPower"]);

        $("#control_controller").append(new Option(editData["controlController"], editData["controlController"]));
        $('#control_controller').val(editData["controlController"]);

        $("#motor_clutch").append(new Option(editData["controlClutchMotor"], editData["controlClutchMotor"]));
        $('#motor_clutch').val(editData["controlClutchMotor"]);

        // $("#fabric_series").append(new Option("glow", "glow"));
        if(editData["controlclutchCover"] == 'true'){
            $('#c_bracket').val(true);
        }
        // motor_clutch
        // $('#sWidth').trigger('change');
        // $('#sLength').trigger('change');

    /*---------------------------------------------------------------------------------------------------*/
    //Valance

        selectedValance = editData["valance"];

        $("#valance_finish").append(new Option(editData["valanceFinish"], editData["valanceFinish"]));
        $('#valance_finish').val(editData["valanceFinish"]);
        
        if(editData["valanceCaps"] != null){
            $("#val_cap").append(new Option(editData["valanceCaps"], editData["valanceCaps"]));
            $('#val_cap').val(editData["valanceCaps"]);
        }   

        if(editData["valanceReturn"] != null){
            $("#return_value").append(new Option(editData["valanceReturn"], editData["valanceReturn"]));
            $('#return_value').val(editData["valanceReturn"]);
        }     

    /*---------------------------------------------------------------------------------------------------*/
    //Mount

        if(editData["mount"] == 'Ceiling'){
            $('#c_mount').prop("checked", true);
        }    
        else if(editData["mount"] == 'Wall'){
            $('#w_mount').prop("checked", true);
        }    
        else if(editData["mount"] == 'Lateral'){
            $('#l_mount').prop("checked", true);
        }

    /*---------------------------------------------------------------------------------------------------*/
    //Advanced

    $('#trim').val(editData["trim"]);
    $('#trim').trigger('change');
    selectedTrim = editData["trimColor"];

    //works if called Manually
    if(selectedTrim != null && selectedTrim != ""){
        $("input[name=trim][value="+selectedTrim +"]").attr('checked', 'checked');
    }

    $('#pull').val(editData["pull"]);
    $('#pull').trigger('change');
    selectedPull = editData["pullColor"];

    if(selectedPull != null && selectedPull != ""){
        $("input[name=pull][value="+selectedPull +"]").attr('checked', 'checked');
    }

    $('#chain_length').val(editData["chainDrop"]);
    if(editData["chainDrop"] == "Custom"){
        $('#drop').val(editData["chainDropLength"]);
    }

    if(editData["liftAssist"] == 'true'){
        $('#lam').prop("checked", true);
    }

    ultra_lam = editData["ultraLite"];
    r24_lam = editData["springAssist"];

    $("#clutch_colour").append(new Option(editData["clutchColor"], editData["clutchColor"]));
    $('#clutch_colour').val(editData["clutchColor"]);


    if(editData["childSafety"] == 'P-Clip'){
        $('input:radio[name=Safety]')[0].checked = true;
    }
    else if(editData["childSafety"] == 'Safety Hold Down'){
        $('input:radio[name=Safety]')[1].checked = true;
    }

    if(editData["holdDownBrackets"] == 'true'){
        $('#hold').prop("checked", true);
    }


    // if(editData["sideChannelMount"] == 'Lateral')
    $('#side_channels').val(editData["sideChannel"]);
    // $('#sc_mount').prop("checked", true);
    // $('#sc_mount').val('Lateral');
    
    //0 is lateral
    //1 is face
    if(editData["sideChannelMount"] == 'lateral'){
        $('input:radio[name=sc_mount]')[0].checked = true;
    }
    else if(editData["sideChannelMount"] == 'face'){
        $('input:radio[name=sc_mount]')[1].checked = true;
    }

    $('#sc_finish').val(editData["sideChannelFinish"]);

    //Gotta do both.
    selectedRoll = editData["rollType"];
    $('#'+editData["rollType"]).prop("checked", true);


    // runDriveSystem();
    $('#motor_clutch').val(editData["controlClutchMotor"]);
    setValance();
    runHem();
    setMount();
    /*---------------------------------------------------------------------------------------------------*/
    REID = editID;
}

function loadGemini(){

    /*---------------------------------------------------------------------------------------------------*/
    // Details
        $('#room').val(editData['shadeID']);

        $('#Quantity').val(editData["quantity"]);

        editWidth = Math.floor(editData["width"]);
        editWFraction = (editData["width"]) - editWidth;

        $('#sWidth').val(editWidth);
        if(editWFraction != 0 && editWFraction != NaN){
            $('#sWFraction').val(editWFraction);
        }

        editLength = Math.floor(editData["length"]);
        editLFraction = (editData["length"]) - editLength;
        $('#sLength').val(editLength);

       if(editLFraction != 0 && editLFraction != NaN){
           $('#sLFraction').val(editLFraction);
       }

        $('#measure').val(editData["measure"]);

    /*---------------------------------------------------------------------------------------------------*/
    //Fabric

        $('#fabric_group').val(editData["group"]);

        $("#fabric_series").append(new Option(editData["series"], editData["series"]));
        // $('#fabric_series').append($('<glow>', {value:glow, text:'glow'}));
        $('#fabric_series').val(editData["series"]);
        
        // $(fabric).prop("checked", true);
        selectedFabric =  editData["fabric"];
        // runFabric();
        //Do both to check box
    
    /*---------------------------------------------------------------------------------------------------*/
    //Hem
        selectedHem = editData["hem"];
        // $('input:radio[name=hem]')[4].checked = true;
        $("input[name=hem][value='"+selectedHem +"']").attr('checked', 'checked');
        // $("input[name=mygroup][value=" + value + "]").attr('checked', 'checked');

        if(editData["hemColor"] != null){
            $("#hem_finish").append(new Option(editData["hemColor"], editData["hemColor"]));
            $('#hem_finish').val(editData["hemColor"]);
        }
        //gotta runHem()

        if(editData["hemCaps"] != null){
            $("#hem_caps").append(new Option(editData["hemCaps"], editData["hemCaps"]));
            $('#hem_caps').val(editData["hemCaps"]);
        }

        $('#sWidth').trigger('change');
        $('#sLength').trigger('change');
        const wait = time => new Promise((resolve) => setTimeout(resolve, time));

        wait(6000).then( function(){

            $('#motor_clutch').val(editData["controlClutchMotor"])
            $('#motor_clutch').trigger('change');

            $('#back_motor_clutch').val(editData["backCClutchMotor"])
            $('#back_motor_clutch').trigger('change');

        });

        runHem();
    /*---------------------------------------------------------------------------------------------------*/
    //Drive

        $('#control_position').val(editData["controlPosition"]);

        $("#control_system").append(new Option(editData["controlSystem"], editData["controlSystem"]));
        $('#control_system').val(editData["controlSystem"]);

        $("#control_power").append(new Option(editData["controlColorPower"], editData["controlColorPower"]));
        $('#control_power').val(editData["controlColorPower"]);

        $("#control_controller").append(new Option(editData["controlController"], editData["controlController"]));
        $('#control_controller').val(editData["controlController"]);

        $("#motor_clutch").append(new Option(editData["controlClutchMotor"], editData["controlClutchMotor"]));
        $('#motor_clutch').val(editData["controlClutchMotor"]);

        // $("#fabric_series").append(new Option("glow", "glow"));
        if(editData["controlclutchCover"] == 'true'){
            $('#c_bracket').val(true);
        }
        // motor_clutch
        // $('#sWidth').trigger('change');
        // $('#sLength').trigger('change');

    /*---------------------------------------------------------------------------------------------------*/
    //Valance

        selectedValance = editData["valance"];

        $("#valance_finish").append(new Option(editData["valanceFinish"], editData["valanceFinish"]));
        $('#valance_finish').val(editData["valanceFinish"]);
        
        if(editData["valanceCaps"] != null){
            $("#val_cap").append(new Option(editData["valanceCaps"], editData["valanceCaps"]));
            $('#val_cap').val(editData["valanceCaps"]);
        }   

        if(editData["valanceReturn"] != null){
            $("#return_value").append(new Option(editData["valanceReturn"], editData["valanceReturn"]));
            $('#return_value').val(editData["valanceReturn"]);
        }     

    /*---------------------------------------------------------------------------------------------------*/
    //Mount

        if(editData["mount"] == 'Ceiling'){
            $('#c_mount').prop("checked", true);
        }    
        else if(editData["mount"] == 'Wall'){
            $('#w_mount').prop("checked", true);
        }    
        else if(editData["mount"] == 'Lateral'){
            $('#l_mount').prop("checked", true);
        }

    /*---------------------------------------------------------------------------------------------------*/
    //Advanced

    $('#chain_length').val(editData["chainDrop"]);
    if(editData["chainDrop"] == "Custom"){
        $('#drop').val(editData["chainDropLength"]);
    }

    $("#clutch_colour").append(new Option(editData["clutchColor"], editData["clutchColor"]));
    $('#clutch_colour').val(editData["clutchColor"]);

    if(editData["childSafety"] == 'P-Clip'){
        $('input:radio[name=Safety]')[0].checked = true;
    }
    else if(editData["childSafety"] == 'Safety Hold Down'){
        $('input:radio[name=Safety]')[1].checked = true;
    }

    //Gotta do both.
    selectedRoll = editData["rollType"];
    $('#'+editData["rollType"]).prop("checked", true);


    // runDriveSystem();
    $('#motor_clutch').val(editData["controlClutchMotor"]);
    setValance();
    runHem();
    setMount();
    setBottomBar();
    /*---------------------------------------------------------------------------------------------------*/
    //Back Fabric

    $('#back_fabric_group').val(editData["backGroup"]);

    $("#back_fabric_series").append(new Option(editData["backSeries"], editData["backSeries"]));
    // $('#fabric_series').append($('<glow>', {value:glow, text:'glow'}));
    $('#back_fabric_series').val(editData["backSeries"]);
    
    // $(fabric).prop("checked", true);
    back_selectedFabric =  editData["backFabric"];
    // runFabric();
    //Do both to check box
   

    /*---------------------------------------------------------------------------------------------------*/
    //Back Hem
    back_selectedHem = editData["backHem"];
    // $('input:radio[name=hem]')[4].checked = true;
    $("input[name=back_hem][value='back_"+selectedHem +"']").attr('checked', 'checked');
    // $("input[name=mygroup][value=" + value + "]").attr('checked', 'checked');

    if(editData["backhemColor"] != null){
        $("#back_hem_finish").append(new Option(editData["backHemColor"], editData["backHemColor"]));
        $('#back_hem_finish').val(editData["backHemColor"]);
    }
    //gotta runHem()

    if(editData["backHemCaps"] != null){
        $("#back_hem_caps").append(new Option(editData["backHemCaps"], editData["backHemCaps"]));
        $('#back_hem_caps').val(editData["backHemCaps"]);
    }

    // $('#sWidth').trigger('change');
    // $('#sLength').trigger('change');
    // const back_wait = time => new Promise((resolve) => setTimeout(resolve, time));

    // back_wait(2000).then(function(){



    // });

    back_runHem();
    back_setBottomBar();
    /*---------------------------------------------------------------------------------------------------*/
    //Back Drive
    $('#back_control_position').val(editData["backCPosition"]);

    $("#back_control_system").append(new Option(editData["backCSystem"], editData["backCSystem"]));
    $('#back_control_system').val(editData["backCSystem"]);

    $("#back_control_power").append(new Option(editData["backCColorPower"], editData["backCColorPower"]));
    $('#back_control_power').val(editData["backCColorPower"]);

    $("#back_control_controller").append(new Option(editData["backCController"], editData["backCController"]));
    $('#back_control_controller').val(editData["backCController"]);

    $("#back_motor_clutch").append(new Option(editData["backCClutchMotor"], editData["backCClutchMotor"]));
    $('#back_motor_clutch').val(editData["backCClutchMotor"]);

    // $("#fabric_series").append(new Option("glow", "glow"));
    if(editData["backcontrolclutchCover"] == 'true'){
        $('#back_c_bracket').val(true);
    }
    // motor_clutch
    // $('#sWidth').trigger('change');
    // $('#sLength').trigger('change');
    /*---------------------------------------------------------------------------------------------------*/
    //Back Advanced

    $('#back_chain_length').val(editData["backChainDrop"]);
    if(editData["backChainDrop"] == "Custom"){
        $('#back_drop').val(editData["backChainDropLength"]);
    }

    $("#back_clutch_colour").append(new Option(editData["backClutchColor"], editData["backClutchColor"]));
    $('#back_clutch_colour').val(editData["backClutchColor"]);


    if(editData["backChildSafety"] == 'P-Clip'){
        $('input:radio[name=back_Safety]')[0].checked = true;
    }
    else if(editData["backChildSafety"] == 'Safety Hold Down'){
        $('input:radio[name=back_Safety]')[1].checked = true;
    }

    $('#side_channels').val(editData["backSideChannel"]);
    // $('#sc_mount').prop("checked", true);
    // $('#sc_mount').val('Lateral');

    //0 is lateral
    //1 is face
    if(editData["backSideChannelMount"] == 'lateral'){
        $('input:radio[name=sc_mount]')[0].checked = true;
    }
    else if(editData["backSideChannelMount"] == 'face'){
        $('input:radio[name=sc_mount]')[1].checked = true;
    }

    $('#sc_finish').val(editData["backSideChannelFinish"]);

    //Gotta do both.
    back_selectedRoll = editData["backRollType"];
    $('#back_'+editData["backRollType"]).prop("checked", true);


    // runDriveSystem();
    // $('#motor_clutch').val(editData["controlClutchMotor"]);
    // setValance();
    back_runHem();
    setMount();
    /*---------------------------------------------------------------------------------------------------*/
    REID = editID;
    // back_
}

function loadFixed(){

    /*---------------------------------------------------------------------------------------------------*/
    // Details
        $('#room').val(editData['shadeID']);

        $('#Quantity').val(editData["quantity"]);

        editWidth = Math.floor(editData["width"]);
        editWFraction = (editData["width"]) - editWidth;

        $('#sWidth').val(editWidth);
        if(editWFraction != 0 && editWFraction != NaN){
            $('#sWFraction').val(editWFraction);
        }

        editLength = Math.floor(editData["length"]);
        editLFraction = (editData["length"]) - editLength;
        $('#sLength').val(editLength);

       if(editLFraction != 0 && editLFraction != NaN){
           $('#sLFraction').val(editLFraction);
       }

        $('#measure').val(editData["measure"]);

    /*---------------------------------------------------------------------------------------------------*/
    //Fabric

        $('#fabric_group').val(editData["group"]);

        $("#fabric_series").append(new Option(editData["series"], editData["series"]));
        // $('#fabric_series').append($('<glow>', {value:glow, text:'glow'}));
        $('#fabric_series').val(editData["series"]);
        
        // $(fabric).prop("checked", true);
        selectedFabric =  editData["fabric"];
        // runFabric();
        //Do both to check box
    
    /*---------------------------------------------------------------------------------------------------*/
    //Hem
        selectedHem = editData["hem"];
        // $('input:radio[name=hem]')[4].checked = true;
        $("input[name=hem][value='"+selectedHem +"']").attr('checked', 'checked');
        // $("input[name=mygroup][value=" + value + "]").attr('checked', 'checked');

        if(editData["hemColor"] != null){
            $("#hem_finish").append(new Option(editData["hemColor"], editData["hemColor"]));
            $('#hem_finish').val(editData["hemColor"]);
        }
        //gotta runHem()

        if(editData["hemCaps"] != null){
            $("#hem_caps").append(new Option(editData["hemCaps"], editData["hemCaps"]));
            $('#hem_caps').val(editData["hemCaps"]);
        }

        $('#sWidth').trigger('change');
        $('#sLength').trigger('change');

        runFixedHem();
        setBottomBar();
    /*---------------------------------------------------------------------------------------------------*/
    //Drive

        // $('#control_position').val(editData["controlPosition"]);

        //$("#fixed_system").append(new Option(editData["controlSystem"], editData["controlSystem"]));
        $('#fixed_system').val(editData["controlSystem"]);

        //$("#control_power").append(new Option(editData["controlColorPower"], editData["controlColorPower"]));
        $('#fix_details').val(editData["controlColorPower"]);
        setFixedDrive();

    /*---------------------------------------------------------------------------------------------------*/
    //Advanced

    $('#trim').val(editData["trim"]);
    $('#trim').trigger('change');
    selectedTrim = editData["trimColor"];

    //works if called Manually
    if(selectedTrim != null && selectedTrim != ""){
        $("input[name=trim][value="+selectedTrim +"]").attr('checked', 'checked');
    }

    $('#pull').val(editData["pull"]);
    $('#pull').trigger('change');
    selectedPull = editData["pullColor"];

    if(selectedPull != null && selectedPull != ""){
        $("input[name=pull][value="+selectedPull +"]").attr('checked', 'checked');
    }

    /*---------------------------------------------------------------------------------------------------*/
    REID = editID;
}
    
// editData = JSON.stringify(editData);
// console.log(editData);
// console.log("Here Rei");

//loadDetails();

// $('#measure').trigger('change');


