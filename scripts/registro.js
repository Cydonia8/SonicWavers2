"use strict"

const login_picker = document.querySelectorAll(".form-option-picker h3")
const forms = document.querySelectorAll(".forms-container form")
const view_pass = document.querySelectorAll(".view-pass")

document.body.style.backgroundImage = "url('../media/assets/register_bg1.jpg')"
// const boton_registro_grupo = document.getElementById("boton-registro-grupo")

// boton_registro_grupo.addEventListener("click", (event)=>{
//     const valor = event.target.dataset.form
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
login_picker.forEach(title =>{
    title.addEventListener("click", changeFormContext)
        // const pressed = event.target
        // let data_form = pressed.getAttribute("data-form-title")
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
        // if(!pressed.classList.contains("active")){
        //     login_picker.forEach(title => title.classList.remove("active"))
        //     pressed.classList.add("active")
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

function changePasswordInput(event){
    const pressed = event.target
        if(pressed.getAttribute("name") == "eye-outline"){
            pressed.setAttribute("name", "eye-off-outline")
            pressed.previousElementSibling.type = "text"
        }else{
            pressed.setAttribute("name", "eye-outline")
            pressed.previousElementSibling.type = "password"
        }
}

function changeFormContext(event){
    const pressed = event.target
    let data_form = pressed.getAttribute("data-form-title")
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
    if(!pressed.classList.contains("active")){
        login_picker.forEach(title => title.classList.remove("active"))
        pressed.classList.add("active")
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