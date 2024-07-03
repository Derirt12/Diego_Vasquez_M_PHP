<?php
    $servername = "localhost";
    $database = "votacionesbd";
    $username = "root";
    $password = "";
    // Crear Conexion
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Revisar Conexion
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    //mysqli_close($conn);
    ?>