<?php

try {
    include 'conexao.php';
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode(array("status" => "erro", "mensagem" => "falha na conexão"));
    exit;
}

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $EMAIL = htmlspecialchars($_POST['email']);
    $NEWPASSWORD = htmlspecialchars($_POST['senha']);
} else {
    http_response_code(400);
    echo json_encode(array("status" => "erro", "mensagem" => "dados incompletos"));
    exit;
}

$userID = validarEmail($EMAIL, $connDB);

//echo "id: ". $userID;

if ($userID == 0) {
    http_response_code(400);
    echo json_encode(array("status" => "erro", "mensagem" => "dados equivocados"));
    //header("Location: forgotPassword.html");
    exit;
} elseif ($userID == -1) {
    http_response_code(500);
    echo json_encode(array("status" => "erro", "mensagem" => "erro interno"));
    //header("Location: forgotPassword.html");
    exit;
}

$NEWPASSWORD = password_hash($NEWPASSWORD, PASSWORD_DEFAULT); // Hash da nova senha
$result = alterarSenha($NEWPASSWORD, $userID, $connDB);


if ($result == 1) {
    http_response_code(200);
    echo json_encode(array("status" => "alterado", "mensagem" => "senha alterada com sucesso"));
    //header("Location: login.html");
} elseif ($result == -1) {
    http_response_code(400);
    echo json_encode(array("status" => "erro", "mensagem" => "erro ao alterar a senha"));
    //header("Location: forgotPassword.html");
}

$connDB->close();

?>

<?php

function validarEmail($emailLocal, $connDB) {
    try {
        $stmt = $connDB->prepare("SELECT id FROM TB_USUARIO WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $emailLocal);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($userID);
                    $stmt->fetch();
                    return $userID;
                } else {
                    return 0;
                }
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    } catch (\Throwable $th) {
        throw $th;
    }
}

?>

<?php

function alterarSenha($NEWPASSWORD, $userID, $connDB) {
    try {
        $stmt = $connDB->prepare("UPDATE TB_USUARIO SET senha = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("ss", $NEWPASSWORD, $userID);
            if ($stmt->execute() && $stmt->affected_rows > 0) {
                return 1;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    } catch (\Throwable $th) {
        throw $th;
    }
}

?>
