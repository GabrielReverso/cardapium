<?php
    try {
        include 'conexao.php';

    } catch (\Throwable $th) {
        throw $th;
        echo "failed connection";
    }


    try {
        $NAME = htmlspecialchars($_POST['nome']);
        $EMAIL = htmlspecialchars($_POST['email']);
        $DATA = htmlspecialchars($_POST['data']);
        $PHONENUMBER = htmlspecialchars($_POST['telefone']);
        $PASSWORD = htmlspecialchars($_POST['senha']);
        $CEP = htmlspecialchars($_POST['cep']);
        $RUA =  htmlspecialchars($_POST['rua']);
        $NUMERO = htmlspecialchars($_POST['numeroEnd']);
        $BAIRRO = htmlspecialchars($_POST['bairro']);
        $COMPLEMENTO = htmlspecialchars($_POST['complemento']);
        $CIDADE = htmlspecialchars($_POST['cidade']);
        $ESTADO = htmlspecialchars($_POST['estado']);
    } catch (\Throwable $th) {
        throw $th;
    }




    $valited = validarEmail($EMAIL, $connDB);
    

    if ($valited == 1){

        $valited = insert();
        if ($valited == 1){
            http_response_code(200);
            $dados = array(
                "status" => "sucesso",
                "mensagem" => "Cadastro realizado com sucesso"
            );
            echo json_encode($dados);
        }elseif ($valited["status"] == "erro bad request"){
            http_response_code(400);
            echo json_encode($valited);
        }elseif ($valited["status"] == "erro interno do banco"){
            http_response_code(500);
            echo json_encode($valited);
        }elseif ($valited["status"] == "erro validacao data"){
            http_response_code(418);
            echo json_encode($valited);
        }
        
    }elseif ($valited == 0){
        http_response_code(400);
        $dados = array(
            "status" => "erro",
            "mensagem" => "usuario ja existente"
        );
        echo json_encode($dados);
    }else{
        http_response_code(500);
        $dados = array(
            "status" => "erro",
            "mensagem" => "internal erro"
        );
        echo json_encode($dados);
    }
    
    
    $connDB->close();
?>



<?php

    function validarEmail($emailLocal, $connDB){

        $result = 0;
        $validated = true;

        try {
            $stmt = $connDB->prepare("SELECT COUNT(*) FROM TB_USUARIO WHERE email = ?");
            if ($stmt){
                $stmt->bind_param("s", $emailLocal);
                if ($stmt->execute()){
                    $stmt->bind_result($result);
                    $stmt->fetch();
                    if ($result != 0){
                        $validated = false;
                    }
                }else{
                    return -1;
                }
            }else{
                return -1;
            }
            return $validated ? 1 : 0;
    
        }catch (\Throwable $th){
            throw $th;
        }

    }

?>


<?php

    function insert(){
    global $connDB, $PASSWORD, $DATA, $NAME, $EMAIL, $PHONENUMBER, $CEP, $RUA, $NUMERO, $BAIRRO, $COMPLEMENTO, $CIDADE, $ESTADO;
        $hash = password_hash($PASSWORD, PASSWORD_DEFAULT); //CRIPTOGRAFia dA SENHA
        $timestamp = strtotime($DATA);//valida o formato

        if ($PASSWORD == ""){
            $dados = array(
                "status" => "erro bad request",
                "mensagem" => "bad request"
            );
            return $dados;
        }

        if ($timestamp){
            $dataCorrigida = date('Y-m-d', $timestamp); //corrige a data para o formato aceito
            try {
                $stmt = $connDB->prepare("INSERT INTO TB_USUARIO (nome, email, data_nascimento, telefone, senha, cep, rua, numero, bairro, complemento, cidade, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if ($stmt){
                    $stmt->bind_param("ssssssssssss", $NAME, $EMAIL, $dataCorrigida, $PHONENUMBER, $hash, $CEP, $RUA, $NUMERO, $BAIRRO, $COMPLEMENTO, $CIDADE, $ESTADO);
                    if ($stmt->execute()){
                        return 1;
                    }else{
                        $dados = array(
                            "status" => "erro bad request",
                            "mensagem" => "bad request"
                        );
                        return $dados;
                    }
                }else{
                    $dados = array(
                        "status" => "erro interno do banco",
                        "mensagem" => "erro interno do banco"
                    );
                    return $dados;
                }
            } catch (\Throwable $th) {
                echo "Erro no try-catch: " . $th->getMessage(); // Exibe erro caso ocorra uma exceção
            }
        }else{ 
            $dados = array(
                "status" => "erro validacao data",
                "mensagem" => "Formato de data invalido",
            );
            return $dados;
        }

    }

?>