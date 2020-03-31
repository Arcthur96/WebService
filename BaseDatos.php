<?php
//---------------------------------------------------------------------
// Utilerias de Bases de Dato
// Alejandro Guzmán Zazueta
// Septiembre 2019
//---------------------------------------------------------------------

try{
        $Cn = new PDO('pgsql:host=localhost;port=5432;dbname=PWeb2;user=postgres;password=hola');
        //$Cn = new PDO('mysql:host=localhost; dbname=bdalumnos','root','');
        $Cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $Cn->exec("SET CLIENT_ENCODING TO 'UTF8';");
        //$Cn->exec("SET CHARACTER SET utf8"); // MYSQL
}catch(Exception $e){
    die("Error: " . $e->GetMessage());
}

//-------------------------Web service--------------------------
function InsertaSen(&$post){
        $id = $post['idsen'];
        $noms = $post['nomsensor'];
        $val = $post['valor'];
        $sentencia = "INSERT INTO cuerpo.sensado(idsen,nomsensor,valor) values ($id, '$noms', $val)";
        return Ejecuta($sentencia);
    }
    function ActualizarSen($post){
        $ids = $post['idsen'];
        $noms = $post['nomsensor'];
        $val = $post['valor'];
        $sentencia = "UPDATE cuerpo.sensado SET nomsensor='$noms', valor=$val WHERE idsen=$ids";
        return Ejecuta($sentencia);
    }
    function InsActSen($post){
        if (InsertaSen($post)!=1)
            return ActualizarSen($post);
        else
            return 1;
    }
    function obj2array($obj) {
        $out = array();
        foreach ($obj as $key => $val) {
          switch(true) {
              case is_object($val):
               $out[$key] = obj2array($val);
               break;
            case is_array($val):
               $out[$key] = obj2array($val);
               break;
            default:
              $out[$key] = $val;
          }
        }
    
        return $out;
      }

//--------------------------Sensado-------------------------------
function consultaSensado()
{
    $query = "SELECT idsen,nomsensor,valor FROM cuerpo.sensado ORDER BY nomsensor";
    return Consulta($query);
}

function InsertarSensado(&$post){
    $noms = $post['noms'];
    $val = $post['valor'];
    $sentencia = "INSERT INTO cuerpo.sensado(nomsensor,valor) values('$noms', $val) RETURNING idsen";
    $id = EjecutaConsecutivo($sentencia,"idsen");
    $post['ids']=$id; 
    return $id;
}

function ActualizarSensado($post){
    $ids = $post['ids'];
    $noms = $post['noms'];
    $val = $post['valor'];
    $sentencia = "UPDATE cuerpo.sensado SET nomsensor='$noms', valor=$val WHERE idsen=$ids";
    return Ejecuta($sentencia);
}

function EliminarSensado($post){
    $ids = $post['ids'];
    $sentencia = "DELETE FROM cuerpo.sensado WHERE idsen=$ids";
    return Ejecuta($sentencia);
}



//------------------------------------------------------------

function validaSess(&$correo, &$tu, &$idsess){
    $correo = $correo;
    $sql = 'SELECT idsession,tipousr FROM "Escuela".usuario  WHERE correo like ' . "'" . $correo . "'";
    $res = Consulta($sql);
    $tipo = 0;
    foreach ($res as $tupla )
    {
        $idsess = $tupla['idsession'];
        $tu = $tupla['tipousr'];
    }   
    return 0;
}

//---------------------------------DeviceType-------------------------------------
function consultaDeviceType()
{
    $query = "SELECT iddevicetype,namedevice FROM cuerpo.devicetype ORDER BY namedevice";
    return Consulta($query);
}

function InsertarDeviceType(&$post){
    $idt = $post['idt'];
    $namt = $post['namt'];
    $sentencia = "INSERT INTO cuerpo.devicetype(namedevice) 
    values('$namt') RETURNING iddevicetype";
    $id = EjecutaConsecutivo($sentencia,"iddevicetype");
    $post['idt']=$id;
    return $id;
}

function ActualizarDeviceType($post){
    $idt = $post['idt'];
    $namt = $post['namt'];
    $sentencia = "UPDATE cuerpo.devicetype SET namedevice='$namt' WHERE iddevicetype=$idt";
    return Ejecuta($sentencia);
}

function EliminarDeviceType($post){
    $idt = $post['idt'];
    $sentencia = "DELETE FROM cuerpo.devicetype WHERE iddevicetype=$idt";
    return Ejecuta($sentencia);
}
