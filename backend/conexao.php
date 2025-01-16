<?php
class Conexao
{
    private $host = "srv1383.hstgr.io";
    private $user = "u139061112_im_banco";
    private $pass = "Im@rui19";
    private $dbName = "u139061112_im_site2023";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbName);

        if ($this->conn->connect_error) {
            die("Erro na conexão: " . $this->conn->connect_error);
        }
    }

    public function getConexao()
    {
        return $this->conn;
    }

    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>