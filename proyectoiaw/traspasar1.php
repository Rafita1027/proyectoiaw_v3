<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado de Fichajes de LaLiga</title>
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

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"], .btn-container a {
            background-color: #e30613;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 10px auto 0;
            text-decoration: none;
            text-align: center;
            width: 50%;
            font-size: 16px; 
            box-sizing: border-box; 
        }

        input[type="submit"]:hover, .btn-container a:hover {
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
        <h1>Mercado de Fichajes de LaLiga</h1>
        <form action="traspasar2.php" method="post">
            <label for="comprador">Equipo que realiza la venta:</label>
            <select name="comprador" id="comprador">
            <?php
                // Establezco conexión
                require 'conexion.php';

                $sql = "SELECT nombre FROM equipos";

                $resultado = $mysqli->query($sql);

                if ($resultado->num_rows > 0) {
                    while($row = $resultado->fetch_assoc()) {
                        echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
                    }
                } else {
                    echo "<option value=''>0 resultados</option>";
                }
            ?>
            </select>
            <input type="submit" value="Seleccionar">
        </form>

        <?php
        // Cierro la conexión
        $mysqli->close();
        ?>
    </div>
</body>
</html>
