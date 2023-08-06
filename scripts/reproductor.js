"use strict"
const main_content = document.getElementById("main-content-dynamic-container")
const loader = document.querySelector("#loader")
const link_inicio = document.getElementById("home-link")
const profile_top_menu = document.querySelector(".profile-menu")
const profile_menu_avatar = document.querySelector(".profile-menu #link-profile")
const eq_link = document.querySelector(".profile-menu #link-eq")
const close_session = document.querySelector(".profile-menu #link-close-session")
const arrow_show_aside = document.getElementById("arrow-show-aside")
const header_aside = document.getElementById("side-menu")
const add_new_playlist = document.getElementById("add-new-playlist")
const playlists_container = document.getElementById("playlists-container")
const new_playlist_container = document.querySelector(".modal-new-playlist")
const form_new_list = document.getElementById("form-new-list")
const nombre_nueva_lista = document.getElementById("nombre-nueva-lista")
const foto_nueva_lista = document.getElementById("foto-nueva-lista")
const crear_lista = document.getElementById("crear-lista")
const search_bar = document.getElementById("search-bar")
const albums_esenciales = document.getElementById("albums-esenciales")
const lista_recomendada = document.getElementById("lista-recomendada")

//Modales y actualizaciones de datos
const close_modal_new_list = document.getElementById("close-modal-new-list")
const actualizar_avatar_usuario = document.querySelector(".actualizar-avatar-usuario")
const close_actualizar_avatar = document.getElementById("close-update-avatar-user")
const form_avatar = document.getElementById("form-new-user-avatar")
const btn_actualizar_avatar = document.getElementById("actualizar-avatar")
const input_new_avatar = document.getElementById("input-new-avatar")

//API Key
const MXMATCH_API_KEY = "230777d3bbd468016bc464b2a53b4c22"

//Alertas
const alert_song_added = document.getElementById("alert-song-added")
const alert_song_repeated = document.getElementById("alert-song-repeated")
const alert_data_modified = document.getElementById("alert-data-modified")
const alert_mail_repeated = document.getElementById("alert-mail-repeated")
const alert_review_missing_data = document.getElementById("alert-review-missing-data")

//Elementos de la barra de reproducción
const seek = document.getElementById("seek")
const bar2 = document.getElementById("bar2")
const dot = document.querySelector(".master-play .time-bar .dot")
const volume_input = document.getElementById("volume-slider")
const volume_bar = document.querySelector(".vol-bar")
const volume_dot = document.querySelector(".vol-dot")
const volume_icon = document.querySelector(".volume-icon")
const track_info = document.querySelector(".track-info")
const player_logo = document.querySelector(".player-logo-color-changer")
const next = document.getElementById("next")
const previous = document.getElementById("previous")
const shuffle = document.getElementById("shuffle")
const letra = document.getElementById("letra")
const play_pause = document.getElementById("play-pause")

//Elementos relativos al tiempo
const current_time = document.getElementById("current-time")
const end_time = document.getElementById("end-time")
const audio = document.querySelector("audio")


//Elementos del ecualizador
const context = new AudioContext()
const lowFilter = new BiquadFilterNode(context,{type:'lowshelf',frequency:100})
const midLowFilter = new BiquadFilterNode(context,{type:'peaking',frequency:400,Q:3})
const midFilter = new BiquadFilterNode(context,{type:'peaking',frequency:400,Q:3})
const midHighFilter = new BiquadFilterNode(context,{type:'peaking',frequency:800,Q:3})
const highFilter = new BiquadFilterNode(context,{type:'highshelf',frequency:1600})
const finalGain = new GainNode(context)

//Cola reproducción que contendrá las canciones que se irán reproduciendo
let cola_reproduccion = []
//Indice de canción que se está reproduciendo
let indice=0

let ultimo_indice
//Variable para controlar el aleatorio
let shuffle_state = false


//Listener para cerrar el modal de actualizar avatar
close_actualizar_avatar.addEventListener("click", ()=>{
    actualizar_avatar_usuario.classList.add("d-none")
})

//Listener que activa el aleatorio
shuffle.addEventListener("click", activateShuffle)

//Listener que genera una lista de canciones recomendadas
lista_recomendada.addEventListener("click", (evt)=>{
    evt.preventDefault()
    loadShufflePlayingList()
})

//Listener que cierra la sesión del usuario
close_session.addEventListener("click", async (evt)=>{
    evt.preventDefault()
    await fetch('../api_audio/close_session.php')
    location.reload()
})

//Función encargada de activar o desactivar el aleatorio
function activateShuffle(){
    if(shuffle.classList.contains("shuffle-active")){
        shuffle.classList.remove("shuffle-active")
        shuffle_state = false
    }else{
        shuffle.classList.add("shuffle-active")
        shuffle_state = true
    }

}

//Listener que muestra el ecualizador
eq_link.addEventListener("click", async (evt)=>{
    evt.preventDefault()
    const respuesta = await fetch('../api_audio/valores_eq.php')
    const datos = await respuesta.json()
    const datos_eq = datos["valores_eq"]

    let val = Object.values(datos_eq[0])

    main_content.innerHTML='<h1 class="text-center">Ecualizador</h1>'
    main_content.innerHTML+=`<div class='d-flex justify-content-between pe-5 ps-5'>
                                <button style='--clr:#04AA6D' class='btn-danger-own'><span>Activar ecualización</span><i></i></button>
                                <button style='--clr:#04AA6D' class='btn-danger-own d-none save'><span>Guardar parámetros</span><i></i></button>
                            </div>`
    const btn_eq = main_content.querySelector("button")
    const btn_guardar = main_content.querySelector(".save")
    btn_eq.addEventListener("click", ()=>{
        activateAudioFilters(btn_guardar) //Activar los filtros de ecualización
    })

    const div_ecualizador = document.createElement("div")
    div_ecualizador.classList.add("d-flex", "flex-column", "w-50", "gap-4", "mx-auto")
    div_ecualizador.innerHTML=`<div class='d-flex w-100 gap-2 flex-column'><h4 class='text-center'>Low filter</h4><div class='d-flex gap-2'>-40db<input class='w-100 slider-eq' type='range' min='-40' max='40' step='0.01' id='lows'>40db</div></div>
                                <div class='d-flex w-100 gap-2 flex-column'><h4 class='text-center'>LowMid Filter</h4><div class='d-flex gap-2'>-40db<input class='w-100 slider-eq' type='range' min='-40' max='40' step='0.01' id='mid-lows'>40db</div></div>
                                <div class='d-flex w-100 gap-2 flex-column'><h4 class='text-center'>Mid filter</h4><div class='d-flex gap-2'>-40db<input class='w-100 slider-eq' type='range' min='-40' max='40' step='0.01' id='mids'>40db</div></div>
                                <div class='d-flex w-100 gap-2 flex-column'><h4 class='text-center'>MidHigh filter</h4><div class='d-flex gap-2'>-40db<input class='w-100 slider-eq' type='range' min='-40' max='40' step='0.01' id='mid-high'>40db</div></div>
                                <div class='d-flex w-100 gap-2 flex-column'><h4 class='text-center'>High filter</h4><div class='d-flex gap-2'>-40db<input class='w-100 slider-eq' type='range' min='-40' max='40' step='0.01' id='highs'>40db</div></div>`

    const lows_i = div_ecualizador.querySelector("#lows")
    const midlows_i  = div_ecualizador.querySelector("#mid-lows")
    const mids_i  = div_ecualizador.querySelector("#mids")
    const midhighs_i = div_ecualizador.querySelector("#mid-high")
    const highs_i = div_ecualizador.querySelector("#highs")

    if(!val.includes(null)){
        lowFilter.gain.value=datos_eq[0].low_eq
        midLowFilter.gain.value=datos_eq[0].midlows_eq
        midFilter.gain.value=datos_eq[0].mids_eq
        midHighFilter.gain.value=datos_eq[0].midhighs_eq
        highFilter.gain.value=datos_eq[0].high_eq

        lows_i.value=datos_eq[0].low_eq
        midlows_i.value=datos_eq[0].midlows_eq
        mids_i.value=datos_eq[0].mids_eq
        midhighs_i.value=datos_eq[0].midhighs_eq
        highs_i.value=datos_eq[0].highs_eq
    }

    lows_i.addEventListener("input", ()=>{
        lowFilter.gain.value=lows_i.value
    })
    midlows_i.addEventListener("input", ()=>{
        midLowFilter.gain.value=midlows_i.value
    })
    mids_i.addEventListener("input", ()=>{
        midFilter.gain.value=mids_i.value
    })
    midhighs_i.addEventListener("input", ()=>{
        midHighFilter.gain.value=midhighs_i.value
    })
    highs_i.addEventListener("input", ()=>{
        highFilter.gain.value=highs_i.value
    })

    //Guardar los parámetros de ecualización
    btn_guardar.addEventListener("click", async ()=>{
        let lows = lows_i.value
        let midlows = midlows_i.value
        let mids = mids_i.value
        let midhighs = midhighs_i.value
        let highs = highs_i.value

        await fetch(`../api_audio/guardar_eq.php?lows=${lows}&midlows=${midlows}&mids=${mids}&midhighs=${midhighs}&highs=${highs}`)

        lows_i.value=lows
        midlows_i.value=midlows
        mids_i.value=mids
        midhighs_i.value=midhighs
        highs_i.value=highs
    })
    main_content.appendChild(div_ecualizador)
})


