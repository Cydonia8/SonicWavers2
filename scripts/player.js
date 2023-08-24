"use strict"
const main_content = document.getElementById("main-content-dynamic-container")
const loader = document.querySelector("#loader")
const link_main_page = document.getElementById("home-link")
const profile_top_menu = document.querySelector(".profile-menu")
const profile_menu_avatar = document.querySelector(".profile-menu #link-profile")
const msgs_link = document.querySelector(".profile-menu #link-msgs")
const close_session = document.querySelector(".profile-menu #link-close-session")
const arrow_show_aside = document.getElementById("arrow-show-aside")
const header_aside = document.getElementById("side-menu")
const add_new_playlist = document.getElementById("add-new-playlist")
const playlists_container = document.getElementById("playlists-container")
const new_playlist_container = document.querySelector(".modal-new-playlist")
const form_new_list = document.getElementById("form-new-list")
const new_playlist_name = document.getElementById("nombre-nueva-lista")
const new_playlist_image = document.getElementById("foto-nueva-lista")
const new_playlist = document.getElementById("crear-lista")
const search_bar = document.getElementById("search-bar")
const favorite_albums = document.getElementById("albums-esenciales")
const recommended_playlist = document.getElementById("lista-recomendada")
const dropdown_menu_user = document.querySelector("ul.dropdown-menu-user")

//Modales y actualizaciones de datos
const close_modal_new_list = document.getElementById("close-modal-new-list")
const update_user_avatar = document.querySelector(".actualizar-avatar-usuario")
const close_update_avatar = document.getElementById("close-update-avatar-user")
const form_avatar = document.getElementById("form-new-user-avatar")
const btn_update_avatar = document.getElementById("actualizar-avatar")
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
let playing_queue = []
//song_index de canción que se está reproduciendo
let song_index=0

let last_song_index
//Variable para controlar el aleatorio
let shuffle_state = false


//Listener para cerrar el modal de actualizar avatar
close_update_avatar.addEventListener("click", ()=>{
    update_user_avatar.classList.add("d-none")
})

//Listener que activa el aleatorio
shuffle.addEventListener("click", activateShuffle)

