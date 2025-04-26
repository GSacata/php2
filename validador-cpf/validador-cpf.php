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

            $requestCPF = $_POST["cpf-validator-field-cpf-to-validate"]; // Vem como string
            // $requestCPF = "367.522.200-42"; // DEV-TESTE
            // $requestCPF = "367.522.200-1"; // DEV-TESTE
            // $requestCPF = "367.522.200-1a"; // DEV-TESTE
            // $requestCPF = "367.522.264-42"; // DEV-TESTE
            // $requestCPF = "22222222222"; // DEV-TESTE
            // $requestCPF = "22222222221"; // DEV-TESTE

            function validateCPF($postedCPF) {
                $postedCPFClean = preg_replace("/\D/", "", $postedCPF);
                
                // verif de tamanho
                if (strlen($postedCPFClean) != 11) return false;

                // verif dígitso iguais
                $postedCPFCleanArray = str_split($postedCPFClean);
                $arrayCPFSingleNumber = array_unique($postedCPFCleanArray);
                if (count($arrayCPFSingleNumber) == 1) {
                    return false;
                }

                $CPFIncomplete = substr($postedCPFClean, 0, 9);
                $arrayCPFIncomplete = str_split($CPFIncomplete);

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

                // var_dump($refCPF);
                // var_dump($postedCPF);

                // comparando
                return ($refCPF == $postedCPFClean) ? true : false;
            };

            $CPFIsValid = validateCPF($requestCPF);
            
            if ($CPFIsValid) {
                echo "CPF válido.\n";
            } else {
                echo "CPF inválido.\n";
            };

        ?>

    </div>
</body>
</html>