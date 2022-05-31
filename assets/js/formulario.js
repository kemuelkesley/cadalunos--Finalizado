async function consultaApi(endpoint) {
    let myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer 9b647431ec66af3bb674ea66b60b63dd059c29e9");
    myHeaders.append('Content-Type', 'application/json');
   

    let requestOptions = {
        mode: 'no-cors',        
        headers: myHeaders,
        redirect: 'follow'
    };

   
    

    return fetch(`https://portaldeservicos.fiea.com.br/relatoriosSESI/sge/cadalunos/formulario_alunos.php${endpoint}`, requestOptions)
        .then(response => response.json())
        .then((result) => {            
            return result
        })
        .catch(error => console.log('error', error));
}

// Dados Bancarios

async function buscaBancos() {

    let endpoint = `?rota=bancos`;
    let consulta = await consultaApi(endpoint);


    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].CODIGO + '">' + consulta[i].BANCO + '</option>'
    }
    document.getElementById('select_bancos').innerHTML = html;

    document.querySelectorAll('select_bancos')

}

function selectStatusLocal() {
    let status = document.getElementById('select_local');
    if (status.dataset.status == 1) {
        modal(true, 'PRÉ-MATRICULA')
    }
    let local = document.getElementById('select_local')
    let teste = document.getElementById('teste')
    teste.value = local.value
    // if (status.dataset.status == 2) {
    //     modal(true, 'MATRICULA')
    // }
}


async function buscaFilial(CodColigada) {

    let endpoint = `?rota=filial&CodColigada=${CodColigada}`;
    let consulta = await consultaApi(endpoint);


    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].CODFILIAL + '">' + consulta[i].FILIAL + '</option>'
    }
    document.getElementById('filial').innerHTML = html;

}

async function buscaFilial(CodColigada) {

    let endpoint = `?rota=filial&CodColigada=${CodColigada}`;
    let consulta = await consultaApi(endpoint);


    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].CODFILIAL + '">' + consulta[i].FILIAL + '</option>'
    }
    document.getElementById('filial').innerHTML = html;

}

// Função para Habilitar botão. 

function desabilitaBotao() {
    let button = document.getElementById('submit-button');
    button.classList.add('disabled');
}
// Função para Desabilitar botão.
function habilitaBotao() {
    let button = document.getElementById('submit-button');
    button.classList.remove('disabled');
}

// Função mascará de idade.
function calculaIdade(dataNasc) {
    let dataAtual = new Date();
    let anoAtual = dataAtual.getFullYear();
    let anoNascParts = '';
    try {
        anoNascParts = dataNasc.split('-');
    } catch (error) {
        console.info(error)
    }
    
    let diaNasc = anoNascParts[2];
    let mesNasc = anoNascParts[1];
    let anoNasc = anoNascParts[0];    
    let idade = anoAtual - anoNasc;
    let mesAtual = dataAtual.getMonth() + 1;
    //Se mes atual for menor que o nascimento, nao fez aniversario ainda;  
    if (mesAtual < mesNasc) {
        idade--;
    } else {
        //Se estiver no mes do nascimento, verificar o dia
        if (mesAtual == mesNasc) {
            if (new Date().getDate() < diaNasc) {
                //Se a data atual for menor que o dia de nascimento ele ainda nao fez aniversario
                idade--;
            }
        }
    }
    return idade;
}

// Modal que apresenta mensagem.

function modal(exibicao,mensagem) {
    if (exibicao) {
        document.getElementById('popUp').style.display = 'flex';              
        document.getElementById('popUpMessage').innerHTML = mensagem;   
    }else{
        document.getElementById('popUp').style.display = 'none';  
    }
     
}

// Modal que apresenta na hora de clicar no botão de enviar.

function modalSubmit(exibicao,mensagem) {
    if (exibicao) {
        document.getElementById('popUp-Enviar').style.display = 'flex';              
        document.getElementById('popUp-EnviarMensagem').innerHTML = mensagem;   
    }else{
        document.getElementById('popUp-Enviar').style.display = 'none';  
    }
   
    
}

// Campo Veracidade, informações, obrigar o usuario escolher uma das opções.


function campoObrigatorio(){

    let campoCheck1 = document.getElementById('veracidade-1').checked;
        
    let campoCheck2 = document.getElementById('veracidade-2').checked;
       
    
    if (!(campoCheck1 || campoCheck2)) {
    
        //desabilitaBotao();    
        alert('Selecionar uma das opções de confirmação de veracidade.')    
    }    
}


