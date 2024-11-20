<?php

header('Access-Control-Allow-Origin: *');

    try {
        include 'conexao.php';

    } catch (\Throwable $th) {
        throw $th;
        echo "failed connection";
    }

    $ITENS = listItensAll($connDB);

    http_response_code(200);
    echo json_encode($ITENS);


?>


<?php

function listItensAll($connDB) {
    $itensList = [];
    $itensListByCategory = [];
    try {
        // Prepara a consulta SQL
        $stmt = $connDB->prepare(
            "SELECT 
                TB_ITENS.id AS item_id, 
                TB_ITENS.nome AS item_nome, 
                TB_ITENS.descricao AS item_descricao, 
                TB_ITENS.foto AS item_foto, 
                TB_ITENS.preco AS item_preco, 
                TB_CATEGORIA.nome AS categoria_nome 
            FROM 
                cardapiumDB.TB_ITENS 
            INNER JOIN 
                cardapiumDB.TB_CATEGORIA 
            ON 
                TB_ITENS.idCategoria = TB_CATEGORIA.id
            "
        );

        if ($stmt) {
            // Executa a consulta
            $stmt->execute();
            // Obtém o resultado
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $item = [
                        "id" => htmlspecialchars($row["item_id"]),
                        "Nome" => htmlspecialchars($row["item_nome"]),
                        "descricao" => htmlspecialchars($row["item_descricao"]),
                        "foto" => htmlspecialchars($row["item_foto"]),
                        "preco" => htmlspecialchars($row["item_preco"]),
                        "categoria" => htmlspecialchars($row["categoria_nome"]),
                    ];
                    array_push($itensList, $item);
                }

                foreach($itensList as $item){
                    if (!isset($itensListByCategory[$item["categoria"]])){
                        $itensListByCategory[$item["categoria"]] = [];
                    }

                    $itensListByCategory[$item["categoria"]][] = $item;
                }
                //echo json_encode($itensListByCategory);
                return $itensListByCategory;
            } else {
                return [
                    "status" => "erro",
                    "mensagem" => "Nenhum item encontrado"
                ];
            }
        } else {
            return [
                "status" => "erro",
                "mensagem" => "Erro ao preparar a consulta no banco"
            ];
        }
    } catch (Throwable $th) {
        return [
            "status" => "erro",
            "mensagem" => "Erro no banco: " . $th->getMessage()
        ];
    }
}
?>


