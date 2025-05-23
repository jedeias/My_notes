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

function prevClick() {

    if(fousPage > 1){
        fousPage -= 1;
    }else{
        fousPage = 3;
    }
    for(let key in hashMap){
        elemento = document.querySelector("." + hashMap[key]);

        console.log(elemento);

        if (key != fousPage) {
            elemento = document.querySelector("." + hashMap[key]);
            elemento.setAttribute("hidden", true);

            console.log(elemento)
        }

    }
    elemento = document.querySelector("." + hashMap[fousPage])
    elemento.removeAttribute("hidden")

}



