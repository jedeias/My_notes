console.log("Funcionado");

let fousPage = 0;

let hashMap = {
    0: "null", 
    1: "anotação",
    2: "agenda",
    3: "atividadesRecomendadas"
}

function nextClick() {
    fousPage += 1;

    for(let key in hashMap){
        elemento = document.querySelector("." + hashMap[key]);

        console.log(elemento);

        if (key != fousPage) {
            elemento = document.querySelector("." + hashMap[key]);
            elemento.setAttribute("hidden", true);

            console.log(elemento)
        }

    }

    if(fousPage > 3){
        fousPage = 1;
    }

    elemento = document.querySelector("." + hashMap[fousPage])
    elemento.removeAttribute("hidden")

}

let currentPaciente = 0;

function nextPaciente() {
    const pacientes = document.querySelectorAll(".paciente-card");
    pacientes[currentPaciente].setAttribute("hidden", true);

    currentPaciente = (currentPaciente + 1) % pacientes.length;

    pacientes[currentPaciente].removeAttribute("hidden");
}

function prevClick() {
    fousPage -= 1;

    for(let key in hashMap){
        elemento = document.querySelector("." + hashMap[key]);

        console.log(elemento);

        if (key != fousPage) {
            elemento = document.querySelector("." + hashMap[key]);
            elemento.setAttribute("hidden", true);

            console.log(elemento)
        }

    }

    if(fousPage < 1){
        fousPage = 3;
    }

    elemento = document.querySelector("." + hashMap[fousPage])
    elemento.removeAttribute("hidden")

}

function toggleCard(card) {
    const details = card.querySelector(".paciente-details");
    if (details.hasAttribute("hidden")) {
        details.removeAttribute("hidden");
        card.classList.add("expanded");
    } else {
        details.setAttribute("hidden", true);
        card.classList.remove("expanded");
    }
}