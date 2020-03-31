<?php 
    include_once("../Utilerias/BaseDatos.php");
    header('Content-type: application/json; charset=utf-8');
    $method=$_SERVER['REQUEST_METHOD'];
    $obj = json_decode( file_get_contents('php://input') );   
    $objArr = (array)$obj;
    if (empty($objArr))
    {
        $response["success"] = 422;  //No encontro información 
        $response["message"] = "Error: checar json entrada";
        header($_SERVER['SERVER_PROTOCOL']." 422  Error: faltan parametros de entrada json ");      
    }
    else
    {
        $response = array();
        $usr= $objArr['usr'];
        $cont= $objArr['pwd'];
        $sen = $objArr['sensado']; // Arrego de JSON
        $res = obj2array($sen);   // Convierte Json -&gt; Array
        
        // Validar que el usuario tiene permisos para actualizar tabla alumnos
        //
        $result = 0;
        foreach ($res as $value){
            $result = InsActSen($value);
        }
                    
        if ($result == 1) {
            $response["success"] = "201";
            $response["message"] = "Se Respaldo Sensado";
        }
        else{
            $response["success"] = "409";
            $response["message"] = "Sensado no se Respaldo";
            header($_SERVER['SERVER_PROTOCOL'] . " 409  Conflicto al Insertar ");
        }
    }
    echo json_encode($response);

?>