//Listener para visualizar la letra de la canción actual
letra.addEventListener("click", async()=>{
    const titulo = track_info.children[1].children[0].innerText
    const artista = track_info.children[1].children[1].innerText
    const foto = track_info.children[0].src

    const respuesta = await fetch(`http://api.musixmatch.com/ws/1.1/matcher.lyrics.get?q_artist=${artista}&q_track=${titulo}&apikey=${MXMATCH_API_KEY}`)
    const datos = await respuesta.json()
  
    let letra
    let copyright
    if("lyrics" in datos.message.body){
        letra = datos.message.body.lyrics.lyrics_body
        copyright = datos.message.body.lyrics.lyrics_copyright
        //Eliminamos la advertencia de uso comercial
        letra = letra.replace("******* This Lyrics is NOT for Commercial use *******", "Pronto, letras completas en Sonic Waves")
    }
    
    //Manejamos cada uno de los supuestos
    if(letra == "" && copyright == ""){
        letra = "Instrumental. Disfruta de la música"
    }else if(letra == "" && copyright == "Unfortunately we're not authorized to show these lyrics."){
        letra = "No nos dejan mostrar esta letra por copyright. Capitalismo."
    }else if(datos.message.header.status_code == "404"){
        letra = "Actualmente no disponemos de esta letra, lo sentimos."
    }

    main_content.innerHTML=`<section class="container-fluid rounded h-100 mx-auto d-flex flex-column justify-content-center align-items-center lyrics-container">
                            <h1 class='text-center mt-3 mb-3'>${titulo}</h1>
                            <h2 class='text-center mb-3'>${artista}</h2>
                            <canvas></canvas>
                            <pre class="text-center" id="song-lyric">${letra}</pre>
                        </section>`
    const canvas = main_content.querySelector("canvas")
    const lyrcs_container = main_content.querySelector(".lyrics-container")
    const img = document.createElement("img")
    canvas.width='300'
    canvas.height='300'
    img.src=`${foto}`
    img.width='300px'
    img.height='300px'
    let ctxt = canvas.getContext("2d")
    canvas.style.display="none"
    ctxt.drawImage(img, 0, 0, 300, 3000)
    const image_data = ctxt.getImageData(0,0,canvas.width, canvas.height)
    let rgb_array = buildRGBArray(image_data.data)
    const quantColors = quantization(rgb_array, 0)
    quantColors.sort((a,b) => a-b)
    let color1 = quantColors[quantColors.length-1]
    let color2 = quantColors[quantColors.length-8]
    let color3 = quantColors[quantColors.length-4]
    let color4 = quantColors[quantColors.length-11]
    let color5 = quantColors[quantColors.length-14]
    lyrcs_container.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color3.r},${color3.g},${color3.b},0.6500175070028011) 50% , rgba(${color2.r}, ${color2.g}, ${color2.b}, .85), rgba(${color5.r},${color5.g},${color5.b},1) 100%)`

})

profile_menu_avatar.addEventListener("click", async (evt)=>{
    evt.preventDefault()
    main_content.innerHTML=""
    const respuesta = await fetch(`../api_audio/info_user.php`)
    const datos = await respuesta.json()
    const datos_usuario = datos["datos"]
    main_content.classList.add("position-absolute", "w-100", "top-0")
    const section_profile_head = document.createElement("section")
    section_profile_head.classList.add("container-fluid", "d-flex","flex-column", "flex-lg-row", "lista-page-header", "gap-3", "align-items-center", "p-3")
    section_profile_head.innerHTML=`<div class='position-relative'><canvas id="profile-avatar-picture"></canvas><ion-icon id="edit-profile-picture-user-canvas" class='position-absolute top-50 start-50 translate-middle' name="pencil-outline"></ion-icon></div>
                                    <div class='d-flex flex-column gap-3 align-items-center align-items-md-start'>
                                        <span>Miembro de Sonic Waves</span>
                                        <h1 class='text-sm-center'>${datos_usuario[0].usuario}</h1>
                                        <h3 class='m-0'>${datos_usuario[0].nombre} ${datos_usuario[0].apellidos}</h3>
                                    </div>`
    const canvas = section_profile_head.querySelector("canvas")
    
    const img = document.createElement("img")
    canvas.width='300'
    canvas.height='300'
    canvas.style.borderRadius="50%"
    img.src=`${datos_usuario[0].foto_avatar}`
    img.width='300px'
    img.height='300px'
    let ctxt = canvas.getContext("2d")
    ctxt.drawImage(img, 0, 0, 300, 300)
    const image_data = ctxt.getImageData(0,0,canvas.width, canvas.height)
    let rgb_array = buildRGBArray(image_data.data)
    const quantColors = quantization(rgb_array, 0)
    quantColors.sort((a,b) => a-b)
    let color1 = quantColors[quantColors.length-1]
    let color2 = quantColors[quantColors.length-8]
    let color3 = quantColors[quantColors.length-4]
    let color4 = quantColors[quantColors.length-11]
    let color5 = quantColors[quantColors.length-14]
    canvas.addEventListener("click", ()=>{
        actualizar_avatar_usuario.classList.remove("d-none")
        btn_actualizar_avatar.addEventListener("click", async ()=>{
            const data_form = new FormData(form_avatar)
            data_form.append("foto", input_new_avatar.files[0])
            
            await fetch('../api_audio/actualizar_avatar_usuario.php',{
                method: "post",
                body: data_form
            })
            form_avatar.reset()
        })
    })

    section_profile_head.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color3.r},${color3.g},${color3.b},0.6500175070028011) 50% , rgba(${color2.r}, ${color2.g}, ${color2.b}, .85), rgba(${color5.r},${color5.g},${color5.b},1) 100%)`
    main_content.appendChild(section_profile_head)

    const respuesa_estilos = await fetch(`../api_audio/estilos.php`)
    const datos_estilos = await respuesa_estilos.json()
    const estilos = datos_estilos["estilos"]

    const datos_user = document.createElement("section")
    datos_user.innerHTML="<h2 class='text-center'>Tus datos de usuario</h2>"
    datos_user.classList.add("container-xl", "mt-4")
    const form = document.createElement("form")
    form.classList.add("w-50", "mx-auto", "d-flex", "flex-column", "gap-3")
    form.innerHTML=`<div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Nombre de usuario</label>
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </div>
                        <input type="text" value="${datos_usuario[0].usuario}" name="usuario" disabled readonly>                      
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Nombre</label>
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </div>
                        <input class='input-name' type="text" value="${datos_usuario[0].nombre}" name="nombre">                      
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Apellidos</label>
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </div>
                        <input class='input-apellidos' type="text" value="${datos_usuario[0].apellidos}" name="apellidos" required>                      
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Correo electrónico</label>
                            <ion-icon name="mail-outline"></ion-icon>
                        </div>
                        <input class='input-correo' type="email" value="${datos_usuario[0].correo}" name="correo" required>                      
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Contraseña</label>
                            <ion-icon name="keypad-outline"></ion-icon>
                        </div>
                        <input class='input-pass' type="password" value="${datos_usuario[0].contraseña}" name="pass" required>                      
                    </div>`
    const select_estilos = document.createElement("select")
    const nombre_input = form.querySelector(".input-name")
    const apellidos_input = form.querySelector(".input-apellidos")
    const correo_input = form.querySelector(".input-correo")
    const pass_input = form.querySelector(".input-pass")
    select_estilos.required=true
    select_estilos.setAttribute("name", "estilo")
    select_estilos.classList.add("p-1", "input-field")
    estilos.forEach(estilo=>{
        if(estilo.nombre == datos_usuario[0].estilo){
            select_estilos.innerHTML+=`<option selected value='${estilo.id}'>${estilo.nombre}</option>`
        }else{
            select_estilos.innerHTML+=`<option value='${estilo.id}'>${estilo.nombre}</option>`
        }
        
    })
    form.appendChild(select_estilos)
    form.innerHTML+=`<button type="button" style='--clr:#0ce8e8' class='btn-danger-own' id='completar-perfil'><span>Actualizar datos</span><i></i></button>`
    const btn_modificar = form.querySelector("button")

    btn_modificar.addEventListener("click", async()=>{
        // if(correo_input.value.trim() !== "" && pass_input.value.trim() !== ""){
            const data_form = new URLSearchParams(new FormData(form))    
  
            const response = await fetch('../api_audio/modificar_datos_usuario.php',{
                method: 'POST',
                body: data_form
            })
            if(!response.ok){
                if(response.status===409){
                    alert_mail_repeated.classList.remove("d-none")
                    setTimeout(removeMailRepeated, 2000)
                }
            }else{
                alert_data_modified.classList.remove("d-none")
                setTimeout(removeDataModifiedAlert, 2000)
            }
        // }else{
        //     alert_review_missing_data.classList.remove("d-none")
        //     setTimeout(removeDataLack, 2000)
        // }
    })
    datos_user.appendChild(form)
    main_content.appendChild(datos_user)
    
})
search_bar.addEventListener("keyup", async ()=>{
    const busqueda = search_bar.value

    // loader.classList.add("d-flex")
    // loader.classList.remove("d-none")
    const respuesta = await fetch(`../api_audio/busqueda.php?patron=${busqueda}`)
    const datos = await respuesta.json()
    // loader.classList.add("d-none")
    // loader.classList.remove("d-flex")
    main_content.classList.remove("position-absolute")
    main_content.innerHTML=""
    main_content.innerHTML="<div class='d-flex justify-content-center mb-3'><img src='../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png' class='w-25 mx-auto'></div>"

    const albumes = datos["albumes"]
    const grupos = datos["grupos"]
    const canciones = datos["canciones"]

    const resultados = document.createElement("section")
    resultados.classList.add("d-flex", "container-fluid", "flex-column", "flex-xl-row", "gap-3")
    const resultados_grupo = document.createElement("section")
    resultados_grupo.classList.add("d-flex", "flex-column", "groups-search-results", "gap-3")
    resultados_grupo.innerHTML=`<h2 class="text-center">Artistas</h2>`
    if(grupos.length != 0){
        grupos.forEach(grupo=>{
            let disco = grupo.discografica == 0 ? '' : 'Artista esencial <ion-icon name="checkmark-circle-outline"></ion-icon>'
            const div_grupo = document.createElement("div")
            div_grupo.classList.add("d-flex", "align-items-center", "gap-3", "group-search-individual-result")
            div_grupo.innerHTML+=`<img src='${grupo.foto_avatar}' class="rounded-circle w-25">
                                            <h4>${grupo.nombre}</h4>
                                            <h5 class='ms-3 d-flex align-items-center gap-2 grupo-esencial-badge'>${disco}</h5>`
            div_grupo.addEventListener("click", ()=>{
                showGroup(grupo.id)
            })
            resultados_grupo.appendChild(div_grupo)
        })
    }else{
        resultados_grupo.innerHTML+="<h4 class='text-center'>Sin resultados</h4>"
    }
    
    const resultados_albumes = document.createElement("section")
    resultados_albumes.classList.add("d-flex", "flex-column", "albums-search-results")
    resultados_albumes.innerHTML=`<h2 class="text-center">Álbumes</h2>`
    if(albumes.length != 0){
        albumes.forEach(album=>{
            const div_album = document.createElement("div")
            div_album.setAttribute("data-album-id", album.id)
            div_album.classList.add("d-flex", "align-items-center", "gap-3", "album-search-individual-result")
            div_album.innerHTML+=`<img src='${album.foto}' class="w-25 rounded">
                                    <h4>${album.titulo}</h4>`
            div_album.addEventListener("click", (evt)=>{
                showAlbum(evt.currentTarget)
            })
            resultados_albumes.appendChild(div_album)
        })
    }else{
        resultados_albumes.innerHTML+="<h4 class='text-center'>Sin resultados</h4>"
    }
    const resultados_canciones = document.createElement("section") 
    resultados_canciones.classList.add("d-flex", "flex-column", "songs-search-results")
    resultados_canciones.innerHTML+=`<h2 class="text-center">Canciones</h2>`
    if(canciones.length != 0){
        canciones.forEach((cancion, index)=>{
            const div_song = document.createElement("div")
            div_song.setAttribute("data-song-id", cancion.archivo)
            div_song.classList.add("d-flex", "align-items-center", "gap-3", "song-search-individual-result")
            div_song.innerHTML=`<img src='${cancion.caratula}' class="w-25 rounded">
                                <div>
                                    <h4>${cancion.titulo}</h4>
                                    <h5>${cancion.autor}</h5>
                                    <button data-bs-auto-close="true" data-song-id=${cancion.id} class="btn-group dropup add-song-to-playlist d-flex align-items-center p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false"><ion-icon name="add-outline"></ion-icon></button>
                                            <ul class="dropdown-menu overflow-auto dropdown-menu-add-playlist">
                                            </ul>
                                </div>`
            const add_song_playlist = div_song.querySelector(".add-song-to-playlist")
            add_song_playlist.addEventListener("click", (evt)=>{
                evt.stopPropagation()
                const id_cancion = evt.currentTarget.getAttribute("data-song-id")
                const ul_container = div_song.querySelector(".dropdown-menu")
                getAllPlaylists(ul_container, "modal", id_cancion)
            })                          

            div_song.addEventListener("click", (evt)=>{
                cola_reproduccion.push(cancion)
                playSearchedSong(cancion)
            })
            resultados_canciones.appendChild(div_song)
        })
    }else{
        resultados_canciones.innerHTML+="<h4 class='text-center'>Sin resultados</h4>"
    }

    resultados.appendChild(resultados_grupo)
    resultados.appendChild(resultados_albumes)
    resultados.appendChild(resultados_canciones)
    main_content.appendChild(resultados)
})

