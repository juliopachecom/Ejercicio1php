<?php
session_start(); 

if ($_SERVER["REQUEST_METHOD"] === "GET" && !isset($_GET["reset"])) {
    reiniciarVariablesSesion();
}


function reiniciarVariablesSesion() {
    $_SESSION['empleadosFemeninos'] = 0;
    $_SESSION['hombresCasadosMayores'] = 0;
    $_SESSION['mujeresViudasMayores'] = 0;
    $_SESSION['sumaEdadHombres'] = 0;
    $_SESSION['totalHombres'] = 0;
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $nombre = $_POST["nombre"];
    $edad = $_POST["edad"];
    $estado_civil = $_POST["estado_civil"];
    $sexo = $_POST["sexo"];
    $sueldo = $_POST["sueldo"];


    $empleado = array(
        "nombre" => $nombre,
        "edad" => $edad,
        "estado_civil" => $estado_civil,
        "sexo" => $sexo,
        "sueldo" => $sueldo
    );


    $datosEmpleado = "<tr>";
    $datosEmpleado .= "<td>" . $empleado["nombre"] . "</td>";
    $datosEmpleado .= "<td>" . $empleado["edad"] . "</td>";
    $datosEmpleado .= "<td>" . $empleado["estado_civil"] . "</td>";
    $datosEmpleado .= "<td>" . $empleado["sexo"] . "</td>";
    $datosEmpleado .= "<td>" . $empleado["sueldo"] . "</td>";
    $datosEmpleado .= "</tr>";

    if (!isset($_SESSION['empleadosFemeninos'])) {

        $_SESSION['empleadosFemeninos'] = 0;
        $_SESSION['hombresCasadosMayores'] = 0;
        $_SESSION['mujeresViudasMayores'] = 0;
        $_SESSION['sumaEdadHombres'] = 0;
        $_SESSION['totalHombres'] = 0;
    }

    if ($empleado["sexo"] === "femenino") {
        $_SESSION['empleadosFemeninos']++;
    }

    if ($empleado["sexo"] === "masculino" && $empleado["estado_civil"] === "casado" && $empleado["sueldo"] === "mayor_2500") {
        $_SESSION['hombresCasadosMayores']++;
    }

    if ($empleado["sexo"] === "femenino" && $empleado["estado_civil"] === "viudo" && $empleado["sueldo"] !== "menor_1000") {
        $_SESSION['mujeresViudasMayores']++;
    }

    if ($empleado["sexo"] === "masculino") {
        $_SESSION['sumaEdadHombres'] += $empleado["edad"];
        $_SESSION['totalHombres']++;
    }

    $edadPromedioHombres = $_SESSION['totalHombres'] > 0 ? $_SESSION['sumaEdadHombres'] / $_SESSION['totalHombres'] : 0;

    $response = array(
        "datosEmpleado" => $datosEmpleado,
        "empleadosFemeninos" => $_SESSION['empleadosFemeninos'],
        "hombresCasadosMayores" => $_SESSION['hombresCasadosMayores'],
        "mujeresViudasMayores" => $_SESSION['mujeresViudasMayores'],
        "edadPromedioHombres" => $edadPromedioHombres
    );

    
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>