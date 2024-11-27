<?php
// Configurações do banco de dados
$host = 'localhost'; // Substituir se necessário
$dbname = 'academia_futura'; // Nome do banco de dados
$username = 'root'; // Usuário do banco
$password = ''; // Senha do banco (substituir se necessário)

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $duvida = filter_input(INPUT_POST, 'duvida', FILTER_SANITIZE_STRING);

    // Verifica se os campos obrigatórios estão preenchidos
    if ($nome && $email && $telefone && $duvida) {
        try {
            // Prepara a inserção no banco de dados
            $stmt = $pdo->prepare("INSERT INTO contato (nome, email, telefone, duvida) VALUES (:nome, :email, :telefone, :duvida)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':duvida', $duvida);

            // Executa a inserção
            $stmt->execute();

            echo "Mensagem enviada com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao salvar os dados: " . $e->getMessage();
        }
    } else {
        echo "Por favor, preencha todos os campos obrigatórios.";
    }
} else {
    echo "Acesso inválido.";
}
?>