albums_esenciales.addEventListener("click", async (evt)=>{
    evt.preventDefault()
    await showFavoriteAlbums()
})

loadShufflePlayingList()
initializeUser()
initialVolume()
playerMainState()
getAllPlaylists(playlists_container, "header")


arrow_show_aside.addEventListener("click", ()=>{
    if(header_aside.classList.contains("show")){
        header_aside.classList.remove("show")
        arrow_show_aside.setAttribute("name", "chevron-forward-outline")
    }else{
        header_aside.classList.add("show")
        arrow_show_aside.setAttribute("name", "chevron-back-outline")
    }
})

async function playSearchedSong(cancion){
    audio.src=`${cancion.archivo}`
    audio.play()
    play_pause.setAttribute("name", "pause-outline")
    player_logo.classList.add("active")
    track_info.innerHTML=`<img src='${cancion.caratula}' class='rounded'>
                            <div class='d-flex flex-column'>
                                <span class='track-info-title'>${cancion.titulo}</span>
                                <span class='track-info-artist'>${cancion.autor}</span>
                            </div>`
}
async function initialSong(){
    const respuesta = await fetch('../api_audio/canciones.php')
    const datos = await respuesta.json()
    let cancion = datos['datos']
    audio.src=cancion[0].archivo
    track_info.innerHTML=`<img src='${cancion[0].caratula}' class='rounded'>
                            <div class='d-flex flex-column'>
                                <span class='track-info-title'>${cancion[0].titulo}</span>
                                <span class='track-info-artist'>${cancion[0].grupo}</span>
                            </div>`
    
}

add_new_playlist.addEventListener("click", ()=>{
    new_playlist_container.classList.add("show-modal-playlist")
})
close_modal_new_list.addEventListener("click", ()=>{
    new_playlist_container.classList.remove("show-modal-playlist")
})
crear_lista.addEventListener("click", async()=>{
    const data_form = new FormData(form_new_list)
    data_form.append("foto", foto_nueva_lista.files[0])
    data_form.append("nombre", nombre_nueva_lista.value)
    await fetch('../api_audio/nueva_playlist.php',{
        method: "post",
        body: data_form
    })
    form_new_list.reset()
    getAllPlaylists(playlists_container, "header")
})

async function getAllPlaylists(dom_padre, ubicacion, cancion){
    dom_padre.innerHTML=""
    const respuesta = await fetch('../api_audio/playlists.php')
    const datos = await respuesta.json()
    const listas = datos["listas"]
    listas.forEach(lista=>{
        let div
        if(ubicacion === "header"){
            div = createPlaylistsLinks(lista.id, lista.nombre, lista.foto, lista.usuario)
        }else{
            div = createPlaylistsLinksModal(lista.id, lista.nombre, lista.usuario, cancion)
        }
        
        dom_padre.appendChild(div)
    })
}

async function showFavoriteAlbums(){
    main_content.innerHTML=""
    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    const respuesta = await fetch('../api_audio/albumes_esenciales.php')
    const datos = await respuesta.json()
    loader.classList.remove("d-flex")
    loader.classList.add("d-none")
    const albumes = datos["albumes"]
    main_content.innerHTML="<h1 class='text-center mt-5'>Tus álbumes favoritos</h1>"
    const section_favoritos = document.createElement("section")
    section_favoritos.classList.add("container-fluid", "d-flex", "flex-column", "gap-3")
    albumes.forEach(album=>{
        const div_album = document.createElement("div")
        div_album.setAttribute("data-album-id", album.id)
        div_album.classList.add("d-flex", "gap-3", "align-items-center", "rounded", "favorite-album-container")
        div_album.innerHTML=`<div class='favorite-album-img-container'>
                                <img src='${album.foto}' class='img-fluid'>
                                <canvas></canvas>
                            </div>
                            <div>
                                <h2>${album.titulo}</h2>
                                <h4>${album.autor}</h4>
                            </div>`
        const canvas = div_album.querySelector("canvas")
        const img = document.createElement("img")
        canvas.width='300'
        canvas.height='300'
        img.src=`${album.foto}`
        img.width='300px'
        img.height='300px'
        let ctxt = canvas.getContext("2d")
        ctxt.drawImage(img, 0, 0, 280, 280)
        const image_data = ctxt.getImageData(0,0,canvas.width, canvas.height)
        let rgb_array = buildRGBArray(image_data.data)
        const quantColors = quantization(rgb_array, 0)
        quantColors.sort((a,b) => a-b)
        let color1 = quantColors[quantColors.length-1]
        let color2 = quantColors[quantColors.length-8]
        let color3 = quantColors[quantColors.length-4]
        let color4 = quantColors[quantColors.length-11]
        let color5 = quantColors[quantColors.length-14]
        canvas.style.display="none"
        div_album.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color3.r},${color3.g},${color3.b},0.6500175070028011) 50% , rgba(${color2.r}, ${color2.g}, ${color2.b}, .85), rgba(${color5.r},${color5.g},${color5.b},1) 100%)`
        div_album.addEventListener("click", (evt)=>{
            showAlbum(evt.currentTarget)
        })
        section_favoritos.appendChild(div_album)
    })
    main_content.appendChild(section_favoritos)
}

function createPlaylistsLinks(id, nombre, foto, usuario){
    const div = document.createElement("div")
    div.setAttribute("data-list-id", id)
    div.classList.add("d-flex", "gap-2", "w-100", "align-items-center", "playlist-side-menu-container")
    div.innerHTML=`<div class='list-image-container-menu'><img src='${foto}' class='playlist-side-menu-foto rounded img-fluid object-fit-cover'></div>
                    <div class='list-text-container-menu d-flex flex-column justify-content-around'>
                        <span>${nombre}</span>
                        <span class='list-creator'>${usuario}</span>
                    </div>`
    div.addEventListener("click", ()=>{
        printPlaylist(id)
    })
    return div
}

function createPlaylistsLinksModal(id, nombre, usuario, cancion){
    const li = document.createElement("li")
    li.setAttribute("data-list-id", id)
    li.classList.add("dropdown-item", "playlist-item")
    // div.classList.add("d-flex", "w-100", "align-items-center")
    li.innerText=`${nombre}`
    li.addEventListener("click", async (evt)=>{
        evt.stopPropagation()
        const respuesta = await fetch(`../api_audio/add_to_playlist.php?lista=${id}&cancion=${cancion}`)

        if(respuesta.status === 200){
            alert_song_added.classList.remove("d-none")
            setTimeout(removeAddedAlert, 2000)
        }else{
            alert_song_repeated.classList.remove("d-none")
            setTimeout(removeRepeatedAlert, 2000)
        }

    })
    return li
}

async function deletePlaylist(id){
    playlists_container.innerHTML=""
    await fetch(`../api_audio/borrar_playlist.php?id=${id}`) 
    await getAllPlaylists(playlists_container, "header")

}

async function printPlaylist(id){
    main_content.innerHTML=""
    const respuesta = await fetch(`../api_audio/imprimir_playlist.php?id=${id}`)
    const datos = await respuesta.json()
    const datos_lista = datos["datos_lista"] 
    main_content.classList.add("position-absolute", "w-100", "top-0")
    const section_playlist_head = document.createElement("section")
    section_playlist_head.classList.add("container-fluid", "d-flex","flex-column", "flex-lg-row", "lista-page-header", "gap-3", "align-items-center", "p-3")
    section_playlist_head.innerHTML=`<canvas></canvas>
                                    <div class='d-flex flex-column gap-3 align-items-center align-items-md-start'>
                                        <span>Playlist</span>
                                        <h1 class='text-sm-center'>${datos_lista[0].nombre}</h1>
                                        <div class='d-flex align-items-center gap-2'>
                                            <img src='${datos_lista[0].foto_avatar}' class='avatar-lista-page'>
                                            <h3 class='m-0'>Playlist de ${datos_lista[0].autor}</h3>
                                        </div>
                                        <h4>Creada el ${formatDate(datos_lista[0].fecha_creacion)}</h4>
                                        <ion-icon id="icon-borrar-playlist" name="trash-outline"></ion-icon>
                                    </div>`
    const canvas = section_playlist_head.querySelector("canvas")
    const borrar_lista = section_playlist_head.querySelector("#icon-borrar-playlist")
    borrar_lista.addEventListener("click", ()=>{
        deletePlaylist(id)
        playerMainState()
    })
    const img = document.createElement("img")
    canvas.width='300'
    canvas.height='300'
    img.src=`${datos_lista[0].foto}`
    img.width='300px'
    img.height='300px'
    let ctxt = canvas.getContext("2d")
    ctxt.drawImage(img, 0, 0, 280, 280)
    const image_data = ctxt.getImageData(0,0,canvas.width, canvas.height)
    let rgb_array = buildRGBArray(image_data.data)
    const quantColors = quantization(rgb_array, 0)
    quantColors.sort((a,b) => a-b)
    let color1 = quantColors[quantColors.length-1]
    let color2 = quantColors[quantColors.length-8]
    let color3 = quantColors[quantColors.length-4]
    let color4 = quantColors[quantColors.length-11]
    let color5 = quantColors[quantColors.length-14]

    section_playlist_head.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color3.r},${color3.g},${color3.b},0.6500175070028011) 50% , rgba(${color2.r}, ${color2.g}, ${color2.b}, .85), rgba(${color5.r},${color5.g},${color5.b},1) 100%)`
    main_content.appendChild(section_playlist_head)

    const lista_canciones = datos["datos_canciones"]

    const section_lista_canciones = document.createElement("section")
    section_lista_canciones.classList.add("p-4", "d-flex", "flex-column", "gap-3")
    lista_canciones.forEach((cancion, index)=>{
        let indice = index+1
        const cancion_container = document.createElement("div")
        cancion_container.classList.add("d-flex", "justify-content-between", "cancion-row")
        cancion_container.setAttribute("data-cancion", id)
        cancion_container.setAttribute("data-index", index)
        cancion_container.innerHTML=`<div class='d-flex gap-3 align-items-center'>
                                        <span>${indice}</span>
                                        <div>
                                            <h5 class='m-0 cancion-link'>${cancion.titulo}</h5> 
                                            <span class='track-info-artist'>${cancion.autor}</span>
                                        </div>
                                        <button data-bs-auto-close="true" data-song-id=${cancion.id} class="btn-group dropup add-song-to-playlist d-flex align-items-center p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false"><ion-icon name="add-outline"></ion-icon></button>
                                            <ul class="dropdown-menu overflow-auto dropdown-menu-add-playlist">
                                            </ul>
                                        <ion-icon class="delete-song-from-playlist" name="close-outline"></ion-icon>                                      
                                    </div>                                    
                                    <div class='d-flex align-items-center gap-3'>
                                        <span>${cancion.duracion}</span>
                                        
                                    </div>`                                    
        cancion_container.addEventListener("click", (evt)=>{
            loadPlayingList(evt, "playlist")
        })     
        const delete_song = cancion_container.querySelector(".delete-song-from-playlist")
        delete_song.addEventListener("click", async (evt)=>{
            evt.stopPropagation()
            await fetch(`../api_audio/delete_from_playlist.php?id_cancion=${cancion.id}&id_lista=${id}`)
            printPlaylist(id)
        })
        const add_song_playlist = cancion_container.querySelector(".add-song-to-playlist")
        add_song_playlist.addEventListener("click", (evt)=>{
            evt.stopPropagation()
            const id_cancion = evt.currentTarget.getAttribute("data-song-id")
            const ul_container = cancion_container.querySelector(".dropdown-menu")
            getAllPlaylists(ul_container, "modal", id_cancion)
        })                          
        section_lista_canciones.appendChild(cancion_container)
        
    })
    main_content.appendChild(section_lista_canciones)
    if(!audio.paused){
        for(const child of section_lista_canciones.children){
            if(child.children[0].children[1].innerText == cola_reproduccion[indice].titulo){
                child.children[0].children[1].classList.add("current-song-playing")
            }
        }
    }  
    
}

