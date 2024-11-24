<?php
    session_start();

    try {
        include '../conexao/conexao.php';

    } catch (\Throwable $th) {
        throw $th;
    }


    $exemplo = array(
        "itens" => [1,2,3,4],
        "quantidade" => [2, 3, 1, 1],
        "precoRelativo" => [40, 45, 7 , 10]
    );

    if (isset($_POST['carrinho'])){
        
        if (isset($_SESSION['userID']) && isset($_SESSION['userName'])){
            $userID = $_SESSION['userID'];
            $userName = $_SESSION['userName'];

    
        }elseif(isset($_COOKIE['userID']) && isset($_COOKIE['userName'])){
            $userID = $_COOKIE['userID'];
            $userName = $_COOKIE['userName'];
        }else {
            http_response_code(400);
            $connDB->close();
            die;
        }  

        $carrinhoJSON = json_decode($_POST['carrinho']);
    }else{
        die;
    }
    

    $pedidoCriado = createOrder($connDB, $userID, $userName);

    if ($pedidoCriado == 1){

        $order = catchOrder($connDB, $userID, $userName);
        if ($order == 0){
            http_response_code(400);
        }elseif ($order == -1){
            http_response_code(500);
        }

        $itenOrder = addItenOrder($connDB, $exemplo, $order);
        if ($itenOrder == 1){
            $updateOrderValidation = updateOrder($connDB,$order);
            if ($updateOrderValidation == 1){
                http_response_code(200);
            }elseif($updateOrderValidation == 0){
                http_response_code(400);
            }else{
                http_response_code(500);
            }
        }elseif ($itenOrder == 0){
            http_response_code(400);
        }else{
            http_response_code(500);
        }
    }elseif ($pedidoCriado == 0){
        http_response_code(400);


    }else {
        http_response_code(500);

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