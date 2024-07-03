<?php
    include 'database.php';
    //Obtiene la region seleccionada
    $region = $_POST['region_selected'];
    //Realiza la peticion filtrando las comunas por la region seleccionada 
    $selectComunasQuery = mysqli_query($conn, "SELECT * FROM comunas WHERE Region = '$region'");
    //Crea un string con las opciones de comunas
    $opcionesComunas = "<option value='' disabled selected>Seleccione una comuna</option>";
    while($row = mysqli_fetch_assoc($selectComunasQuery)){
        $opcionesComunas .= "<option value='" . $row['Comuna'] . "'>" . $row['Comuna'] . "</option>";
    }
    //Devuelve las opciones de comunas en formato JSON
    echo json_encode($opcionesComunas, JSON_UNESCAPED_UNICODE);
?>