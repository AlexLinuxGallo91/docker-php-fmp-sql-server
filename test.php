<?php

print "------Inicio Prueba" . date('Y-m-d H:i:s') . "\n";


/* $serverName = "192.168.45.207\SQL2K16,1443";
$connectionOptions = array(
    "database" => "itoc_Admon_Herramientas",
    "uid" => "alberto.garcia",
    "pwd" => "X:~sVG.5g7t3pC0zC7q0"
);
$tsql = "
SELECT top (10) [ID]
,[VERSION]
,[TITLE]
,[DESCRIPTION]
,[SOLUTION]
,[STATE]
,[SEVERITY]
,[PRIORITY]
,[CATEGORY]
,[SUBCATEGORY]
,[TYPE]
,[RELATED_CI_HINT]
,[OM_SERVICE_ID]
,[RELATED_CI_ID]
,[RELATED_CI_TYPE]
,[OM_USER]
,[ASSIGNED_USER]
,[ASSIGNED_GROUP]
,[CAUSE_ID]
,[TIME_CREATED]
,[TIME_CHANGED]
,[TIME_STATE_CHANGED]
,[TIME_RECEIVED]
,[APPLICATION]
,[OBJECT]
FROM [172.20.40.89].[BSMOMI].[dbo].[ALL_EVENTS] WITH (NOLOCK)
"; */

$dsn = "mysql:host=localhost;dbname=homestead;charset=UTF8";
$vc_user = "root";
$vc_passw = "Itoc.Triara521*";

/* $dsn = "mysql:host=172.20.45.242;dbname=itoc-plus;charset=UTF8";
$vc_user = "itoc";
$vc_passw = "Itoc.Triara521*";
*/

$respuesta = array();
$rows = array();
$v = array();
$num = 0;
$tsql = "
SELECT id, application, category, priority, severity, state, time_created_label, time_received_label, created_at, updated_at, assigned_user, time_created_dt, time_received_dt, time_changed_dt, custom_attribute_list
FROM events order by id desc limit 10
";

try {

    /*  $conn = sqlsrv_connect($serverName, $connectionOptions);
    print "\n";
    var_dump($conn);
    if ($conn === false) {
        if (($errors = sqlsrv_errors()) != null) {
            print "\n";
            var_dump($errors);
        }
        $respuesta = array("id" => 0, "Detalle" => "Error en la conexion a la Base de Datos" . $list_errors);
    } else {
        $link = $conn;
        $stmt = sqlsrv_query($link, $tsql);
        print_r('Respuesta del sqlsrv_query  $stmt:');
        print "\n";
        var_dump($stmt);
        if ($stmt) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                print "\n";
                $num++;
                print_r('Respuesta del sqlsrv_query  $row:' . $num);
                print "\n";
                print_r($row);
                array_push($rows, $row);
            }
            $respuesta = array("id" => 1, "Detalle" => $rows);
        } else {
            $respuesta = array("id" => 0, "Detalle" => "Error en SQL " . json_encode(sqlsrv_errors()));
        }
    }
    print_r(json_encode($rows));  */


    $conn = new PDO($dsn, $vc_user, $vc_passw);
    if (!$conn) {
        $conn = false;
    }
    if ($conn) {
        $statement = $conn->prepare($tsql);
        //$statement->bindParam(':parametros', $parametrosJSON, PDO::PARAM_STR);
        $statement->execute();
        do {
            $row = $statement->fetchAll(PDO::FETCH_ASSOC);
            if ($row) {
                array_push($v, $row);
            }
        } while ($statement->nextRowset());
    } else {
        $respuesta = array(array('id' => 0, 'Detalle' => 'Error de conexion a la BD.'));
    }
    if (isset($salida[0])) {
        $respuesta = $salida[0];
    }
} catch (Exception $e) {
    $respuesta = array("id" => 0, "Detalle" => "Error Proceso Exception" . $e);
} catch (PDOException $e) {
    $respuesta = array("id" => 0, "Detalle" => "Error Proceso PDOException" . $e);
}