play_pause.addEventListener("click", ()=>{
    if(audio.paused){
        audio.play()
        play_pause.setAttribute("name", "pause-outline")
        player_logo.classList.add("active")
    }else{
        audio.pause()
        play_pause.setAttribute("name", "play-outline")
        player_logo.classList.remove("active")
    }
})
link_inicio.addEventListener("click", (evt)=>{
    evt.preventDefault()
    playerMainState()
})

async function playerMainState(){
    main_content.innerHTML=''
    main_content.classList.remove("position-absolute")
    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    const respuesta = await fetch("../api_audio/player_main_state.php")
    const datos = await respuesta.json()
    loader.classList.remove("d-flex")
    loader.classList.add("d-none")
    
    const recomendado = {
        foto: datos["grupo_recomendado"],
        id: datos["id_grupo_recomendado"],
        nombre: datos["nombre_grupo_recomendado"],
        discografica: datos["discografica"]
    }
    let disco = 'Grupo <ion-icon name="checkmark-circle-outline"></ion-icon>'
    const banner_main = document.createElement("div")
    banner_main.classList.add("banner-recomended", "mx-auto", "d-flex", "align-items-center", "flex-column", "justify-content-end", "position-relative", "mb-4")
    banner_main.setAttribute("data-artist-id", recomendado.id)
    banner_main.innerHTML=`<h2 class='recomended-group-name mb-0'>${recomendado.nombre}</h2>
    <h5 class='ms-3 d-flex align-items-center gap-2 grupo-esencial-badge'>${disco}</h5>`
    
    banner_main.style.backgroundImage=`url('${recomendado.foto}')`
    banner_main.style.backgroundSize='cover'
    banner_main.style.backgroundPosition='center'
    banner_main.style.height='40vh'
   
    main_content.appendChild(banner_main)
    
    const main_albums_container = document.createElement("div")
    main_albums_container.classList.add("main-content-albums-container", "container-fluid", "d-flex", "flex-column", "flex-lg-row", "gap-3", "mb-5")
    main_content.innerHTML+=`<h2 class='ms-4'>Álbumes populares</h2>`
    main_content.appendChild(main_albums_container)
    const main_content_albums_container = main_content.querySelector(".main-content-albums-container")
    datos["datos"].forEach(disco=>{
        const div_album_container = document.createElement("div")
        div_album_container.classList.add("d-flex", "flex-column", "justify-content-around", "album-inner-container")
        div_album_container.setAttribute("data-album-id", disco.id)
        div_album_container.innerHTML= `<img src='${disco.foto}' class='img-fluid mb-1 rounded'>
        <a>${disco.titulo}</a>
        <span class='artist-link' data="${disco.grupo_id}">${disco.autor}</span>`

        
        main_content_albums_container.appendChild(div_album_container)       
    })
    
    const main_artists_container = document.createElement("div")
    main_artists_container.classList.add("d-flex", "flex-column", "flex-lg-row", "gap-3", "main-content-artists-container", "container-fluid")
    main_content.innerHTML+=`<h2 class='ms-4 mt-3'>Artistas populares</h2>`
    main_content.appendChild(main_artists_container)
    const main_content_artists_container = main_content.querySelector(".main-content-artists-container")
    datos["artistas"].forEach(artista=>{
        const div_artist_container = document.createElement("div")
        div_artist_container.setAttribute("data-artist-id", artista.id)
        div_artist_container.addEventListener("click", ()=>{
            showGroup(artista.id)
        })
        div_artist_container.classList.add("d-flex", "flex-column", "justify-content-around", "artist-inner-container")   
        div_artist_container.innerHTML=`<img src='${artista.foto_avatar}' class='img-fluid rounded-circle'>
        <a class='text-center text-white'>${artista.nombre}</a>`
        main_content_artists_container.appendChild(div_artist_container)
    })

    const estilo_r1 = datos["estilo_random1"]
    const albums_estilo_r1 = datos["albums_estilo_r1"];

    const albums_random1 = document.createElement("div")
    albums_random1.classList.add("d-flex", "flex-column", "flex-lg-row", "justify-content-start", "gap-3", "main-content-artists-container", "container-fluid")
    main_content.innerHTML+=`<h2 class='ms-4 mt-3'>Álbumes recomendados de ${estilo_r1}</h2>`
    albums_estilo_r1.forEach(album=>{
        const div_album_r1_container = document.createElement("div")
        div_album_r1_container.classList.add("d-flex", "flex-column", "justify-content-around", "album-inner-container")
        div_album_r1_container.setAttribute("data-album-id", album.id)
        div_album_r1_container.innerHTML=`<img src='${album.foto}' class='img-fluid mb-1 rounded'>
        <a>${album.titulo}</a>
        <span class='artist-link' data="${album.grupo_id}">${album.autor}</span>`
        albums_random1.appendChild(div_album_r1_container)
    })
    main_content.appendChild(albums_random1)
    const pubs_random = datos["publicaciones_random"]
    console.log(pubs_random)
    main_content.innerHTML+="<h2 class='ms-4 mt-3'>Consulta algunas de nuestras publicaciones exclusivas</h2>"
    const div_publis = document.createElement("div")
    div_publis.classList.add("d-flex", "flex-column", "p-3", "gap-3", "initial-state-pubs-container")
    pubs_random.forEach(pub=>{
        const div_pub = document.createElement("div")
        div_pub.classList.add("d-flex", "gap-3")
        div_pub.innerHTML=`<img src='${pub.foto}' class='img-pub-initial-state'>
                            <div class='p-1 d-flex flex-column align-items-start gap-2'>
                                <h3>${pub.titulo}</h3>
                                <h4>${pub.grupo}</h4>
                                <i>${formatDate(pub.fecha)}</i>
                                <button type="button" style='--clr:#0ce8e8' class='btn-danger-own'><span>Ver completa</span><i></i></button>
                            </div>`
        const ver_publicacion = div_pub.querySelector("button")
        ver_publicacion.addEventListener("click", ()=>{
            watchFullPost(pub.id)
        })
        div_publis.appendChild(div_pub)
    })
    main_content.appendChild(div_publis)
}

async function initializePlayer(evt){
    evt.preventDefault()
}

//Actualizar tiempo actual de la canción
audio.addEventListener("timeupdate", ()=>{
    let current_minutos = Math.floor(audio.currentTime/60)
    let current_segundos = Math.floor(audio.currentTime - current_minutos * 60)

    let width = parseFloat(audio.currentTime / audio.duration * 100)
    seek.value = width
    bar2.style.width=`${width}%`
    dot.style.left=`${width}%`
    if(current_segundos < 10){
        current_segundos = `0${current_segundos}`
    }
    current_time.innerText=`${current_minutos}:${current_segundos}`
})

