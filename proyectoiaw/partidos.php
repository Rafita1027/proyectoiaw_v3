<?php
    require 'conexion.php';

    if (isset($_GET['id'])) {
        $id_equipo = $_GET['id'];

        $sql = "SELECT p.Jornada, e1.nombre AS local, e2.nombre AS visitante, p.Gol_local, p.Gol_visitante
                FROM partido p
                INNER JOIN equipos e1 ON p.Id_local = e1.id
                INNER JOIN equipos e2 ON p.Id_visitante = e2.id
                WHERE p.Id_local = ? OR p.Id_visitante = ?
                ORDER BY p.Jornada DESC";

        $stmt = $mysqli->prepare($sql);
        
        $stmt->bind_param("ii", $id_equipo, $id_equipo);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<!DOCTYPE html>
                <html lang='es'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Partidos del Equipo</title>
                    <link rel='icon' type='image/png' href='images/laliga_logo.png'>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #fff; 
                            color: #333; 
                            margin: 0;
                            padding: 0;
                        }
                        .container {
                            width: 80%;
                            margin: 20px auto;
                        }
                        h1 {
                            color: #ff0000; 
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 20px;
                        }
                        th, td {
                            border: 1px solid #ccc; 
                            padding: 8px;
                            text-align: center;
                        }
                        th {
                            background-color: #ff0000; 
                            color: #fff; 
                        }
                        tbody tr:nth-child(even) {
                            background-color: #f2f2f2; 
                        }
                        tbody tr:hover {
                            background-color: #ddd; 
                        }
                        .logo {
                            position: absolute;
                            top: 10px;
                            left: 10px;
                            width: 100px; 
                            cursor: pointer; /* Cambiar cursor a pointer para indicar que es clickeable */
                        }
                        .btn-volver {
                            background-color: #e30613;
                            color: #fff;
                            border: none;
                            padding: 10px 20px;
                            border-radius: 5px;
                            cursor: pointer;
                            display: block;
                            margin: 20px auto 0;
                            text-decoration: none;
                            text-align: center;
                            width: fit-content;
                        }
                        .btn-volver:hover {
                            background-color: #c20410;
                        }
                        @media (max-width: 600px) {
                            .container {
                                width: 90%;
                                margin: 10px auto;
                            }
                            h1 {
                                font-size: 1.5em;
                            }
                            table, th, td {
                                font-size: 12px;
                                padding: 5px;
                            }
                            .logo {
                                width: 0px;
                            }
                            .btn-volver {
                                padding: 8px 16px;
                            }
                        }
                    </style>
                </head>
                <body>
                    <a href='index.php'><img class='logo' src='images/laliga_logo.png' alt='Logo de La Liga'></a>
                    <div class='container'>
                        <h1>Partidos del Equipo</h1>
                        <table id='tabla' class='display'>
                            <thead>
                                <tr>
                                    <th>Jornada</th>
                                    <th>Equipo Local</th>
                                    <th>Goles Local</th>
                                    <th>Equipo Visitante</th>
                                    <th>Goles Visitante</th>
                                </tr>
                            </thead>
                            <tbody>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['Jornada']}</td>";
                echo "<td>{$row['local']}</td>";
                echo "<td>{$row['Gol_local']}</td>";
                echo "<td>{$row['visitante']}</td>";
                echo "<td>{$row['Gol_visitante']}</td>";
                echo "</tr>";
            }

            echo "</tbody>
                </table>
                <a href='clasificacion.php' class='btn-volver'>Volver a la clasificación</a>
                </div>
                </body>
                </html>";

        } else {
            echo "<p>No se encontraron partidos para este equipo.</p>";
            echo "<a href='clasificacion.php' class='btn-volver'>Volver a la clasificación</a>";
        }

        $stmt->close();
        $mysqli->close();

    } else {
        header("Location: index.php");
        exit;
    }
?>