print "\n\n\n\n\n -------Finalizacion Test" . date('Y-m-d H:i:s') . "\n";
print_r(json_encode($respuesta));
print "\n";
print "Rows:  \n";
print_r(json_encode($v));
print "\n";
print "\n\n\n\n\n -------Finalizacion Test" . date('Y-m-d H:i:s') . "\n";
print "\n\n\n\n\n -------" . "\n";

/* foreach ($row as $row2) {

    if (isset($row2["assigned_user"])) {
        print "\n\n\n\n";
        var_dump($row2["assigned_user"]);
        print "\n\n";
        $assigned_user = trim($row2["assigned_user"], "\"");;
        print "Event no: " . $num++ . "       |||||     assigned_user que viene de la BD: " . $assigned_user . "\n\n\n";
        print "var_dum  assigned_user \n";
        var_dump($assigned_user);
        print "\n\n";
        if ($assigned_user == "92") {
            $assigned_user_details["id"] = '92';
            $assigned_user_details["login_name"] = 'angela.galvan';
            $assigned_user_details["user_name"] = 'Angela Galvan';
        } else if ($assigned_user == "148") {
            $assigned_user_details["id"] = '148';
            $assigned_user_details["login_name"] = 'juan.cruz';
            $assigned_user_details["user_name"] = 'Juan Cruz';
        } else if ($assigned_user == "71") {
            $assigned_user_details["id"] = '71';
            $assigned_user_details["login_name"] = 'lorena.cruz';
            $assigned_user_details["user_name"] = 'Lorena Cruz';
        } else if ($assigned_user == "82") {
            $assigned_user_details["id"] = '82';
            $assigned_user_details["login_name"] = 'mario.gutierrez';
            $assigned_user_details["user_name"] = 'Mario Gutierrez';
        } else if ($assigned_user == "138") {
            $assigned_user_details["id"] = '138';
            $assigned_user_details["login_name"] = 'alan.torres';
            $assigned_user_details["user_name"] = 'Alan Torres';
        } else if ($assigned_user == "130") {
            $assigned_user_details["id"] = '130';
            $assigned_user_details["login_name"] = 'OPC.Zenoss';
            $assigned_user_details["user_name"] = 'OPC Zenoss';
        } else if ($assigned_user == "110") {
            $assigned_user_details["id"] = '110';
            $assigned_user_details["login_name"] = 'arkadi.padilla';
            $assigned_user_details["user_name"] = 'Arkadi Padilla';
        } else {
            $assigned_user_details["id"] = '-1';
            $assigned_user_details["login_name"] = '<unknown>';
            $assigned_user_details["user_name"] = '<unknown>';
        }
        print "\n\n";
        print 'userDetailsById resultado del metodo :' . json_encode($assigned_user_details);
        $row2["user_name"] = $assigned_user_details["user_name"];
        print "\n\n";
        print "user_name";
        print "\n\n";
        print $row2["user_name"];
        print "\n\n";
    }
}  */



















