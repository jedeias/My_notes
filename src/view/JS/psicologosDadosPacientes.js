function dadosPacientes(pk){
    $.ajax({
            url: '../../../../Controllers/ajaxRequests/dadosPacientes.php',
            method: 'POST',
            dataType: 'json',
            data: {
                'pk': pk,
            },
            success:function(response){
                console.log(response);

                let itensAtividades = document.getElementsByClassName("atividadeItem");
                while (itensAtividades.length > 0) {
                    itensAtividades[0].remove();
                }

                let itensAnotacoes = document.getElementsByClassName("anotacoesItem");
                while (itensAnotacoes.length > 0) {
                    itensAnotacoes[0].remove();
                }

                if (Array.isArray(response.atividades)) {
                    showListaDeAtividadesPaciente(response.atividades);
                } else {
                    let section = document.getElementById("listaDeAtividadesDoPaciente");
                    let errorDiv = document.createElement('div');
                    errorDiv.className = "atividadeItem";
                    errorDiv.innerHTML = response.atividades || "Nenhuma atividade encontrada.";
                    section.appendChild(errorDiv);
                }

                if (Array.isArray(response.anotacoes)) {
                    showListaDeAnotacoesPaciente(response.anotacoes);
                } else {
                    let section = document.getElementById("listaDeAnotacoesDoPaciente");
                    let errorDiv = document.createElement('div');
                    errorDiv.className = "anotacoesItem";
                    errorDiv.innerHTML = response.anotacoes || "Nenhuma anotação encontrada.";
                    section.appendChild(errorDiv);
                }

                telaAtual = 1;
                atualizarTela();
                ligarVisibilidadeDasAnotacoes();
            

                // if(response.length){
                    
                //     response.forEach(element => {
                //         let dataAnotacao = document.getElementById("data_da_anotação");
                //         let descricaoAnotacao = document.getElementById("descricao");

                //         console.log("data da anotação", element.anotacoes[0].anotacao);

                //         dataAnotacao.innerHTML = element.anotacoes[0].anotacao;
                //         descricaoAnotacao.innerHTML = element.anotacoes[0].diaDaAnotacao;
    
                //     });
                
                // }else{
                //     let dataAnotacao = document.getElementById("data_da_anotação");
                //     let descricaoAnotacao = document.getElementById("descricao");

                //     console.log("data da anotação", response.anotacoes[0].anotacao);

                //     dataAnotacao.innerHTML = response.anotacoes[0].anotacao;
                //     descricaoAnotacao.innerHTML = response.anotacoes[0].diaDaAnotacao;
                    
                //     console.log(response.atividades);

                //     showListaDeAtividadesPaciente(response.atividades)
                //     // response.atividades.forEach(element => {
                //     //     console.log(element.titulo, element.descricao);
                //     // });
                // }
            
            },
            error: function(xhr, status, error) {
                console.error('dadosPacientes AJAX error:', status, error);
                console.error(xhr.responseText);
                let section = document.getElementById("listaDeAnotacoesDoPaciente");
                if (section) {
                    section.innerHTML = '<div class="anotacoesItem">Erro ao carregar dados do paciente.</div>';
                }
            }
    });
}

function showListaDeAtividadesPaciente(array){
    let section = document.getElementById("listaDeAtividadesDoPaciente");

    array.forEach(element => {
        let divNovoItem = document.createElement('div');
        divNovoItem.className = "atividadeItem";

        let titulo = document.createElement("p");
        titulo.className = "tituloDaAtividadePaciente";
        titulo.innerHTML = "TITULO:" + element['titulo'];

        let descricao = document.createElement("p");
        descricao.className = "descricaoDaAtividadePaciente";
        descricao.innerHTML = "DESCRIÇÃO:" + element['descricao'];

        divNovoItem.appendChild(titulo)
        divNovoItem.appendChild(descricao)
        section.appendChild(divNovoItem)

    });

    showPacienteSelecionado(array[0]['nome'])
}

function showListaDeAnotacoesPaciente(array){

    let section = document.getElementById("listaDeAnotacoesDoPaciente");

    array.forEach(element => {
        let divNovoItem = document.createElement('div');
        divNovoItem.className = "anotacoesItem";

        let dataDaAnotacao = document.createElement("p");
        dataDaAnotacao.className = "dataDaAnotacaoPaciente";
        dataDaAnotacao.innerHTML = "DATA: " + element['diaDaAnotacao'];

        let descricao = document.createElement("p");
        descricao.className = "descricaoDaAtividadePaciente";
        descricao.innerHTML = "DESCRIÇÃO: " + element['anotacao'];

        let img = document.createElement("img");
        img.src = "../../../image/flag.png";

        let flag = document.createElement("div");
        flag.className = "flag";

        flag.appendChild(img);

        if(element['color']){
            flag.style.backgroundColor = element['color'];
        }else{
            flag.style.backgroundColor = "transparent";
        }

        let redirect = document.createElement('button');
        redirect.className = "redirectParaAnotacao";
        redirect.innerHTML = "Fazer observação";

        let newNotePk = document.getElementById("pkPaciente");
        newNotePk.value = element['pkPaciente'];

        redirect.onclick = () => {
            window.location.href = '../psicologos/notasPsicologo.php?pkAnotacaoPaciente='+element["pkAnotacaoPaciente"];
        };

        divNovoItem.appendChild(dataDaAnotacao)
        divNovoItem.appendChild(descricao)
        divNovoItem.appendChild(flag)
        divNovoItem.appendChild(redirect)
        section.appendChild(divNovoItem)

        showPacienteSelecionado(array[0]['nome'])

    });
}


// function paginaDeCriarAnotação(pkAnotacaoPaciente) {
//     window.location.href = '../telas/psicologos/notasPsicologo'
// }

function ligarVisibilidadeDasAtividades(){
    let section = document.getElementById("listaDeAtividadesDoPaciente");
    section.removeAttribute("hidden");
}

function hiddenListaDeAtividades(){
    let section = document.getElementById("listaDeAtividadesDoPaciente");
    section.hidden = true
}

function ligarVisibilidadeDasAnotacoes(){
    let section = document.getElementById("listaDeAnotacoesDoPaciente");
    section.removeAttribute("hidden");
}

function hiddenListaDeAnotacoes(){
    let section = document.getElementById("listaDeAnotacoesDoPaciente");
    section.hidden = true
}

function showPacienteSelecionado(nome){
    let paciente_selecionado = document.getElementById("nome_selecionado");
    let paciente_selecionado_anotacao = document.getElementById("nome_selecionado_anotacao");

    paciente_selecionado.value = nome;
    paciente_selecionado_anotacao.value = nome;
}