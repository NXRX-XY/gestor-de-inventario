function RegisterName () {
    let x = document.forms["myform"]["nname"];
    if (x == ""){
        alert("Debe ingresar un nombre");
        return false;
    }
}

function RegisterLName () {
    let x = document.forms["myLName"]["fname"]
    if (x == ""){
        alert("Debe ingresar un apellido");
        return false;
    }
}

function RegisterEmail () {
    let x = document.forms["myEmail"]["email"]
    if (x == ""){
        alert("Debe ingresar un email");
        return false;
    }
}

function RegisterGender () {
    let x = document.forms["myEmail"]["gender"]
    if (x == ""){
        alert("Debe ingresar un email");
        return false;
    }
}

function RegisterGender () {
    let x = document.forms["myEmail"]["password"]
    if (x == ""){
        alert("Debe ingresar una contraseña");
        return false;
    }
}