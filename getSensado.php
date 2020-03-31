<?php
/*
 * El siguiente código Obtiene los valores Sensados
 * AGZ    Sept/2019
 */
include_once("../Utilerias/BaseDatos.php");
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = consultaSensado();
    if (!empty($result)) {
            $response["success"] = 200;   // El success=200 es que encontro registros
            $response["message"] = "Sensado encontrados";
            $response["sensado"] = array();
            foreach ($result as $tupla){        // Recorre los registro que retorno
                $sensado = array();
                $sensado["idsen"] = $tupla["idsen"];
                $sensado["nomsensor"] = $tupla["nomsensor"];
                $sensado["valor"] = $tupla["valor"];
                array_push($response["sensado"], $sensado);
            }
           // codifica la información en formato de JSON response
           echo json_encode($response);
    } else {
        $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $response["message"] = "Valores de sensado no encontrados";
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 400;
    $response["message"] = "La solicitud no fue válida";

    // echoing JSON response
    echo json_encode($response);
}
?>