//Listener que genera una lista de canciones recomendadas
recommended_playlist.addEventListener("click", (evt)=>{
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
// eq_link.addEventListener("click", async (evt)=>{
//     evt.preventDefault()
//     const respuesta = await fetch('../api_audio/valores_eq.php')
//     const datos = await respuesta.json()
//     const datos_eq = datos["valores_eq"]

//     let val = Object.values(datos_eq[0])

//     main_content.innerHTML='<h1 class="text-center">Ecualizador</h1>'
//     main_content.innerHTML+=`<div class='d-flex justify-content-between pe-5 ps-5'>
//                                 <button style='--clr:#04AA6D' class='btn-danger-own'><span>Activar ecualización</span><i></i></button>
//                                 <button style='--clr:#04AA6D' class='btn-danger-own d-none save'><span>Guardar parámetros</span><i></i></button>
//                             </div>`
//     const btn_eq = main_content.querySelector("button")
//     const btn_guardar = main_content.querySelector(".save")
//     btn_eq.addEventListener("click", ()=>{
//         activateAudioFilters(btn_guardar) //Activar los filters de ecualización
//     })

//     const div_ecualizador = document.createElement("div")
//     div_ecualizador.classList.add("d-flex", "flex-column", "w-50", "gap-4", "mx-auto")
//     div_ecualizador.innerHTML=`<div class='d-flex w-100 gap-2 flex-column'><h4 class='text-center'>Low filter</h4><div class='d-flex gap-2'>-40db<input class='w-100 slider-eq' type='range' min='-40' max='40' step='0.01' id='lows'>40db</div></div>
//                                 <div class='d-flex w-100 gap-2 flex-column'><h4 class='text-center'>LowMid Filter</h4><div class='d-flex gap-2'>-40db<input class='w-100 slider-eq' type='range' min='-40' max='40' step='0.01' id='mid-lows'>40db</div></div>
//                                 <div class='d-flex w-100 gap-2 flex-column'><h4 class='text-center'>Mid filter</h4><div class='d-flex gap-2'>-40db<input class='w-100 slider-eq' type='range' min='-40' max='40' step='0.01' id='mids'>40db</div></div>
//                                 <div class='d-flex w-100 gap-2 flex-column'><h4 class='text-center'>MidHigh filter</h4><div class='d-flex gap-2'>-40db<input class='w-100 slider-eq' type='range' min='-40' max='40' step='0.01' id='mid-high'>40db</div></div>
//                                 <div class='d-flex w-100 gap-2 flex-column'><h4 class='text-center'>High filter</h4><div class='d-flex gap-2'>-40db<input class='w-100 slider-eq' type='range' min='-40' max='40' step='0.01' id='highs'>40db</div></div>`

//     const lows_i = div_ecualizador.querySelector("#lows")
//     const midlows_i  = div_ecualizador.querySelector("#mid-lows")
//     const mids_i  = div_ecualizador.querySelector("#mids")
//     const midhighs_i = div_ecualizador.querySelector("#mid-high")
//     const highs_i = div_ecualizador.querySelector("#highs")

//     if(!val.includes(null)){
//         lowFilter.gain.value=datos_eq[0].low_eq
//         midLowFilter.gain.value=datos_eq[0].midlows_eq
//         midFilter.gain.value=datos_eq[0].mids_eq
//         midHighFilter.gain.value=datos_eq[0].midhighs_eq
//         highFilter.gain.value=datos_eq[0].high_eq

//         lows_i.value=datos_eq[0].low_eq
//         midlows_i.value=datos_eq[0].midlows_eq
//         mids_i.value=datos_eq[0].mids_eq
//         midhighs_i.value=datos_eq[0].midhighs_eq
//         highs_i.value=datos_eq[0].highs_eq
//     }

//     lows_i.addEventListener("input", ()=>{
//         lowFilter.gain.value=lows_i.value
//     })
//     midlows_i.addEventListener("input", ()=>{
//         midLowFilter.gain.value=midlows_i.value
//     })
//     mids_i.addEventListener("input", ()=>{
//         midFilter.gain.value=mids_i.value
//     })
//     midhighs_i.addEventListener("input", ()=>{
//         midHighFilter.gain.value=midhighs_i.value
//     })
//     highs_i.addEventListener("input", ()=>{
//         highFilter.gain.value=highs_i.value
//     })

//     //Guardar los parámetros de ecualización
//     btn_guardar.addEventListener("click", async ()=>{
//         let lows = lows_i.value
//         let midlows = midlows_i.value
//         let mids = mids_i.value
//         let midhighs = midhighs_i.value
//         let highs = highs_i.value

//         await fetch(`../api_audio/guardar_eq.php?lows=${lows}&midlows=${midlows}&mids=${mids}&midhighs=${midhighs}&highs=${highs}`)

//         lows_i.value=lows
//         midlows_i.value=midlows
//         mids_i.value=mids
//         midhighs_i.value=midhighs
//         highs_i.value=highs
//     })
//     main_content.appendChild(div_ecualizador)
// })


//Listener para visualizar la letra de la canción actual
// letra.addEventListener("click", async()=>{
//     const titulo = track_info.children[1].children[0].innerText
//     const artista = track_info.children[1].children[1].innerText
//     const foto = track_info.children[0].src

//     const respuesta = await fetch(`http://api.musixmatch.com/ws/1.1/matcher.lyrics.get?q_artist=${artista}&q_track=${titulo}&apikey=${MXMATCH_API_KEY}`)
//     const datos = await respuesta.json()
  
//     let letra
//     let copyright
//     if("lyrics" in datos.message.body){
//         letra = datos.message.body.lyrics.lyrics_body
//         copyright = datos.message.body.lyrics.lyrics_copyright
//         //Eliminamos la advertencia de uso comercial
//         letra = letra.replace("******* This Lyrics is NOT for Commercial use *******", "Pronto, letras completas en Sonic Waves")
//     }
    
//     //Manejamos cada uno de los supuestos
//     if(letra == "" && copyright == ""){
//         letra = "Instrumental. Disfruta de la música"
//     }else if(letra == "" && copyright == "Unfortunately we're not authorized to show these lyrics."){
//         letra = "No nos dejan mostrar esta letra por copyright. Capitalismo."
//     }else if(datos.message.header.status_code == "404"){
//         letra = "Actualmente no disponemos de esta letra, lo sentimos."
//     }

//     main_content.innerHTML=`<section class="container-fluid rounded h-100 mx-auto d-flex flex-column justify-content-center align-items-center lyrics-container">
//                             <h1 class='text-center mt-3 mb-3'>${titulo}</h1>
//                             <h2 class='text-center mb-3'>${artista}</h2>
//                             <canvas></canvas>
//                             <pre class="text-center" id="song-lyric">${letra}</pre>
//                         </section>`
//     const canvas = main_content.querySelector("canvas")
//     const lyrcs_container = main_content.querySelector(".lyrics-container")
//     const img = document.createElement("img")
//     canvas.width='300'
//     canvas.height='300'
//     img.src=`${foto}`
//     img.width='300px'
//     img.height='300px'
//     let ctxt = canvas.getContext("2d")
//     canvas.style.display="none"
//     ctxt.drawImage(img, 0, 0, 300, 3000)
//     const image_data = ctxt.getImageData(0,0,canvas.width, canvas.height)
//     let rgb_array = buildRGBArray(image_data.data)
//     const quantColors = quantization(rgb_array, 0)
//     quantColors.sort((a,b) => a-b)
//     let color1 = quantColors[quantColors.length-1]
//     let color2 = quantColors[quantColors.length-8]
//     let color3 = quantColors[quantColors.length-4]
//     let color4 = quantColors[quantColors.length-11]
//     let color5 = quantColors[quantColors.length-14]
//     lyrcs_container.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color3.r},${color3.g},${color3.b},0.6500175070028011) 50% , rgba(${color2.r}, ${color2.g}, ${color2.b}, .85), rgba(${color5.r},${color5.g},${color5.b},1) 100%)`

// })

profile_menu_avatar.addEventListener("click", async (evt)=>{
    evt.preventDefault()
    main_content.innerHTML=""
    const response = await fetch(`../api_audio/info_user.php`)
    const data = await response.json()
    const user_data = data["data"]
  
    main_content.classList.add("position-absolute", "w-100", "top-0")
    const section_profile_head = document.createElement("section")
    section_profile_head.classList.add("container-fluid", "d-flex","flex-column", "flex-lg-row", "lista-page-header", "gap-3", "align-items-center", "p-3")
    section_profile_head.innerHTML=`<div class='position-relative'><canvas id="profile-avatar-picture"></canvas><ion-icon id="edit-profile-picture-user-canvas" class='position-absolute top-50 start-50 translate-middle' name="pencil-outline"></ion-icon></div>
                                    <div class='d-flex flex-column gap-3 align-items-center align-items-md-start'>
                                        <span>Miembro de Sonic Waves</span>
                                        <h1 class='text-sm-center'>${user_data[0].username}</h1>
                                        <h3 class='m-0'>${user_data[0].name} ${user_data[0].surname}</h3>
                                    </div>`
    const canvas = section_profile_head.querySelector("canvas")
    
    const img = document.createElement("img")
    canvas.width='300'
    canvas.height='300'
    canvas.style.borderRadius="50%"
    img.src=`${user_data[0].avatar}`
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
        update_user_avatar.classList.remove("d-none")
        btn_update_avatar.addEventListener("click", async ()=>{
            const data_form = new FormData(form_avatar)
            data_form.append("foto", input_new_avatar.files[0])
            
            await fetch('../api_audio/update_user_avatar.php',{
                method: "post",
                body: data_form
            })
            form_avatar.reset()
        })
    })

    section_profile_head.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color3.r},${color3.g},${color3.b},0.6500175070028011) 50% , rgba(${color2.r}, ${color2.g}, ${color2.b}, .85), rgba(${color5.r},${color5.g},${color5.b},1) 100%)`
    main_content.appendChild(section_profile_head)

    const response_styles = await fetch(`../api_audio/styles.php`)
    const data_styles = await response_styles.json()
    const styles = data_styles["styles"]

    const user_data_section = document.createElement("section")
    user_data_section.innerHTML="<h2 class='text-center'>Tus datos de usuario</h2>"
    user_data_section.classList.add("container-xl", "mt-4")
    const form = document.createElement("form")
    form.classList.add("w-50", "mx-auto", "d-flex", "flex-column", "gap-3")
    form.innerHTML=`<div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Nombre de usuario</label>
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </div>
                        <input type="text" value="${user_data[0].username}" name="usuario" disabled readonly>                      
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Nombre</label>
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </div>
                        <input class='input-name' type="text" value="${user_data[0].name}" name="nombre">                      
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Apellidos</label>
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </div>
                        <input class='input-apellidos' type="text" value="${user_data[0].surname}" name="apellidos" required>                      
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Correo electrónico</label>
                            <ion-icon name="mail-outline"></ion-icon>
                        </div>
                        <input class='input-correo' type="email" value="${user_data[0].mail}" name="correo" required>                      
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Contraseña</label>
                            <ion-icon name="keypad-outline"></ion-icon>
                        </div>
                        <input class='input-pass' type="password" value="${user_data[0].pass}" name="pass" required>                      
                    </div>`
    const select_styles = document.createElement("select")
    const nombre_input = form.querySelector(".input-name")
    const apellidos_input = form.querySelector(".input-apellidos")
    const correo_input = form.querySelector(".input-correo")
    const pass_input = form.querySelector(".input-pass")
    select_styles.required=true
    select_styles.setAttribute("name", "estilo")
    select_styles.classList.add("p-1", "input-field")
    styles.forEach(style=>{
        if(style.name == user_data[0].style){
            select_styles.innerHTML+=`<option selected value='${style.id}'>${style.name}</option>`
        }else{
            select_styles.innerHTML+=`<option value='${style.id}'>${style.name}</option>`
        }
        
    })
    form.appendChild(select_styles)
    form.innerHTML+=`<button type="button" style='--clr:#0ce8e8' class='btn-danger-own' id='completar-perfil'><span>Actualizar datos</span><i></i></button>`
    const btn_update = form.querySelector("button")

    btn_update.addEventListener("click", async()=>{
        // if(correo_input.value.trim() !== "" && pass_input.value.trim() !== ""){
            const data_form = new URLSearchParams(new FormData(form))    
  
            const response = await fetch('../api_audio/update_user_data.php',{
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
    user_data_section.appendChild(form)
    main_content.appendChild(user_data_section)
    
})
search_bar.addEventListener("keyup", async ()=>{
    const search = search_bar.value

    // loader.classList.add("d-flex")
    // loader.classList.remove("d-none")
    const response = await fetch(`../api_audio/search.php?patron=${search}`)
    const data = await response.json()
    // loader.classList.add("d-none")
    // loader.classList.remove("d-flex")
    main_content.classList.remove("position-absolute")
    main_content.innerHTML=""
    main_content.innerHTML="<div class='d-flex justify-content-center mb-3'><img src='../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png' class='w-25 mx-auto'></div>"

    const albums = data["albums"]
    const artists = data["artists"]
    const songs = data["songs"]

    const results = document.createElement("section")
    results.classList.add("d-flex", "container-fluid", "flex-column", "flex-xl-row", "gap-3")
    const artists_results = document.createElement("section")
    artists_results.classList.add("d-flex", "flex-column", "groups-search-results", "gap-3")
    artists_results.innerHTML=`<h2 class="text-center">Artistas</h2>`
    if(artists.length != 0){
        artists.forEach(artist=>{
            const div_artist = document.createElement("div")
            div_artist.classList.add("d-flex", "align-items-center", "gap-3", "group-search-individual-result")
            div_artist.innerHTML+=`<img src='${artist.avatar}' class="rounded-circle w-25">
                                            <h4>${artist.name}</h4>`
            div_artist.addEventListener("click", ()=>{
                showGroup(artist.id)
            })
            artists_results.appendChild(div_artist)
        })
    }else{
        artists_results.innerHTML+="<h4 class='text-center'>Sin resultados</h4>"
    }
    
    const albums_results = document.createElement("section")
    albums_results.classList.add("d-flex", "flex-column", "albums-search-results")
    albums_results.innerHTML=`<h2 class="text-center">Álbumes</h2>`
    if(albums.length != 0){
        albums.forEach(album=>{
            const div_album = document.createElement("div")
            div_album.setAttribute("data-album-id", album.id)
            div_album.classList.add("d-flex", "align-items-center", "gap-3", "album-search-individual-result")
            div_album.innerHTML+=`<img src='${album.picture}' class="w-25 rounded">
                                    <h4>${album.title}</h4>`
            div_album.addEventListener("click", (evt)=>{
                showAlbum(evt.currentTarget)
            })
            albums_results.appendChild(div_album)
        })
    }else{
        albums_results.innerHTML+="<h4 class='text-center'>Sin resultados</h4>"
    }
    const songs_results = document.createElement("section") 
    songs_results.classList.add("d-flex", "flex-column", "songs-search-results")
    songs_results.innerHTML+=`<h2 class="text-center">Canciones</h2>`
    if(songs.length != 0){
        songs.forEach((song, index)=>{
            const div_song = document.createElement("div")
            div_song.setAttribute("data-song-id", song.file)
            div_song.classList.add("d-flex", "align-items-center", "gap-3", "song-search-individual-result")
            div_song.innerHTML=`<img src='${song.picture}' class="w-25 rounded">
                                <div>
                                    <h4>${song.title}</h4>
                                    <h5>${song.author}</h5>
                                    <button data-bs-auto-close="true" data-song-id=${song.id} class="btn-group dropup add-song-to-playlist d-flex align-items-center p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false"><ion-icon name="add-outline"></ion-icon></button>
                                            <ul class="dropdown-menu overflow-auto dropdown-menu-add-playlist">
                                            </ul>
                                </div>`
            const add_song_playlist = div_song.querySelector(".add-song-to-playlist")
            add_song_playlist.addEventListener("click", (evt)=>{
                evt.stopPropagation()
                const id_song = evt.currentTarget.getAttribute("data-song-id")
                const ul_container = div_song.querySelector(".dropdown-menu")
                getAllPlaylists(ul_container, "modal", id_song)
            })                          

            div_song.addEventListener("click", (evt)=>{
                playing_queue.push(song)
                playSearchedSong(song)
            })
            songs_results.appendChild(div_song)
        })
    }else{
        songs_results.innerHTML+="<h4 class='text-center'>Sin resultados</h4>"
    }

    results.appendChild(artists_results)
    results.appendChild(albums_results)
    results.appendChild(songs_results)
    main_content.appendChild(results)
})

favorite_albums.addEventListener("click", async (evt)=>{
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

async function playSearchedSong(song){
    audio.src=`${song.file}`
    audio.play()
    play_pause.setAttribute("name", "pause-outline")
    player_logo.classList.add("active")
    track_info.innerHTML=`<img src='${song.picture}' class='rounded'>
                            <div class='d-flex flex-column'>
                                <span class='track-info-title'>${song.title}</span>
                                <span class='track-info-artist'>${song.author}</span>
                            </div>`
                            
    await fetch(`../api_audio/update_times_played.php?id=${song.id}`)
}
async function initialSong(){
    const response = await fetch('../api_audio/songs.php')
    const data = await response.json()
    let song = data['data']
    audio.src=song[0].archivo
    track_info.innerHTML=`<img src='${song[0].picture}' class='rounded'>
                            <div class='d-flex flex-column'>
                                <span class='track-info-title'>${song[0].title}</span>
                                <span class='track-info-artist'>${song[0].artist}</span>
                            </div>`
 
    await fetch(`../api_audio/update_times_played.php?id=${song[0].song_id}`)
}

add_new_playlist.addEventListener("click", ()=>{
    new_playlist_container.classList.add("show-modal-playlist")
})
close_modal_new_list.addEventListener("click", ()=>{
    new_playlist_container.classList.remove("show-modal-playlist")
})
new_playlist.addEventListener("click", async()=>{
    const data_form = new FormData(form_new_list)
    data_form.append("foto", new_playlist_image.files[0])
    data_form.append("nombre", new_playlist_name.value)
    await fetch('../api_audio/new_playlist.php',{
        method: "post",
        body: data_form
    })
    form_new_list.reset()
    getAllPlaylists(playlists_container, "header")
})

async function getAllPlaylists(parent_dom, context, song){
    parent_dom.innerHTML=""
    const response = await fetch('../api_audio/playlists.php')
    const data = await response.json()
    const playlists = data["playlists"]
    console.log(playlists)
    playlists.forEach(list=>{
        let div
        if(context === "header"){
            div = createPlaylistsLinks(list.id, list.title, list.image, list.user)
        }else{
            div = createPlaylistsLinksModal(list.id, list.title, list.user, song)
        }
        
        parent_dom.appendChild(div)
    })
}

async function showFavoriteAlbums(){
    main_content.innerHTML=""
    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    const response = await fetch('../api_audio/favorite_albums.php')
    const data = await response.json()
    loader.classList.remove("d-flex")
    loader.classList.add("d-none")
    const albums = data["albums"]
    main_content.innerHTML="<h1 class='text-center mt-5'>Tus álbumes favoritos</h1>"
    const section_favorite_albums = document.createElement("section")
    section_favorite_albums.classList.add("container-fluid", "d-flex", "flex-column", "gap-3")
    albums.forEach(album=>{
        const div_album = document.createElement("div")
        div_album.setAttribute("data-album-id", album.id)
        div_album.classList.add("d-flex", "gap-3", "align-items-center", "rounded", "favorite-album-container")
        div_album.innerHTML=`<div class='favorite-album-img-container'>
                                <img src='${album.picture}' class='img-fluid'>
                                <canvas></canvas>
                            </div>
                            <div>
                                <h2>${album.title}</h2>
                                <h4>${album.author}</h4>
                            </div>`
        const canvas = div_album.querySelector("canvas")
        const img = document.createElement("img")
        canvas.width='300'
        canvas.height='300'
        img.src=`${album.picture}`
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
        section_favorite_albums.appendChild(div_album)
    })
    main_content.appendChild(section_favorite_albums)
}

function createPlaylistsLinks(id, name, image, user){
    const div = document.createElement("div")
    div.setAttribute("data-list-id", id)
    div.classList.add("d-flex", "gap-2", "w-100", "align-items-center", "playlist-side-menu-container")
    div.innerHTML=`<div class='list-image-container-menu'><img src='${image}' class='playlist-side-menu-foto rounded img-fluid object-fit-cover'></div>
                    <div class='list-text-container-menu d-flex flex-column justify-content-around'>
                        <span>${name}</span>
                        <span class='list-creator'>${user}</span>
                    </div>`
    div.addEventListener("click", ()=>{
        printPlaylist(id)
    })
    return div
}

function createPlaylistsLinksModal(id, name, usuario, song){
    const li = document.createElement("li")
    li.setAttribute("data-list-id", id)
    li.classList.add("dropdown-item", "playlist-item")
    // div.classList.add("d-flex", "w-100", "align-items-center")
    li.innerText=`${name}`
    li.addEventListener("click", async (evt)=>{
        evt.stopPropagation()
        const response = await fetch(`../api_audio/add_to_playlist.php?lista=${id}&cancion=${song}`)

        if(response.status === 200){
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
    await fetch(`../api_audio/delete_playlist.php?id=${id}`) 
    await getAllPlaylists(playlists_container, "header")

}

async function printPlaylist(id){
    main_content.innerHTML=""
    const response = await fetch(`../api_audio/print_playlist.php?id=${id}`)
    const data = await response.json()
    const playlist_data = data["playlist_data"] 
    main_content.classList.add("position-absolute", "w-100", "top-0")
    const section_playlist_head = document.createElement("section")
    section_playlist_head.classList.add("container-fluid", "d-flex","flex-column", "flex-lg-row", "lista-page-header", "gap-3", "align-items-center", "p-3")
    section_playlist_head.innerHTML=`<canvas></canvas>
                                    <div class='d-flex flex-column gap-3 align-items-center align-items-md-start'>
                                        <span>Playlist</span>
                                        <h1 class='text-sm-center'>${playlist_data[0].title}</h1>
                                        <div class='d-flex align-items-center gap-2'>
                                            <img src='${playlist_data[0].image}' class='avatar-lista-page'>
                                            <h3 class='m-0'>Playlist de ${playlist_data[0].author}</h3>
                                        </div>
                                        <h4>Creada el ${formatDate(playlist_data[0].pl_date)}</h4>
                                        <ion-icon id="icon-borrar-playlist" name="trash-outline"></ion-icon>
                                    </div>`
    const canvas = section_playlist_head.querySelector("canvas")
    const delete_playlist = section_playlist_head.querySelector("#icon-borrar-playlist")
    delete_playlist.addEventListener("click", ()=>{
        deletePlaylist(id)
        playerMainState()
    })
    const img = document.createElement("img")
    canvas.width='300'
    canvas.height='300'
    img.src=`${playlist_data[0].image}`
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

    const songs_list = data["songs_data"]

    const section_songs_list = document.createElement("section")
    section_songs_list.classList.add("p-4", "d-flex", "flex-column", "gap-3")
    songs_list.forEach((song, index)=>{
        let song_index = index+1
        const song_container = document.createElement("div")
        song_container.classList.add("d-flex", "justify-content-between", "cancion-row")
        song_container.setAttribute("data-cancion", id)
        song_container.setAttribute("data-index", index)
        song_container.innerHTML=`<div class='d-flex gap-3 align-items-center'>
                                        <span>${song_index}</span>
                                        <div>
                                            <h5 class='m-0 cancion-link'>${song.title}</h5> 
                                            <span class='track-info-artist'>${song.author}</span>
                                        </div>
                                        <button data-bs-auto-close="true" data-song-id=${song.id} class="btn-group dropup add-song-to-playlist d-flex align-items-center p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false"><ion-icon name="add-outline"></ion-icon></button>
                                            <ul class="dropdown-menu overflow-auto dropdown-menu-add-playlist">
                                            </ul>
                                        <ion-icon class="delete-song-from-playlist" name="close-outline"></ion-icon>                                      
                                    </div>                                    
                                    <div class='d-flex align-items-center gap-3'>
                                        <span>${song.length}</span>
                                        
                                    </div>`                                    
        song_container.addEventListener("click", (evt)=>{
            loadPlayingList(evt, "playlist")
        })     
        const delete_song = song_container.querySelector(".delete-song-from-playlist")
        delete_song.addEventListener("click", async (evt)=>{
            evt.stopPropagation()
            await fetch(`../api_audio/delete_from_playlist.php?id_cancion=${song.id}&id_lista=${id}`)
            printPlaylist(id)
        })
        const add_song_playlist = song_container.querySelector(".add-song-to-playlist")
        add_song_playlist.addEventListener("click", (evt)=>{
            evt.stopPropagation()
            const song_id = evt.currentTarget.getAttribute("data-song-id")
            const ul_container = song_container.querySelector(".dropdown-menu")
            getAllPlaylists(ul_container, "modal", song_id)
        })                          
        section_songs_list.appendChild(song_container)
        
    })
    main_content.appendChild(section_songs_list)
    if(!audio.paused){
        for(const child of section_songs_list.children){
            if(child.children[0].children[1].innerText == playing_queue[song_index].titulo){
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
link_main_page.addEventListener("click", (evt)=>{
    evt.preventDefault()
    playerMainState()
})

async function playerMainState(){
    main_content.innerHTML=''
    main_content.classList.remove("position-absolute")
    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    const response = await fetch("../api_audio/player_main_state.php")
    const data = await response.json()
    loader.classList.remove("d-flex")
    loader.classList.add("d-none")
    console.log(data)
    const recommended = {
        image: data["artist"],
        id: data["id_recommended_artist"],
        name: data["name"],
    }
    let disco = 'Grupo <ion-icon name="checkmark-circle-outline"></ion-icon>'
    const banner_main = document.createElement("div")
    banner_main.classList.add("banner-recomended", "mx-auto", "d-flex", "align-items-center", "flex-column", "justify-content-end", "position-relative", "mb-4")
    banner_main.setAttribute("data-artist-id", recommended.id)
    banner_main.innerHTML=`<h2 class='recomended-group-name mb-0'>${recommended.name}</h2>
    <h5 class='ms-3 d-flex align-items-center gap-2 grupo-esencial-badge'>${disco}</h5>`
    
    banner_main.style.backgroundImage=`url('${recommended.image}')`
    banner_main.style.backgroundSize='cover'
    banner_main.style.backgroundPosition='center'
    banner_main.style.height='40vh'
   
    main_content.appendChild(banner_main)
    
    const main_albums_container = document.createElement("div")
    main_albums_container.classList.add("main-content-albums-container", "container-fluid", "d-flex", "flex-column", "flex-lg-row", "gap-3", "mb-5")
    main_content.innerHTML+=`<h2 class='ms-4'>Álbumes populares</h2>`
    main_content.appendChild(main_albums_container)
    const main_content_albums_container = main_content.querySelector(".main-content-albums-container")
    data["data"].forEach(album=>{
        const div_album_container = document.createElement("div")
        div_album_container.classList.add("d-flex", "flex-column", "justify-content-around", "album-inner-container")
        div_album_container.setAttribute("data-album-id", album.id)
        div_album_container.innerHTML= `<img src='${album.picture}' class='img-fluid mb-1 rounded'>
        <a>${album.title}</a>
        <span class='artist-link' data="${album.artist_id}">${album.author}</span>`

        
        main_content_albums_container.appendChild(div_album_container)       
    })
    
    const main_artists_container = document.createElement("div")
    main_artists_container.classList.add("d-flex", "flex-column", "flex-lg-row", "gap-3", "main-content-artists-container", "container-fluid")
    main_content.innerHTML+=`<h2 class='ms-4 mt-3'>Artistas populares</h2>`
    main_content.appendChild(main_artists_container)
    const main_content_artists_container = main_content.querySelector(".main-content-artists-container")
    data["artists"].forEach(artist=>{
        const div_artist_container = document.createElement("div")
        div_artist_container.setAttribute("data-artist-id", artist.id)
        div_artist_container.addEventListener("click", ()=>{
            showGroup(artist.id)
        })
        div_artist_container.classList.add("d-flex", "flex-column", "justify-content-around", "artist-inner-container")   
        div_artist_container.innerHTML=`<img src='${artist.avatar}' class='img-fluid rounded-circle'>
        <a class='text-center text-white'>${artist.name}</a>`
        main_content_artists_container.appendChild(div_artist_container)
    })

    const style_r1 = data["random_style1"]
    const albums_style_r1 = data["albums_style_r1"];

    const albums_random1 = document.createElement("div")
    albums_random1.classList.add("d-flex", "flex-column", "flex-lg-row", "justify-content-start", "gap-3", "main-content-artists-container", "container-fluid")
    main_content.innerHTML+=`<h2 class='ms-4 mt-3'>Álbumes recomendados de ${style_r1}</h2>`
    albums_style_r1.forEach(album=>{
        const div_album_r1_container = document.createElement("div")
        div_album_r1_container.classList.add("d-flex", "flex-column", "justify-content-around", "album-inner-container")
        div_album_r1_container.setAttribute("data-album-id", album.id)
        div_album_r1_container.innerHTML=`<img src='${album.picture}' class='img-fluid mb-1 rounded'>
        <a>${album.title}</a>
        <span class='artist-link' data="${album.artist_id}">${album.author}</span>`
        albums_random1.appendChild(div_album_r1_container)
    })
    main_content.appendChild(albums_random1)
    const pubs_random = data["random_posts"]
  
    main_content.innerHTML+="<h2 class='ms-4 mt-3'>Consulta algunas de nuestras publicaciones exclusivas</h2>"
    const div_publis = document.createElement("div")
    div_publis.classList.add("d-flex", "flex-column", "p-3", "gap-3", "initial-state-pubs-container")
    pubs_random.forEach(pub=>{
        const div_pub = document.createElement("div")
        div_pub.classList.add("d-flex", "gap-3")
        div_pub.innerHTML=`<img src='${pub.image}' class='img-pub-initial-state'>
                            <div class='p-1 d-flex flex-column align-items-start gap-2'>
                                <h3>${pub.title}</h3>
                                <h4>${pub.artist}</h4>
                                <i>${formatDate(pub.p_date)}</i>
                                <button type="button" style='--clr:#0ce8e8' class='btn-danger-own'><span>Ver completa</span><i></i></button>
                            </div>`
        const full_post = div_pub.querySelector("button")
        full_post.addEventListener("click", ()=>{
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
    let current_minutes = Math.floor(audio.currentTime/60)
    let current_seconds = Math.floor(audio.currentTime - current_minutes * 60)

    let width = parseFloat(audio.currentTime / audio.duration * 100)
    seek.value = width
    bar2.style.width=`${width}%`
    dot.style.left=`${width}%`
    if(current_seconds < 10){
        current_seconds = `0${current_seconds}`
    }
    current_time.innerText=`${current_minutes}:${current_seconds}`
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
    let length_min = Math.floor(audio.duration/60)
    let length_seconds = Math.floor(audio.duration - length_min * 60);
    if(length_seconds < 10){
        length_seconds = `0${length_seconds}`
    }   
    end_time.innerText=`${length_min}:${length_seconds}`
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
        song_index++
    }else{
        song_index = Math.floor(Math.random()*playing_queue.length)
    }
    
    const row_album = document.querySelectorAll(".cancion-row")
    let arr = Array.from(row_album)
    const filter = arr.filter(cont=>cont.children[0].children[0].innerText == song_index+1)
    if(song_index < playing_queue.length){
        if(filter.length != 0){
            arr.forEach(item=>{
                item.children[0].children[1].classList.remove("current-song-playing")
            })
            filter[0].children[0].children[1].classList.add("current-song-playing")
        }
        playSong(song_index)
    }
})
next.addEventListener("click", ()=>{
    if(!shuffle_state){
        song_index++
    }else{
        last_song_index = song_index
        song_index = Math.floor(Math.random()*playing_queue.length)
    }
    
    const row_album = document.querySelectorAll(".cancion-row")

    let arr = Array.from(row_album)
    const filter = arr.filter(cont=>cont.children[0].children[0].innerText == song_index+1)
    
    if(song_index < playing_queue.length){
        if(filter.length != 0){
            arr.forEach(item=>{
                item.children[0].children[1].classList.remove("current-song-playing")
            })

            if(filter[0].children[0].children[1].children[0].innerText == playing_queue[song_index].title){
                filter[0].children[0].children[1].classList.add("current-song-playing")
            }
            
        }
        playSong(song_index)
    }else{
        song_index = 0
        if(row_album.length != 0){
            row_album.item(row_album.length-1).children[0].children[1].classList.remove("current-song-playing")
            row_album.item(0).children[0].children[1].classList.add("current-song-playing")
        }
        playSong(song_index)
    }
})
previous.addEventListener("click", ()=>{
    if(!shuffle_state){
        song_index--
    }else{
        song_index = last_song_index
    }
    
    const row_album = document.querySelectorAll(".cancion-row")
    let arr = Array.from(row_album)
    const filter = arr.filter(cont=>cont.children[0].children[0].innerText == song_index+1)
    if(song_index >= 0){
        if(filter.length != 0){
            arr.forEach(item=>{
                item.children[0].children[1].classList.remove("current-song-playing")
            })
            if(filter[0].children[0].children[1].children[0].innerText == playing_queue[song_index].title){
                filter[0].children[0].children[1].classList.add("current-song-playing")
            }
        }
        playSong(song_index)
    }else{
        song_index = 0
        playSong(song_index)
    }
})

volume_input.addEventListener("input", ()=>{
    let value = volume_input.value
    audio.volume=value
    let width = value*100
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
    const response = await fetch(`../api_audio/info_user.php`)
    const data = await response.json()
    let user_data = data["data"]
    console.log(user_data)
    let completed = data["profile_completed"]
    if(completed == 0){
        const response_styles = await fetch('../api_audio/styles.php');
        const data_styles = await response_styles.json()
        const styles = data_styles["styles"]

        const form_complete = document.createElement("section")
        form_complete.classList.add("position-fixed", "top-0", "d-flex", "justify-content-center", "align-items-center")
        const div_container = document.createElement("div")
        div_container.classList.add("d-flex", "flex-column", "p-3", "gap-3","border", "align-items-center")
        div_container.style.background=`linear-gradient(90deg, rgba(0,0,0,1) 5%, rgba(12,159,196,1) 55%, rgba(0,0,0,1) 93%)`
        div_container.innerHTML=`<img src='../media/assets/sonic-waves-logo-simple.png' class="w-25 mx-auto">
        <h1 class='text-center'>¡Bienvenido a Sonic Waves!</h1>
        <p class="w-50 text-center">¡Enhorabuena ${user_data[0].name} ${user_data[0].surname}! Ya formas parte de la familia de Sonic Waves. Antes de podar usar
        nuestro reproductor y todas las posibilidades que este ofrece deberás completar tu perfil. Pero 
        ¡no te preocupes, no te llevará más de 30 segundos!</p>`
        const form = document.createElement("form")
        form.classList.add("d-flex", "flex-column", "align-items-center", "gap-3")
        form.setAttribute("enctype", "multipart/form-data")
        form.setAttribute("method", "post")
        const select_style = createSelect(styles)
        form.appendChild(select_style)
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
        const input_date = form.querySelector("#f_nac")
        const input_avatar = form.querySelector("#foto_avatar")
        const input_style = form.querySelector("select")
        const btn_update = form.querySelector("#completar-perfil")

        div_container.appendChild(form)
        form_complete.style.width="100%"
        form_complete.style.height="100dvh"
        form_complete.style.backdropFilter="blur(3px)"
        form_complete.style.zIndex="8888888888888888888888888888888888888888888888888888888888888"
        form_complete.appendChild(div_container)
        document.body.appendChild(form_complete)
        btn_update.addEventListener("click", ()=>{
            if(input_style.value.trim() !== "" && input_avatar.value.trim() !== "" && input_date.value.trim() !== ""){
                updateProfile(input_avatar, input_style, input_date, form)
                location.reload()
            }
            
        })
        
    }
    profile_menu_avatar.parentElement.parentElement.previousElementSibling.src=user_data[0].avatar

    if(user_data[0].artist != "sin grupo"){
        const li = document.createElement("li")
        li.innerHTML='<a class="dropdown-item" id="link-msgs" href="">Mensajes</a>'

        dropdown_menu_user.insertBefore(li, dropdown_menu_user.lastElementChild)
        const link_messages = li.querySelector("a")
        link_messages.addEventListener("click", async (evt)=>{
            evt.preventDefault()
            loadUserMessages()
            // main_content.innerHTML=""
            // main_content.innerHTML="<h1 class='text-center mb-4'>Mensajes recibidos</h1>"
            // const response = await fetch('../api_audio/get_user_messages.php')
            // const data = await response.json()
            // const section_msgs = document.createElement("section")
            // section_msgs.classList.add("container-xl", "d-flex", "flex-column", "gap-3")
            // data.messages.forEach(msg=>{
            //     const div_msg = document.createElement("div")
            //     if(msg.estado == 0){
            //         div_msg.classList.add("message-not-readed")
            //     }else{
            //         div_msg.classList.add("message-readed")
            //     }
            //     div_msg.classList.add("container-message", 'p-3', "rounded")
            //     div_msg.innerHTML=`<h3>Mensaje de ${msg.name_group} del ${msg.m_date}</h3>
            //                         <p>${msg.content}</p>`
            //     if(msg.estado == 0){
            //         div_msg.innerHTML+=`<span class="mark-msg-as-readed"><ion-icon name="checkmark-done-outline"></ion-icon>Marcar como leído</span>`
            //         const mark_msg = div_msg.querySelector(".mark-msg-as-readed")
            //         mark_msg.addEventListener("click", async ()=>{
            //             await fetch(`../api_audio/mark_message_as_read.php?id=${msg.id_msg}`)
            //         })
            //     }
            //     section_msgs.appendChild(div_msg)
            // })
            // main_content.appendChild(section_msgs)
        })
    }
}


