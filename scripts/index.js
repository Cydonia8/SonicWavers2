const audios = document.querySelectorAll("audio");
const img = document.querySelectorAll(".cancion-prev .img-fluid")
const button_menu = document.querySelector(".button-menu-responsive")
const header = document.querySelector("header")
const audio_index = document.querySelectorAll(".audio-index")
const play_index = document.querySelectorAll(".play-simbol")
const inputs = document.querySelectorAll(".timebar-container input")

play_index.forEach(play=>{
    play.addEventListener("click", (evt)=>{
        const id = evt.target.getAttribute("data-audio")
        audio_index.forEach(audio=>{
            let limite = (audio.duration/2) + 15
            inputs.forEach(input=>{
                input.setAttribute("max", limite)
                input.setAttribute("min", audio.duration/2)
            })
            const id_audio = audio.getAttribute("data-audio")
            if(id === id_audio){
                audio.currentTime = audio.duration/2
                
                if(audio.paused){
                    audio.play()
                    play.setAttribute("name", "pause-circle-outline")
                }else{
                    audio.pause()
                    play.setAttribute("name", "play-circle-outline")
                }
                const inp = document.querySelector(`div.bar2.${id_audio}`)
                console.log(inp)
                let width=0
                audio.addEventListener("timeupdate", ()=>{
                    inp.style.width=`${width}%`
                    if(audio.currentTime >= limite){
                        audio.pause()
                        play.setAttribute("name", "play-circle-outline")
                        inp.style.width='0'
                    }
                    width+=1.76
                })
                
            }
        })
    })
})
// audio_index.forEach(audio=>{
//     let limite = (audio.duration/2) + 15
//     audio.addEventListener("timeupdate", ()=>{
//         console.log(audio.currentTime)
//         if(audio.currentTime >= limite){
//             audio.pause()
//         }
//     })
// })



// const height = img.clientHeight
// const width = img.clientWidth

button_menu.addEventListener("click", ()=>{
    if(header.classList.contains("header-mobile")){
        header.classList.remove("header-mobile")
    }else{
        header.classList.add("header-mobile")
    }
})

img.forEach(imagen => {
    let height = imagen.clientHeight
    let width = imagen.clientWidth
    imagen.addEventListener("mousemove", (evento) => {
        const {layerX, layerY} = evento
    
        const yRotation = ((layerX - width / 2) / width) * 20
        const xRotation = ((layerY - height / 2) / height) * 20
    
        const string = `perspective(500px)
                        scale(1.05)
                        rotateX(${xRotation}deg) 
                        rotateY(${yRotation}deg)`
        imagen.style.transform = string
    })

    imagen.addEventListener("mouseout", () => {
        imagen.style.transform = `
        perspective(0px)
        scale(1)
        rotateX(0deg)
        rotateY(0deg)
        `
    })
})

// audios.forEach((audio) => {
//     let start = 30
//     audio.currentTime=start
//     audio.addEventListener("timeupdate", (e) => {
//         let currentTime = e.target.currentTime
//         if (currentTime > start + 15){
//             audio.pause()
//         }
//     })
// })
