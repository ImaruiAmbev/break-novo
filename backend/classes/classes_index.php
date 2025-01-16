<?php
class Modulos
{
    private $conn;

    public function __construct($conexao)
    {
        $this->conn = $conexao;
    }

    public function ListarModulo()
    {
        $query_modulo = "SELECT * FROM v4_break_modulos";
        $result_modulo = $this->conn->query($query_modulo);

        if ($result_modulo->num_rows > 0) {
            $modulo = [];
            while ($row_modulo = $result_modulo->fetch_assoc()) {
                $modulo[] = [
                    'id' => $row_modulo['id'],
                    'nome' => $row_modulo['nome'],
                    'cor' => $row_modulo['cor'],
                    'imagem' => $row_modulo['imagem'],
                    'acesso' => $row_modulo['acesso']
                ];
            }
            return $modulo;
        }
        return [];
    }
}

?>