document.addEventListener("click", (evt)=>{
    const target = evt.target.closest(".album-inner-container"); // Or any other selector.  
    if(target){
      showAlbum(target)
    }
  })

document.addEventListener("click", (evt)=>{
    const target = evt.target.closest(".banner-recomended"); // Or any other selector.
    if(target){
        const id = target.getAttribute("data-artist-id")
        showGroup(id)
    }
})

document.addEventListener("click", (evt)=>{
    const target = evt.target.closest(".artist-inner-container"); // Or any other selector.
    if(target){
        const id = target.getAttribute("data-artist-id")
        showGroup(id)
    }
})

//Actualizar duración total de la canción
audio.addEventListener("loadedmetadata", ()=>{
    seek.max=audio.duration
    let duracion_min = Math.floor(audio.duration/60)
    let duracion_segundos = Math.floor(audio.duration - duracion_min * 60);
    if(duracion_segundos < 10){
        duracion_segundos = `0${duracion_segundos}`
    }   
    end_time.innerText=`${duracion_min}:${duracion_segundos}`
})


seek.addEventListener("input", ()=>{
    audio.currentTime=seek.value
})

audio.addEventListener("ended", ()=>{
    bar2.style.width='0%'
    dot.style.left='0'
    current_time.innerText='0:00'
    end_time.innerText='0:00'
    play_pause.setAttribute("name", "play-outline")
    if(!shuffle_state){
        indice++
    }else{
        indice = Math.floor(Math.random()*cola_reproduccion.length)
    }
    
    const row_album = document.querySelectorAll(".cancion-row")
    let arr = Array.from(row_album)
    const filtro = arr.filter(cont=>cont.children[0].children[0].innerText == indice+1)
    if(indice < cola_reproduccion.length){
        if(filtro.length != 0){
            arr.forEach(item=>{
                item.children[0].children[1].classList.remove("current-song-playing")
            })
            filtro[0].children[0].children[1].classList.add("current-song-playing")
        }
        playSong(indice)
    }
})
next.addEventListener("click", ()=>{
    if(!shuffle_state){
        indice++
    }else{
        ultimo_indice = indice
        indice = Math.floor(Math.random()*cola_reproduccion.length)
    }
    
    const row_album = document.querySelectorAll(".cancion-row")

    let arr = Array.from(row_album)
    const filtro = arr.filter(cont=>cont.children[0].children[0].innerText == indice+1)
    
    if(indice < cola_reproduccion.length){
        if(filtro.length != 0){
            arr.forEach(item=>{
                item.children[0].children[1].classList.remove("current-song-playing")
            })

            if(filtro[0].children[0].children[1].children[0].innerText == cola_reproduccion[indice].titulo){
                filtro[0].children[0].children[1].classList.add("current-song-playing")
            }
            
        }
        playSong(indice)
    }else{
        indice = 0
        if(row_album.length != 0){
            row_album.item(row_album.length-1).children[0].children[1].classList.remove("current-song-playing")
            row_album.item(0).children[0].children[1].classList.add("current-song-playing")
        }
        playSong(indice)
    }
})
previous.addEventListener("click", ()=>{
    if(!shuffle_state){
        indice--
    }else{
        indice = ultimo_indice
    }
    
    const row_album = document.querySelectorAll(".cancion-row")
    let arr = Array.from(row_album)
    const filtro = arr.filter(cont=>cont.children[0].children[0].innerText == indice+1)
    if(indice >= 0){
        if(filtro.length != 0){
            arr.forEach(item=>{
                item.children[0].children[1].classList.remove("current-song-playing")
            })
            if(filtro[0].children[0].children[1].children[0].innerText == cola_reproduccion[indice].titulo){
                filtro[0].children[0].children[1].classList.add("current-song-playing")
            }
        }
        playSong(indice)
    }else{
        indice = 0
        playSong(indice)
    }
})

volume_input.addEventListener("input", ()=>{
    let valor = volume_input.value
    audio.volume=valor
    let width = valor*100
    volume_bar.style.width=`${width}%`
    volume_dot.style.left=`${width}%`
    if(audio.volume > 0 && audio.volume <= .25){
        volume_icon.setAttribute("name","volume-low-outline")
    }else if(audio.volume > .25 && audio.volume < .75){
        volume_icon.setAttribute("name", "volume-medium-outline")
    }else if(audio.volume >= .75){
        volume_icon.setAttribute("name", "volume-high-outline")
    }else{
        volume_icon.setAttribute("name", "volume-mute-outline")
    }
})


// async function getAlbum(id){
//     const respuesta = await fetch(`../api_audio/album_peticion.php?id=${id}`)
//     const datos = await respuesta.json()
//     return datos["datos"]
// }

function initialVolume(){
    document.addEventListener("DOMContentLoaded", ()=>{
        audio.volume='0.5'
        volume_bar.style.width=`50%`
        volume_dot.style.left=`50%`
    })
}
 
async function initializeUser(){
    const respuesta = await fetch(`../api_audio/info_user.php`)
    const datos = await respuesta.json()
    let usuario_datos = datos["datos"]
    let completado = datos["perfil_completado"]
    if(completado == 0){
        const respuesta_est = await fetch('../api_audio/estilos.php');
        const datos_est = await respuesta_est.json()
        const estilos = datos_est["estilos"]

        const formulario_completar = document.createElement("section")
        formulario_completar.classList.add("position-fixed", "top-0", "d-flex", "justify-content-center", "align-items-center")
        const div_container = document.createElement("div")
        div_container.classList.add("d-flex", "flex-column", "p-3", "gap-3","border", "align-items-center")
        div_container.style.background=`linear-gradient(90deg, rgba(0,0,0,1) 5%, rgba(12,159,196,1) 55%, rgba(0,0,0,1) 93%)`
        div_container.innerHTML=`<img src='../media/assets/sonic-waves-logo-simple.png' class="w-25 mx-auto">
        <h1 class='text-center'>¡Bienvenido a Sonic Waves!</h1>
        <p class="w-50 text-center">¡Enhorabuena ${usuario_datos[0].nombre} ${usuario_datos[0].apellidos}! Ya formas parte de la familia de Sonic Waves. Antes de podar usar
        nuestro reproductor y todas las posibilidades que este ofrece deberás completar tu perfil. Pero 
        ¡no te preocupes, no te llevará más de 30 segundos!</p>`
        const form = document.createElement("form")
        form.classList.add("d-flex", "flex-column", "align-items-center", "gap-3")
        form.setAttribute("enctype", "multipart/form-data")
        form.setAttribute("method", "post")
        const select_estilo = createSelect(estilos)
        form.appendChild(select_estilo)
        form.innerHTML+=`<div class="input-field d-flex flex-column mb-3">
                            <div class="input-visuals d-flex justify-content-between align-items-center gap-3">
                                <label for="usuario">Fecha de nacimiento</label>
                                <ion-icon name="calendar-outline"></ion-icon>
                            </div>
                            <input id="f_nac" name='f_nac' type='date'>                        
                        </div>
                        <div class="input-field d-flex flex-column mb-3">
                            <div class="input-visuals d-flex justify-content-between align-items-center gap-3">
                                <label for="usuario">Foto de avatar</label>
                                <ion-icon name="image-outline"></ion-icon>
                            </div>
                            <input id="foto_avatar" class="custom-file-input" type="file" accept=".jpg,.png,.webp">                        
                        </div>                  
                        
                        <button type="button" style='--clr:#0ce8e8' class='btn-danger-own' id='completar-perfil'><span>Completar datos</span><i></i></button>`
        const input_fecha = form.querySelector("#f_nac")
        const input_foto = form.querySelector("#foto_avatar")
        const input_estilo = form.querySelector("select")
        const btn_update = form.querySelector("#completar-perfil")

        div_container.appendChild(form)
        formulario_completar.style.width="100%"
        formulario_completar.style.height="100dvh"
        formulario_completar.style.backdropFilter="blur(3px)"
        formulario_completar.style.zIndex="8888888888888888888888888888888888888888888888888888888888888"
        formulario_completar.appendChild(div_container)
        document.body.appendChild(formulario_completar)
        btn_update.addEventListener("click", ()=>{
            if(input_estilo.value.trim() !== "" && input_foto.value.trim() !== "" && input_fecha.value.trim() !== ""){
                updateProfile(input_foto, input_estilo, input_fecha, form)
                location.reload()
            }
            
        })
        
    }
    profile_menu_avatar.parentElement.parentElement.previousElementSibling.src=usuario_datos[0].foto_avatar
}


function createSelect(estilos){
    const select = document.createElement("select")
    select.classList.add("p-1")
    select.setAttribute("name", "estilo")
    select.innerHTML="<option checked hidden value='null'>Escoge un estilo</option>"
    estilos.forEach(estilo=>{
        select.innerHTML+=`<option value="${estilo.id}">${estilo.nombre}</option>`
    })
    
    return select
}

async function updateProfile(input_foto, input_estilo, input_fecha, formulario_perfil){
    const formData = new FormData()
    formData.append("foto_avatar", input_foto.files[0])
    formData.append("estilo", input_estilo.value)
    formData.append("f_nac", input_fecha.value)

    
    await fetch(`../api_audio/actualizar_perfil.php`, {
        method: 'POST',
        body: formData
    })
    formulario_perfil.reset()
    
}

