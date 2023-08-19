const selects = document.querySelectorAll("select")
const selects_container = document.querySelectorAll(".selects-container li")
const reset = document.querySelector(".reset-form-recopilatorio")
const submit = document.querySelector("ul~button")
const alert_repeated = document.querySelector(".repeated")


// console.log(selects_container.length)
let chosen_songs = []
let clickEvent = new Event('click');
let arr = Array.from(selects)
let current = 1
let length = selects_container.length
// console.log(arr[0])

selects.forEach((select, index)=>{
    select.addEventListener("change", (event)=>{
        const clicked = event.target
        let value = select.value
        chosen_songs.push(value)
        for(i = index+1; i < length; i++){
            let array = Array.from(selects[i])
            let index = array.find(cancion=>cancion.value==value)
            index.style.display="none"

        }
        if(!chosen_songs.every(isFirst)){
            submit.setAttribute("disabled", true)
            setTimeout(()=>{
                location.reload()
                submit.removeAttribute("disabled")
            },2000)
            alert_repeated.classList.remove("d-none")
            
            
            
        }
        
        // console.log(array)
        // let index = array.find(cancion=>cancion.value==value)
        // index.style.display="none"
        // if(chosen_songs.includes)
        // mov.forEach(cancion=>{
        //     if(chosen_songs.includes(cancion.getAttribute("value"))){
        //         cancion.remove()
        //     }
        // })
    })
})

reset.addEventListener("click", ()=>{
    // selects.forEach(select=>{
    //     select.children[0].removeAttribute("hidden")
    //     select.dispatchEvent(clickEvent)
    //     console.log(select.children[0])
    //     for(opt of select){
    //         opt.style.display="block"
    //     }
    // })
    location.reload()
})

submit.addEventListener("click", (event)=>{
    if(!chosen_songs.every(isFirst)){
        event.preventDefault()
        window.alert("canciones repetidas")
        chosen_songs.length=0
        location.reload()
    }
})

function isFirst(value, index, list) {
    return (list.indexOf(value) === index);
}