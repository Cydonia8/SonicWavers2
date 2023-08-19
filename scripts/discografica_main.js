"use strict"
const section_update_avatar = document.querySelector(".update-avatar-photo")
const avatar_group = document.querySelector(".avatar-discografica-editable")
const edit_avatar = document.querySelector(".icon-edit-avatar-discografica")
const close_modal = document.querySelector(".close-modal-update-avatar")

avatar_group.addEventListener("mouseenter", ()=>{
    edit_avatar.classList.remove("d-none")
})
avatar_group.addEventListener("mouseleave", ()=>{
    edit_avatar.classList.add("d-none")
})

avatar_group.addEventListener("click", (evt)=>{
    evt.preventDefault()
    section_update_avatar.classList.add("d-flex")
    section_update_avatar.classList.remove("d-none")
})

close_modal.addEventListener("click", ()=>{
    section_update_avatar.classList.remove("d-flex")
    section_update_avatar.classList.add("d-none")
})

setTimeout(()=> {
    $(".alert").fadeTo(500, 0).slideUp(500, ()=>{
        $(this).remove(); 
    });
}, 3000);