let sectionDadosPessoais = document.createElement('section');
let h2DadosPessoais = document.createElement('h2');
h2DadosPessoais.innerHTML = "Dados pessoais";
sectionDadosPessoais.className = 'dadosPessoais';
sectionDadosPessoais.id = 'dadosPessoais';

sectionDadosPessoais.appendChild(h2DadosPessoais);

let sectionEndereco = document.createElement('section');
let h2Endereco = document.createElement('h2');
h2Endereco.innerHTML = "endereco";
sectionEndereco.className = 'endereco';
sectionEndereco.id = 'endereco';

sectionEndereco.appendChild(h2Endereco)

let sectionTelefones = document.createElement('section');
let h2Telefones = document.createElement('h2');
h2Telefones.innerHTML = "Telefone de contato";
sectionTelefones.className = 'telefones';
sectionTelefones.id = 'telefones';

sectionTelefones.appendChild(h2Telefones);

let formDadosPessoais = document.createElement('form');

formDadosPessoais.method = 'post';
formDadosPessoais.id = 'dadosPessoais';

let enderecoFrom = document.createElement('form');

enderecoFrom.method = 'post';
enderecoFrom.id = 'enderecoFrom';

let telefoneFrom = document.createElement('form');

telefoneFrom.method = 'post';
telefoneFrom.id = 'telefoneFrom';

let body = document.querySelector('body');

sectionDadosPessoais.appendChild(formDadosPessoais);


var enderecos = ['rua', 'numero', 'complemento', 'bairro', 'cep', 'cidade', 'estado'];
var telefones = ['DD', 'contato'];

function createDadosPsicologos(){

    dadosPessoais = ['nome', 'email', 'senha', 'RG', 'CPF', 'CRM'];

    for (let index = 0; index < dadosPessoais.length; index++) {

        let label = document.createElement('label');
        label.textContent = dadosPessoais[index];
        label.setAttribute('for', dadosPessoais[index])
    
        formDadosPessoais.appendChild(label);
    
        let input = document.createElement('input');
        input.className = dadosPessoais[index];
        input.name = dadosPessoais[index];
        input.id = dadosPessoais[index];
    
        formDadosPessoais.appendChild(input);    
    }

    return formDadosPessoais;
}

function createDadosPascientes(){

    dadosPessoais = ['nome', 'email', 'senha', 'RG', 'CPF'];
    
    for (let index = 0; index < dadosPessoais.length; index++) {

        let label = document.createElement('label');
        label.textContent = dadosPessoais[index];
        label.setAttribute('for', dadosPessoais[index]);
        formDadosPessoais.appendChild(label);
        let input = document.createElement('input');
        input.className = dadosPessoais[index];
        input.name = dadosPessoais[index];
        input.id = dadosPessoais[index];
        formDadosPessoais.appendChild(input);    
    }

    return formDadosPessoais;
}

function createEndereco(){
    for (let index = 0; index < enderecos.length; index++) {

        let label = document.createElement('label');
        label.textContent = enderecos[index];
        label.setAttribute('for', enderecos[index])

        enderecoFrom.appendChild(label);

        let input = document.createElement('input');
        input.className = enderecos[index];
        input.name = enderecos[index];
        input.id = enderecos[index];

        enderecoFrom.appendChild(input);    
    }

    return enderecoFrom;
}

function createTelefones(){
    for (let index = 0; index < telefones.length; index++) {

        let label = document.createElement('label');
        label.textContent = telefones[index];
        label.setAttribute('for', telefones[index]);
        telefoneFrom.appendChild(label);
        let input = document.createElement('input');
        input.className = telefones[index];
        input.name = telefones[index];
        input.id = telefones[index];

        telefoneFrom.appendChild(input);    
    }

    return telefoneFrom;
}

function openFormsPacientes(){
    
    let main = document.querySelector(".summerFroms");

    fromExist = document.querySelector('.dadosPessoais');

    if(fromExist ){
        clearForms();
    }
    let telefoneFrom = createTelefones();    
    let enderecoFrom = createEndereco();
    let formDadosPessoais = createDadosPascientes();
    
    sectionTelefones.appendChild(telefoneFrom);
    sectionDadosPessoais.appendChild(formDadosPessoais);
    sectionEndereco.appendChild(enderecoFrom);
    main.appendChild(sectionDadosPessoais);
    main.appendChild(sectionEndereco);
    main.appendChild(sectionTelefones);

}

function openFormsPsicologos(){

    let main = document.querySelector(".summerFroms");

    
    fromExist = document.querySelector('.dadosPessoais');
    
    if(fromExist ){
        clearForms();
    }

    let telefoneFrom = createTelefones();    
    let enderecoFrom = createEndereco();
    let formDadosPessoais = createDadosPsicologos();

    sectionTelefones.appendChild(telefoneFrom);

    sectionDadosPessoais.appendChild(formDadosPessoais);
    sectionEndereco.appendChild(enderecoFrom);

    main.appendChild(sectionDadosPessoais);
    main.appendChild(sectionEndereco);
    main.appendChild(sectionTelefones);

    console.log(formDadosPessoais);

}


function clearForms(){

    window.location.reload();

}