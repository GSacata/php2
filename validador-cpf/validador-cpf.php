<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validador de CPF</title>
</head>
<body>
    <div>
        <?php
            echo "Chamou validador-cpf.php\n";

            // $requestCPF = $_POST["cpf-validator-field-cpf-to-validate"]; // Vem como string
            $requestCPF = "384.294.578-79"; // DEV-TESTE
            // $requestCPF = "22222222221"; // DEV-TESTE

            // planejamento:
            // primeiro limpar o CPF de símbolos estranhos
            // tamanho de 11
            // se todos os dígitos são iguais
            // aplicação de fórmula
            // comparação com input

            function devEchoTested($d=false, ...$args) {
                // $i = 0;
                // $len = count($args);
                // for ($i = 0; $i < $len; $i += 1) {
                //     echo ""
                // }
                foreach($args as $x) {
                    if ($d) {
                        var_dump($x);
                    } else {
                        echo "$x\n";
                    };
                }
            }

            function devEchoArrayElem($d=false, $pArray) {
                foreach($pArray as $elem) {
                    if ($d) {
                        var_dump($elem);
                    } else {
                        echo "$elem\n";
                    };
                }
            }

            function validateCPF($postedCPF) {
                $postedCPFClean = preg_replace("/\D/", "", $postedCPF);
                $CPFIncomplete = substr($postedCPFClean, 0, 9);
                $arrayCPFIncomplete = str_split($CPFIncomplete);

                // devEchoTested($d=false, '$postedCPF', $postedCPF);
                // devEchoTested($d=false, '$postedCPFClean', $postedCPFClean);
                // devEchoTested($d=false, '$CPFIncomplete', $CPFIncomplete);
                // devEchoArrayElem($d=false, $arrayCPFIncomplete);
                
                $arrayCPFIncomplete = array_map(function ($x) {
                    return (int)$x;
                }, $arrayCPFIncomplete);

                $totalFirstPart = 0;
                
                // calculando primeiro dígito
                $paramFirstDigit = 10;
                foreach ($arrayCPFIncomplete as $num) {
                    $totalFirstPart += ($num * $paramFirstDigit);
                    $paramFirstDigit -= 1;
                }
                
                $divRestFirstDigit = ($totalFirstPart % 11);
                $diffFirstDigit = 11 - $divRestFirstDigit;

                // devEchoTested($d=false, "divRestFirstDigit", $divRestFirstDigit, "diffFirstDigit", $diffFirstDigit);
                
                $firstDigit = 0;
                if ($diffFirstDigit >= 10) {
                    $firstDigit = 0;
                } else {
                    $firstDigit = $diffFirstDigit;
                }
                array_push($arrayCPFIncomplete, $firstDigit);

                // calculadndo segundo dígito
                $totalSecondPart = 0;
                $paramSecondDigit = 11;
                
                foreach ($arrayCPFIncomplete as $num) {
                    $totalSecondPart += ($num * $paramSecondDigit);
                    $paramSecondDigit -= 1;
                }
                
                $divRestSecondDigit = ($totalSecondPart % 11);
                $diffSecondDigit = 11 - $divRestSecondDigit;
                
                $secondDigit = 0;
                if ($diffSecondDigit >= 10) {
                    $secondDigit = 0;
                } else {
                    $secondDigit = $diffSecondDigit;
                }
                array_push($arrayCPFIncomplete, $secondDigit);

                // remontando CPF
                $refCPF = implode("", $arrayCPFIncomplete);

                devEchoTested($d=true, $refCPF);
                // comparando
                if ($refCPF == $postedCPFClean) {
                    echo "CPF válido.\n";
                    devEchoTested($d=false, '$refCPF', $refCPF, '$postedCPF', $postedCPF);
                } else {
                    echo "CPF inválido\n";
                    devEchoTested($d=false, '$refCPF', $refCPF, '$postedCPF', $postedCPF);
                };

            };
            validateCPF($requestCPF);

        ?>

    </div>
</body>
</html>