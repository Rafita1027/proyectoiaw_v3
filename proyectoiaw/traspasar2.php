<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traspaso de Jugadores</title>
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

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        select, input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #e30613;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 10px auto 0;
            text-align: center;
            width: 50%;
            font-size: 16px; 
            box-sizing: border-box; 
        }

        input[type="submit"]:hover {
            background-color: #c20410;
        }

        .btn-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .error {
            color: red;
            margin-top: 5px;
            text-align: center;
        }

        .success {
            color: green;
            margin-top: 5px;
            text-align: center;
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
        <h1>Traspaso de Jugadores</h1>
        <?php
        // Establezco conexión
        require 'conexion.php';

        $equipo_vendedor = $_POST['comprador'];

        $sql_jugadores = "SELECT nombre FROM jugadores WHERE id_equipo = (SELECT id FROM equipos WHERE nombre = '$equipo_vendedor')";

        $resultado_jugadores = $mysqli->query($sql_jugadores);

        $sql_equipos = "SELECT nombre FROM equipos";

        $resultado_equipos = $mysqli->query($sql_equipos);
        ?>

        <form action="procesar_traspaso.php" method="post">
            <label for="jugador">Jugador a vender:</label>
            <select name="jugador" id="jugador">
            <?php
                if ($resultado_jugadores->num_rows > 0) {
                    while($row = $resultado_jugadores->fetch_assoc()) {
                        echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay jugadores disponibles</option>";
                }
            ?>
            </select>

            <label for="equipo_comprador">Equipo que compra:</label>
            <select name="equipo_comprador" id="equipo_comprador">
            <?php
                if ($resultado_equipos->num_rows > 0) {
                    while($row = $resultado_equipos->fetch_assoc()) {
                        echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay equipos disponibles</option>";
                }
            ?>
            </select>

            <label for="cantidad">Cantidad de traspaso:</label>
            <input type="number" name="cantidad" id="cantidad" required>

            <input type="hidden" name="comprador" value="<?php echo $equipo_vendedor; ?>">
            <input type="submit" value="Realizar Traspaso">
        </form>

        <?php
        // Cierro la conexión
        $mysqli->close();
        ?>
    </div>
</body>
</html>