async function showAlbum(target){
    main_content.innerHTML=''

    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    const id = target.getAttribute("data-album-id")

    const respuesta = await fetch(`../api_audio/album_peticion.php?id=${id}`)
    const datos = await respuesta.json()
    loader.classList.add("d-none")
    loader.classList.remove("d-flex")
    
    const favorito = datos["favorito"]
    const total_canciones = datos["canciones_totales"]
   
    const datos_album = datos["datos_album"]
    const corazon = favorito == 0 ? "fa-regular" : "fa-solid"
    main_content.classList.add("position-absolute", "w-100", "top-0")
    const section_album_head = document.createElement("section")
    section_album_head.classList.add("container-fluid", "d-flex","flex-column", "flex-lg-row", "album-page-header", "gap-3", "align-items-center", "p-3")
    section_album_head.innerHTML=`<canvas></canvas>
                                    <div class='d-flex flex-column gap-3 align-items-center align-items-md-start'>
                                        <h1 class='text-sm-center'>${datos_album[0].titulo}</h1>
                                        <div class='d-flex align-items-center gap-2'>
                                            <img src='${datos_album[0].avatar}' class='avatar-album-page'>
                                            <h3 data-artist-id=${datos_album[0].id_grupo} class='m-0 album-page-artist-link'>${datos_album[0].autor}</h3>
                                        </div>
                                        <h4>Lanzado el ${formatDate(datos_album[0].lanzamiento)} · ${total_canciones} canciones</h4>
                                        <div class='d-flex gap-4'>
                                            <i data-favorite=${favorito} class="${corazon} fa-heart add-favorite-album"></i>
                                            <i data-album-id="${id}" class="fa-regular fa-comment add-album-review see-album-reviews"></i>
                                        </div>
                                    </div>`
    const canvas = section_album_head.querySelector("canvas")
    const add_favorite = section_album_head.querySelector(".add-favorite-album")
    const see_reviews = section_album_head.querySelector(".see-album-reviews")
    add_favorite.addEventListener("click", (evt)=>{
        const es_favorito = evt.target.getAttribute("data-favorite")
        if(es_favorito == 0){
            addFavoriteAlbum(id)
            add_favorite.classList.remove("fa-regular")
            add_favorite.classList.add("fa-solid")
            add_favorite.setAttribute("data-favorite", 1)
        }else{
            deleteFavoriteAlbum(id)
            add_favorite.classList.remove("fa-solid")
            add_favorite.classList.add("fa-regular")
            add_favorite.setAttribute("data-favorite", 0)
        }
    })
    see_reviews.addEventListener("click", async ()=>{
        await seeAlbumReviews(id)
    })
    const enlace_grupo = section_album_head.querySelector("h3")
    enlace_grupo.addEventListener("click", ()=>{
        showGroup(datos_album[0].id_grupo)
    })
    const img = document.createElement("img")
    canvas.width='300'
    canvas.height='300'
    img.src=`${datos_album[0].foto}`
    img.width='300px'
    img.height='300px'
    let ctxt = canvas.getContext("2d")
    ctxt.drawImage(img, 0, 0, 280, 280)
    const image_data = ctxt.getImageData(0,0,canvas.width, canvas.height)
    let rgb_array = buildRGBArray(image_data.data)
    const quantColors = quantization(rgb_array, 0)
    quantColors.sort((a,b) => a-b)
    let color1 = quantColors[quantColors.length-1]
    let color2 = quantColors[quantColors.length-8]
    let color3 = quantColors[quantColors.length-4]
    let color4 = quantColors[quantColors.length-11]
    let color5 = quantColors[quantColors.length-14]

    section_album_head.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color3.r},${color3.g},${color3.b},0.6500175070028011) 50% , rgba(${color2.r}, ${color2.g}, ${color2.b}, .85), rgba(${color5.r},${color5.g},${color5.b},1) 100%)`
    main_content.appendChild(section_album_head)
    const lista_canciones = datos["lista_canciones"]
    const section_lista_canciones = document.createElement("section")
    section_lista_canciones.classList.add("p-4", "d-flex", "flex-column", "gap-3")

    lista_canciones.forEach((cancion, index)=>{
        let indice = index+1
        const cancion_container = document.createElement("div")
        cancion_container.classList.add("d-flex", "justify-content-between", "cancion-row")
        cancion_container.setAttribute("data-cancion", cancion.album)
        cancion_container.setAttribute("data-index", index)
        cancion_container.innerHTML=`<div class='d-flex gap-3 align-items-center'>
                                        <span>${indice}</span>
                                        <div>
                                            <h5 class='m-0 cancion-link'>${cancion.titulo}</h5> 
                                            <span class='track-info-artist'>${datos_album[0].autor}</span>
                                        </div>
                                        <button data-bs-auto-close="true" data-song-id=${cancion.id} class="btn-group dropup add-song-to-playlist d-flex align-items-center p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false"><ion-icon name="add-outline"></ion-icon></button>
                                            <ul class="dropdown-menu overflow-auto dropdown-menu-add-playlist">
                                            </ul>                                      
                                    </div>                                    
                                    <div class='d-flex align-items-center gap-3'>
                                        <span>${cancion.duracion}</span>
                                        
                                    </div>`                                   
        cancion_container.addEventListener("click", (evt)=>{
            loadPlayingList(evt, "album")
        })     
        const add_song_playlist = cancion_container.querySelector(".add-song-to-playlist")
        add_song_playlist.addEventListener("click", (evt)=>{
            evt.stopPropagation()
            const id_cancion = evt.currentTarget.getAttribute("data-song-id")
            const ul_container = cancion_container.querySelector(".dropdown-menu")
            getAllPlaylists(ul_container, "modal", id_cancion)
        })                          
        section_lista_canciones.appendChild(cancion_container)
        
    })
    // if(datos_album[0].discografica != "Autogestionado"){
    //     main_content.innerHTML+=`<i class="album-copyright">Publicado por ${datos_album[0].discografica}, All Rights Reserved © <img src='${datos_album[0].foto_discografica}' class='rounded-circle discografica-copyright-image'></i>`
    // }else{
    //     section_lista_canciones.innerHTML+=`<i class="album-copyright">Publicado por ${datos_album[0].autor}, All Rights Reserved © <img src='${datos_album[0].avatar}' class='rounded-circle discografica-copyright-image'></i>`
    // }
    main_content.appendChild(section_lista_canciones)
    
    if(!audio.paused){
        for(const child of section_lista_canciones.children){
            if(!child.classList.contains("album-copyright")){
          
                if(child.children[0].children[1].children[0].innerText == cola_reproduccion[indice].titulo){
                    child.children[0].children[1].classList.add("current-song-playing")
                }
            }
            
        }
    }  
}

async function addFavoriteAlbum(id){
    await fetch(`../api_audio/add_album_favorito.php?id=${id}`)
}

async function deleteFavoriteAlbum(id){
    await fetch(`../api_audio/remove_album_favorito.php?id=${id}`)
}

async function seeAlbumReviews(id){
    main_content.innerHTML=''
    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    
    const respuesta = await fetch(`../api_audio/album_reviews.php?id=${id}`)
    const datos = await respuesta.json()
    loader.classList.remove("d-flex")
    loader.classList.add("d-none")

    const datos_album = datos["datos_album"]
    const reseña_escrita = datos["reseña_escrita"]
    main_content.classList.add("position-absolute", "w-100", "top-0")
    const section_album_head = document.createElement("section")
    // section_album_head.setAttribute("data-album-id", id)
    section_album_head.classList.add("container-fluid", "d-flex","flex-column", "flex-lg-row", "album-page-header", "gap-3", "align-items-center", "p-3")
    section_album_head.innerHTML=`<canvas></canvas>
                                    <div class='d-flex flex-column gap-3'>
                                        <h1>${datos_album[0].titulo}</h1>
                                        <div class='d-flex align-items-center gap-2'>
                                            <img src='${datos_album[0].avatar}' class='avatar-album-page'>
                                            <h3 data-artist-id=${datos_album[0].id_grupo} class='m-0'>${datos_album[0].autor}</h3>
                                        </div>
                                        <h4>Lanzado el ${formatDate(datos_album[0].lanzamiento)}</h4>
                                        <div class='d-flex gap-4'>
                                      
                                            <ion-icon data-album-id="${id}"  class="album-song-list" name="musical-notes-outline"></ion-icon>
                                        </div>
                                    </div>`
    const canvas = section_album_head.querySelector("canvas")
    const album_songs = section_album_head.querySelector(".album-song-list")
    album_songs.addEventListener("click", (evt)=>{
        showAlbum(evt.target)
    })
    const enlace_grupo = section_album_head.querySelector("h3")
    enlace_grupo.addEventListener("click", ()=>{
        showGroup(datos_album[0].id_grupo)
    })
    const img = document.createElement("img")
    canvas.width='300'
    canvas.height='300'
    img.src=`${datos_album[0].foto}`
    let ctxt = canvas.getContext("2d")
    ctxt.drawImage(img, 0, 0, 280, 280)
    const image_data = ctxt.getImageData(0,0,canvas.width, canvas.height)
    let rgb_array = buildRGBArray(image_data.data)
    const quantColors = quantization(rgb_array, 0)
    quantColors.sort((a,b) => a-b)
    let color1 = quantColors[quantColors.length-1]
    let color2 = quantColors[quantColors.length-8]
    let color3 = quantColors[quantColors.length-4]
    let color4 = quantColors[quantColors.length-11]
    let color5 = quantColors[quantColors.length-13]

    section_album_head.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color3.r},${color3.g},${color3.b},0.6500175070028011) 50% , rgba(${color2.r}, ${color2.g}, ${color2.b}, .85), rgba(${color5.r},${color5.g},${color5.b},1) 100%)`
    main_content.appendChild(section_album_head)
    // main_content.innerHTML+="<h2 class='text-center'>Reseñas de los usuarios de Sonic Waves</h2>"

    const datos_reviews = datos["reseñas"]
    if(reseña_escrita[0].comprobante == 0){
        const formulario_reseña = document.createElement("form")
        formulario_reseña.setAttribute("id", "formulario-insertar-reseña")
        formulario_reseña.classList.add("d-flex", "flex-column", "gap-5", "align-items-center", "p-3")
        formulario_reseña.innerHTML=`<div class='input-field w-100'><input class="w-100" placeholder="Título de la reseña" name="titulo" type="text" id="titulo-reseña" required></div>
                                    <div class='input-field w-100'><input class="w-100" placeholder="Contenido de la reseña" type="text" id="contenido-reseña" name="contenido" required></div>
                                    <input hidden value="${id}" name="id-album">
                                    <button data-album-id="${id}" id="enviar-reseña" type="button" style='--clr:#0ce8e8' class='btn-danger-own'><span>Comentar</span><i></i></button>`
        const section_nueva_reseña = document.createElement("section")
        section_nueva_reseña.innerHTML=`<h2 class='text-center mt-4'>Añade tu reseña para ${datos_album[0].titulo}</h2>`
        const boton_insertar_reseña = formulario_reseña.querySelector("#enviar-reseña")
        const titulo_reseña = formulario_reseña.querySelector("#titulo-reseña")
        const contenido_reseña = formulario_reseña.querySelector("#contenido-reseña")
        section_nueva_reseña.appendChild(formulario_reseña)
        boton_insertar_reseña.addEventListener("click", async (evt)=>{
            if(titulo_reseña.value.trim() !== "" && contenido_reseña.value.trim() !== ""){
                await insertReview(formulario_reseña)
                await seeAlbumReviews(id)
            }else{
                alert_review_missing_data.classList.remove("d-none")
                setTimeout(removeDataLack, 2000)
            }
            
        })
        main_content.appendChild(section_nueva_reseña)
    }
    const section_reviews = document.createElement("section")
    section_reviews.classList.add("container-fluid")
    section_reviews.innerHTML="<h2 class='text-center mt-3'>Reseñas de los usuarios de Sonic Waves</h2>"
    const reviews_container = document.createElement("div")
    reviews_container.classList.add("d-flex", "flex-column", "gap-3")
    datos_reviews.forEach(review=>{
        let fecha = formatDate(review.fecha)
        const review_cont = document.createElement("div")
        review_cont.classList.add("d-flex", "flex-column", "single-review-container", "p-2","rounded")
        review_cont.innerHTML=`<h3>${review.titulo}</h3>
                                <p>${review.contenido}</p>
                                <div class='d-flex align-items-center gap-2'>
                                    <img src='${review.foto}' class='rounded-circle see-album-reviews-avatar-user'>
                                    <i>Escrita por ${review.autor} el ${fecha}</i>
                                </div>`
                                
        // review_cont.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color2.r}, ${color2.g}, ${color2.b}, .5), rgba(${color5.r},${color5.g},${color5.b},.5) 70%)`
        reviews_container.appendChild(review_cont)
    })
    section_reviews.appendChild(reviews_container)
    main_content.appendChild(section_reviews)
    
}

