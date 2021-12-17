function desplegaMenuResponsive(){
    if(document.getElementById("barraMenu").style.display=="inline"){
        document.getElementById("barraMenu").style.display = "none";
        document.getElementById("editarPerfil").style.display = "none";
    }else{
        document.getElementById("barraMenu").style.display = "inline";
        document.getElementById("editarPerfil").style.display = "inline";
    }
    
}
