<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTP NOTICIAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="shortcut icon" href="CSS/Edson.pnj.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/estilosnav.css">
    <link rel="stylesheet" href="css/fondo.css">
    <link rel="stylesheet" href="soda/Modi_datos/form_pedi.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <style>
      *{
        font-family: Arial, Helvetica, sans-serif;
      }
      a{
        text-decoration: none;
      }
      #horaFinalizado {
        display: none;
        text-align: center;
        font-size: 24px;
        color: red;
        margin-bottom: 20px;
      }
      .error-message {
        display: none;
        color: red;
        margin-top: 5px;
      }
    </style>
    
</head>

<body>

  <header>
    <h2>Pedidos de Almuerzo</h2>
    <br>
    <a id="regre" href="index2.1.php">Regresar</a>
    <style>
      #regre{
        text-decoration: none;
        background-color: rgba(49, 49, 255, 0.397);
        color:black;
        padding: 13px;
        border-radius: 10px;
      }
    </style>
  </header>
  
  <div class="container">
    <?php 
    include "soda/Modi_datos/conexion.php";
    include "controlador_pedi.php";
    ?>
  <form id="pedidoForm" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
  <div id="horaFinalizado">
    La hora para realizar pedidos ha finalizado. <br> La hora límite para hacer pedidos es entre las 9 am y las 11:30 am <br> ¡Gracias por tu preferencia!
  </div>

      <label>Nombre completo</label> <br>
      <input type="text" name="nombre" placeholder="Nombre Completo" disabled> <br>
      <label>Número de teléfono</label>
      <input type="tel" name="telefono" placeholder="Número de teléfono" disabled>
      <label>Cliente</label>
      <select name="cliente" id="cliente" disabled onchange="toggleGrupo(this)">
      <?php
  $inc=include("soda/Modi_datos/conexion.php");
  if ($inc) {
    $consulta = "SELECT * FROM data_cliente";
    $resultado= mysqli_query($conexion,$consulta);
    if ($resultado) {
      while($row = $resultado->fetch_array()){
        $id=$row['id'];
        $cliente=$row['cliente'];?>
        <option value="<?php echo $cliente;?>"><?php echo $cliente; ?></option >
        <?php
      }
    }
  }
  ?>
      </select>  <br>
      <label for="">Grupo</label>
      <select name="grupo" id="grupo" disabled>
      <?php
  $inc=include("soda/Modi_datos/conexion.php");
  if ($inc) {
    $consulta = "SELECT * FROM data_grupo";
    $resultado= mysqli_query($conexion,$consulta);
    if ($resultado) {
      while($row = $resultado->fetch_array()){
        $id=$row['id'];
        $grupo=$row['grupo'];?>    
        <option value="<?php echo $grupo;?>"><?php echo $grupo; ?></option>
        <?php
      }
    }
  }
  ?>
<div id="errorGrupo" class="alert alert-danger" style="display:none;">
    Por favor, seleccione un grupo para el estudiante.
</div>

    </select>  <br>
    <label for="">Comida</label>
      <select name="comida" id="comida">
      <?php
  $inc=include("soda/Modi_datos/conexion.php");
  if ($inc) {
    $consulta = "SELECT * FROM data_comida";
    $resultado= mysqli_query($conexion,$consulta);
    if ($resultado) {
      while($row = $resultado->fetch_array()){
        $id=$row['id'];
        $comida=$row['comida'];?>
        <option value="<?php echo $comida;?>"><?php echo $comida; ?></option>
        <?php
      }
    }
  }
?>
    </select>  
    <input id="enviar" type="submit" name="enviar" value="ENVIAR" disabled>
