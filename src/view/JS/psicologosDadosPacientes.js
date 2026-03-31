function dadosPacientes(pk){
    $.ajax({
            url: '../../../../Controllers/ajaxRequests/dadosPacientes.php',
            method: 'POST',
            dataType: 'json',
            data: {
                'pk': pk,
            },
            success:function(response){
                
                console.log(response.anotacoes);

                let itensAtividades = document.getElementsByClassName("atividadeItem");
                while (itensAtividades.length > 0) {
                    itensAtividades[0].remove();
                }

                let itensAnotacoes = document.getElementsByClassName("anotacoesItem");
                while (itensAnotacoes.length > 0) {
                    itensAnotacoes[0].remove();
                }

                showListaDeAtividadesPaciente(response.atividades);
                showListaDeAnotacoesPaciente(response.anotacoes);
            

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
        descricao.descricaoDaAtividadePaciente = "tituloDaAtividadePaciente";
        descricao.innerHTML = "DESCRIÇÃO:" + element['descricao'];

        divNovoItem.appendChild(titulo)
        divNovoItem.appendChild(descricao)
        section.appendChild(divNovoItem)

    });
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
        descricao.descricaoDaAtividadePaciente = "tituloDaAtividadePaciente";
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