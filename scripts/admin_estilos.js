"use strict"

const btn_form = document.getElementById("abrir-form-estilo")
const close_form = document.getElementById("close-form-add-style")
const form_style = document.querySelector(".modal-form-estilo")

btn_form.addEventListener("click", ()=>{
    form_style.style.display="flex"
})

close_form.addEventListener("click", ()=>{
    form_style.style.display="none"
})