</form>
  </div>
 <br>
 <br><br><br><br>
 <p>
  - Se les recomienda presionar el botón de enviar 1 vez para evitar malentendidos y no saber si su pedido fue enviado <br>
  - La información compartida aquí no será y no puede revelarse a nadie aunque no sea información relevante <br>
  - En caso de no funcionar, contactar a la soda para pedir ayuda
 </p>

 <script>
    // Define las horas límite
    var horaInicio = new Date();
    horaInicio.setHours(9); // 9:00 AM
    horaInicio.setMinutes(0); // 00 minutos
    horaInicio.setSeconds(0); // 00 segundos
    horaInicio.setMilliseconds(0); // 00 milisegundos

    var horaLimite = new Date();
    horaLimite.setHours(24); // 11:00 AM
    horaLimite.setMinutes(30); // 30 minutos
    horaLimite.setSeconds(0); // 00 segundos
    horaLimite.setMilliseconds(0); // 00 milisegundos

    var formulario = document.getElementById('pedidoForm');
    var nombreInput = document.querySelector('input[name="nombre"]');
    var telefonoInput = document.querySelector('input[name="telefono"]');
    var clienteSelect = document.getElementById('cliente');
    var grupoSelect = document.getElementById('grupo');
    var comidaSelect = document.getElementById('comida');
    var enviarButton = document.getElementById('enviar');
    var errorGrupo = document.getElementById('errorGrupo');


    // Función para comprobar si es antes de las 9:00 AM
    function comprobarHoraInicio() {
        var ahora = new Date();
        if (ahora >= horaInicio && ahora < horaLimite) {
            // Si es después de las 9:00 AM y antes de las 11:30 AM, habilitar los elementos
            nombreInput.disabled = false;
            telefonoInput.disabled = false;
            clienteSelect.disabled = false;
            grupoSelect.disabled = false;
            comidaSelect.disabled = false;
            enviarButton.disabled = false;
        } else {
            // Si es antes de las 9:00 AM o después de las 11:30 AM, mostrar el mensaje y deshabilitar los elementos
            document.getElementById('horaFinalizado').style.display = 'block';
            nombreInput.disabled = true;
            telefonoInput.disabled = true;
            clienteSelect.disabled = true;
            grupoSelect.disabled = true;
            comidaSelect.disabled = true;
            enviarButton.disabled = true;
        }
    }

    // Comprobar si es antes de las 9:00 AM al cargar la página
    comprobarHoraInicio();

    // Función para activar o desactivar el campo de selección de grupo según la opción seleccionada en el campo de selección de cliente
    function toggleGrupo(select) {
    var selectedOption = select.options[select.selectedIndex].value;
    if (selectedOption === "Estudiante") {
        grupoSelect.disabled = false;
        grupoSelect.selectedIndex = 0; // El índice 0 es la primera opción disponible
        document.querySelector('#grupo option[value="Ninguno"]').hidden = true;
    } else {
        grupoSelect.disabled = true;
        grupoSelect.selectedIndex = -1; // Reiniciar a ningún grupo seleccionado
        document.querySelector('#grupo option[value="Ninguno"]').hidden = false;
    }
}

    // Función para validar el formulario antes de enviarlo
    function validarFormulario() {
        var selectedCliente = clienteSelect.value;
        var selectedGrupo = grupoSelect.value;

        // Verificar si se seleccionó "Estudiante" y "Ninguno" está seleccionado en el grupo
        if (selectedCliente === "Estudiante" && selectedGrupo === "") {
            errorGrupo.style.display = 'block';
            return false; // Evitar el envío del formulario
        } else {
            errorGrupo.style.display = 'none';
        }

        // Si todo está bien, permitir el envío del formulario
        return true;
    }

    // Agregar un listener al formulario para ejecutar la función de validación antes de enviarlo
    formulario.addEventListener('submit', function(event) {
        if (!validarFormulario()) {
            event.preventDefault(); // Evitar el envío del formulario si la validación falla
        }
    });
    function calcularTiempoRestante() {
        var ahora = new Date();
        var tiempoRestante;

        if (ahora < horaInicio) {
            // Si es antes de las 9:00 AM, calcula el tiempo hasta las 9:00 AM
            tiempoRestante = horaInicio - ahora;
        } else if (ahora < horaLimite) {
            // Si es después de las 9:00 AM pero antes de las 11:30 AM, calcula el tiempo hasta las 11:30 AM
            tiempoRestante = horaLimite - ahora;
        } else {
            // Si es después de las 11:30 AM, calcula el tiempo hasta las 9:00 AM del día siguiente
            horaInicio.setDate(horaInicio.getDate() + 1);
            tiempoRestante = horaInicio - ahora;
        }

        // Convierte el tiempo restante de milisegundos a segundos
        return Math.floor(tiempoRestante / 1000);
    }

    // Función para recargar la página cuando sea necesario
    function recargarPagina() {
        var tiempoRestante = calcularTiempoRestante();

        if (tiempoRestante <= 0) {
            // Si el tiempo restante es menor o igual a cero, recarga la página
            location.reload();
        } else {
            // Si no, espera el tiempo restante y luego recarga la página
            setTimeout(recargarPagina, tiempoRestante * 1000);
        }
    }

    // Iniciar el contador al cargar la página
    recargarPagina();  
</script>

</body>
</html>
