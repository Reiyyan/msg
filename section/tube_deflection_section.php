<?php

    $tubes = array();
    $possibleDeflectionTubes = array();
    
    /*Array of Tubes
    [0]---> 1 Inch Tube
    [1]---> 1.125 Inch Tube
    [2]---> 1.5 Inch Tube
    [3]---> 2 Inch Tube
    [4]---> 2.5 Inch Tube
    [5]---> 3 Inch Tube
    [6]---> J 1.5 Inch Tube
    Check mySql DB for errors  
    */

    class Tube{

        var $tube_name;
        var $tube_radius;
        var $tube_weight;
        var $tube_inertia;

        public function  __construct($tube_name, $tube_radius, $tube_weight, $tube_inertia) {
            $this->tube_name = $tube_name;
            $this->tube_radius = $tube_radius;
            $this->tube_weight = $tube_weight;
            $this->tube_inertia = $tube_inertia;
        }

    }

    $selectedTube = new Tube(0,0,0,0);

    $tubequery = "SELECT name, radius, weight, inertia FROM _tube;";
    $tresult = $conn->query($tubequery);

    //Creating Tubes Array and Tube Objects
    if ($tresult->num_rows > 0) {
        while($row = $tresult->fetch_assoc()) {
            $tubes[] = $row;
        }

        //Separating the tubes from the arrays, into objects
        $tube_0 = new Tube($tubes[0]["name"],$tubes[0]["radius"],$tubes[0]["weight"],$tubes[0]["inertia"]);
        $tube_1 = new Tube($tubes[1]["name"],$tubes[1]["radius"],$tubes[1]["weight"],$tubes[1]["inertia"]);
        $tube_2 = new Tube($tubes[2]["name"],$tubes[2]["radius"],$tubes[2]["weight"],$tubes[2]["inertia"]);
        $tube_3 = new Tube($tubes[3]["name"],$tubes[3]["radius"],$tubes[3]["weight"],$tubes[3]["inertia"]);
        $tube_4 = new Tube($tubes[4]["name"],$tubes[4]["radius"],$tubes[4]["weight"],$tubes[4]["inertia"]);
        $tube_5 = new Tube($tubes[5]["name"],$tubes[5]["radius"],$tubes[5]["weight"],$tubes[5]["inertia"]);
        $tube_6 = new Tube($tubes[6]["name"],$tubes[6]["radius"],$tubes[6]["weight"],$tubes[6]["inertia"]);
        $tube_7 = new Tube($tubes[7]["name"],$tubes[7]["radius"],$tubes[7]["weight"],$tubes[7]["inertia"]);
    }

    //Calculating Deflection for each Tube
    foreach($tubes as $tube){
    $deflection = deflectionCalculus($fabric_width, $fabric_length, $fabric_weight, $tube['weight'], $hem_weight, $tube['inertia']);
    array_push($deflectionArray, $deflection);
    } 

?>