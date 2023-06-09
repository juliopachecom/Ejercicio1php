<?php
// Definir los arreglos para almacenar los datos
$empleados = [];

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $estado_civil = $_POST['estado_civil'];
    $sexo = $_POST['sexo'];
    $sueldo = $_POST['sueldo'];

    // Guardar los datos en el arreglo de empleados
    $empleados[] = [
        'nombre' => $nombre,
        'edad' => $edad,
        'estado_civil' => $estado_civil,
        'sexo' => $sexo,
        'sueldo' => $sueldo
    ];
}

// Realizar los cálculos y mostrar los resultados
$totalFemenino = 0;
$totalHombresCasados = 0;
$totalMujeresViudas = 0;
$edadPromedioHombres = 0;
$contadorHombres = 0;

foreach ($empleados as $empleado) {
    if ($empleado['sexo'] === 'femenino') {
        $totalFemenino++;
    }

    if ($empleado['sexo'] === 'masculino' && $empleado['estado_civil'] === 'casado' && $empleado['sueldo'] === 'mas de 2500') {
        $totalHombresCasados++;
    }

    if ($empleado['sexo'] === 'femenino' && $empleado['estado_civil'] === 'viudo' && $empleado['sueldo'] === 'mas de 1000') {
        $totalMujeresViudas++;
    }

    if ($empleado['sexo'] === 'masculino') {
        $edadPromedioHombres += $empleado['edad'];
        $contadorHombres++;
    }
}

if ($contadorHombres > 0) {
    $edadPromedioHombres /= $contadorHombres;
}

// Mostrar los resultados en una tabla
echo '<table>';
echo '<tr><th>Total empleado de sexo femenino</th><td>' . $totalFemenino . '</td></tr>';
echo '<tr><th>Total de hombres casados que ganan más de 2500</th><td>' . $totalHombresCasados . '</td></tr>';
echo '<tr><th>Total de mujeres viudas que ganan más de 1000</th><td>' . $totalMujeresViudas . '</td></tr>';
echo '<tr><th>Edad promedio de hombres</th><td>' . $edadPromedioHombres . '</td></tr>';
echo '</table>';
?>
