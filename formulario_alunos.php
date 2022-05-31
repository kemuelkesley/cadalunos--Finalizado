<?php
header("Access-Control-Allow-Origin: *");
ini_set('default_charset','UTF-8');

include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {
        $ChaveTurma = $_POST['select_local'];
        $Nome_Aluno = $_POST['nome'];
        $Endereco = $_POST['logradouro'];
        $Numero_Aluno = $_POST['numero'];
        $Complemento_Aluno = '';
        $Bairro_Aluno = $_POST['bairro'];
        $Municipio = $_POST['cidade'];
        $Pais_Aluno = 'Brasil';
        $Sigla_Estado = $_POST['estado'];
        $CEP_Aluno = $_POST['cep'];
        $Telefone = $_POST['cel'];
        $Cpf_Aluno = $_POST['cpf'];
        $Email_Aluno = $_POST['email'];
        $Sexo_Aluno = $_POST['sexo'];
        $Nascimento = $_POST['nascimento'];
        $Estado_Civil = 'S';
        $Cor_raca = $_POST['corraca'];
        $Grau_instrucao = $_POST['grau'];
        $Nacionalidade = '37';
        $Nome_Mae = $_POST['nome_mae'];
        $Estado_Natal = $_POST['estado_natal'];
        $Nome_Responsavel = $_POST['nome_responsavel'];
        $Email_Responsavel = $_POST['email_responsavel'];
        $Cpf_Responsavel = $_POST['cpf_resp'];
        $Dtnascimento_Responsavel = $_POST['data_nascimento_responsavel'];
        $Banco = $_POST['select_bancos'];
        $Agencia = $_POST['agencia'];
        $Conta = $_POST['conta'];
        $Operacao = $_POST['operacao'];
        $Veracidade = $_POST['veracidade'];
        $EscolaEstadual = $_POST['escola_estadual'];
        $HorarioContato = $_POST['HorarioContato'];
        $LocalContato = $_POST['LocalContato'];
        
        $Nascimento = date('d/m/Y',strtotime($Nascimento));
        $Dtnascimento_Responsavel = date('d/m/Y',strtotime($Dtnascimento_Responsavel));
        $Cpf_Aluno = str_replace("-","",str_replace(".","",$Cpf_Aluno));
        $Cpf_Responsavel = str_replace("-","",str_replace(".","",$Cpf_Responsavel));

        // $sql = "EXECUTE [dbo].[SP_Formulario_Matricula]
        //             '$ChaveTurma'
        //             ,'$Nome_Aluno'
        //             ,'$Endereco'
        //             ,'$Numero_Aluno'
        //             ,'$Complemento_Aluno'
        //             ,'$Bairro_Aluno'
        //             ,'$Municipio'
        //             ,'$Pais_Aluno'
        //             ,'$Sigla_Estado'
        //             ,'$CEP_Aluno'
        //             ,'$Telefone'
        //             ,'$Cpf_Aluno'
        //             ,'$Email_Aluno'
        //             ,'$Sexo_Aluno'
        //             ,'$Nascimento'
        //             ,'$Estado_Civil'
        //             ,'$Cor_raca'
        //             ,'$Grau_instrucao'
        //             ,'$Nacionalidade'
        //             ,'$Nome_Mae'
        //             ,'$Estado_Natal'
        //             ,'$Nome_Responsavel'
        //             ,'$Email_Responsavel'
        //             ,'$Cpf_Responsavel'
        //             ,'$Dtnascimento_Responsavel'
        //             ,'$Banco'
        //             ,'$Agencia'
        //             ,'$Conta'
        //             ,'$Operacao'
        //             ,'$Veracidade'
        //             ,'$EscolaEstadual'
        //             ,'$HorarioContato'
        //             ,'$LocalContato'";

        // $stmt = sqlsrv_query($conexao, $sql);
        // $result = array();
        // do {
        //     while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {$result[] = $row;}
        // } 
        // while (sqlsrv_next_result($stmt));


        $sql2 = "SELECT
                    PPESSOA.NOME
                    ,SALUNO.RA
                    ,SMATRICPL.CODTURMA
                    ,SSTATUS.DESCRICAO STATUS
                    ,SSTATUS.CODSTATUS
                FROM SMATRICPL
                INNER JOIN SALUNO
                    ON SMATRICPL.CODCOLIGADA = SALUNO.CODCOLIGADA
                    AND SMATRICPL.RA = SALUNO.RA
                INNER JOIN SSTATUS
                    ON SSTATUS.CODCOLIGADA = SMATRICPL.CODCOLIGADA
                    AND SSTATUS.CODSTATUS = SMATRICPL.CODSTATUS
                INNER JOIN PPESSOA
                    ON PPESSOA.CODIGO = SALUNO.CODPESSOA
                WHERE PPESSOA.CPF = '$Cpf_Aluno'
                AND CONCAT(SMATRICPL.IDPERLET,SMATRICPL.IDHABILITACAOFILIAL,SMATRICPL.CODTURMA) = '$ChaveTurma'";
        $stmt2 = sqlsrv_query($conexao, $sql2);
        $result = array();
        do {
            while ($row = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {$result[] = $row;}
        } 
        while (sqlsrv_next_result($stmt2));
        
        echo json_encode($result);
        
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
} 

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    

    $rota = $_GET['rota'];    
    $estado = isset($_GET['estado']) ?  strtoupper($_GET['estado']) : false;
    $cpf = isset($_GET['cpf']) ? preg_replace( '/[^0-9]/is', '', $_GET['cpf'] ) : false;
    
    if($rota == 'filial'){
        $parametros = [];
        $parametro = [$_GET['CodColigada']];
        
        $sql = "SELECT CODFILIAL,NOME FILIAL FROM GFILIAL WHERE CODCOLIGADA = ?";
                
        $stmt = sqlsrv_query($conexao, $sql, $parametro);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    } 


    if($rota == 'Nome_Mae'){
                
        $sql = "";
                
        $stmt = sqlsrv_query($conexao, $sql);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }    


    if($rota == 'bancos'){
                
        $sql = "SELECT CODCLIENTE CODIGO, DESCRICAO BANCO FROM GCONSIST WHERE CODTABELA = 'BANCOS' ORDER BY DESCRICAO";
                
        $stmt = sqlsrv_query($conexao, $sql);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }    
    
    if($rota == 'cidade'){
              
        $sql = "SELECT DISTINCT CODCIDADE, UPPER(CIDADE) CIDADE FROM [vw_turmas_abertas_qualifica]";
               
                
        $stmt = sqlsrv_query($conexao, $sql);
        $result = array();
        
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    } 
    
    if($rota == 'area'){
        
        $parametro = [$_GET['CIDADE']];
        
        $sql = "SELECT DISTINCT CODAREA, UPPER(AREA) AREA FROM [vw_turmas_abertas_qualifica] WHERE CODCIDADE = ?";
                
        $stmt = sqlsrv_query($conexao, $sql, $parametro);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }  



    if($rota == 'turmas'){
        $parametros = [];
        $parametro = [
            $_GET['CODCIDADE'],
            $_GET['CODAREA']
        ];
        
        
        $sql = "SELECT CONCAT(CODGRADE,CODTURMA) CODGRADE, CURSO FROM [vw_turmas_abertas_qualifica] WHERE CODCIDADE = ? AND CODAREA = ?";
                
        $stmt = sqlsrv_query($conexao, $sql, $parametro);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }

    if($rota == 'localidade'){
        $parametros = [];
        $parametro = [
            $_GET['CODGRADE']
        ];
                
        $sql = "SELECT STATUS_ALUNO, CHAVE_TURMA, UPPER(LOCALIDADE) LOCALIDADE FROM [vw_turmas_abertas_qualifica] WHERE CONCAT(CODGRADE,CODTURMA) = ?";
                
        $stmt = sqlsrv_query($conexao, $sql, $parametro);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }  

    if($rota == 'corraca'){
        
        $parametros = [];
        // $parametro = [$_GET['CodColigada']];
        
        $sql = "SELECT CODCLIENTE, DESCRICAO FROM PCORRACA";
                
        $stmt = sqlsrv_query($conexao, $sql);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }   
    
    if($rota == 'nacionalidade'){
        $parametros = [];       
        
        $sql = "SELECT CODCLIENTE, DESCRICAO FROM PCODNACAO";
                
        $stmt = sqlsrv_query($conexao, $sql);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }   

    
    if($rota == 'naturalidade'){
        $parametros = [];       
        
        $sql = "SELECT CODMUNICIPIO, NOMEMUNICIPIO FROM GMUNICIPIO WHERE CODETDMUNICIPIO = '$estado'";
                
        $stmt = sqlsrv_query($conexao, $sql);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }   
    
    if($rota == 'estado_natal'){
        $parametros = [];       
        
        $sql = "SELECT CODETD, NOME FROM GETD WHERE IDPAIS = 1";
                
        $stmt = sqlsrv_query($conexao, $sql);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }   
    
    
    if($rota == 'grau'){
        $parametros = [];       
        
        $sql = "SELECT CODCLIENTE, DESCRICAO  FROM PCODINSTRUCAO";
                
        $stmt = sqlsrv_query($conexao, $sql);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }   
    
    if($rota == 'pais'){
        $parametros = [];       
        
        $sql = "SELECT IDPAIS, DESCRICAO FROM GPAIS";
                
        $stmt = sqlsrv_query($conexao, $sql);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }   
    
    
    if($rota == 'estado'){
        $parametros = [];       
        
        $sql = "SELECT CODETD, NOME  FROM GETD WHERE IDPAIS = 1";
                
        $stmt = sqlsrv_query($conexao, $sql);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }   
    

    if($rota == 'cpf'){
        $parametros = [];       
        
        $sql = "SELECT 
                    NOME
                    ,ESTADONATAL
                    ,NATURALIDADE
                    ,DTNASCIMENTO
                    ,SEXO
                    ,EMAIL
                    ,CORRACA
                    ,GRAUINSTRUCAO
                    ,CEP
                    ,RUA
                    ,NUMERO
                    ,BAIRRO
                    ,ESTADO
                    ,CIDADE
                    ,TELEFONE1
                    ,IDADE
                    ,NOME_MAE
                    ,FONTE
                FROM [dbo].[vw_pessoa]
                WHERE PRIORIDADE IN (SELECT MIN(PRIORIDADE) FROM [dbo].[vw_pessoa] WHERE CPF = '$cpf')
                AND CPF = '$cpf' 
";
                
        $stmt = sqlsrv_query($conexao, $sql);
        $result = array();
    
        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }
        } while (sqlsrv_next_result($stmt));
        
        echo json_encode($result);
        return;
    }   


}


echo 'ERRO DE REQUEST - >'. $_SERVER['REQUEST_METHOD']; 
return;