// botao
function chamarModalEnviar(event) {
    //Ativar campo de obrigatoriedade veracidade.
    //campoObrigatorio();
    
    event.preventDefault();
   
    
    // let camposNulos = false;
    // let camposNulosList = new Array();

    // Array.from(document.querySelectorAll('[required]')).forEach(
    //     (campo)=>{
    //         if(campo.value.length <= 0) {
    //             camposNulos = true
    //             camposNulosList.push(document.querySelector(`[for=${campo.getAttribute('id')}]`)?.innerText || campo.getAttribute('id'));
    //         }
    //     }
    // )

    // if (camposNulos == true) {
    //     console.log(camposNulosList)
    //     alert('Preencha os campos:\n' + camposNulosList.reduce((inicial, valor)=>{ return inicial += `\n    ${valor}` }, ''));
    //     return 
    // }


    modalSubmit(true,`Olá UserTeste lindo, <nome style="color:#000000">`+document.getElementById('nome').value+`</nome>
Tendo em vista o Regimento Interno das Unidades Operacionais do SENAI, conforme Capítulo I, Seção III, no Artigo 41, fica impedida a realização de cursos de Qualificação Profissional para menores de 14 anos.
Qualifica Educação: Educação profissional para transformar a sua vida.
Um programa do Governo do Estado de Alagoas em parceria com o SENAI.`)
        
        // modal(true,'Menor 14 anos');
        
     

}


// Função que calcula idade se ele for menor de 14 anos.
function verificaIdade() {
    let campoNascimento = document.getElementById('nascimento');
    let idade = calculaIdade(campoNascimento.value);
    
    if (idade >= 14) {
        modal(false,'');
        habilitaBotao()      
    }else{          
        modal(true,`Olá, <nome style="color:#000000">`+document.getElementById('nome').value+`</nome>
Tendo em vista o Regimento Interno das Unidades Operacionais do SENAI, conforme Capítulo I, Seção III, no Artigo 41, fica impedida a realização de cursos de Qualificação Profissional para menores de 14 anos.
Qualifica Educação: Educação profissional para transformar a sua vida.
Um programa do Governo do Estado de Alagoas em parceria com o SENAI.`)
        
        // modal(true,'Menor 14 anos');
        desabilitaBotao()     
    } 

}

// Função que calcula a idade do Responsável se ele for maior de 18 anos.

function verificaIdadeResponsavel() {
    let campoNascimento = document.getElementById('data_nascimento_responsavel');
    let idade = calculaIdade(campoNascimento.value);
    
    if (idade >= 18) {
        modal(false,'');
        habilitaBotao()      
    }else{          
        modal(true,'Responsável menor de idade');
        desabilitaBotao()     
    } 

}


// Validação de CPF data_nascimento_responsavel

function testaCPF(id) {
    let CPF = document.getElementById(id);
    if(id == "cpf"){
        variavel = 'tooltip-cpf'
    }else{
        variavel = 'tooltip-cpf_resp'
    }

    let tooltip = document.getElementById(variavel);
    
    let Soma;
    let Resto;
    let cpfFormatado = CPF.value.replaceAll('.', '');
    cpfFormatado = cpfFormatado.replaceAll('-', '');
    cpfFormatado = cpfFormatado.replaceAll(',', '');
    cpfFormatado = cpfFormatado.replace(/\s/g, '');
    Soma = 0;
    if (cpfFormatado == "00000000000") {
        CPF.classList.add('error');
        tooltip.classList.remove(variavel);
        return desabilitaBotao()
    }
    for (i = 1; i <= 9; i++) Soma = Soma + parseInt(cpfFormatado.substring(i - 1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(cpfFormatado.substring(9, 10))) {
        CPF.classList.add('error');
        tooltip.classList.remove(variavel);
        return desabilitaBotao()
    }
    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(cpfFormatado.substring(i - 1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(cpfFormatado.substring(10, 11))) {
        CPF.classList.add('error');
        tooltip.classList.remove(variavel);
        return desabilitaBotao()
    }

    CPF.classList.remove('error');
    tooltip.classList.add(variavel);
    return habilitaBotao()
}

// validação celular teste

// function mascara(o,f){
//     v_obj=o
//     v_fun=f
//     setTimeout("maskdate()",1)
// }
// function maskdate(){
//     v_obj.value=v_fun(v_obj.value)
// }
// function formatdate(v){
//     v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
//     v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
//     v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
//     return v;
// }
// function id(el){
// 	return document.getElementById('cel');
// }
// window.onload = function(){
// 	id('cel').onkeyup = function(){
// 		mascara( this, formatdate );
// 	}
// }


async function corRaca() {

    let endpoint = `?rota=corraca`;
    let consulta = await consultaApi(endpoint);

    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].CODCLIENTE + '">' + consulta[i].DESCRICAO + '</option>'
    }
    document.getElementById('corraca').innerHTML = html;

}


