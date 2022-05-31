<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once 'database.php';
    try {
        $pdo = new PDO("sqlsrv:Server=SQLSERV02\SQL01_I2; Database=Corporerm_Contabilidade", "rm", "rm");

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        return;
        foreach ($_POST as $key => $value) {
            # code...
        }

        $Id_Formulario      = 1;// $_POST['Id_Formulario'];
        $ChaveTurma         = $_POST['ChaveTurma'];
        $Nome_Aluno         = $_POST['Nome_Aluno'];
        $Endereco           = $_POST['Endereco'];
        $Numero_Aluno       = $_POST['Numero_Aluno'];
        $Complemento_Aluno  = $_POST['Complemento_Aluno'];
        $Bairro_Aluno       = $_POST['Bairro_Aluno'];
        $Municipio          = $_POST['Municipio'];
        $Pais_Aluno         = $_POST['Pais_Aluno'];
        $Sigla_Estado       = $_POST['Sigla_Estado'];
        $CEP_Aluno          = $_POST['CEP_Aluno'];
        $Telefone           = $_POST['Telefone'];
        $Cpf_Aluno          = $_POST['Cpf_Aluno'];
        $Email_Aluno        = $_POST['Email_Aluno'];
        $Sexo_Aluno         = $_POST['Sexo_Aluno'];
        $Nascimento         = $_POST['Nascimento'];
        $Estado_Civil       = $_POST['Estado_Civil'];
        $Cor_raca           = $_POST['Cor_raca'];
        $Grau_instrucao     = $_POST['Grau_instrucao'];
        $Nacionalidade      = $_POST['Nacionalidade'];
        $Nome_Mae           = $_POST['Nome_Mae'];
        $Estado_Natal       = $_POST['Estado_Natal'];        
		$CodStatus          = $_POST['CodStatus'];
		$Nome_Responsavel   = $_POST['Nome_Responsavel'];
		$Email_Responsavel  = $_POST['Email_Responsavel'];
		$Cpf_Responsavel    = $_POST['Cpf_Responsavel'];
		$Dtnascimento_Responsavel = $_POST['Dtnascimento_Responsavel'];
		$Banco              =$_POST['Banco'];
		$Agencia            =$_POST['Agencia'];
		$Conta              =$_POST['Conta'];
		$Operacao           =$_POST['Operacao'];
		$Veracidade         =$_POST['Veracidade'];

        

        $query = "EXECUTE [SP_Formulario_Matricula]
                    :Id_Formulario
                    ,:ChaveTurma
                    ,:Nome_Aluno
                    ,:Endereco
                    ,:Numero_Aluno
                    ,:Complemento_Aluno
                    ,:Bairro_Aluno
                    ,:Municipio
                    ,:Pais_Aluno
                    ,:Sigla_Estado
                    ,:CEP_Aluno
                    ,:Telefone
                    ,:Cpf_Aluno
                    ,:Email_Aluno
                    ,:Sexo_Aluno
                    ,:Nascimento
                    ,:Estado_Civil
                    ,:Cor_raca
                    ,:Grau_instrucao
                    ,:Nacionalidade
                    ,:Nome_Mae
                    ,:Estado_Natal
                    ,:CodStatus
                    ,:Nome_Responsavel
                    ,:Email_Responsavel
                    ,:Cpf_Responsavel
                    ,:Dtnascimento_Responsavel
                    ,:Banco
                    ,:Agencia
                    ,:Conta
                    ,:Operacao
                    ,:Veracidade
                ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':Id_Formulario', $Id_Formulario);
        $stmt->bindParam(':ChaveTurma', $ChaveTurma);
        $stmt->bindParam(':Nome_Aluno', $Nome_Aluno);
        $stmt->bindParam(':Endereco', $Endereco);
        $stmt->bindParam(':Numero_Aluno', $Numero_Aluno);
        $stmt->bindParam(':Complemento_Aluno', $Complemento_Aluno);
        $stmt->bindParam(':Bairro_Aluno', $Bairro_Aluno);
        $stmt->bindParam(':Municipio', $Municipio);
        $stmt->bindParam(':Pais_Aluno', $Pais_Aluno);
        $stmt->bindParam(':Sigla_Estado', $Sigla_Estado);
        $stmt->bindParam(':CEP_Aluno', $CEP_Aluno);
        $stmt->bindParam(':Telefone', $Telefone);
        $stmt->bindParam(':Cpf_Aluno', $Cpf_Aluno);
        $stmt->bindParam(':Email_Aluno', $Email_Aluno);
        $stmt->bindParam(':Sexo_Aluno', $Sexo_Aluno);
        $stmt->bindParam(':Nascimento', $Nascimento);
        $stmt->bindParam(':Estado_Civil', $Estado_Civil);
        $stmt->bindParam(':Cor_raca', $Cor_raca);
        $stmt->bindParam(':Grau_instrucao', $Grau_instrucao);
        $stmt->bindParam(':Nacionalidade', $Nacionalidade);
        $stmt->bindParam(':Nome_Mae', $Nome_Mae);
        $stmt->bindParam(':Estado_Natal', $Estado_Natal);
        $stmt->bindParam(':CodStatus', $CodStatus);
        $stmt->bindParam(':Nome_Responsavel', $Nome_Responsavel);
        $stmt->bindParam(':Email_Responsavel', $Email_Responsavel);
        $stmt->bindParam(':Cpf_Responsavel', $Cpf_Responsavel);
        $stmt->bindParam(':Dtnascimento_Responsavel', $Dtnascimento_Responsavel);
        $stmt->bindParam(':Banco', $Banco);
        $stmt->bindParam(':Agencia', $Agencia);
        $stmt->bindParam(':Conta', $Conta);
        $stmt->bindParam(':Operacao', $Operacao);
        $stmt->bindParam(':Veracidade', $Veracidade);
        

        $stmt->execute();

        if ($stmt) {
            echo json_encode("success");
        }

       exit;

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        echo json_encode(array('erro' => 'Falha na consulta dos dados', 'detalhes' => $stmt->errorInfo()));
        exit;
    }catch(Exception $e){
        echo $e->getMessage();
        echo json_encode(array('erro' => 'Falha na consulta dos dados', 'detalhes' => $stmt->errorInfo()));
        exit;    
    }
} else {
    http_response_code(405);
    exit;
}
