<?php
    //session_start();

    try {
        include 'conexao.php';

    } catch (\Throwable $th) {
        throw $th;
    }



    if (isset($_POST['carrinho'])){

        $carrinhoJSON = json_decode($_POST['carrinho'], true);

            // Verificar se o JSON é válido
        if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo json_encode([
                "mensagem" => "O JSON enviado é inválido.",
                "erro" => json_last_error_msg()
            ]);
            die;
        }
        
        if (array_key_exists('userID', $carrinhoJSON) && array_key_exists('userName', $carrinhoJSON)){
            $userID = $carrinhoJSON['userID'];
            $userName = $carrinhoJSON['userName'];
        }else {
            http_response_code(400);
            $dados = array(
                "mensagem" => "não foi encontrado as variaveis userID e userName"
            );
            echo json_encode($dados);
            $connDB->close();
            die;
        }  
    }else{
        die;
    }
    

    $pedidoCriado = createOrder($connDB, $userID, $userName);

    if ($pedidoCriado == 1){

        $order = catchOrder($connDB, $userID, $userName);
        if ($order == 0){
            http_response_code(400);
            $dados = array(
                "mensagem" => "Nenhum pedido encontrado"
            );
            echo json_encode($dados);
        }elseif ($order == -1){
            http_response_code(500);
            $dados = array(
                "mensagem" => "Erro na solicitação do servidor pros pedidos"
            );
            echo json_encode($dados);
        }

        $itenOrder = addItenOrder($connDB, $carrinhoJSON, $order);
        if ($itenOrder == 1){
            $updateOrderValidation = updateOrder($connDB,$order);
            if ($updateOrderValidation == 1){
                http_response_code(200);
                $dados = array(
                    "mensagem" => "Pedido atualizado"
                );
                echo json_encode($dados);
            }elseif($updateOrderValidation == 0){
                http_response_code(400);
                $dados = array(
                    "mensagem" => "Não foi possível fazer update"
                );
                echo json_encode($dados);
            }else{
                http_response_code(500);
                $dados = array(
                    "mensagem" => "Erro na solicitação do servidor pros pedidos"
                );
                echo json_encode($dados);
            }
        }elseif ($itenOrder == 0){
            http_response_code(400);
            $dados = array(
                "mensagem" => "Não adicionado nos pedidos"
            );
            echo json_encode($dados);
        }else{
            http_response_code(500);
            $dados = array(
                "mensagem" => "Erro na solicitação do servidor pros pedidos"
            );
            echo json_encode($dados);
        }
    }elseif ($pedidoCriado == 0){
        http_response_code(400);
        $dados = array(
            "mensagem" => "Pedido não criado"
        );
        echo json_encode($dados);

    }else {
        http_response_code(500);
        $dados = array(
            "mensagem" => "Erro na solicitação do servidor pros pedidos"
        );
        echo json_encode($dados);
    }

    $connDB->close();


?>


<?php

    //status do pedido :
    //0 -> em preparo
    //1 -> finalizado
    //2 -> para entrega (WIP)
    function createOrder($connDB, $userID, $userName){

        $preco = 0;  // O preço do pedido (valor fixo)
        $finalizado = 0;  // Status do pedido (0 = não finalizado)

        try {
            $stmt = $connDB->prepare("INSERT INTO TB_PEDIDOS (preco, nome,idUsuario,finalizado) VALUES (?, ?, ?, ?)");
            if ($stmt){
                $stmt->bind_param("dsii", $preco, $userName, $userID, $finalizado); //cria um pedido com preço 0, nome do usuario, o id do usuario, e status de não finalizado
                if ($stmt->execute()){
                    return 1;
                }else {
                    return 0;
                }
            }else{
                return -1;
            }
        } catch (\Throwable $th) {
           return -1;
        }
    }

?>

<?php

    function catchOrder($connDB, $userID, $userName){
        $preco = 0;  // O preço do pedido (valor fixo)
        $finalizado = 0;  // Status do pedido (0 = não finalizado)
        $idOrder = 0;

        try {
            $stmt = $connDB->prepare(
                "SELECT id
                FROM TB_PEDIDOS
                WHERE nome = ?
                    AND idUsuario = ?
                    AND preco = 0
                    AND finalizado = 0"
            );
            if ($stmt){
                $stmt->bind_param("si", $userName, $userID); //cria um pedido com preço 0, nome do usuario, o id do usuario, e status de não finalizado
                if ($stmt->execute()){
                    $stmt->store_result();

                    if ($stmt->num_rows > 0){
                        $stmt->bind_result($idOrder);
                        $stmt->fetch();

                        return $idOrder;
                    }
                }else {
                    return 0;
                }
            }else{
                return -1;
            }
        } catch (\Throwable $th) {
           return -1;
        }

        
    }
?>

<?php

    function addItenOrder($connDB, $cart, $order){

        
        
        $itens = $cart['itens'];
        $quantidade = $cart['quantidade'];
        $precoRelativo = $cart['precoRelativo'];
        $validation = 0;



        foreach ($itens as $key => $item) {
            $quantidadeItem = $quantidade[$key];
            $precoRelativoItem = $precoRelativo[$key];            

            try {
                $stmt = $connDB->prepare("INSERT INTO TB_ITENS_PEDIDOS (idPedido, idItem, quantidade, preco) VALUES (?, ?, ?, ?);");

                if ($stmt){
                    $stmt->bind_param("iiid", $order, $item, $quantidadeItem, $precoRelativoItem); //cria um pedido com preço 0, nome do usuario, o id do usuario, e status de não finalizado
                    
                    if ($stmt->execute()){
                        $validation += 1;
                    }else{
                        return 0;
                    }
                }else{
                    return -1;
                }
            } catch (\Throwable $th) {
                return -1;
            }
        }

        if ($validation == count($cart['itens'])){
            return 1;
        }else{
            return -1;
        }

    }

?>

<?php


    function cathPrecoTotal($connDB, $order){

        $precoTotal = 0;

        try {
            $stmt = $connDB->prepare(
                "SELECT SUM(preco) AS precoTotal
                FROM TB_ITENS_PEDIDOS
                WHERE TB_ITENS_PEDIDOS.idPedido = ?;"
            );
            if ($stmt){
                $stmt->bind_param("i", $order);
                if ($stmt->execute()){
                    $stmt->store_result();

                    if ($stmt->num_rows > 0){
                        $stmt->bind_result($precoTotal);
                        $stmt->fetch();

                        return $precoTotal;
                    }else{
                        return 0;
                    }
                }
            }else{
                return -1;
            }
        } catch (\Throwable $th) {
            return -1;
        }
    }

    function updateOrder($connDB, $order){
        try {
            $stmt = $connDB->prepare(
                "UPDATE TB_PEDIDOS 
                SET preco = ?, finalizado = 1
                where id = ?;"
            );
            if ($stmt){
                $precoTotal = cathPrecoTotal($connDB, $order);
                $stmt->bind_param("di", $precoTotal, $order);
                if ($stmt->execute()){
                    return 1;
                }else{
                    return 0;
                }
            }else{
                return -1;
            }
        } catch (\Throwable $th) {
            return -1;
        }
    }

?>