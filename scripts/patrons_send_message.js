"use strict"

const new_msg_modal = document.querySelector(".patrons-new-message-modal")
const btns_open_modal = document.querySelectorAll("button.open-message-modal")
const containers_grupos = document.querySelectorAll(".disc-grupo-detalle");
const busqueda = document.querySelector(".busqueda-dinamica-disc")
const close_modal = document.querySelector(".close-message-patron-modal")

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

close_modal.addEventListener("click", ()=>{
    new_msg_modal.classList.add("d-none")
})

btns_open_modal.forEach(btn=>{
    btn.addEventListener("click", (evt)=>{
        if(new_msg_modal.classList.contains("d-none")){
            new_msg_modal.classList.remove("d-none")
            new_msg_modal.children[1].children[1].setAttribute("value",evt.currentTarget.getAttribute("data-id-group"))
        }
    })
})

setTimeout(()=> {
    $(".alert").fadeTo(500, 0).slideUp(500, ()=>{
        $(this).remove(); 
    });
}, 3000);


