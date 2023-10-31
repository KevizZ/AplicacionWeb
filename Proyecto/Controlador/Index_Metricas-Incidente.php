<?php require_once("Verificador.php");
require_once("../Repositorio/Database.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- MESES -->
    <style>
        a {
            border-radius: 10px;
        }

        /* Estilos para los botones cuando no están clickeados */
        .mes-button {
            background-color: blue;

            cursor: pointer;
            text-decoration: none;
            color: white;

        }

        /* Estilos para los botones cuando son clickeados */
        .mes-button-clicked {
            background-color: skyblue;

            cursor: pointer;

            color: white;
            border-radius: 10px;

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
            text-align: center;
            margin-top: 20px;
        }

        #chartContainer {
            margin-left: 12%;
            margin-top: 20px;
        }
    </style>
</head>

<body class="bg-secondary">
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
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3 col-sm-3">
            <div id="chartContainer" style="height: 500px;"></div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div id="chartContainer2" style="height: 250px;"></div>
        </div>
        <div class=" bg-light col-md-3 col-sm-3 shadow">
            <h2 class="text-center mt-3 mb-3">Involucrados</h2>
            <?php
            $personas = BD::getPersonasCantidadIncidentes();

            echo "<div class='d-flex justify-content-center'>
            <table class='table table-bordered mx-auto'>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Incidentes</th>
            </tr>
        </thead>";
            foreach ($personas as $persona) {
                echo "<tr>
                <td>{$persona->getNombre()} {$persona->getApellido()}</td>
                <td>{$persona->getCantidadIncidentes()}</td>
                </tr>";
            }
            echo "</table>
            </div>";

            ?>
        </div>
    </div>
</div>

<script>
    window.onload = function () {
        // Primer gráfico
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1",
            title: {
                text: "Categorías"
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