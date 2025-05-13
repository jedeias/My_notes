let quantidadeDeElementosNoArrayAnotacoes = document.getElementById('quantidadeDeAnotacoes');
let jsonAnotacoes = document.getElementById('jsonDeAnotacoes');
let dados = JSON.parse(jsonAnotacoes.value);
let timerUltimaAnotacao = document.getElementById('digital-clock');
let diaDoAno = document.getElementById('digital-date');
let pointer = document.getElementById('notepad-count').innerHTML;
let quantidadeDeAnotacoes = document.getElementById('quantidadeDeAnotacoes').innerHTML;
var valorAtual = 0;

// console.log(quantidadeDeElementosNoArrayAnotacoes.getAttribute('values'));
console.log("tamanho de dados"+[valorAtual], dados.length);

console.log("ponteiro é >_:", pointer.split('/')[0]);

let textArea = document.getElementById('textarea');
textArea.value = dados[valorAtual].anotacao;

function nextNote(){
    if(valorAtual < dados.length){
        valorAtual++;
        textArea.value = dados[valorAtual].anotacao;
    }else if(dados.length[valorAtual] == undefined){
        valorAtual++;
        textArea.value = "insira uma nova anotação";
    }
    console.log(dados[valorAtual]);
}

function prevNote(){
    if(valorAtual > dados.length){
        valorAtual--;
        textArea.value = dados[valorAtual].anotacao;
    }else if(dados.length[valorAtual] == undefined){
        valorAtual = 0;
        textArea.value = dados[valorAtual].anotacao;
    }

    console.log(dados[valorAtual]);
}
