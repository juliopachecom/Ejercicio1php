$(document).ready(function() {
    // Función para obtener los datos del archivo JSON y actualizar las estadísticas
    function obtenerDatosEmpleados() {
        $.getJSON('empleados.json', function(empleados) {
            var empleadosFemeninos = 0;
            var hombresCasadosMayores = 0;
            var mujeresViudasMayores = 0;
            var sumaEdadHombres = 0;
            var totalHombres = 0;

            // Calcular las estadísticas
            $.each(empleados, function(index, empleado) {
                if (empleado.sexo === 'femenino') {
                    empleadosFemeninos++;
                }
                if (empleado.sexo === 'masculino' && empleado.estado_civil === 'casado' && empleado.sueldo === 'mayor_2500') {
                    hombresCasadosMayores++;
                }
                if (empleado.sexo === 'femenino' && empleado.estado_civil === 'viudo' && empleado.sueldo !== 'menor_1000') {
                    mujeresViudasMayores++;
                }
                if (empleado.sexo === 'masculino') {
                    sumaEdadHombres += parseInt(empleado.edad);
                    totalHombres++;
                }
            });

            var edadPromedioHombres = totalHombres > 0 ? sumaEdadHombres / totalHombres : 0;

            // Actualizar la lista de peticiones
            $('#lista-peticiones li:nth-of-type(1)').html('Total empleado de sexo femenino: ' + empleadosFemeninos);
            $('#lista-peticiones li:nth-of-type(2)').html('Total de hombres casados que ganan mas de 2500: ' + hombresCasadosMayores);
            $('#lista-peticiones li:nth-of-type(3)').html('Total de mujeres viudas que ganan mas de 1000: ' + mujeresViudasMayores);
            $('#lista-peticiones li:nth-of-type(4)').html('Edad promedio de hombres: ' + edadPromedioHombres);

            // Actualizar la tabla con los datos del archivo JSON
            $('#tabla-resultados tbody').empty();
            $.each(empleados, function(index, empleado) {
                var fila = '<tr>' +
                    '<td>' + empleado.nombre + '</td>' +
                    '<td>' + empleado.edad + '</td>' +
                    '<td>' + empleado.estado_civil + '</td>' +
                    '<td>' + empleado.sexo + '</td>' +
                    '<td>' + empleado.sueldo + '</td>' +
                    '</tr>';
                $('#tabla-resultados tbody').append(fila);
            });
        });
    }

    // Llamar a la función al cargar la página
    obtenerDatosEmpleados();

    $('#formulario').submit(function(e) {
        e.preventDefault();
    
        var datosFormulario = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'formulario.php',
            data: datosFormulario,
            dataType: 'json', // Indicar que se espera una respuesta JSON
            success: function(response) {
                // Limpiar los campos del formulario
                formulario.reset();
    
                // Mostrar la alerta de registro exitoso
                alert('Registro exitoso');
    
                // Actualizar la tabla con los nuevos datos
                $('#tabla-resultados tbody').append(response.datosEmpleado);
    
                // Actualizar las estadísticas y la tabla nuevamente
                obtenerDatosEmpleados();
            }
        });
    });    
});
