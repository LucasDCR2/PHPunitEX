<?php
require 'vendor/autoload.php';                                                                                  // Incluindo o arquivo da biblioteca
use Respect\Validation\Validator as v;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);                                                        // Recebe os dados doformulário via POST e armazena em um array associativo

if (empty($dados['nome']) || empty($dados['email']) || empty($dados['cpf']) || empty($dados['genero'])) {       // Verifica se as chaves do array estão vazias ou não foram definidas.
    $retorna = ['status' => false, 'msg' => "Preencha todos os campos obrigatórios!"];

} elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {                                                // Verifica se o CPF está no formato correto usando o preg_match()
    $retorna = ['status' => false, 'msg' => "Erro! Insira um email válido!"];                                   //Se o formato estiver correto, o código então verifica se o CPF é válido usando a biblioteca

} else if (!preg_match("/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/", $dados['cpf']) || !v::cpf()->validate(str_replace(['.', '-'], '', $dados['cpf']))) {
    $retorna = ['status' => false, 'msg' => "Erro! Insira um CPF válido!"];

} else {
	// Cria uma nova string com os dados do formulário
    $conteudo = '-------------------------------------'."\n".
                'Nome: '.$dados['nome'] ."\n". 
                'E-mail: '.$dados['email'] ."\n". 
                'CPF: ' .$dados['cpf'] ."\n". 
                'Gênero: '.$dados['genero']."\n" . 
                '-------------------------------------'."\n";
	// Salva a string no arquivo de texto
    file_put_contents('dados.txt', $conteudo, FILE_APPEND | LOCK_EX);
    $retorna = ['status' => true, 'msg' => "SUCESSO!"];
	
}

// Retorna a resposta em formato JSON
echo json_encode($retorna);

?>