async function loadUserMessages(){
    main_content.innerHTML=""
    main_content.innerHTML="<h1 class='text-center mb-4'>Mensajes recibidos</h1>"
    const response = await fetch('../api_audio/get_user_messages.php')
    const data = await response.json()

    const section_msgs = document.createElement("section")
    section_msgs.classList.add("container-xl", "d-flex", "flex-column", "gap-3")
    data.messages.forEach(msg=>{
        let date_split = msg.m_date.split(" ")

        const div_msg = document.createElement("div")
        if(msg.state == 0){
            div_msg.classList.add("message-not-readed")
        }else{
            div_msg.classList.add("message-readed")
        }
        div_msg.classList.add("container-message", 'p-3', "rounded")
        div_msg.innerHTML=`<h3>Mensaje de ${msg.name_group} del ${formatDate(date_split[0])} a las ${date_split[1]}</h3>
                            <p>${msg.content}</p>`
        if(msg.state == 0){
            div_msg.innerHTML+=`<span class="mark-msg-as-readed"><ion-icon name="checkmark-done-outline"></ion-icon>Marcar como leído</span>`
            const mark_msg = div_msg.querySelector(".mark-msg-as-readed")
            mark_msg.addEventListener("click", async ()=>{
                await fetch(`../api_audio/mark_message_as_read.php?id=${msg.id_msg}`)
                loadUserMessages()
            })
        }
        section_msgs.appendChild(div_msg)
    })
    main_content.appendChild(section_msgs)
}

