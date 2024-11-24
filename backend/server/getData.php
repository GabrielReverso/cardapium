<?php

    session_start();

    try {
        include 'conexao.php';

    } catch (\Throwable $th) {
        throw $th;
    }

    if (isset($_POST['filtro'])){
        $categoriaFiltro = $_POST['filtro'];

        $ITENS = listItensFilterByCategory($connDB, $categoriaFiltro);


    }else{
        $ITENS = listItensAll($connDB);
    }

    if (isset($ITENS["status"])){
        http_response_code(400);
        echo  json_encode($ITENS);
        $connDB->close();
        exit;
    }

    http_response_code(200);
    echo json_encode($ITENS);

    $connDB->close();

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
                        "nome" => htmlspecialchars($row["item_nome"]),
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


<?php

    function cathCategoriaID($connDB, $categoria){
        $categoriaID = 0;
        try {
            $stmt = $connDB->prepare("select id from TB_CATEGORIA where nome = ?");
            if ($stmt){
                $stmt->bind_param("s", $categoria);
                if ($stmt->execute()){
                    $stmt->bind_result($categoriaID);
                    $stmt->fetch();
                    return $categoriaID;
                }else{
                    return 0;
                }
            }else{
                return -1;
            }
        } catch (\Throwable $th) {
            throw $th;
            return -1;
        }
    }

    function listItensFilterByCategory($connDB, $categoria){
        $itensList = [];
        $itensListByCategory = [];
        try {
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
                WHERE TB_CATEGORIA.id = ?;
                "
            );
            if ($stmt){
                $categoriaID = cathCategoriaID($connDB, $categoria);
                if ($categoria == 0) {
                    return [
                        "status" => "erro",
                        "mensagem" => "Nenhuma categoria foi encontrada"
                    ];              
                }elseif ($categoria == -1){
                    return [
                        "status" => "erro",
                        "mensagem" => "Erro no banco ao procurar a categoria"
                    ];
                }
                $stmt->bind_param("i", $categoriaID);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()){
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
                }



            }else {
                return [
                    "status" => "erro",
                    "mensagem" => "Erro ao preparar a consulta no banco"
                ];
            }


        } catch (\Throwable $th) {
            return [
                "status" => "erro",
                "mensagem" => "Erro no banco: " . $th->getMessage()
            ];
        }
    }

?>