async function insertReview(formulario_reseña){
    const datos_formulario_reseña = new URLSearchParams(new FormData(formulario_reseña))
    await fetch(`../api_audio/insertar_reseña.php`, {
        method: 'POST',
        body: datos_formulario_reseña
    })
    formulario_reseña.reset()
    
}

async function loadShufflePlayingList(){
    cola_reproduccion.length = 0
    const respuesta = await fetch('../api_audio/shuffle.php')
    const datos = await respuesta.json()
    const lista_aleatorio = datos["lista_aleatorio"]
    lista_aleatorio.forEach(cancion=>{
        cola_reproduccion.push(cancion)
    })
    console.log(cola_reproduccion)
    playSong(indice)
}

async function loadPlayingList(evt, context){
    let padre = evt.currentTarget.parentElement
    
    for(const child of padre.children){
        let titulo = child.children[0].children[1]
        if(titulo.classList.contains("current-song-playing")){
            titulo.classList.remove("current-song-playing")
        }
    }
    let titulo_actual = evt.currentTarget.children[0].children[1]
    titulo_actual.classList.add("current-song-playing")
    const id = evt.currentTarget.getAttribute("data-cancion")
   
    const index = evt.currentTarget.getAttribute("data-index")
    indice = index
    const respuesta = await fetch(`../api_audio/array_reproduccion.php?id=${id}&contexto=${context}`)
    const datos = await respuesta.json()
    const lista = datos["lista_canciones"]
    
    if(cola_reproduccion.length != 0){
        if(cola_reproduccion.length != lista.length){
            cola_reproduccion.length = 0
        }
        else{
            if(lista[indice].titulo != cola_reproduccion[indice].titulo){
                cola_reproduccion.length = 0
            }
        }
    }

    if(cola_reproduccion.length == 0){
        lista.forEach(cancion=>{
            cola_reproduccion.push(cancion)
        })
    }
       
    playSong(indice)
    
}

//Función que muestra todo el perfil de un grupo junto con su información
async function showGroup(id){
    main_content.innerHTML=''
    main_content.classList.add("position-absolute", "w-100", "top-0")
    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    // const id = evt.currentTarget.getAttribute("data-artist-id")
    const respuesta = await fetch(`../api_audio/artista_peticion.php?id=${id}`)
    const datos = await respuesta.json()
    loader.classList.add("d-none")
    loader.classList.remove("d-flex")
    const datos_grupo = datos["datos_grupo"]
    const discos = datos["discos_grupo"]
    // const tiene_discografica = datos_grupo[0].discografica
    let publicaciones = []
    // if(tiene_discografica == 0){
        publicaciones = datos["publicaciones_grupo"] 
        console.log(datos)
    // }
 
    let disco = 'Grupo<ion-icon name="checkmark-circle-outline"></ion-icon>'
    let header_extra = 'Publicaciones'
    const section_artist_head = document.createElement("section")
    section_artist_head.classList.add("mb-5")
    const div_artist_avatar = document.createElement("div")
    section_artist_head.innerHTML=`<div class='d-flex flex-column align-items-start'><h1 class='ms-4 section-artist-title mb-0'>${datos_grupo[0].nombre}</h1>
    <h5 class='ms-4 d-flex align-items-center grupo-esencial-badge'>${disco}</h5></div>`
    section_artist_head.classList.add("d-flex","justify-content-end", "flex-column")
    div_artist_avatar.classList.add("position-absolute")
    div_artist_avatar.style.width='100%'
    div_artist_avatar.style.height='100%'
    div_artist_avatar.innerHTML=`<img class='position-absolute rounded-circle section-artist-avatar' src='${datos_grupo[0].foto_avatar}'>`
    section_artist_head.appendChild(div_artist_avatar)
    section_artist_head.classList.add("w-100")
    section_artist_head.style.backgroundImage=`url('${datos_grupo[0].foto}')`
    section_artist_head.style.height='55vh'
    section_artist_head.style.backgroundSize='cover'
    section_artist_head.style.backgroundPosition='center'
    // section_artist_head.style.position='absolute'
    // section_artist_head.style.top='0'
    main_content.appendChild(section_artist_head)
    const section_artist_content = document.createElement("section")
    section_artist_content.classList.add("container-lg", "pt-3")
    section_artist_content.innerHTML=`<div class='d-flex flex-column flex-md-row justify-content-center gap-5 artist-section-picker mb-5 align-items-center align-items-md-start'>
                                        <h2 class="active" data-picker='bio'>Biografía</h2>
                                        <h2 data-picker='discos'>Discos publicados</h2>
                                        <h2 data-picker='pubs'>${header_extra}</h2>
                                    </div>`
    const div_artist_content = document.createElement("div")
    // div_artist_content.classList.add("d-flex", "flex-column")
    const bio = document.createElement("p")
    bio.classList.add("artist-section-bio", "options-artist")
    bio.setAttribute("data-info-artist", "bio")
    bio.innerText=`${datos_grupo[0].biografia}`
    div_artist_content.appendChild(bio)
    const div_albums_container = document.createElement("div")
    div_albums_container.classList.add("d-flex", "gap-3", "d-none", "options-artist", "flex-column", "flex-lg-row", "mb-3")
    div_albums_container.setAttribute("data-info-artist", "discos")
    if(discos.length != 0){
        discos.forEach(disco=>{
            const album = document.createElement("div")
            album.classList.add("d-flex", "gap-3", "align-items-center", "album-individual-container")
            album.setAttribute("data-album-id", disco.id)
            album.innerHTML+=`<div class='w-50'>
                                <img src='${disco.foto}' class='img-fluid object-fit-cover'>
                            </div>
                            <div class='d-flex w-50'>
                                <h5>${disco.titulo}</h5>
                            </div>`
            album.addEventListener("click", (evt)=>{
                showAlbum(evt.currentTarget)
            })
            div_albums_container.appendChild(album)
        })
    }else{
        div_albums_container.innerHTML=`<h2 class='text-center'>Este artista no tiene álbumes por el momento</h2>`
    }
    
    div_artist_content.appendChild(div_albums_container)

    const div_publicaciones = document.createElement("div")
    div_publicaciones.classList.add("d-flex", "d-none", "options-artist", "flex-column", "container-lg", "gap-4")
    div_publicaciones.setAttribute("data-info-artist", "pubs")
    // if(tiene_discografica == 0){    
        if(publicaciones.length != 0){
            publicaciones.forEach(publicacion=>{
                const div_publicacion = document.createElement("div")
                let preview_texto = publicacion.contenido.substring(0, 400)
                div_publicacion.classList.add("post-individual-container", "d-flex","gap-3", "p-3", "flex-column", "flex-md-row")
                div_publicacion.innerHTML=`<div>
                                                <img src='${publicacion.foto}' class='img-fluid'>
                                            </div>
                                            <div class='gap-2 d-flex flex-column align-items-start'>
                                                <h2>${publicacion.titulo}</h2>
                                                <p>${preview_texto}...</p>
                                                <i>${formatDate(publicacion.fecha)}</i>
                                                <button type="button" style='--clr:#0ce8e8' class='btn-danger-own'><span>Ver completa</span><i></i></button>
                                            </div>`
                const ver_publicacion = div_publicacion.querySelector("button")
                ver_publicacion.addEventListener("click", ()=>{
                    watchFullPost(publicacion.id)
                })
                div_publicaciones.appendChild(div_publicacion)
            })
        }else{
            div_publicaciones.innerHTML="<h3 class='text-center'>No hay publicaciones</h3>"
        }
        
    // }else{
    //     // await seeUpcomingEvents(datos_grupo[0].nombre, div_publicaciones)
    // }
    div_artist_content.appendChild(div_publicaciones)

    section_artist_content.appendChild(div_artist_content)
    const headers = section_artist_content.querySelectorAll("h2")
    const options = div_artist_content.querySelectorAll(".options-artist")
   
    headers.forEach(header=>{
        // if(header.innerText==='Próximos eventos'){
        //     header.addEventListener("click", ()=>{
                
        //         // div_artist_content.appendChild(div_eventos)
        //     })
        // }
        header.addEventListener("click", (evt)=>{
            headers.forEach(h=>h.classList.remove("active"))
            const data = evt.target.getAttribute("data-picker")
            header.classList.add("active")
      
            options.forEach(option=>{
                if(option.getAttribute("data-info-artist") == data){
                    option.classList.add("d-flex")
                    option.classList.remove("d-none")
                   
                }else{
                    option.classList.remove("d-flex")
                    option.classList.add("d-none")
                }
            })
        })
    })
    main_content.appendChild(section_artist_content)
    
}

    //Función que imprime una publicación completa
