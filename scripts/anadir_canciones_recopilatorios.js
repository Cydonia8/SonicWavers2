const selects = document.querySelectorAll("select")
const selects_container = document.querySelectorAll(".selects-container li")
const reset = document.querySelector(".reset-form-recopilatorio")
const submit = document.querySelector("ul~button")
const alert_repeated = document.querySelector(".repeated")
console.log(alert_repeated)

// console.log(selects_container.length)
let canciones_escogidas = []
let clickEvent = new Event('click');
let arr = Array.from(selects)
let actual = 1
let longitud = selects_container.length
// console.log(arr[0])

selects.forEach((select, index)=>{
    select.addEventListener("change", (event)=>{
        const pulsado = event.target
        let valor = select.value
        canciones_escogidas.push(valor)
        for(i = index+1; i < longitud; i++){
            let array = Array.from(selects[i])
            let indice = array.find(cancion=>cancion.value==valor)
            indice.style.display="none"
            console.log(indice)
        }
        if(!canciones_escogidas.every(esPrimero)){
            submit.setAttribute("disabled", true)
            setTimeout(()=>{
                location.reload()
                submit.removeAttribute("disabled")
            },2000)
            alert_repeated.classList.remove("d-none")
            
            
            
        }
        
        // console.log(array)
        // let indice = array.find(cancion=>cancion.value==valor)
        // indice.style.display="none"
        // if(canciones_escogidas.includes)
        // mov.forEach(cancion=>{
        //     if(canciones_escogidas.includes(cancion.getAttribute("value"))){
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

submit.addEventListener("click", (evento)=>{
    if(!canciones_escogidas.every(esPrimero)){
        evento.preventDefault()
        window.alert("canciones repetidas")
        canciones_escogidas.length=0
        location.reload()
    }
})

function esPrimero(valor, indice, lista) {
    return (lista.indexOf(valor) === indice);
}