async function dsNascionalidade() {

    let endpoint = `?rota=nacionalidade`;
    let consulta = await consultaApi(endpoint);

    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].CODCLIENTE + '">' + consulta[i].DESCRICAO + '</option>'
    }
    document.getElementById('nacionalidade').innerHTML = html;


}


async function selectNaturalidade(idEstado, municipio,id) {
    
    let endpoint = `?rota=naturalidade&estado=${idEstado}`;
    let consulta = await consultaApi(endpoint);

  
    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].NOMEMUNICIPIO + '">' + consulta[i].NOMEMUNICIPIO + '</option>'
    }
    if(id == "estado_natal"){
        document.getElementById('cidadeNascimento').innerHTML = html;
        // document.getElementById('cidade').innerHTML = html;
        document.getElementById('cidadeNascimento').value = municipio;
        // document.getElementById('cidade').value = naturalidade;
    } else if(id == "estado"){
        document.getElementById('cidade').innerHTML = html;
        document.getElementById('cidade').value = municipio;
    }

}

async function selectArea(idCidade) {

    let endpoint = `?rota=area&CIDADE=${idCidade}`;
    let consulta = await consultaApi(endpoint);

    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].CODAREA + '">' + consulta[i].AREA + '</option>'
    }
    document.getElementById('select-area').innerHTML = html;
}


async function selectTurma(valorArea, valorCidade) {

    let endpoint = `?rota=turmas&CODAREA=${valorArea}&CODCIDADE=${valorCidade}`;
    let consulta = await consultaApi(endpoint);


    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].CODGRADE + '">' + consulta[i].CURSO + '</option>'
    }
    document.getElementById('select-turma').innerHTML = html;
}


async function selectLocal(valorTurma) {

    let endpoint = `?rota=localidade&CODGRADE=${valorTurma}`;
    let consulta = await consultaApi(endpoint);

    
    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option data-status="'+ consulta[i].STATUS_ALUNO +'" value="' + consulta[i].CHAVE_TURMA + '">' + consulta[i].LOCALIDADE + '</option>'
    }
    document.getElementById('select_local').innerHTML = html;
}


async function estadoNatal() {

    let endpoint = `?rota=estado_natal`;
    let consulta = await consultaApi(endpoint);

    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option data-CODETD="' + consulta[i].CODETD + '" value="' + consulta[i].CODETD + '">' + consulta[i].CODETD + '</option>'
    }
    document.getElementById('estado_natal').innerHTML = html;

}


async function grauDeInstrucao() {

    let endpoint = `?rota=grau`;
    let consulta = await consultaApi(endpoint);

    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].CODCLIENTE + '">' + consulta[i].DESCRICAO + '</option>'
    }
    document.getElementById('grau').innerHTML = html;
}

async function selectCidades() {

    let endpoint = `?rota=cidade`;
    let consulta = await consultaApi(endpoint);
   
    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].CODCIDADE + '">' + consulta[i].CIDADE + '</option>'
    }
    document.getElementById('select-cidade').innerHTML = html;
}


async function paisOrigem() {

    let endpoint = `?rota=pais`;
    let consulta = await consultaApi(endpoint);

    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].IDPAIS + '">' + consulta[i].DESCRICAO + '</option>'
    }
    document.getElementById('pais').innerHTML = html;

}


async function estadoOrigem() {

    let endpoint = `?rota=estado`;
    let consulta = await consultaApi(endpoint);

    let html = '<option value="">Selecione</option>';
    for (i = 0; i < consulta.length; i++) {
        html += '<option value="' + consulta[i].CODETD + '">' + consulta[i].NOME + '</option>'
    }
    document.getElementById('estado').innerHTML = html;

}


