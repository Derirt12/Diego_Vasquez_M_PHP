<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <title>Votacion</title>
    <link rel="stylesheet" href="../CSS/styles.css?<?php echo time(); ?>">
</head>
<body class="body-index">
    <?php 
        //revisa si el formulario fue enviado, obtiene las variable y las guarda en la base de datos correspondiente.
        if(isset($_POST['enviar'])){
            include 'database.php';
            $nombre = $_POST['nombre'];
            $alias = $_POST['alias'];
            $rut = $_POST['rut'];
            $email = $_POST['email'];
            $region = $_POST['region'];
            $comuna = $_POST['comuna'];
            $candidato = $_POST['candidato'];
            $check_web = isset($_POST['check-web']) ? $_POST['check-web'] : 'off';
            $check_amigo = isset($_POST['check-amigo']) ? $_POST['check-amigo'] : 'off';
            $check_redes = isset($_POST['check-redes']) ? $_POST['check-redes'] : 'off';
            $check_tv = isset($_POST['check-tv']) ? $_POST['check-tv'] : 'off';

            $checkVotanteQuery = mysqli_query($conn, 'SELECT * FROM votantes WHERE Rut = "' . $rut . '"');
            $checkVotoQuery = mysqli_query($conn, 'SELECT * FROM votos WHERE Rut_Votante = "' . $rut . '"');
            
            //revisa si el rut ya ha votado
            if(mysqli_num_rows($checkVotanteQuery) > 0 || mysqli_num_rows($checkVotoQuery) > 0){
                echo '<script>alert("Usted ya ha votado")</script>';
                mysqli_close($conn);
            }
            else{
                //realiza la transaccion de los datos
                $autoCommitQuery = mysqli_query($conn, "SET autocommit = OFF");
                $savePointQuery = mysqli_query($conn, "COMMIT");
                $insertVotantesQuery = mysqli_query($conn, "INSERT INTO votantes (Rut, Nombre, Alias, Correo, Region, Comuna, Web, Amigo, Redes, TV) VALUES ('$rut', '$nombre', '$alias', '$email', '$region', '$comuna', '$check_web', '$check_amigo', '$check_redes', '$check_tv')");
                $insertVotosQuery = mysqli_query($conn, "INSERT INTO votos (Rut_Votante, Rut_Candidato) VALUES ('$rut', '$candidato')");

    
                if($insertVotantesQuery && $insertVotosQuery){
                    //se guarda y cierra conexion.
                    $savePointQuery = mysqli_query($conn, "COMMIT");
                    $autoCommitQuery = mysqli_query($conn, "SET autocommit = ON");
                    mysqli_close($conn);
                    //redirige a la pagina final
                    echo '<script>alert("Voto registrado con exito")
                    location.assign("final.php")
                    </script>';
                }
                else{
                    //si hay un error se revierte la transaccion y se cierra la conexion.
                    $rollBackPointQuery = mysqli_query($conn, "ROLLBACK");
                    $autoCommitQuery = mysqli_query($conn, "SET autocommit = ON");
    
                    echo '<script>alert("Error al registrar voto")</script>';
                    mysqli_close($conn);
                }
            }
        }
    ?>
    <?php
        //abre conexion y obtiene las regiones y candidatos para mostrar en el formulario.
        include 'database.php';
        $selectRegionesQuery = mysqli_query($conn, 'SELECT * FROM region');
        $selectCandidatoQuery = mysqli_query($conn, 'SELECT * FROM candidatos');

        $arrayRegiones = array();
        $arrayCandidatos = array();

        while($row = mysqli_fetch_array($selectRegionesQuery)){
            $arrayRegiones[] = $row;
        }
        while($row = mysqli_fetch_array($selectCandidatoQuery)){
            $arrayCandidatos[] = $row;
        }
    ?>
    <div class="div1-index">

        <h2 class="titulo">Formulario de Votación</h2>

        <form id="form-votacion" action="<?=$_SERVER['PHP_SELF']?>" onsubmit="return onSubmit()" method="post">

            <label class="form-label" for="nombre">Nombre y Apellido:</label>
            <input type="text" name="nombre" id="nombre" required>
            <br>
            <br>
            
            <label class="form-label" for="alias">Alias:</label>
            <input type="text" name="alias" id="alias" placeholder="Al menos una letra y un número." required minlenght="5" pattern="(?=.*[a-zA-Z])(?=.*[0-9]).+">
            <br>
            <br>

            <label class="form-label" for="rut">Rut:</label>
            <input type="text" name="rut" id="rut" placeholder="11111111-1" required pattern= "^\d{7,8}-[0-9kK]">
            <br>
            <br>

            <label class="form-label" for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="hola@mundo.com" required pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,5}">
            <br>
            <br>

            <label class="form-label" for="region">Región:</label>
            <select name="region" id="region" required>
                <option value="" disabled selected>Seleccione una región</option>
                <?php foreach($arrayRegiones as $row){
                    echo '<option value=' . $row['Region'] . '>' . $row['Region'] . '</option>';
                } ?>
            </select>
            <br>
            <br>
            <label class="form-label" for="comuna">Comuna:</label>
            <select name="comuna" id="comuna" required>
            </select>
            <br>
            <br>

            <label class="form-label" for="candidato">Candidato:</label>
            <select name="candidato" id="candidato" required>
                <?php foreach($arrayCandidatos as $row){
                    echo '<option value=' . $row['Rut'] . '>' . $row['Nombre'] . '</option>';
                } ?>
            </select>
            <br>
            <br>

            <label class="form-label">Como se entero de nosotros:</label>

                <input class="form-label-check" type="checkbox" name="check-web" value="web">
                <label class="form-label-check" for="check-web">Web</label>

                <input class="form-label-check" type="checkbox" name="check-amigo" value="amigo">
                <label class="form-label-check" for="check-amigo">Amigo</label>

                <input class="form-label-check" type="checkbox" name="check-redes" value="redes">
                <label class="form-label-check" for="check-redes">Redes Sociales</label>

                <input class="form-label-check" type="checkbox" name="check-tv" value="tv">
                <label class="form-label-check" for="check-tv">TV</label>

            <br>
            <br>

            <input type="submit" name="enviar" value="Votar">
        </form>
    </div>

    <script type="text/javascript" src="../JS/main.js?<?php echo time(); ?>"></script>
</body>
</html>