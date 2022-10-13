<?php

print "------Inicio Prueba conexion a Base de Datos" . date('Y-m-d H:i:s') . "\n";

$respuesta = array();
$rows = array();
$serverName = "172.20.45.141\SQL2K16,1443";
$connectionOptions = array(
    "database" => "itoc_Admon_Herramientas",
    "uid" => "alberto.garcia",
    "pwd" => "X:~sVG.5g7t3pC0zC7q0",
"Encrypt"=>false,
                         "TrustServerCertificate"=>true,
);

$num = 0;

$last_event_received = '2022-09-28 21:20:00.383';

$sql = "
        SELECT top (1) 
        t1.ID as id_event
        ,t1.APPLICATION as application
        ,t1.ASSIGNED_USER as assigned_user
        ,t1.ASSIGNED_GROUP as assigned_group
        ,t1.CATEGORY as category
        ,t1.PRIORITY as priority 
        ,t1.SEVERITY as severity
        ,t1.STATE as state 
        ,t1.TIME_CHANGED as  time_changed
        ,t1.TIME_STATE_CHANGED
        ,t1.TIME_CREATED as time_created
        ,t1.TIME_RECEIVED as time_received
        ,t1.TITLE as title
        ,[OBJECT] as object
        ,STUFF((SELECT ' ___ ' + concat(t0.ID, ' ::: ', t0.VERSION, ' ::: ', t0.USER_ID, ' ::: ', t0.TIME_CHANGED, ' ::: ', t0.EVENT_REF)
             FROM [172.20.40.89].[BSMOMI].[dbo].HISTORY_LINE t0
             WHERE t1.ID = t0.EVENT_REF
             FOR XML PATH('')), 1, 5, '') [symptom_list]
        ,STUFF((SELECT ' ___ ' + concat(t2.idx, ' ::: ', t2.elt)
             FROM [172.20.40.89].[BSMOMI].[dbo].[EVENT_CUSTOM_ATTRIBUTES] t2
             WHERE t1.ID = t2.EVENT_ID
             FOR XML PATH('')), 1, 5, '') [custom_attribute_list]
        ,STUFF((SELECT ' ___ ' + concat(t3.TEXT, ' ::: ', t3.AUTHOR, ' ::: ', t3.TIME_CREATED)
             FROM [172.20.40.89].[BSMOMI].[dbo].[EVENT_ANNOTATIONS] t3
             WHERE t1.ID = t3.EVENT_ID
             FOR XML PATH('')), 1, 5, '') [annotation_list]
        FROM [172.20.40.89].[BSMOMI].[dbo].[ALL_EVENTS] t1 with (nolock) WHERE t1.TIME_CHANGED > '{$last_event_received}' ORDER BY t1.TIME_RECEIVED DESC
        ";

try {
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn === false) {
        if (($errors = sqlsrv_errors()) != null) {
            $list_errors = json_encode($errors);
            $response = array("id" => 0, "response" => "Error en la conexion a la Base de Datos" . $list_errors);
        }
        $response = array("id" => 0, "response" => "Error en la conexion a la Base de Datos");
    } else {
        $stmt = sqlsrv_query($conn, $sql);
        if ($stmt) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                array_push($rows, $row);
            }
            $response = array("id" => 1, "response" => $rows);
        } else {
            $response = array("id" => 0, "response" => "Error en SQL: sqlsrv_query fail");
        }
    }
} catch (Exception $e) {
    $response = array("id" => 0, "response" => "SQL Serve ErrorException" . $e);
}


print "\n\n\n\n -------Finalizacion Test Request Base de Datos" . date('Y-m-d H:i:s') . "\n";
//print_r($respuesta);
print_r(json_encode($response['response']));
