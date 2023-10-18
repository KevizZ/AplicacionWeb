<?php
class Conexion
{
    private $conn;
    private $user;
    private $password;
    private $baseDeDatos;
    private $puerto;

    public function __construct()
    {
        $this->user = 'root';
        $this->password = '';
        $this->baseDeDatos = 'proyecto';
        $this->puerto = 3306;
    }

    public function getConexion()
    {

        $dsn = "mysql:host=localhost:$this->puerto;dbname=$this->baseDeDatos;charset=UTF8";

        try {
            $pdo = new PDO($dsn, $this->user, $this->password);

            if ($pdo) {
                // $this->debug_to_console("Connected to the $this->baseDeDatos database successfully!");
                // esto manda el log al archivo /var/log/syslog 
                syslog(LOG_INFO, "Se establecio conexion");
            }
            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //esto mando un log a la consola del browser
    //TODO mandar esta funcion a una clase util
    public function debug_to_console($data)
    {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
}




?>