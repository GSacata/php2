<?php
    namespace CPFCreator;
    
    require_once "validador-cpf.php";
    use function CPFValidator\calculateCPFLastDigits;

    $arrayCPFIncomplete = [];

    for ($i = 0; $i < 9; $i += 1) {
        $randNum = rand(0, 9);
        array_push($arrayCPFIncomplete, $randNum);
    };

    $arrayLastDigits = calculateCPFLastDigits($arrayCPFIncomplete);
    $arrayCPFComplete = array_merge($arrayCPFIncomplete, $arrayLastDigits);

    $CPFString = implode($arrayCPFComplete);
    echo "$CPFString";
?>