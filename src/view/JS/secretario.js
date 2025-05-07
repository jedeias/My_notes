$(document).ready(function () {

    // Abrir o menu lateral
    function openNav() {
        $('#mySidenav').css('width', '350px');
    }

    // Fechar o menu lateral
    function closeNav() {
        $('#mySidenav').css('width', '0');
    }

    // Abrir modal
    function openModal(modalId) {
        $(`#${modalId}`).fadeIn();
    }

    // Fechar modal
    function closeModal(modalId) {
        $(`#${modalId}`).fadeOut();
    }

    // Alternar exibição da seção de consultas
    function toggleConsultas() {
        $('#consultasSection').fadeIn();
        $('.buttons').hide();
    }

    // Alternar exibição para voltar ao cadastro
    function toggleCadastro() {
        $('#consultasSection').fadeOut(() => {
            $('.buttons').fadeIn();
        });
    }

    // Eventos de clique para abrir e fechar o menu
    $(document).on('click', '#menuBtn', openNav);
    $(document).on('click', '.closebtn', closeNav);

    // Eventos de clique para abrir os modais
    $(document).on('click', '.paci', function () {
        openModal('pacienteModal');
    });

    $(document).on('click', '.psico', function () {
        openModal('psicologoModal');
    });

    // Evento de clique para fechar os modais
    $(document).on('click', '.modal .close', function () {
        const modalId = $(this).closest('.modal').attr('id');
        closeModal(modalId);
    });

    // Fechar modal ao clicar fora dele
    $(document).on('click', function (event) {
        if ($(event.target).hasClass('modal')) {
            const modalId = $(event.target).attr('id');
            closeModal(modalId);
        }
    });

    // Eventos de clique para alternar entre consultas e cadastro
    $(document).on('click', '#consultasBtn', toggleConsultas);
    $(document).on('click', '#cadastrarNovamenteBtn', toggleCadastro);

    let currentPage = 1; // Contador de páginas

    // Função para ir para a próxima página
    function goToNextPage() {
        const notes = $('#notesInput').val(); // Captura as anotações
        $('#notesInput').val(''); // Limpa as anotações da página atual

        currentPage++; // Incrementa o contador de páginas
        $('#pageCounter').text(`Página ${currentPage}`); // Atualiza o contador na interface

        // Exibe as anotações na nova página
        $('#notesDisplay').append(`<div class="page-notes">Página ${currentPage - 1}: ${notes}</div>`);
    }

    // Evento de clique para ir para a próxima página
    $(document).on('click', '#nextPageBtn', goToNextPage);
});