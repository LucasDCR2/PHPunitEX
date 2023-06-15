<?php

use PHPUnit\Framework\TestCase;

class ValidarDados {
    public function verificarCamposObrigatorios($dados) {
        if (empty($dados['nome']) || empty($dados['email']) || empty($dados['cpf']) || empty($dados['genero'])) {
            $retorna = ['status' => false, 'msg' => "Preencha todos os campos obrigatórios!"];
            return $retorna;
        }
    }

    public function validarEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $retorna = ['status' => false, 'msg' => "Erro! Insira um email válido!"];
            return $retorna;
        }

        $retorna = ['status' => true, 'msg' => "Email válido!"];
        return $retorna;
    }

    public function validarCPF($cpf) {
        if (!preg_match("/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/", $cpf)) {
            $retorna = ['status' => false, 'msg' => "Erro! Insira um CPF válido!"];
            return $retorna;
        }

        $retorna = ['status' => true, 'msg' => "CPF válido!"];
        return $retorna;
    }

    public function validarNome($nome) {
        if (empty($nome)) {
            $retorna = ['status' => false, 'msg' => "Erro! Insira um nome válido!"];
            return $retorna;
        }

        $retorna = ['status' => true, 'msg' => "Nome válido!"];
        return $retorna;
    }
}
//=====================================================================================CLASSE==========================================================================================//

    class ValidarDadosTest extends TestCase {
        public function testValidacaoDosCamposFormulario() {
            $validarDados = new ValidarDados();

//==============================================================================SETAR DADOS INVÁLIDOS==================================================================================//

        $emailInvalido = 'email_invalido';
        $cpfInvalido = '123456789';
        $nomeVazio = '';

        $conteudosEsperados = [
            'validarEmail' => ['status' => false, 'msg' => "Erro! Insira um email válido!"],
            'validarCPF' => ['status' => false, 'msg' => "Erro! Insira um CPF válido!"],
            'validarNome' => ['status' => false, 'msg' => "Erro! Insira um nome válido!"],
            'verificarCamposObrigatorios' => ['status' => false, 'msg' => "Preencha todos os campos obrigatórios!"]
         ];

//==================================================================================DADOS INVÁLIDOS====================================================================================//

        // Testar validarEmail com email inválido
        $resultado = $validarDados->validarEmail($emailInvalido);
        $this->assertFalse($resultado['status']);
        $this->assertEquals($conteudosEsperados['validarEmail'], $resultado);

        // Testar validarCPF com CPF inválido
        $resultado = $validarDados->validarCPF($cpfInvalido);
        $this->assertFalse($resultado['status']);
        $this->assertEquals($conteudosEsperados['validarCPF'], $resultado);

        // Testar validarNome com nome vazio
        $resultado = $validarDados->validarNome($nomeVazio);
        $this->assertFalse($resultado['status']);
        $this->assertEquals($conteudosEsperados['validarNome'], $resultado);

        // Testar verificarCamposObrigatorios com dados vazios
        $dadosVazios = [
            'nome' => '',
            'email' => '',
            'cpf' => '',
            'genero' => ''
        ];
        $resultado = $validarDados->verificarCamposObrigatorios($dadosVazios);
        $this->assertFalse($resultado['status']);
        $this->assertEquals($conteudosEsperados['verificarCamposObrigatorios'], $resultado);        

//==============================================================================SETAR DADOS VÁLIDOS==================================================================================//

        $emailValido = 'email@example.com';
        $cpfValido = '123.456.789-00';
        $nomeValido = 'João da Silva';

        $conteudosEsperadosValidos = [
            'validarEmail' => ['status' => true, 'msg' => "Email válido!"],
            'validarCPF' => ['status' => true, 'msg' => "CPF válido!"],
            'validarNome' => ['status' => true, 'msg' => "Nome válido!"],
            'verificarCamposObrigatorios' => null
        ];

//=================================================================================DADOS VÁLIDOS=====================================================================================//

       // Testar validarEmail para um email válido
       $resultado = $validarDados->validarEmail($emailValido);
       $this->assertTrue($resultado['status']);
       $this->assertEquals($conteudosEsperadosValidos['validarEmail'], $resultado);

       // Testar validarCPF para um CPF válido
       $resultado = $validarDados->validarCPF($cpfValido);
       $this->assertTrue($resultado['status']);
       $this->assertEquals($conteudosEsperadosValidos['validarCPF'], $resultado);

       // Testar validarNome para um nome válido
       $resultado = $validarDados->validarNome($nomeValido);
       $this->assertTrue($resultado['status']);
       $this->assertEquals($conteudosEsperadosValidos['validarNome'], $resultado);

       // Testar verificarCamposObrigatorios para dados preenchidos corretamente
       $dadosPreenchidos = [
           'nome' => 'João da Silva',
           'email' => 'email@example.com',
           'cpf' => '123.456.789-00',
           'genero' => 'Masculino'
       ];
       $resultado = $validarDados->verificarCamposObrigatorios($dadosPreenchidos);
       $this->assertNull($resultado);
    }
}

//cd "C:\Users\Pichau\OneDrive\Área de Trabalho\PHP\testeUNIT - Copia\tests"
//vendor/bin/phpunit ValidarDadosTest.php
