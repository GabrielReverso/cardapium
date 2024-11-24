<?php

    try {
        include 'conexao.php';

    } catch (\Throwable $th) {
        throw $th;
        echo "failed connection";
    }

    try {
        $EMAIL = htmlspecialchars($_POST['email']);
        $PASSWORD = htmlspecialchars($_POST['senha']);
    } catch (\Throwable $th) {
        throw $th;
    }

    $validated = login($EMAIL, $PASSWORD, $connDB);

    if ($validated == 1){
        session_start(); //inicio da sessão

        $userID = cathIDUser($EMAIL, $connDB);
        $userName = cathNameUser($EMAIL, $connDB);

        $_SESSION['userID'] = $userID; //armazena o id do usuario para pegar informações no banco
        $_SESSION['userName'] = $userName;

       //criação do cookie
       if (isset($_POST['lembrar'])){ //mudar variavel conforme o front
            setcookie("userID", $userID, time() + (86400 * 30), "/");
            setcookie("userName", $userName, time() + (86400 * 30), "/");
        }

        http_response_code(200);
        $dados = array(
            "status" => "validado",
            "mensagem" => "usuario validado com sucesso"
        );
        echo json_encode($dados);

        //header("Location: ../home/home.html");//mudar conforme a necessidade do front
    }elseif ($validated == 0){
        http_response_code(400);
        $dados = array(
            "status" => "erro",
            "mensagem" => "dados equivocados"
        );
        echo json_encode($dados);
        //header("Location: login.html");
    }else {
        http_response_code(500);
        $dados = array(
            "status" => "erro",
            "mensagem" => "internal error"
        );
        echo json_encode($dados);
    }
    
    $connDB->close();

?>

<?php

    function login($email, $senha, $connDB){

        try {
            $stmt = $connDB->prepare("SELECT senha FROM TB_USUARIO WHERE email = ?");

            if ($stmt) {
                $stmt->bind_param("s", $email);
                if ($stmt->execute()){

                    $stmt->store_result(); //instancia os dados para busca de dados

                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($senhaBanco);

                        $stmt->fetch();

                        if (password_verify($senha, $senhaBanco)){
                            return 1;
                        }else{
                            return 0;
                        }
                    }else{
                        return 0;
                    }
                }
            }else{
                return -1; //retorna erro
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

?>


<?php

    function cathIDUser($email, $connDB){

        try {
            $stmt = $connDB->prepare("SELECT id FROM TB_USUARIO WHERE email = ?");

            if ($stmt) {
                $stmt->bind_param("s", $email);
                if ($stmt->execute()){

                    $stmt->store_result(); //instancia os dados para busca de dados

                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($idUsuario);

                        $stmt->fetch();
                        
                        return $idUsuario;
                    }else{
                        return -1;
                    }
                }
            }else{
                return -1; //retorna erro
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

?>


<?php

    function cathNameUser($email, $connDB){

        try {
            $stmt = $connDB->prepare("SELECT nome FROM TB_USUARIO WHERE email = ?");

            if ($stmt) {
                $stmt->bind_param("s", $email);
                if ($stmt->execute()){

                    $stmt->store_result(); //instancia os dados para busca de dados

                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($idUsuario);

                        $stmt->fetch();
                        
                        return $idUsuario;
                    }else{
                        return -1;
                    }
                }
            }else{
                return -1; //retorna erro
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

?>