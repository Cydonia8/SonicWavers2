"use strict"

 const containers_artists = document.querySelectorAll(".grupo-detalle");
 const search = document.querySelector(".busqueda-dinamica-admin")
//  const h2s = document.querySelectorAll(".admin-grupos-selector h2");
let array = Array.from(containers_artists)

if(search !== null){
    search.addEventListener("keyup", ()=>{
        let value = search.value.toLowerCase()
        // let result = array.filter(div=>div.dataset.name.includes(value))
        // console.log(result)
        containers_artists.forEach(grupo=>{
            let attribute = grupo.getAttribute("data-name").toLowerCase()

            if(!attribute.includes(value)){
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
}

