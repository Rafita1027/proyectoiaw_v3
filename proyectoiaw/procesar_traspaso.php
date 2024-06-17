<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Traspaso</title>
    <link rel="icon" type="image/png" href="images/laliga_logo.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
            margin: 0;
            padding: 0;
        }

        #header {
            background-color: #e30613;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        #header img {
            max-width: 100px;
            height: auto;
        }

        #container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #e30613;
            text-align: center;
        }

        .message {
            text-align: center;
            margin-top: 20px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn-container a {
            background-color: #e30613;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
        }

        .btn-container a:hover {
            background-color: #c20410;
        }

        @media (max-width: 600px) {
            #container {
                margin: 20px auto;
                padding: 10px;
            }

            img {
                max-width: 30px;
                max-height: 30px;
            }
        }
    </style>
</head>
<body>
    <div id="header">
        <a href="index.php"><img src="images/laliga_logo.png" alt="La Liga EA Sports"></a>
    </div>
    <div id="container">
        <h1>Procesar Traspaso</h1>
        <div class="message">
            <?php
            // Establezco conexión
            require 'conexion.php';

            $jugador = $_POST['jugador'];
            $equipo_comprador = $_POST['equipo_comprador'];
            $cantidad = $_POST['cantidad'];
            $equipo_vendedor = $_POST['comprador'];

            if ($equipo_comprador == $equipo_vendedor) {
                die("<span class='error'>El equipo comprador no puede ser el mismo que el equipo vendedor.</span>");
            }

            $sql_equipo_comprador = "SELECT id, presupuesto FROM equipos WHERE nombre = '$equipo_comprador'";
            $resultado_equipo_comprador = $mysqli->query($sql_equipo_comprador);
            $row_equipo_comprador = $resultado_equipo_comprador->fetch_assoc();
            $equipo_comprador_id = $row_equipo_comprador['id'];
            $presupuesto_comprador = $row_equipo_comprador['presupuesto'];

            $sql_equipo_vendedor = "SELECT id, presupuesto FROM equipos WHERE nombre = '$equipo_vendedor'";
            $resultado_equipo_vendedor = $mysqli->query($sql_equipo_vendedor);
            $row_equipo_vendedor = $resultado_equipo_vendedor->fetch_assoc();
            $presupuesto_vendedor = $row_equipo_vendedor['presupuesto'];

            if ($presupuesto_comprador < $cantidad) {
                die("<span class='error'>El equipo comprador no tiene suficiente presupuesto para realizar el traspaso.</span>");
            }

            $nuevo_presupuesto_comprador = $presupuesto_comprador - $cantidad;
            $nuevo_presupuesto_vendedor = $presupuesto_vendedor + $cantidad;

            $sql_update_presupuesto_comprador = "UPDATE equipos SET presupuesto = $nuevo_presupuesto_comprador WHERE id = $equipo_comprador_id";
            $sql_update_presupuesto_vendedor = "UPDATE equipos SET presupuesto = $nuevo_presupuesto_vendedor WHERE id = " . $row_equipo_vendedor['id'];

            if ($mysqli->query($sql_update_presupuesto_comprador) === TRUE && $mysqli->query($sql_update_presupuesto_vendedor) === TRUE) {
                $sql_update_jugador = "UPDATE jugadores SET id_equipo = '$equipo_comprador_id' WHERE nombre = '$jugador'";

                if ($mysqli->query($sql_update_jugador) === TRUE) {
                    $sql_insert_traspaso = "INSERT INTO traspasos (nombre, e_nuevo, e_viejo, valor) VALUES ('$jugador', '$equipo_comprador', '$equipo_vendedor', '$cantidad')";
                    
                    if ($mysqli->query($sql_insert_traspaso) === TRUE) {
                        echo "<span class='success'>Traspaso realizado con éxito.</span><br>";
                        echo "Jugador: " . $jugador . "<br>";
                        echo "Equipo vendedor: " . $equipo_vendedor . "<br>";
                        echo "Equipo comprador: " . $equipo_comprador . "<br>";
                        echo "Cantidad de traspaso: " . $cantidad . "<br>";
                    } else {
                        echo "<span class='error'>Error al insertar el traspaso: " . $mysqli->error . "</span>";
                    }
                } else {
                    echo "<span class='error'>Error al actualizar el equipo del jugador: " . $mysqli->error . "</span>";
                }
            } else {
                echo "<span class='error'>Error al actualizar el presupuesto de los equipos: " . $mysqli->error . "</span>";
            }

            // Cierro la conexión
            $mysqli->close();
            ?>
        </div>
        <div class="btn-container">
            <a href="index.php">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
