"use strict"
const btn = document.getElementById("btn-add-photos")
const modal = document.querySelector(".modal-añadir-fotos-publi")
const input_date = document.querySelector("input[type=date]")
const close_modal = document.querySelector(".close-modal-photos-post")

let fecha = new Date()
let anio = fecha.getFullYear()
let mes = cerosFecha(fecha.getMonth()+1)
let dia = cerosFecha(fecha.getDate())
let fecha_actual = `${anio}-${mes}-${dia}`

input_date.setAttribute("min", fecha_actual)

btn.addEventListener("click", ()=>{
    modal.classList.remove("d-none")
    modal.classList.add("d-flex")
})
close_modal.addEventListener("click", ()=>{
    modal.classList.remove("d-flex")
    modal.classList.add("d-none")
})

function cerosFecha(fecha){
    return fecha < 10 ? `0${fecha}` : fecha
}

setTimeout(()=> {
    $(".alert").fadeTo(500, 0).slideUp(500, ()=>{
        $(this).remove(); 
    });
}, 3000);