async function watchFullPost(id){
    main_content.innerHTML=""
    main_content.style.height="100vh"
    // main_content.classList.remove("position-absolute")
    const respuesta = await fetch(`../api_audio/publicacion_completa.php?id=${id}`)
    const datos = await respuesta.json()
    const datos_publicacion = datos["datos_publicacion"]
    const fotos_extra = datos["fotos_extra"]
  
    
    // main_content.innerHTML=`<button type="button" style='--clr:#0ce8e8' class='ms-3 btn-danger-own'><span>Volver al grupo</span><i></i></button>`
   
    const publicacion_container = document.createElement("section")
    publicacion_container.classList.add("container-fluid", "d-flex", "flex-column", "gap-3", "p-3", "full-post-container")
    publicacion_container.innerHTML=`   <div class='d-flex w-100 gap-3 flex-column flex-lg-row align-items-center align-items-md-start'><canvas></canvas>
                                        <img src='${datos_publicacion[0].foto}' class='rounded object-fit-cover main-photo'>
                                
                                    <div class='d-flex flex-column gap-3 align-items-start'>
                                        <h1>${datos_publicacion[0].titulo}</h1>
                                        <pre class='full-post-content'>${datos_publicacion[0].contenido}</pre>
                                        <i>Publicado el ${formatDate(datos_publicacion[0].fecha)}</i>
                                        <button type="button" style='--clr:#0ce8e8' class='btn-danger-own'><span>Volver al grupo</span><i></i></button>
                                    </div></div>`
    if(fotos_extra != undefined){
        const div_fotos_extra = document.createElement("div")
        div_fotos_extra.classList.add("d-flex", "flex-column", "flex-md-row", "gap-3")
        
        fotos_extra.forEach(foto=>{
            const img = document.createElement("img")
            img.classList.add("rounded", "extra-photo-post", "object-fit-cover")
            img.src=`${foto.enlace}`
            div_fotos_extra.appendChild(img)
        })
        publicacion_container.appendChild(div_fotos_extra)
    }
    const btn = publicacion_container.querySelector("button")
    btn.addEventListener("click", ()=>{
        showGroup(datos_publicacion[0].grupo)
    })
    const canvas = publicacion_container.querySelector("canvas")
    const img = publicacion_container.querySelector(".main-photo")
    canvas.width='300'
    canvas.height='300'
    let ctxt = canvas.getContext("2d")
    ctxt.drawImage(img, 0, 0, 280, 280)
    canvas.style.display="none"
    const image_data = ctxt.getImageData(0,0,canvas.width, canvas.height)
    let rgb_array = buildRGBArray(image_data.data)
    const quantColors = quantization(rgb_array, 0)
    quantColors.sort((a,b) => a-b)
    let color1 = quantColors[quantColors.length-1]
    let color2 = quantColors[quantColors.length-8]
    let color3 = quantColors[quantColors.length-4]
    let color4 = quantColors[quantColors.length-11]
    let color5 = quantColors[quantColors.length-13]

    publicacion_container.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color3.r},${color3.g},${color3.b},0.6500175070028011) 50% , rgba(${color2.r}, ${color2.g}, ${color2.b}, .85), rgba(${color5.r},${color5.g},${color5.b},1) 100%)`
    main_content.appendChild(publicacion_container)
}

// async function seeUpcomingEvents(artist, dom){
   
//     loader.classList.add("d-flex")
//     loader.classList.remove("d-none")
//     const url = `https://concerts-artists-events-tracker.p.rapidapi.com/artist?name=${artist}&page=1`
//     const options = {
//         method: 'GET',
//         headers: {
//             'X-RapidAPI-Key': 'f67c08b6a0mshee3b6b1bacda154p13ebabjsne09459e39cae',
//             'X-RapidAPI-Host': 'concerts-artists-events-tracker.p.rapidapi.com'
//         }
        
//     }
//     const concerts = await fetch(url, options)
//     const datos_c = await concerts.json()
 
//     loader.classList.add("d-none")
//     loader.classList.remove("d-flex")
//     const proximos_conciertos = datos_c["data"]
 

//     const div_eventos = document.createElement("div")
//     div_eventos.setAttribute("data-info-artist", "pubs")
//     div_eventos.classList.add("d-flex", "d-none", "options-artist", "flex-column", "container-lg", "gap-4")

//     if('error' in datos_c || proximos_conciertos.length == 0){
//         div_eventos.innerHTML="<h2 class='text-center'>No tenemos resultados para este artista, lo sentimos.</h2>"
//     }else{
//         proximos_conciertos.forEach(concierto=>{
//             const div_evento = document.createElement("div")
//             div_evento.classList.add("post-individual-container", "d-flex","gap-3", "p-3", "flex-column", "flex-md-row")
//             div_evento.innerHTML=`
//                                     <img src='${concierto.image}' class='img-fluid rounded'>
                                
//                                 <div class='gap-2 d-flex flex-column align-items-start'>
//                                     <h2>${concierto.description}</h2>
//                                     <i>${concierto.location.name}, ${concierto.location.address.addressCountry}, ${concierto.location.address.addressLocality}</i>
//                                     <i>Este evento dura hasta el ${formatDate(concierto.endDate)}</i>
//                                 </div>`
//             div_eventos.appendChild(div_evento)
//         })
//     }
    
//     dom.appendChild(div_eventos)
// }

async function playSong(index){
    audio.src=cola_reproduccion[index].archivo
    track_info.innerHTML=`<img src='${cola_reproduccion[index].caratula}' class='rounded'>
                            <div class='d-flex flex-column'>
                                <span class='track-info-title'>${cola_reproduccion[index].titulo}</span>
                                <span class='track-info-artist'>${cola_reproduccion[index].autor}</span>
                            </div>`
    console.log(cola_reproduccion[index])
    bar2.style.width='0%'
    dot.style.left='0'
    current_time.innerText='0:00'
    audio.play()
    play_pause.setAttribute("name", "pause-outline")
    player_logo.classList.add("active")
    await fetch(`../api_audio/update_times_played.php?id=${cola_reproduccion[index].cancion_id}`)
}


//Funcion para crear un array de valores RGB manejable a partir de los datos del elemento canvas
function buildRGBArray(imageData){
const rgbValues = []
  for (let i = 0; i < imageData.length; i += 4) {
    const rgb = {
      r: imageData[i],
      g: imageData[i + 1],
      b: imageData[i + 2],
    }
    rgbValues.push(rgb)
  }
  return rgbValues
}

//Funcion que, partiendo del array de valores RGB, nos devuelve qué componente (R red, G green o B blue) es el más representativo de la imagen
function findBiggestColorRange(rgb_array){
    let rMin = Number.MAX_VALUE
    let gMin = Number.MAX_VALUE
    let bMin = Number.MAX_VALUE
  
    let rMax = Number.MIN_VALUE
    let gMax = Number.MIN_VALUE
    let bMax = Number.MIN_VALUE
  
    rgb_array.forEach((pixel) => {
      rMin = Math.min(rMin, pixel.r)
      gMin = Math.min(gMin, pixel.g)
      bMin = Math.min(bMin, pixel.b)
  
      rMax = Math.max(rMax, pixel.r)
      gMax = Math.max(gMax, pixel.g)
      bMax = Math.max(bMax, pixel.b)
    })
  
    const rRange = rMax - rMin
    const gRange = gMax - gMin
    const bRange = bMax - bMin
  
    const biggestRange = Math.max(rRange, gRange, bRange)
    if (biggestRange === rRange) {
      return "r"
    } else if (biggestRange === gRange) {
      return "g"
    } else {
      return "b"
    }
  };

  //Última función del proceso de extracción de colores de la imagen, la cual nos devolverá un array de objetos con los valores RGB más presentes en dicha imagen
  function quantization(rgbValues, depth){
    const MAX_DEPTH = 4
  
    if (depth === MAX_DEPTH || rgbValues.length === 0) {
      const color = rgbValues.reduce(
        (prev, curr) => {
          prev.r += curr.r;
          prev.g += curr.g;
          prev.b += curr.b;
  
          return prev;
        },
        {
          r: 0,
          g: 0,
          b: 0,
        }
      )
  
      color.r = Math.round(color.r / rgbValues.length)
      color.g = Math.round(color.g / rgbValues.length)
      color.b = Math.round(color.b / rgbValues.length)
  
      return [color]
    }
  
    /**
     *  Mediante recursividad seguimos el siguiente procediminento:
     *  1. Encontrar el valor (R,G o B) con la mayor diferencia
     *  2. Realizamos una ordenación a partir de este canal
     *  3. Dividimos la lista de colores RGB por la mitad
     *  4. Repetimos el proceso hasta alcanzar la profundidad deseada
     */
    const componentToSortBy = findBiggestColorRange(rgbValues)
    rgbValues.sort((p1, p2) => {
      return p1[componentToSortBy] - p2[componentToSortBy]
    })
  
    const mid = rgbValues.length / 2;
    return [
      ...quantization(rgbValues.slice(0, mid), depth + 1),
      ...quantization(rgbValues.slice(mid + 1), depth + 1),
    ]
  }

  //Función que recibe una fecha y la devuelve en formato español
  function formatDate(fecha){
    let date_object = new Date(fecha)
    return `${addZeroToDate(date_object.getDate())}-${addZeroToDate(date_object.getMonth()+1)}-${date_object.getFullYear()}`
  }

  //Función que añade ceros a la izquierda a una fecha si fuera necesario (ej. 2 => 02)
  function addZeroToDate(fecha){
    return fecha < 10 ? `0${fecha}` : fecha
  }

  function activateAudioFilters(btn_guardar, canvas){
    let src = context.createMediaElementSource(audio)
    src.connect(lowFilter)
    src.connect(context.destination)
    lowFilter.connect(midLowFilter)
    lowFilter.connect(context.destination)
    midLowFilter.connect(midFilter)
    midLowFilter.connect(context.destination)
    midFilter.connect(midHighFilter)
    midFilter.connect(context.destination)
    midHighFilter.connect(highFilter)
    midHighFilter.connect(context.destination)
    highFilter.connect(finalGain)
    highFilter.connect(context.destination)
    btn_guardar.classList.remove("d-none")
    
  }


// setInterval(()=>{
//     setTimeout(()=> {
//         $(".alert").fadeTo(500, 0).slideUp(500, ()=>{
//             $(this).remove(); 
//         });
//     }, 3000);
// },500)

function removeAddedAlert(){
    alert_song_added.classList.add("d-none")
}

function removeRepeatedAlert(){
    alert_song_repeated.classList.add("d-none")
}

function removeDataModifiedAlert(){
    alert_data_modified.classList.add("d-none")
}

function removeMailRepeated(){
    alert_mail_repeated.classList.add("d-none")
}

function removeDataLack(){
    alert_review_missing_data.classList.add("d-none")
}
