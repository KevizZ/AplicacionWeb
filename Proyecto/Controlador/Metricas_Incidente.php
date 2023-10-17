<?php require_once("Verificador.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- MESES -->
    <style>
        /* Estilos para los botones cuando no están clickeados */
        .mes-button {
            background-color: #ccc;
            border: 1px solid #999;

            cursor: pointer;
            text-decoration: none;
            color: white;

            background-color: #4fa8fb;
        }

        /* Estilos para los botones cuando son clickeados */
        .mes-button-clicked {
            background-color: skyblue;
            border: 1px solid #999;

            cursor: pointer;

            color: white;
            border-radius: 3px;

        }

        .contenedor>a {
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            font-size: 13px;
            border-radius: 3 px;
            font-family: Arial, sans-serif;
        }

        .contenedor {
            align-items: center;
            margin-left: 20%;
            margin-top: 20px;
        }

        #chartContainer {
            align-items: center;
            margin-left: 20%;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="contenedor">

        <!-- PHP -->
        <?php
        include_once("../Negocio/Incidente.php");
        require("Menu_Lateral.php");
        $meses = ["", "Enero", "Febrero", "Abril", "Mayo", "Marzo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"];
        getMes();
        function getMes()
        {
            if (isset($_GET["mes"])) {
                $mes = $_GET["mes"];
            } else {
                $mes = "all";
            }

            $meses = ["", "Enero", "Febrero", "Abril", "Mayo", "Marzo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"];
            $page = $_SERVER["PHP_SELF"];

            echo "<th><a href='" . $page . "?mes='all'' class='mes-button'> Siempre </a></th>";

            for ($i = 0; $i < 13; $i++) {
                if ($i > 0 && $mes != $i) {
                    echo '<th><a href="' . $page . '?mes=' . $i . '" class="mes-button">' . $meses[$i] . '</a></th>';

                } else if ($mes == $i) {
                    echo '<th><a href="' . $page . '?mes=' . $i . '" class="mes-button-clicked">' . $meses[$i] . '</a></th>';
                }

            }
        }
        function getSQLFecha()
        {
            $sql = "";
            if (isset($_GET["mes"]) && 0 < $_GET["mes"] && 12 >= $_GET["mes"]) {
                $sql = "YEAR(incidente.fecha) = 2023 AND MONTH(incidente.fecha) = " . $_GET['mes'];
            } else {
                $sql = "YEAR(incidente.fecha) = 2023";
            }
            return $sql;
        }

        $fecha = getSQLFecha();

        $conexion = new Conexion();

        // CATEGORIAS
        $query = "SELECT categoria.categoria as categoria, COUNT(incidente.id) as cantidad 
    FROM categoria 
    LEFT JOIN incidente ON categoria.id = incidente.id
    WHERE $fecha
    GROUP BY categoria.categoria
    ORDER BY categoria ASC;
    ";


        $stmt = $conexion->getConexion()->prepare($query);

        $stmt->execute([]);

        $dataPoints = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $d = array("y" => $row["cantidad"], "label" => $row["categoria"]);
            array_push($dataPoints, $d);

        }
        // INCIDENTES POR MES
        $query = "SELECT COUNT(incidente.id) as cantidad, MONTH(incidente.fecha) as mes 
        FROM incidente 
        WHERE YEAR(incidente.fecha) = 2023
        GROUP BY mes 
        ORDER BY mes ASC;";


        $stmt = $conexion->getConexion()->prepare($query);

        $stmt->execute([]);

        $dataPoints2 = [];
        $meses = ["Enero", "Febrero", "Abril", "Mayo", "Marzo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $mesNumero = $row["mes"]; // Número del mes
            $nombreMes = $meses[$mesNumero - 1]; // Restamos 1 ya que los índices del arreglo comienzan en 0
            $d = array("y" => $row["cantidad"], "x" => $mesNumero, "label" => $nombreMes);
            array_push($dataPoints2, $d);
        }

        ?>


    </div>
</body>

<!-- CANVAS JS -->

<div style="display: flex; justify-content: space-between; margin-top: 50px;">
    <div style="width: 48%;">
        <div id="chartContainer" style="height: 250px;"></div>
    </div>
    <div style="width: 48%;">
        <div id="chartContainer2" style="height: 250px;"></div>
    </div>
</div>


<script>
    window.onload = function () {
        // Primer gráfico
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light2",
            title: {
                text: "Categorías de Incidentes"
            },
            axisY: {
                includeZero: true
            },
            data: [{
                type: "bar",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

        // Segundo gráfico
        var chart2 = new CanvasJS.Chart("chartContainer2", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1",
            title: {
                text: "Incidentes en <?php echo date('Y'); ?>"
            },
            axisY: {
                includeZero: true
            },
            data: [{
                type: "column",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart2.render();
    }
</script>


</html>