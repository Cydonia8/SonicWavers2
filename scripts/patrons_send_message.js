"use strict"

const new_msg_modal = document.querySelector(".patrons-new-message-modal")
const btns_open_modal = document.querySelectorAll("button.open-message-modal")
const containers_artist = document.querySelectorAll(".disc-artist-detalle");
const search = document.querySelector(".busqueda-dinamica-disc")
const close_modal = document.querySelector(".close-message-patron-modal")

let array = Array.from(containers_artist)
search.addEventListener("keyup", ()=>{
    let value = search.value.toLowerCase()
    // let result = array.filter(div=>div.dataset.name.includes(value))
    // console.log(result)
    containers_artist.forEach(artist=>{
        let attribute = artist.getAttribute("data-name").toLowerCase()
        if(!attribute.includes(value)){
            // artist.style.visibility="hidden"
            artist.classList.remove("d-flex")
            artist.classList.add("d-none")
        }else{
            // artist.style.visibility="visible"
            artist.classList.add("d-flex")
            artist.classList.remove("d-none")
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


