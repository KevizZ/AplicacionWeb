<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    <!-- MESES -->
    <style>
        /* Estilos para los botones cuando no están clickeados */
        .mes-button {
            background-color: #ccc;
            border: 1px solid #999;
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            border-radius: 10px;
            background-color: #4fa8fb;
        }

        /* Estilos para los botones cuando son clickeados */
        .mes-button-clicked {
            background-color: skyblue;
            border: 1px solid #999;
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            border-radius: 10px;
        }

        .contenedor{
            align-items: center;
            margin-left: 20%;
            margin-top: 20px;
        }

        #chartContainer{
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

    getMes();
    function getMes()
    {
        if (isset($_GET["mes"])) {
            $mes = $_GET["mes"];
        } else {
            $mes = "all";
        }

        $meses = ["","Enero", "Febrero", "Abril", "Mayo", "Marzo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"];
        $page = $_SERVER["PHP_SELF"];

        echo "<th><a href='".$page ."?mes='all''> X </a></th>";

        for ($i = 0; $i < 13; $i++) {
            if ( $i > 0 &&$mes != "all" && $mes != $i) {
                echo '<th><a href="' . $page . '?mes=' . $i. ' " class="mes-button">' . $meses[$i] . '</a></th>';

            } else if ($mes == $i) {
                echo '<th><a href="' . $page . '?mes=' . $i . '" class="mes-button-clicked">' . $meses[$i] . '</a></th>';
            } else if ($mes == "all") {
                echo '<th><a href="' . $page . '" class="mes-button">' . $meses[$i] . '</a></th>';
            }

        }
    }
    function getSQLFecha()
    {
        $sql = "";
        if (isset($_GET["mes"]) && 0 < $_GET["mes"] && 12 >= $_GET["mes"] ) {
            $sql = "YEAR(incidente.fecha) = 2023 AND MONTH(incidente.fecha) = " . $_GET['mes'];
        } else {
            $sql = "YEAR(incidente.fecha) = 2023";
        }
        return $sql;
    }
    
    $fecha = getSQLFecha();
    
    $conexion = new Conexion();
    
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


    ?>


</div>
</body>

<!-- CANVAS JS -->

<div id="chartContainer" style="height: 250px; width: 60%;"></div>
<script>
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Categorías de Inicidentes"
            },
            axisY: {
                includeZero: true
            },
            data: [{
                type: "bar", //change type to bar, line, area, pie, etc
                //indexLabel: "{y}", //Shows y value on all Data Points
                indexLabelFontColor: "#5A5757",
                indexLabelFontSize: 16,
                indexLabelPlacement: "outside",
                dataPoints: <?php  echo json_encode($dataPoints, JSON_NUMERIC_CHECK);?> 
            }]
        });
        chart.render();

    }
</script>

</html>