function maskCPF(v, id) {
    v = v.replace(/\D/g, "")                    //Remove tudo o que não é dígito
    v = v.replace(/(\d{3})(\d)/, "$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    //de novo (para o segundo bloco de números)
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    document.getElementById(id).value = v
}

async function cpfOrigem(cpf, id) {
   
    testaCPF(id);

    let endpoint = `?rota=cpf&cpf=${cpf}`;
    let consulta = await consultaApi(endpoint);
    let dtNasc = '';
    try {
        dtNasc = consulta[0].DTNASCIMENTO.split('/').reverse();
    } catch (error) {
        console.info('Não preencheu nada:', error)
    }
    
    let arrayResponsavel = document.querySelectorAll('.campos-responsavel');
    if (consulta[0].IDADE >= 18) {
        arrayResponsavel.forEach(campos => {
            campos.style.display = 'flex';
        });
        document.getElementById('data_nascimento_responsavel').value = dtNasc[0] + '-' + dtNasc[1] + '-' + dtNasc[2];
        document.getElementById('nome_responsavel').value = consulta[0].NOME;
        document.getElementById('cpf_resp').value = cpf;
    } else {
        arrayResponsavel.forEach(campos => {
            campos.style.display = 'flex';
        });
        document.getElementById('data_nascimento_responsavel').value = '';
        document.getElementById('nome_responsavel').value = '';
        document.getElementById('cpf_resp').value = '';
    }


    document.getElementById('nome').value = consulta[0].NOME;
    document.getElementById('nascimento').value = dtNasc[0] + '-' + dtNasc[1] + '-' + dtNasc[2];
    document.getElementById('corraca').value = consulta[0].CORRACA;
    document.getElementById('email').value = consulta[0].EMAIL;

    // document.getElementById('nacionalidade').value    = consulta[0].NACIONALIDADE;
    document.getElementById('estado_natal').value = consulta[0].ESTADONATAL;
    document.getElementById('sexo').value = consulta[0].SEXO;
    document.getElementById('grau').value = consulta[0].GRAUINSTRUCAO;
    document.getElementById('cel').value = consulta[0].TELEFONE1;
    document.getElementById('cep').value = consulta[0].CEP;
    document.getElementById('logradouro').value = consulta[0].RUA;
    document.getElementById('estado').value = consulta[0].ESTADO;
    document.getElementById('numero').value = consulta[0].NUMERO;
    document.getElementById('bairro').value = consulta[0].BAIRRO;
    document.getElementById('nome_mae').value = consulta[0].NOME_MAE;
    document.getElementById('cidade').value = consulta[0].CIDADE;

    // document.getElementById('pais').value             = consulta[0].PAIS;   

    selectNaturalidade(consulta[0].ESTADONATAL, consulta[0].NATURALIDADE,"estado_natal");
    selectNaturalidade(consulta[0].ESTADO, consulta[0].CIDADE,"estado");
    
}


//Ao selecionar o campo "caixa econômica" vai aparecer a opção OPERAÇÂO.

function mostrarOperacaoCaixa(){
    let select = document.querySelector('#select_bancos');
    let div = document.querySelector('#operacao')
    //Esconder campo
    div.parentElement.setAttribute('style','display:none');
   
    if(select.value == 104){
        div.parentElement.setAttribute('style','display:block');
    } else {
        div.parentElement.setAttribute('style','display:none');
        document.getElementById('operacao').value = ""
    }
}


//Deixar só numeros no campo agencia e conta.

function onlynumber(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    //var regex = /^[0-9.,]+$/;
    var regex = /^[0-9.]+$/;
    if( !regex.test(key) ) {
       theEvent.returnValue = false;
       if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

// Função checked

function checarHorario(){
    let teste = document.getElementsByClassName('check-horario');
    let check = false;
    let mostrarMensagem = document.getElementById('alerta')

    for (let i = 0; i < teste.length; i++){
        if (teste[i].children[0].checked){
            check = true;
            mostrarMensagem.setAttribute('hidden',true);
            return check;
        }
    }
    mostrarMensagem.removeAttribute('hidden');
    //desabilitaBotao();
    
    // $(document).ready(function(){
    //     $("#submit-button").click(function(){
    //       $("#alerta").toggle();
    //     });
    // });

}
function horarioMarcado(){
    var horario = ''
    for(i=0;i<document.getElementsByClassName("check-horario").length;i++){
        if(document.getElementsByClassName("check-horario")[i].checked == true){
            horario += document.getElementsByClassName("check-horario")[i].value+', '
        }
    }
    horario = horario.substr(0,horario.length-2)
    document.getElementById('HorarioContato').value = horario
}
function localMarcado(){
    var local = ''
    for(i=0;i<document.getElementsByClassName("local_contato").length;i++){
        if(document.getElementsByClassName("local_contato")[i].checked == true){
            local += document.getElementsByClassName("local_contato")[i].value
        }
    }

    document.getElementById('LocalContato').value = local
}
function veracidadeMarcada(){
    var local = ''
    for(i=0;i<document.getElementsByClassName("veracidade").length;i++){
        if(document.getElementsByClassName("veracidade")[i].checked == true){
            local += document.getElementsByClassName("veracidade")[i].value
        }
    }

    document.getElementById('veracidade').value = local
}