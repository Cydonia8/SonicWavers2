"use strict"
const btn = document.getElementById("btn-add-photos")
const modal = document.querySelector(".modal-añadir-fotos-publi")
const input_date = document.querySelector("input[type=date]")
const close_modal = document.querySelector(".close-modal-photos-post")

let date = new Date()
let year = date.getFullYear()
let month = addZerosToDate(date.getMonth()+1)
let day = addZerosToDate(date.getDate())
let current_date = `${year}-${month}-${day}`

input_date.setAttribute("min", current_date)

btn.addEventListener("click", ()=>{
    modal.classList.remove("d-none")
    modal.classList.add("d-flex")
})
close_modal.addEventListener("click", ()=>{
    modal.classList.remove("d-flex")
    modal.classList.add("d-none")
})

function addZerosToDate(date){
    return date < 10 ? `0${date}` : date
}

setTimeout(()=> {
    $(".alert").fadeTo(500, 0).slideUp(500, ()=>{
        $(this).remove(); 
    });
}, 3000);