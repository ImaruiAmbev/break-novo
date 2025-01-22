<?php

class Mapa
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function ListarMapas($matricula)
    {
        $hoje = date("Y-m-d");
        $stmt = $this->conn->prepare("SELECT DISTINCT mapa FROM mapa_dia WHERE id = ? AND data = ?");
        $stmt->bind_param("is", $matricula, $hoje);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function ListarClientes($mapaSelecionado)
    {
        $stmt = $this->conn->prepare("SELECT cod_cli FROM mapa_dia WHERE mapa = ?");
        $stmt->bind_param("i", $mapaSelecionado);
        $stmt->execute();
        $result = $stmt->get_result();

        $clientes = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $clientes[] = $row['cod_cli'];
            }
        }

        return $clientes;
    }

    public function ListarNf($PdvSelecionado)
    {
        $hoje = date('Y-m-d');
        $stmt = $this->conn->prepare("SELECT nf FROM mapa_dia WHERE cod_cli = ? AND data = '$hoje'");
        $stmt->bind_param("s", $PdvSelecionado);
        $stmt->execute();
        $result = $stmt->get_result();

        $nfs = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nfs[] = $row['nf'];
            }
        }

        return $nfs;
    }
}
