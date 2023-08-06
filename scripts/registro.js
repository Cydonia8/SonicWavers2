"use strict"

const login_picker = document.querySelectorAll(".form-option-picker h3")
const forms = document.querySelectorAll(".forms-container form")
const view_pass = document.querySelectorAll(".view-pass")

document.body.style.backgroundImage = "url('../media/assets/register_bg1.jpg')"
// const boton_registro_grupo = document.getElementById("boton-registro-grupo")

// boton_registro_grupo.addEventListener("click", (evento)=>{
//     const valor = evento.target.dataset.form
//     console.log(valor)
//     login_picker.forEach(element => {
//         console.log(element.getAttribute("data-form-title"))
//         if(element.getAttribute("data-form-title") == valor){
//             element.classList.add("active")
//         }else{
//             element.classList.remove("active")
//         }
//     })
// })

let last_form = JSON.parse(localStorage.getItem("user_data") ?? "[]")
if(last_form.length != 0){
    console.log(last_form)
    rememberFormContext()
    // switch(last_form.load_form){
    //     case "group":
    //         document.body.style.backgroundImage = "url('../media/assets/register_bg2.0.jpg')"
    //         break
    //     case "user":
    //         document.body.style.backgroundImage = "url('../media/assets/register_bg1.jpg')"
    //         break
    //     case "disc":
    //         document.body.style.backgroundImage = "url('../media/assets/register_bg3.jpg')"
    //         break
    // }
    // login_picker.forEach(element => {
    //     if(element.getAttribute("data-form-title") == last_form.load_form){
    //         element.classList.add("active")
    //     }else{
    //         element.classList.remove("active")
    //     }
    // })
    // forms.forEach(form => {
    //     if(form.getAttribute("data-form") == last_form.load_form){
    //         form.classList.add("active-form")
    //     }else{
    //         form.classList.remove("active-form")
    //     }
    // })
}
login_picker.forEach(titulo =>{
    titulo.addEventListener("click", changeFormContext)
        // const pulsado = evento.target
        // let data_form = pulsado.getAttribute("data-form-title")
        // let load_form = {load_form: data_form}
        // localStorage.setItem("last_form", JSON.stringify(load_form))
        // switch(data_form){
        //     case "group":
        //         document.body.style.backgroundImage = "url('../media/assets/register_bg2.0.jpg')"
        //         break
        //     case "user":
        //         document.body.style.backgroundImage = "url('../media/assets/register_bg1.jpg')"
        //         break
        //     case "disc":
        //         document.body.style.backgroundImage = "url('../media/assets/register_bg3.jpg')"
        //         break
        // }
        // if(!pulsado.classList.contains("active")){
        //     login_picker.forEach(titulo => titulo.classList.remove("active"))
        //     pulsado.classList.add("active")
        // }
        // forms.forEach(form => {
        //     if(form.getAttribute("data-form") == data_form){
        //         forms.forEach(form => form.classList.remove("active-form"))
        //         form.classList.add("active-form")
        //     }
        // })
    
})

view_pass.forEach(element =>{
    element.addEventListener("click", changePasswordInput)
})

function changePasswordInput(evento){
    const pulsado = evento.target
        if(pulsado.getAttribute("name") == "eye-outline"){
            pulsado.setAttribute("name", "eye-off-outline")
            pulsado.previousElementSibling.type = "text"
        }else{
            pulsado.setAttribute("name", "eye-outline")
            pulsado.previousElementSibling.type = "password"
        }
}

function changeFormContext(eventos){
    const pulsado = eventos.target
    let data_form = pulsado.getAttribute("data-form-title")
    let load_form = {load_form: data_form}
    localStorage.setItem("user_data", JSON.stringify(load_form))
    switch(data_form){
        case "group":
            document.body.style.backgroundImage = "url('../media/assets/register_bg2.0.jpg')"
            break
        case "user":
            document.body.style.backgroundImage = "url('../media/assets/register_bg1.jpg')"
            break
        case "disc":
            document.body.style.backgroundImage = "url('../media/assets/register_bg3.jpg')"
            break
    }
    if(!pulsado.classList.contains("active")){
        login_picker.forEach(titulo => titulo.classList.remove("active"))
        pulsado.classList.add("active")
    }
    forms.forEach(form => {
        if(form.getAttribute("data-form") == data_form){
            forms.forEach(form => form.classList.remove("active-form"))
            form.classList.add("active-form")
        }
    })
}

function rememberFormContext(){
    switch(last_form.load_form){
        case "group":
            document.body.style.backgroundImage = "url('../media/assets/register_bg2.0.jpg')"
            break
        case "user":
            document.body.style.backgroundImage = "url('../media/assets/register_bg1.jpg')"
            break
        case "disc":
            document.body.style.backgroundImage = "url('../media/assets/register_bg3.jpg')"
            break
    }
    login_picker.forEach(element => {
        if(element.getAttribute("data-form-title") == last_form.load_form){
            element.classList.add("active")
        }else{
            element.classList.remove("active")
        }
    })
    forms.forEach(form => {
        if(form.getAttribute("data-form") == last_form.load_form){
            form.classList.add("active-form")
        }else{
            form.classList.remove("active-form")
        }
    })
}

const removeAlerts = setTimeout(()=> {
    $(".alert").fadeTo(500, 0).slideUp(500, ()=>{
        $(this).remove(); 
    });
}, 3000);