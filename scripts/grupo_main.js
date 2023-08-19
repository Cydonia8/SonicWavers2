"use strict"
const section_form = document.querySelector(".form-group-completition")
const btn_complete_data = document.querySelector(".btn-completar-info-inicial")
const section_group = document.querySelector(".banner-group-main")
const edit_avatar  = document.querySelector(".icon-edit-avatar-group")
const avatar_group = document.querySelector(".banner-group-main-avatar-link")
const close_modal = document.querySelector(".close-modal-update-avatar")
const section_update_avatar = document.querySelector(".update-avatar-photo")
const edit_photo = document.querySelector(".banner-group-main-photo-link")
const section_update_photo = document.querySelector(".update-main-photo")
const close_modal_update_photo = document.querySelector(".close-modal-update-main-photo")
const edit_bio = document.getElementById("edit-biografia-grupo")
const bio = document.querySelector("textarea")
const edit_data = document.getElementById("edit-datos-grupo")
const submit_bio = document.getElementsByName("actualizar-bio")
const submit_data = document.querySelector(".actualizar-datos-submit")
const input_data = document.querySelectorAll(".form-edit-datos-grupo input:not([type=submit]):not(.pass-original)")


edit_bio.addEventListener("click", ()=>{
    if(bio.hasAttribute("disabled")){
        bio.removeAttribute("disabled")
        submit_bio.forEach(sub=>sub.removeAttribute("hidden"))
    }else{
        bio.setAttribute("disabled", true)
        submit_bio.forEach(sub=>sub.setAttribute("hidden", true))
    }
    
})

edit_data.addEventListener("click", ()=>{
    input_data.forEach(input=>{
        if(input.hasAttribute("disabled")){
            input.removeAttribute("disabled")
        }else{
            input.setAttribute("disabled", true)
        }
    })
    if(submit_data.hasAttribute("hidden")){
        submit_data.removeAttribute("hidden")
    }else{
        submit_data.setAttribute("hidden", true)
    }
})


let bg = section_group.getAttribute("data-bg")
// section_group.style.height="70vh"
section_group.style.backgroundImage=`url('${bg}')`
section_group.style.backgroundSize="cover"
// btn_complete_data.addEventListener("click", () => {
//     section_form.classList.add("hide")
// })

avatar_group.addEventListener("mouseenter", ()=>{
    edit_avatar.classList.remove("d-none")
})
avatar_group.addEventListener("mouseleave", ()=>{
    edit_avatar.classList.add("d-none")
})
avatar_group.addEventListener("click", (event)=>{
    event.preventDefault()
    section_update_avatar.classList.add("d-flex")
    section_update_avatar.classList.remove("d-none")
})
edit_photo.addEventListener("click", ()=>{
    section_update_photo.classList.add("d-flex")
    section_update_photo.classList.remove("d-none")
})

close_modal.addEventListener("click", ()=>{
    section_update_avatar.classList.remove("d-flex")
    section_update_avatar.classList.add("d-none")
})

close_modal_update_photo.addEventListener("click", ()=>{
    section_update_photo.classList.remove("d-flex")
    section_update_photo.classList.add("d-none")
})

setTimeout(()=> {
    $(".alert").fadeTo(500, 0).slideUp(500, ()=>{
        $(this).remove(); 
    });
}, 3000);