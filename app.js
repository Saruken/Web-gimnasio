"use strict"

const dia_noche=document.getElementById("dia_noche");

dia_noche.addEventListener("click",()=>{
    if(document.body.classList.contains("modo_noche")){
        document.body.classList.remove("modo_noche");
        dia_noche.innerHTML="<i class='fa-solid fa-sun dia'></i>";
    }else{
        document.body.classList.add("modo_noche");  
        dia_noche.innerHTML="<i class='fa-solid fa-moon noche'></i>";
    }
    localStorage.setItem("modo",JSON.stringify(document.body.classList.contains("modo_noche")));
})

let modo=JSON.parse(localStorage.getItem("modo")??"[]");
if(modo){
    document.body.classList.add("modo_noche");
    dia_noche.innerHTML="<i class='fa-solid fa-moon noche'></i>";
}else{
    dia_noche.innerHTML="<i class='fa-solid fa-sun dia'></i></i>";
}