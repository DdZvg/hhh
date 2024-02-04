<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <style>
        td {
            color: black;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https:/Kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
    <title>Usuarios</title>
    <script>
    // Función para comprobar si se encuentra dentro del rango de horas permitidas
    function comprobarRangoHoras() {
        // Obtener la hora actual
        var ahora = new Date();
        var horaActual = ahora.getHours();
        var minutosActual = ahora.getMinutes();

        if (horaActual >= 9 && (horaActual < 11 || (horaActual == 11 && minutosActual <= 30))) {
            document.getElementById('mensajeHoraLimite').style.display = 'none';
        } else {
            // Si está fuera del rango, mostrar el mensaje de pedidos detenidos
            document.getElementById('mensajeHoraLimite').style.display = 'block';
        }
    }

    // Llamar a la función al cargar la página
    window.onload = function() {
        comprobarRangoHoras();
        // Llama a la función para cargar la tabla al cargar la página
        cargarTabla();
    };
</script>
    <!-- Agrega el script aquí para asegurar que se ejecute después de cargar la página -->
    <script>
           $(document).ready(function() {
            var storedVisibleRows = localStorage.getItem('visibleRows');
            if (storedVisibleRows !== null) {
                updateRowCount(storedVisibleRows);
            }
        });

        function updateRowCount(visibleRows) {
            document.getElementById('numResultados').innerText = "Resultados encontrados: " + visibleRows;
        }
    </script>
    <script type="text/javascript">
        function confirmar(){
            return confirm('¿Estas seguro de que quieres eliminar los datos?');
        }
    </script>
</head>

<body>

<br>

<nav>
    <ul>
        <li id="lia"><a id="hover" href="indexM.php">Regresar</a></li>
        <li id="lia"><a id="hover" name="limpiar" href='limpiar.php' onclick='return confirmar()'>Limpiar lista</a></li>
        <li id="lia" ><a id="hover" name="reportes" href="reportes.php"><i class="fa-solid fa-download"></i>  Descargar el reporte del dia</a></li>
    </ul>
</nav>
<div class="container is-fluid">
      <div class="container-fluid">
  <form class="d-flex">
      <input class="form-control me-2 light-table-filter" data-table="table_id" type="text" placeholder="Buscar " id=buscar>
      <hr>
      </form>
      <br>
  </div>
  <div id="numResultadosContainer">
      <span id="numResultados"></span>
      <style>
        span{
            font-family: Arial, Helvetica, sans-serif;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
        }
        #numResultadosContainer{
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        
      </style>
    </div>
</div>  
<br>
				<?php
include("conexion.php");
$SQL="SELECT id, nombre, telefono, cliente,
comida, grupo FROM pedidos";
$dato = mysqli_query($conexion, $SQL);
?>
<div class="container">
<div id="mensajeHoraLimite"><h5>Los pedidos han sido detenidos. La hora límite ha pasado.</h5></div>

      <table id="tbl" class="table table-striped table-dark table_id text-center "  >
                         <thead>    
                         <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Cliente</th>
                        <th>Comida</th>
                        <th>grupo</th>         
                        </tr>
                        </thead>
                        <tbody name="tbody" id="tbClientes">


<?php



if($dato -> num_rows >0){
    while($fila=mysqli_fetch_assoc($dato)){


?>

<tr>
<td><?php echo $fila['id']; ?></td>
<td><?php echo $fila['nombre']; ?></td>
<td><?php echo $fila['telefono']; ?></td>
<td><?php echo $fila['cliente']; ?></td>
<td><?php echo $fila['comida']; ?></td>
<td><?php echo $fila['grupo']; ?></td>
</tr>


<?php
}
}else{

    ?>
    <tr class="text-center">
    <td colspan="16">No existen registros</td>
    </tr>

    
    <?php
    
}

 ?>
   </tbody>
  </table>
</div>


<script>
    $(document).ready(function() {
        // Actualiza la tabla cada 60 segundos
        setInterval(cargarTabla, 60000);

        // Función para cargar la tabla desde el servidor
        function cargarTabla() {
            $.ajax({
                url: 'list_pedidos.php', // Reemplaza 'cargar_tabla.php' con la URL correcta para cargar los datos del servidor
                type: 'GET',
                success: function(data) {
                    $('#tbClientes').html(data);

                    // Llama a la función que hemos agregado para actualizar el contador
                    actualizarContador();
                },
                error: function(error) {
                    console.log('Error al cargar la tabla: ' + error);
                }
            });
        }

        // Función para actualizar el contador
        function actualizarContador() {
            var visibleRows = $('#tbClientes tr:visible').length;
            document.getElementById('numResultados').innerText = "Resultados encontrados: " + visibleRows;
        }

        // Llama a la función que hemos agregado para actualizar el contador
        actualizarContador();

        // Agrega el código para el buscador
        var $rows = $('#tbClientes tr');
        $('#buscar').keyup(function() {
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();

            // Llama a la función que hemos agregado para actualizar el contador
            actualizarContador();
        });
    });
</script>
        <style>
        td {
            color: black;
        }
        #mensajeHoraLimite {
            display: none; /* Para ocultar el mensaje por defecto */
            text-align: center;
            font-size: 20px;
            color: red;
            border: solid 1px black;
            background-color: orange;
            margin-bottom: 10px;
            border-radius: 1rem;
            
        }

    </style>

</body>
</html>
