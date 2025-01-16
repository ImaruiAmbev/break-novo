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

    public function ListarCLiente($mapa_selecionado)
    {
        $stmt_cliente = $this->conn->prepare("SELECT cliente FROM mapa_dia WHERE mapa = ?");
        $stmt_cliente->bind_param("i", $mapa_selecionado);
        $stmt_cliente->exeute();
        $result_cliente = $stmt_cliente->get_result();

        if ($result_cliente->num_rows > 0) {
            return $result_cliente->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
