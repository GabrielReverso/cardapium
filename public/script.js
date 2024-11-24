function openModal(type) {
    const element = document.getElementById(`${type}-modal`)
    element.classList.remove('hidden')
    element.classList.add('flex')
    document.body.classList.add('overflow-y-hidden')
    element.focus()
}

function closeModal(type) {
    const element = document.getElementById(`${type}-modal`)
    element.classList.remove('flex')
    element.classList.add('hidden')
    document.body.classList.remove('overflow-y-hidden')
}

function loginHandler() {
    const emailInput = document.getElementById('email-login');
    const passwordInput = document.getElementById('password-login');

    // Verificar se os campos estão preenchidos
    if (!emailInput.value || !passwordInput.value) {
        alert('Por favor, preencha todos os campos.');
        return;
    }

    fetch('http://localhost:8000/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${encodeURIComponent(emailInput.value)}&senha=${encodeURIComponent(passwordInput.value)}`,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "validado") {
                // Redirecionar para a página de sucesso ou atualizar o estado da aplicação
                console.log("Sucesso")
                closeModal("login")
            } else {
                console.log(data.status)
                alert('E-mail ou senha incorretos.');
            }
        })
        .catch(error => console.error('Erro:', error));
}

function passwordRecoveryHandler() {
    const emailInput = document.getElementById('email-recovery');
    const passwordInput = document.getElementById('password-recovery');
    const confirmPasswordInput = document.getElementById('confirm-password-recovery');

    // Verificar se os campos estão preenchidos
    if (!emailInput.value || !passwordInput.value || !confirmPasswordInput.value) {
        alert('Por favor, preencha todos os campos.');
        return;
    }

    if (passwordInput.value !== confirmPasswordInput.value) {
        alert('As senhas não conferem.');
        return;
    }

    fetch('http://localhost:8000/forgotPassword.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${encodeURIComponent(emailInput.value)}&senha=${encodeURIComponent(passwordInput.value)}`,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "alterado") {
                // Redirecionar para a página de sucesso ou atualizar o estado da aplicação
                console.log("Sucesso")
                alert("Senha trocada com sucesso!")
                closeModal("password-recovery")
            } else {
                console.log(data.status)
                alert('E-mail ou senha incorretos.');
            }
        })
        .catch(error => console.error('Erro:', error));
}

function registerHandler() {
    const nameInput = document.getElementById('name-register');
    const emailInput = document.getElementById('email-register');
    const dataInput = document.getElementById('data-register');
    const cellInput = document.getElementById('cell-register');
    const passwordInput = document.getElementById('password-register');
    const confirmPasswordInput = document.getElementById('confirm-password-register');
    const cepInput = document.getElementById('cep-register');
    const ruaInput = document.getElementById('rua-register');
    const numeroInput = document.getElementById('numero-register');
    const complementoInput = document.getElementById('complemento-register');
    const bairroInput = document.getElementById('bairro-register');
    const cidadeInput = document.getElementById('cidade-register');
    const estadoInput = document.getElementById('estado-register');

    function isEmpty(value) {
        return value.trim() === '';
    }

    // Verificar se os campos estão preenchidos
    if (
        isEmpty(nameInput.value) ||
        isEmpty(emailInput.value) ||
        //isEmpty(dataInput.value) ||
        isEmpty(cellInput.value) ||
        isEmpty(passwordInput.value) ||
        isEmpty(confirmPasswordInput.value) ||
        isEmpty(cepInput.value) ||
        isEmpty(ruaInput.value) ||
        isEmpty(numeroInput.value) ||
        isEmpty(complementoInput.value) ||
        isEmpty(bairroInput.value) ||
        isEmpty(cidadeInput.value) ||
        isEmpty(estadoInput.value)
    ) {
        alert('Por favor, preencha todos os campos.');
        return;
    }

    if (passwordInput.value !== confirmPasswordInput.value) {
        alert('As senhas não conferem')
        return
    }

    fetch('http://localhost:8000/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `nome=${encodeURIComponent(nameInput.value)}&email=${encodeURIComponent(emailInput.value)}&data=${encodeURIComponent(dataInput.value)}&telefone=${encodeURIComponent(cellInput.value)}&senha=${encodeURIComponent(passwordInput.value)}&cep=${encodeURIComponent(cepInput.value)}&rua=${encodeURIComponent(ruaInput.value)}&numeroEnd=${encodeURIComponent(numeroInput.value)}&bairro=${encodeURIComponent(bairroInput.value)}&complemento=${encodeURIComponent(complementoInput.value)}&cidade=${encodeURIComponent(cidadeInput.value)}&estado=${encodeURIComponent(estadoInput.value)}`,
        //body: `nome=${encodeURIComponent(nameInput.value)}&email=${encodeURIComponent(emailInput.value)}&data=${encodeURIComponent("2000-10-10")}&telefone=${encodeURIComponent(cellInput.value)}&senha=${encodeURIComponent(passwordInput.value)}&cep=${encodeURIComponent(cepInput.value)}&rua=${encodeURIComponent(ruaInput.value)}&numeroEnd=${encodeURIComponent(numeroInput.value)}&bairro=${encodeURIComponent(bairroInput.value)}&complemento=${encodeURIComponent(complementoInput.value)}&cidade=${encodeURIComponent(cidadeInput.value)}&estado=${encodeURIComponent(estadoInput.value)}`,
        //body: `nome=${encodeURIComponent("Gabriel")}&email=${encodeURIComponent("email@email")}&data=${encodeURIComponent("2000-10-10")}&telefone=${encodeURIComponent("1")}&senha=${encodeURIComponent("123")}&cep=${encodeURIComponent("123")}&rua=${encodeURIComponent("Rua")}&numeroEnd=${encodeURIComponent("1")}&bairro=${encodeURIComponent("Bairro")}&complemento=${encodeURIComponent("1")}&cidade=${encodeURIComponent("RP")}&estado=${encodeURIComponent("SP")}`,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "sucesso") {
                console.log(data)
                alert("Cadastro Realizado com Sucesso!")
                closeModal("register")
            } else {
                console.warn(data.status)
                alert(data.mensagem);
            }
        })
        .catch(error => {
            console.error('Erro:', error)
            alert(error);
        });
}