function createSelect(styles){
    const select = document.createElement("select")
    select.classList.add("p-1")
    select.setAttribute("name", "estilo")
    select.innerHTML="<option checked hidden value='null'>Escoge un estilo</option>"
    styles.forEach(style=>{
        select.innerHTML+=`<option value="${style.id}">${style.name}</option>`
    })
    
    return select
}

async function updateProfile(input_avatar, input_style, input_date, profile_form){
    const formData = new FormData()
    formData.append("foto_avatar", input_avatar.files[0])
    formData.append("estilo", input_style.value)
    formData.append("f_nac", input_date.value)

    
    await fetch(`../api_audio/update_profile.php`, {
        method: 'POST',
        body: formData
    })
    profile_form.reset()
    
}

async function showAlbum(target){
    main_content.innerHTML=''

    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    const id = target.getAttribute("data-album-id")

    const response = await fetch(`../api_audio/album_request.php?id=${id}`)
    const data = await response.json()
    loader.classList.add("d-none")
    loader.classList.remove("d-flex")
    
    const favorite = data["favorite"]
    const total_songs = data["total_songs"]
   
    const album_data = data["album_data"]
    const heart = favorite == 0 ? "fa-regular" : "fa-solid"
    main_content.classList.add("position-absolute", "w-100", "top-0")
    const section_album_head = document.createElement("section")
    section_album_head.classList.add("container-fluid", "d-flex","flex-column", "flex-lg-row", "album-page-header", "gap-3", "align-items-center", "p-3")
    section_album_head.innerHTML=`<canvas></canvas>
                                    <div class='d-flex flex-column gap-3 align-items-center align-items-md-start'>
                                        <h1 class='text-sm-center'>${album_data[0].title}</h1>
                                        <div class='d-flex align-items-center gap-2'>
                                            <img src='${album_data[0].avatar}' class='avatar-album-page'>
                                            <h3 data-artist-id=${album_data[0].artist_id} class='m-0 album-page-artist-link'>${album_data[0].author}</h3>
                                        </div>
                                        <h4>Lanzado el ${formatDate(album_data[0].release_date)} · ${total_songs} canciones</h4>
                                        <div class='d-flex gap-4'>
                                            <i data-favorite=${favorite} class="${heart} fa-heart add-favorite-album"></i>
                                            <i data-album-id="${id}" class="fa-regular fa-comment add-album-review see-album-reviews"></i>
                                        </div>
                                    </div>`
    const canvas = section_album_head.querySelector("canvas")
    const add_favorite = section_album_head.querySelector(".add-favorite-album")
    const see_reviews = section_album_head.querySelector(".see-album-reviews")
    add_favorite.addEventListener("click", (evt)=>{
        const is_favorite = evt.target.getAttribute("data-favorite")
        if(is_favorite == 0){
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
    const artist_link = section_album_head.querySelector("h3")
    artist_link.addEventListener("click", ()=>{
        showGroup(album_data[0].artist_id)
    })
    const img = document.createElement("img")
    canvas.width='300'
    canvas.height='300'
    img.src=`${album_data[0].picture}`
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
    const songs_list = data["songs_list"]
    const section_songs_list = document.createElement("section")
    section_songs_list.classList.add("p-4", "d-flex", "flex-column", "gap-3")

    songs_list.forEach((song, index)=>{
        let song_index = index+1
        const song_container = document.createElement("div")
        song_container.classList.add("d-flex", "justify-content-between", "cancion-row")
        song_container.setAttribute("data-cancion", song.album)
        song_container.setAttribute("data-index", index)
        song_container.innerHTML=`<div class='d-flex gap-3 align-items-center'>
                                        <span>${song_index}</span>
                                        <div>
                                            <h5 class='m-0 cancion-link'>${song.title}</h5> 
                                            <span class='track-info-artist'>${album_data[0].author}</span>
                                        </div>
                                        <button data-bs-auto-close="true" data-song-id=${song.id} class="btn-group dropup add-song-to-playlist d-flex align-items-center p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false"><ion-icon name="add-outline"></ion-icon></button>
                                            <ul class="dropdown-menu overflow-auto dropdown-menu-add-playlist">
                                            </ul>                                      
                                    </div>                                    
                                    <div class='d-flex align-items-center gap-3'>
                                        <span>${song.length}</span>
                                        
                                    </div>`                                   
        song_container.addEventListener("click", (evt)=>{
            loadPlayingList(evt, "album")
        })     
        const add_song_playlist = song_container.querySelector(".add-song-to-playlist")
        add_song_playlist.addEventListener("click", (evt)=>{
            evt.stopPropagation()
            const song_id = evt.currentTarget.getAttribute("data-song-id")
            const ul_container = song_container.querySelector(".dropdown-menu")
            getAllPlaylists(ul_container, "modal", song_id)
        })                          
        section_songs_list.appendChild(song_container)
        
    })
    // if(datos_album[0].discografica != "Autogestionado"){
    //     main_content.innerHTML+=`<i class="album-copyright">Publicado por ${datos_album[0].discografica}, All Rights Reserved © <img src='${datos_album[0].foto_discografica}' class='rounded-circle discografica-copyright-image'></i>`
    // }else{
    //     section_songs_list.innerHTML+=`<i class="album-copyright">Publicado por ${datos_album[0].autor}, All Rights Reserved © <img src='${datos_album[0].avatar}' class='rounded-circle discografica-copyright-image'></i>`
    // }
    main_content.appendChild(section_songs_list)
    
    if(!audio.paused){
        for(const child of section_songs_list.children){
            if(!child.classList.contains("album-copyright")){
          
                if(child.children[0].children[1].children[0].innerText == playing_queue[song_index].titulo){
                    child.children[0].children[1].classList.add("current-song-playing")
                }
            }
            
        }
    }  
}

async function addFavoriteAlbum(id){
    await fetch(`../api_audio/add_favorite_album.php?id=${id}`)
}

async function deleteFavoriteAlbum(id){
    await fetch(`../api_audio/remove_album_favorito.php?id=${id}`)
}

async function seeAlbumReviews(id){
    main_content.innerHTML=''
    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    
    const response = await fetch(`../api_audio/album_reviews.php?id=${id}`)
    const data = await response.json()
    loader.classList.remove("d-flex")
    loader.classList.add("d-none")

    const album_data = data["album_data"]
    const written_review = data["has_wrote_review"]
    main_content.classList.add("position-absolute", "w-100", "top-0")
    const section_album_head = document.createElement("section")
    // section_album_head.setAttribute("data-album-id", id)
    section_album_head.classList.add("container-fluid", "d-flex","flex-column", "flex-lg-row", "album-page-header", "gap-3", "align-items-center", "p-3")
    section_album_head.innerHTML=`<canvas></canvas>
                                    <div class='d-flex flex-column gap-3'>
                                        <h1>${album_data[0].title}</h1>
                                        <div class='d-flex align-items-center gap-2'>
                                            <img src='${album_data[0].avatar}' class='avatar-album-page'>
                                            <h3 data-artist-id=${album_data[0].artist_id} class='m-0'>${album_data[0].author}</h3>
                                        </div>
                                        <h4>Lanzado el ${formatDate(album_data[0].release_date)}</h4>
                                        <div class='d-flex gap-4'>
                                      
                                            <ion-icon data-album-id="${id}"  class="album-song-list" name="musical-notes-outline"></ion-icon>
                                        </div>
                                    </div>`
    const canvas = section_album_head.querySelector("canvas")
    const album_songs = section_album_head.querySelector(".album-song-list")
    album_songs.addEventListener("click", (evt)=>{
        showAlbum(evt.target)
    })
    const artist_link = section_album_head.querySelector("h3")
    artist_link.addEventListener("click", ()=>{
        showGroup(album_data[0].artist_id)
    })
    const img = document.createElement("img")
    canvas.width='300'
    canvas.height='300'
    img.src=`${album_data[0].picture}`
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

    const review_data = data["reviews"]
    if(written_review[0].checker == 0){
        const form_review = document.createElement("form")
        form_review.setAttribute("id", "formulario-insertar-reseña")
        form_review.classList.add("d-flex", "flex-column", "gap-5", "align-items-center", "p-3")
        form_review.innerHTML=`<div class='input-field w-100'><input class="w-100" placeholder="Título de la reseña" name="titulo" type="text" id="titulo-reseña" required></div>
                                    <div class='input-field w-100'><input class="w-100" placeholder="Contenido de la reseña" type="text" id="contenido-reseña" name="contenido" required></div>
                                    <input hidden value="${id}" name="id-album">
                                    <button data-album-id="${id}" id="enviar-reseña" type="button" style='--clr:#0ce8e8' class='btn-danger-own'><span>Comentar</span><i></i></button>`
        const section_new_review = document.createElement("section")
        section_new_review.innerHTML=`<h2 class='text-center mt-4'>Añade tu reseña para ${album_data[0].title}</h2>`
        const btn_insert_review = form_review.querySelector("#enviar-reseña")
        const review_title = form_review.querySelector("#titulo-reseña")
        const review_content = form_review.querySelector("#contenido-reseña")
        section_new_review.appendChild(form_review)
        btn_insert_review.addEventListener("click", async (evt)=>{
            if(review_title.value.trim() !== "" && review_content.value.trim() !== ""){
                await insertReview(form_review)
                await seeAlbumReviews(id)
            }else{
                alert_review_missing_data.classList.remove("d-none")
                setTimeout(removeDataLack, 2000)
            }
            
        })
        main_content.appendChild(section_new_review)
    }
    const section_reviews = document.createElement("section")
    section_reviews.classList.add("container-fluid")
    section_reviews.innerHTML="<h2 class='text-center mt-3'>Reseñas de los usuarios de Sonic Waves</h2>"
    const reviews_container = document.createElement("div")
    reviews_container.classList.add("d-flex", "flex-column", "gap-3")
    review_data.forEach(review=>{
        let r_date = formatDate(review.r_date)
        const review_cont = document.createElement("div")
        review_cont.classList.add("d-flex", "flex-column", "single-review-container", "p-2","rounded")
        review_cont.innerHTML=`<h3>${review.title}</h3>
                                <p>${review.content}</p>
                                <div class='d-flex align-items-center gap-2'>
                                    <img src='${review.avatar}' class='rounded-circle see-album-reviews-avatar-user'>
                                    <i>Escrita por ${review.author} el ${r_date}</i>
                                </div>`
                                
        // review_cont.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color2.r}, ${color2.g}, ${color2.b}, .5), rgba(${color5.r},${color5.g},${color5.b},.5) 70%)`
        reviews_container.appendChild(review_cont)
    })
    section_reviews.appendChild(reviews_container)
    main_content.appendChild(section_reviews)
    
}

async function insertReview(form_review){
    const data_form_review = new URLSearchParams(new FormData(form_review))
    await fetch(`../api_audio/insert_review.php`, {
        method: 'POST',
        body: data_form_review
    })
    form_review.reset()
    
}

async function loadShufflePlayingList(){
    playing_queue.length = 0
    const response = await fetch('../api_audio/shuffle.php')
    const data = await response.json()
    const random_list = data["random_list"]
    random_list.forEach(song=>{
        playing_queue.push(song)
    })
    console.log(playing_queue)
    playSong(song_index)
}

async function loadPlayingList(evt, context){
    let parent = evt.currentTarget.parentElement
    
    for(const child of parent.children){
        let title = child.children[0].children[1]
        if(title.classList.contains("current-song-playing")){
            title.classList.remove("current-song-playing")
        }
    }
    let title_current = evt.currentTarget.children[0].children[1]
    title_current.classList.add("current-song-playing")
    const id = evt.currentTarget.getAttribute("data-cancion")
   
    const index = evt.currentTarget.getAttribute("data-index")
    song_index = index
    const response = await fetch(`../api_audio/playing_array.php?id=${id}&contexto=${context}`)
    const data = await response.json()
    const songlist = data["songlist"]
    
    if(playing_queue.length != 0){
        if(playing_queue.length != songlist.length){
            playing_queue.length = 0
        }
        else{
            if(songlist[song_index].title != playing_queue[song_index].title){
                playing_queue.length = 0
            }
        }
    }

    if(playing_queue.length == 0){
        songlist.forEach(song=>{
            playing_queue.push(song)
        })
    }
       
    playSong(song_index)
    
}

//Función que muestra todo el perfil de un grupo junto con su información
async function showGroup(id){
    main_content.innerHTML=''
    main_content.classList.add("position-absolute", "w-100", "top-0")
    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    // const id = evt.currentTarget.getAttribute("data-artist-id")
    const response = await fetch(`../api_audio/artist_request.php?id=${id}`)
    const data = await response.json()
    loader.classList.add("d-none")
    loader.classList.remove("d-flex")
    const artist_data = data["artist_data"]
    const albums = data["artist_albums"]
    // const tiene_discografica = datos_grupo[0].discografica
    let posts = []
    // if(tiene_discografica == 0){
        posts = data["artist_posts"] 
        console.log(data)
    // }
 
    let album = 'Grupo<ion-icon name="checkmark-circle-outline"></ion-icon>'
    let header_extra = 'Publicaciones'
    const section_artist_head = document.createElement("section")
    section_artist_head.classList.add("mb-5")
    const div_artist_avatar = document.createElement("div")
    section_artist_head.innerHTML=`<div class='d-flex flex-column align-items-start'><h1 class='ms-4 section-artist-title mb-0'>${artist_data[0].name}</h1>
    <h5 class='ms-4 d-flex align-items-center grupo-esencial-badge'>${album}</h5></div>`
    section_artist_head.classList.add("d-flex","justify-content-end", "flex-column")
    div_artist_avatar.classList.add("position-absolute")
    div_artist_avatar.style.width='100%'
    div_artist_avatar.style.height='100%'
    div_artist_avatar.innerHTML=`<img class='position-absolute rounded-circle section-artist-avatar' src='${artist_data[0].avatar}'>`
    section_artist_head.appendChild(div_artist_avatar)
    section_artist_head.classList.add("w-100")
    section_artist_head.style.backgroundImage=`url('${artist_data[0].image}')`
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
    bio.innerText=`${artist_data[0].bio}`
    div_artist_content.appendChild(bio)
    const div_albums_container = document.createElement("div")
    div_albums_container.classList.add("d-flex", "gap-3", "d-none", "options-artist", "flex-column", "flex-lg-row", "mb-3")
    div_albums_container.setAttribute("data-info-artist", "discos")
    if(albums.length != 0){
        albums.forEach(album=>{
            const album_detail = document.createElement("div")
            album_detail.classList.add("d-flex", "gap-3", "align-items-center", "album-individual-container")
            album_detail.setAttribute("data-album-id", album.id)
            album_detail.innerHTML+=`<div class='w-50'>
                                <img src='${album.picture}' class='img-fluid object-fit-cover'>
                            </div>
                            <div class='d-flex w-50'>
                                <h5>${album.title}</h5>
                            </div>`
            album_detail.addEventListener("click", (evt)=>{
                showAlbum(evt.currentTarget)
            })
            div_albums_container.appendChild(album_detail)
        })
    }else{
        div_albums_container.innerHTML=`<h2 class='text-center'>Este artista no tiene álbumes por el momento</h2>`
    }
    
    div_artist_content.appendChild(div_albums_container)

    const div_posts = document.createElement("div")
    div_posts.classList.add("d-flex", "d-none", "options-artist", "flex-column", "container-lg", "gap-4")
    div_posts.setAttribute("data-info-artist", "pubs")
    // if(tiene_discografica == 0){    
        if(posts.length != 0){
            posts.forEach(post=>{
                const div_post = document.createElement("div")
                let preview_text = post.content.substring(0, 400)
                div_post.classList.add("post-individual-container", "d-flex","gap-3", "p-3", "flex-column", "flex-md-row")
                div_post.innerHTML=`<div>
                                                <img src='${post.image}' class='img-fluid'>
                                            </div>
                                            <div class='gap-2 d-flex flex-column align-items-start'>
                                                <h2>${post.title}</h2>
                                                <p>${preview_text}...</p>
                                                <i>${formatDate(post.p_date)}</i>
                                                <button type="button" style='--clr:#0ce8e8' class='btn-danger-own'><span>Ver completa</span><i></i></button>
                                            </div>`
                const watch_post = div_post.querySelector("button")
                watch_post.addEventListener("click", ()=>{
                    watchFullPost(post.id)
                })
                div_posts.appendChild(div_post)
            })
        }else{
            div_posts.innerHTML="<h3 class='text-center'>No hay publicaciones</h3>"
        }
        
    // }else{
    //     // await seeUpcomingEvents(datos_grupo[0].nombre, div_posts)
    // }
    div_artist_content.appendChild(div_posts)

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
    const response = await fetch(`../api_audio/full_post.php?id=${id}`)
    const data = await response.json()
    const post_data = data["post_data"]
    const extra_photos = data["extra_photos"]
  
    
    // main_content.innerHTML=`<button type="button" style='--clr:#0ce8e8' class='ms-3 btn-danger-own'><span>Volver al grupo</span><i></i></button>`
   
    const post_container = document.createElement("section")
    post_container.classList.add("container-fluid", "d-flex", "flex-column", "gap-3", "p-3", "full-post-container")
    post_container.innerHTML=`   <div class='d-flex w-100 gap-3 flex-column flex-lg-row align-items-center align-items-md-start'><canvas></canvas>
                                        <img src='${post_data[0].image}' class='rounded object-fit-cover main-photo'>
                                
                                    <div class='d-flex flex-column gap-3 align-items-start'>
                                        <h1>${post_data[0].title}</h1>
                                        <pre class='full-post-content'>${post_data[0].content}</pre>
                                        <i>Publicado el ${formatDate(post_data[0].p_date)}</i>
                                        <button type="button" style='--clr:#0ce8e8' class='btn-danger-own'><span>Volver al grupo</span><i></i></button>
                                    </div></div>`
    if(extra_photos != undefined){
        const div_extra_photos = document.createElement("div")
        div_extra_photos.classList.add("d-flex", "flex-column", "flex-md-row", "gap-3")
        
        extra_photos.forEach(photo=>{
            const img = document.createElement("img")
            img.classList.add("rounded", "extra-photo-post", "object-fit-cover")
            img.src=`${photo.link}`
            div_extra_photos.appendChild(img)
        })
        post_container.appendChild(div_extra_photos)
    }
    const btn = post_container.querySelector("button")
    btn.addEventListener("click", ()=>{
        showGroup(post_data[0].artist)
    })
    const canvas = post_container.querySelector("canvas")
    const img = post_container.querySelector(".main-photo")
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

    post_container.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color3.r},${color3.g},${color3.b},0.6500175070028011) 50% , rgba(${color2.r}, ${color2.g}, ${color2.b}, .85), rgba(${color5.r},${color5.g},${color5.b},1) 100%)`
    main_content.appendChild(post_container)
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
    audio.src=playing_queue[index].file
    track_info.innerHTML=`<img src='${playing_queue[index].picture}' class='rounded'>
                            <div class='d-flex flex-column'>
                                <span class='track-info-title'>${playing_queue[index].title}</span>
                                <span class='track-info-artist'>${playing_queue[index].author}</span>
                            </div>`
    console.log(playing_queue[index])
    bar2.style.width='0%'
    dot.style.left='0'
    current_time.innerText='0:00'
    audio.play()
    play_pause.setAttribute("name", "pause-outline")
    player_logo.classList.add("active")
    await fetch(`../api_audio/update_times_played.php?id=${playing_queue[index].song_id}`)
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
  function formatDate(date){
    let date_object = new Date(date)
    return `${addZeroToDate(date_object.getDate())}-${addZeroToDate(date_object.getMonth()+1)}-${date_object.getFullYear()}`
  }

  //Función que añade ceros a la izquierda a una date si fuera necesario (ej. 2 => 02)
  function addZeroToDate(date){
    return date < 10 ? `0${date}` : date
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
