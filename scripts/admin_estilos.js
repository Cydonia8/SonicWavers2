"use strict"

const btn_form = document.getElementById("abrir-form-estilo")
const cerrar_form = document.getElementById("close-form-add-style")
const form_estilo = document.querySelector(".modal-form-estilo")

btn_form.addEventListener("click", ()=>{
    form_estilo.style.display="flex"
})

cerrar_form.addEventListener("click", ()=>{
    form_estilo.style.display="none"
})
