"use strict"

const contenedor=document.getElementById("libro");
const cargando=document.getElementById("cargando");
const otro=document.querySelector(".otro");

inicio();

async function inicio(){
    cargando.style.display="flex";
    const respuesta=await fetch(`https://gutendex.com/books/`);
    const datos=await respuesta.json();

    const array=datos.results;

    const libro=array[Math.floor(Math.random()*array.length)];
    cargar_lista(libro,contenedor,ficha_user);
    cargando.style.display="none";

}
dia_noche.parentElement.style.display="flex";

function cargar_lista(lista,contenedor,creador){
    contenedor.innerHTML="";
    contenedor.appendChild(creador(lista));
}

function ficha_user(l){
    const prod=document.createElement("div");
    let {title,
        authors:[{
            name,
            birth_year,
            death_year
        }],
        formats}=l;

    let formato_imagen;
    let formato_libro;
    for(let i=0; i<Object.keys(formats).length; i++){
        if(Object.keys(formats)[i]=="text/html"){
            formato_libro=Object.values(formats)[i];
        }
        if(Object.keys(formats)[i]=="image/jpeg"){
            formato_imagen=Object.values(formats)[i];
        }
    }

    prod.innerHTML=`
        <h1>${title}</h1>
        <div>
            <img src="${formato_imagen}">
        </div>
        <p><b>Autor:</b> ${name}; ${birth_year}-${death_year}</p>
        <a href="${formato_libro}">Click aquí para leerlo</a>
    `;

    return prod;
}

otro.addEventListener("click",inicio);