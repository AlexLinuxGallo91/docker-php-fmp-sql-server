<?php

printf("iniciando esta madre\n");

$serverName = "sql-server,1433";
$database = "master";
$user = "sa";
$password = "TriaraItoc521*";
$trustedServerCertificate = true;

$connectionOptions = [
    "TrustServerCertificate" => $trustedServerCertificate,
    "Database" => $database,
    "UID" => $user,
    "PWD" => $password,
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

$server_info = sqlsrv_server_info($conn);
if ($server_info) {
    foreach ($server_info as $key => $value) {
        echo $key . ": " . $value . "<br />";
    }
} else {
    die(print_r(sqlsrv_errors(), true));
}

print("\n");
