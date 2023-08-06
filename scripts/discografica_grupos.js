"use strict"

 const containers_grupos = document.querySelectorAll(".disc-grupo-detalle");
 const busqueda = document.querySelector(".busqueda-dinamica-disc")
//  const h2s = document.querySelectorAll(".admin-grupos-selector h2");
let array = Array.from(containers_grupos)
busqueda.addEventListener("keyup", ()=>{
    let valor = busqueda.value.toLowerCase()
    // let result = array.filter(div=>div.dataset.name.includes(valor))
    // console.log(result)
    containers_grupos.forEach(grupo=>{
        let atributo = grupo.getAttribute("data-name").toLowerCase()
        if(!atributo.includes(valor)){
            // grupo.style.visibility="hidden"
            grupo.classList.remove("d-flex")
            grupo.classList.add("d-none")
        }else{
            // grupo.style.visibility="visible"
            grupo.classList.add("d-flex")
            grupo.classList.remove("d-none")
        }
    })
})


//  h2s.forEach(titulo=>{
//     titulo.addEventListener("click", (evento)=>{
//         const pulsado = evento.target
//         let data = pulsado.getAttribute("data-type")
//         if(!titulo.classList.contains("tipo-activo")){
//             h2s.forEach(titulo => titulo.classList.remove("tipo-activo"))
//             titulo.classList.add("tipo-activo");
//         }
//         containers_grupos.forEach(container =>{
//             if(container.getAttribute("data-section") == data){
//                 container.classList.add("container-activo")
//             }else{
//                 container.classList.remove("container-activo")
//             }
//         })
//     })
//  })