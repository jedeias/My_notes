console.log("Sistema de navegação carregado!");

// Usar um Array é muito melhor e mais limpo que um Objeto com números
const telas = ["agenda", "anotação", "atividadesRecomendadas"];

// Começamos no índice 0 (que equivale a 'agenda' no array)
let telaAtual = 0; 

// Função central que faz o trabalho de mostrar/esconder
function atualizarTela() {
    telas.forEach((classeTela, index) => {
        const elemento = document.querySelector("." + classeTela);
        
        if (!elemento) return; // Proteção: se não achar o elemento, não dá erro
        
        if (index === telaAtual) {
            // Se for o índice atual, mostra a tela
            elemento.removeAttribute("hidden");
        } else {
            // Se não for, esconde
            elemento.setAttribute("hidden", true);
        }
    });
}

// Botão de Próximo
function nextClick() {
    telaAtual += 1;
    
    // Se passar do limite do Array, volta pro índice 0 (primeira tela)
    if (telaAtual >= telas.length) {
        telaAtual = 0;
    }
    
    atualizarTela();
}

// Botão de Voltar
function prevClick() {
    telaAtual -= 1;
    
    // Se voltar antes do 0, vai para a última tela do Array
    if (telaAtual < 0) {
        telaAtual = telas.length - 1;
    }
    
    atualizarTela();
}

// Opcional: Garantir que a tela inicie no estado correto
// atualizarTela();