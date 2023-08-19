const section = document.querySelector("section")
let img = section.getAttribute("data-foto")
// section.style.backgroundImage=`url('${foto}')`
// section.style.height='50vh'
// section.style.backgroundPosition="top"
// section.style.backgroundSize="cover"

setTimeout(()=> {
    $(".alert").fadeTo(500, 0).slideUp(500, ()=>{
        $(this).remove(); 
    });
}, 3000);