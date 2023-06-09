<?php
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

    $empleados = [];
    if (file_exists('empleados.json')) {
        $empleadosJson = file_get_contents('empleados.json');
        $empleados = json_decode($empleadosJson, true);
    }

    $empleados[] = $empleado;

    $empleadosJson = json_encode($empleados, JSON_PRETTY_PRINT);
    file_put_contents('empleados.json', $empleadosJson);

    $empleadosFemeninos = 0;
    $hombresCasadosMayores = 0;
    $mujeresViudasMayores = 0;
    $sumaEdadHombres = 0;
    $totalHombres = 0;

    foreach ($empleados as $empleado) {
        if ($empleado["sexo"] === 'femenino') {
            $empleadosFemeninos++;
        }
        if ($empleado["sexo"] === 'masculino' && $empleado["estado_civil"] === 'casado' && $empleado["sueldo"] === 'mayor_2500') {
            $hombresCasadosMayores++;
        }
        if ($empleado["sexo"] === 'femenino' && $empleado["estado_civil"] === 'viudo' && $empleado["sueldo"] !== 'menor_1000') {
            $mujeresViudasMayores++;
        }
        if ($empleado["sexo"] === 'masculino') {
            $sumaEdadHombres += $empleado["edad"];
            $totalHombres++;
        }
    }

    $edadPromedioHombres = $totalHombres > 0 ? $sumaEdadHombres / $totalHombres : 0;

    $response = array(
        "datosEmpleado" => "<tr>
            <td>{$empleado['nombre']}</td>
            <td>{$empleado['edad']}</td>
            <td>{$empleado['estado_civil']}</td>
            <td>{$empleado['sexo']}</td>
            <td>{$empleado['sueldo']}</td>
        </tr>",
        "empleadosFemeninos" => $empleadosFemeninos,
        "hombresCasadosMayores" => $hombresCasadosMayores,
        "mujeresViudasMayores" => $mujeresViudasMayores,
        "edadPromedioHombres" => $edadPromedioHombres
    );

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