/////////////////////////////////////////Custom attributes 
/* $respuesta = array();
$customs = array();
$row = array();
$str = "cCI_id :::  ___ cliente ::: \\\/Clientes\\\/LOTERIA NACIONAL ___ cLocalidad :::  ___ Component_Name :::  ___ contacto ::: INTEGRACION_ZENOSS ___ Correo :::  ___ cPais ::: N\\\/A ___ cProveedor ::: N\\\/A ___ cReferencia ::: N\\\/A ___ cRespaldo ::: N\\\/A ___ cResponsable ::: N\\\/A ___ cResponsable2 ::: N\\\/A ___ cResponsable3 :::  ___ cResponsableDelSitio ::: N\\\/A ___ cRFCAlta ::: N\\\/A ___ Evento Zenoss ::: {\"uuid\":\"71c9aaed-5af9-4f11-a1ed-27e8ef862187\",\"action\":\"EventsRouter\",\"result\":{\"totalCount\":1,\"events\":[{\"prodState\":\"Production\",\"firstTime\":1663980617.986,\"facility\":null,\"eventClassKey\":null,\"agent\":\"zencommand\",\"dedupid\":\"10.200.130.88||\/Perf\/CPU|CPULOAD|CPULOAD_total 5m|CPU Error|4\",\"Location\":[{\"uid\":\"\/zport\/dmd\/Locations\/Triara Monterrey\/Colocado\",\"name\":\"\/Triara Monterrey\/Colocado\"}],\"ownerid\":null,\"eventClass\":{\"text\":\"\/Perf\/CPU\",\"uid\":\"\/zport\/dmd\/Events\/Perf\/CPU\"},\"id\":\"0242ac11-0008-80f7-11ed-3ba3069a0b01\",\"DevicePriority\":\"Normal\",\"monitor\":\"LOTENAL\",\"priority\":null,\"details\":{\"Hostname\":[\"magic3\"],\"FechaAlta\":[\"N\/A\"],\"cSAPSOLMAN\":[\"N\/A\"],\"manager\":[\"55b368b91b9f\"],\"cResponsableDelSitio\":[\"N\/A\"],\"subcategory1\":[\"\/Server\/Microsoft\/Windows\/Spanish\"],\"zenoss.device.priority\":[\"3\"],\"cProveedor\":[\"N\/A\"],\"cAlmacenamiento\":[\"N\/A\"],\"cIPMabe\":[\"N\/A\"],\"cdeviceuid\":[\"\/zport\/dmd\/Devices\/Server\/Microsoft\/Windows\/Spanish\/devices\/10.200.130.88\"],\"Vendor\":[\"N\/A\"],\"cRFCAlta\":[\"N\/A\"],\"zenoss.device.groups\":[\"\/Clientes\/LOTERIA NACIONAL\"],\"zenoss.device.device_class\":[\"\/Server\/Microsoft\/Windows\/Spanish\"],\"Marca\":[\"N\/A\"],\"current\":[\"100.0\"],\"how\":[\"exceeded\"],\"Modelo\":[\"N\/A\"],\"cLocalidad\":[\"N\/A\"],\"IP\":[\"10.200.130.88\"],\"cIdllamada\":[\"N\/A\"],\"nombre\":[\"magic3\"],\"contacto\":[\"INTEGRACION_ZENOSS\"],\"cTriOrgCust\":[\"N\/A\"],\"medium\":[\"ZENOSS\"],\"description\":[\"threshold of CPU Error exceeded: current value 100.000000\"],\"CL\":[\"0\"],\"cClasificacion\":[\"N\/A\"],\"cRespaldo\":[\"N\/A\"],\"cAdministrado\":[\"0\"],\"cResponsable2\":[\"N\/A\"],\"zenoss.device.production_state\":[\"1000\"],\"Localidad\":[\"\/Triara Monterrey\/Colocado\"],\"zenoss.device.ip_address\":[\"10.200.130.88\"],\"Cliente\":[\"\/Clientes\/LOTERIA NACIONAL\"],\"Metrica\":[\"\/Perf\/CPU\"],\"cReferencia\":[\"N\/A\"],\"max\":[\"90\"],\"zenoss.device.location\":[\"\/Triara Monterrey\/Colocado\"],\"cResponsable\":[\"N\/A\"],\"cAplicacion\":[\"N\/A\"],\"cGpoITOCApp\":[\"N\/A\"],\"cPais\":[\"N\/A\"],\"cCI_id\":[\"SIS-EQU-SVI-13597\"],\"cCriticidad\":[\"N\/A\"],\"subcategory2\":[\"\/Perf\/CPU\"],\"OS\":[\"N\/A\"]},\"DeviceClass\":[{\"uid\":\"\/zport\/dmd\/Devices\/Server\/Microsoft\/Windows\/Spanish\",\"name\":\"\/Server\/Microsoft\/Windows\/Spanish\"}],\"eventKey\":\"CPULOAD|CPULOAD_total 5m|CPU Error\",\"evid\":\"0242ac11-0008-80f7-11ed-3ba3069a0b01\",\"eventClassMapping\":\"\",\"component\":{\"url\":null,\"text\":null,\"uid\":null,\"uuid\":null},\"clearid\":null,\"DeviceGroups\":[{\"uid\":\"\/zport\/dmd\/Groups\/Clientes\/LOTERIA NACIONAL\",\"name\":\"\/Clientes\/LOTERIA NACIONAL\"}],\"eventGroup\":null,\"device\":{\"url\":\"\/zport\/dmd\/goto?guid=5752b090-6006-4187-9ab3-0c88120ac710\",\"text\":\"magic3\",\"uuid\":\"5752b090-6006-4187-9ab3-0c88120ac710\",\"uid\":\"\/zport\/dmd\/Devices\/Server\/Microsoft\/Windows\/Spanish\/devices\/10.200.130.88\"},\"message\":\"threshold of CPU Error exceeded: current value 100.000000\",\"severity\":4,\"count\":2,\"stateChange\":1663980617.986,\"ntevid\":null,\"summary\":\"El equipo sobrepaso el umbral establecido de utilizacion de CPU. Con un valor actual del 100%\",\"eventState\":\"New\",\"lastTime\":1663980917.986,\"ipAddress\":[\"10.200.130.88\"],\"Systems\":[]}],\"success\":true,\"asof\":1663980873.226087},\"tid\":1,\"type\":\"rpc\",\"method\":\"query\",\"notificacion_zenoss\":\"\",\"trigger_zenoss\":\"\"} ___ EventoZenoss_Id  ::: 0242ac11-0008-80f7-11ed-3ba3069a0b01 ___ FechaAlta ::: N\\\/A ___ Hostname ::: magic3 ___ IM :::  ___ ipAddress ::: 10.200.130.88 ___ ITOCapp ::: N\\\/A ___ Location ::: \/Triara Monterrey\/Colocado ___ mail_from :::  ___ mail_to :::  ___ monitor ::: LOTENAL ___ MS :::  ___ Notificacion_Zenoss :::  ___ Trigger_Zenoss :::  ___ VM_Name :::  ___ zCHAT :::  ___ zCORREO :::  ___ zLLAMADA ::: ";


$arr1 = (explode(" ___ ", $str));


foreach ($arr1 as $custom_att) {
    $rows = (explode(" ::: ", $custom_att));
    array_push($respuesta, $rows);
}

foreach ($respuesta as $att_im) {

    if (in_array("MS", $att_im)) {
        if (preg_match('/[IM]{2}[0-9]{7}/', $att_im[1],  $match)) {
            $row["im"] = $match[0];
        } else if ($att_im[1] == '') {
            $row["im_empty"] = 'Vacío/Crear IM';
        } else {
            $row["im_fake"] = $att_im[1];
        }
        array_push($customs, $row);
    }
    if (in_array('cResponsable', $att_im)) {
        $row["cResponsable"] = $att_im[1];
        array_push($customs, $row);
    }
    if (in_array('EventoZenoss_Id', $att_im)) {
        $row["EventoZenoss_Id"] = $att_im[1];
        array_push($customs, $row);
    }
    if (in_array('CO', $att_im)) {
        $row["CO"] = $att_im[1];
        array_push($customs, $row);
    }
} */


/* print "\n\n\n\n\n -------Finalizacion Test" . date('Y-m-d H:i:s') . "\n";
print_r(json_encode($respuesta));
print "\n";
print "Custom:  \n";
print_r(json_encode($row));
print "\n"; */
