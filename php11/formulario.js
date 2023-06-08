$(document).ready(function() {
    localStorage.clear();
    $('#formulario').submit(function(e) {
        e.preventDefault(); 

        var datosFormulario = $(this).serialize(); 
        $.ajax({
            type: 'POST',
            url: 'formulario.php',
            data: datosFormulario,
            success: function(response) {
                $('#tabla-resultados tbody').append(response.datosEmpleado); 
                $('#lista-peticiones li:nth-of-type(1)').html('Total empleado de sexo femenino: ' + response.empleadosFemeninos);
                $('#lista-peticiones li:nth-of-type(2)').html('Total de hombres casados que ganan más de 2500: ' + response.hombresCasadosMayores);
                $('#lista-peticiones li:nth-of-type(3)').html('Total de mujeres viudas que ganan más de 1000: ' + response.mujeresViudasMayores);
                $('#lista-peticiones li:nth-of-type(4)').html('Edad promedio de hombres: ' + response.edadPromedioHombres);
            }
        });
    });
});
