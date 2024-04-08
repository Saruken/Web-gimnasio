"use strict"

let bd_noticias=[];
const contenedor_noticias=document.getElementById("noticiero");
const siguiente=document.getElementById("siguiente");
const anterior=document.getElementById("anterior");
const cargando=document.getElementById("cargando");

siguiente.addEventListener("click",paginar);
anterior.addEventListener("click",paginar);

function paginar(eventos){
    eventos.preventDefault();
    generar(eventos.target.parentElement.href);
}

generar("../../noticiasLista.php");

async function generar(api){
    cargando.style.display="flex";
    // CONEXION
    const respuesta=await fetch(api);
    const datos=await respuesta.json();
    
    bd_noticias=datos["datos"];
    
    // PAGINAS
    if(datos["siguiente"]!=="null"){
        siguiente.setAttribute("href","http://"+datos["siguiente"]);
        siguiente.style.display="inline";
    }else{
        siguiente.setAttribute("href","");
        siguiente.style.display="none";
    }
    
    if(datos["anterior"]!=="null"){
        anterior.setAttribute("href","http://"+datos["anterior"]);
        anterior.style.display="inline";
    }else{
        anterior.style.display="none";
        anterior.setAttribute("href","");
    }
    
    cargar_lista(bd_noticias,contenedor_noticias,ficha_noti);
    cargando.style.display="none";
}

function cargar_lista(lista,contenedor,creador){
    contenedor.innerHTML="";
    lista.forEach((p)=>{
        const elemento=creador(p);
        contenedor.appendChild(elemento);
    });
}

function ficha_noti(n){
    const prod=document.createElement("div");
    let cont=n.contenido;
    if(cont.length>850){
        cont=cont.slice(0,850)+"...";
    }

    prod.innerHTML=`
    <div class='noticia_lista'>
        <img src='../../${n.imagen}' alt=''>
        <div>
            <div class='cabecera_noticia'>
                <p>${n.titulo}</p>
                <p>${n.fecha_publicacion}</p>
            </div>
            <p class="text-truncate">${cont}</p>
            <a href='mostrar_noticia.php?id=${n.id}'>Mas info</a>
        </div>
    </div>`;

    return prod;
}