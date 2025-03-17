function openNav() {
    document.getElementById("mySidenav").style.width = "300px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

function updateClock() {
    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds();

    if (hours < 10) {
        hours = "0" + hours;
    }

    if (minutes < 10) {
        minutes = "0" + minutes;
    }

    if (seconds < 10) {
        seconds = "0" + seconds;
    }

    document.querySelector('.notepad-clock').innerHTML = hours + ":" + minutes + ":" + seconds;
}

function UpdateDate(){
    let now = new Date();
    let day = now.getDate();
    let month = now.getMonth() + 1;
    let year = now.getFullYear();

    if (day < 10) {
        day = "0" + day;
    }

    if (month < 10) {
        month = "0" + month;
    }

    document.querySelector('.notepad-date').innerHTML = day + "/" + month + "/" + year;
}

setInterval(updateClock, 1000);
updateClock(); // Inicializa o relógio imediatamente
UpdateDate(); // Inicializa a data imediatamente