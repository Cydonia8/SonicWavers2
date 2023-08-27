"use strict"
const main_content = document.getElementById("main-content-dynamic-container")
const loader = document.querySelector("#loader")
const link_main_page = document.getElementById("home-link")
const arrow_show_aside = document.getElementById("arrow-show-aside")
const header_aside = document.getElementById("side-menu")
const search_bar = document.getElementById("search-bar")
const recommended_list = document.getElementById("lista-recomendada")


//API Key
const MXMATCH_API_KEY = "230777d3bbd468016bc464b2a53b4c22"

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
// const letra = document.getElementById("letra")
const play_pause = document.getElementById("play-pause")

//Elementos relativos al tiempo
const current_time = document.getElementById("current-time")
const end_time = document.getElementById("end-time")
const audio = document.querySelector("audio")


//Elementos del ecualizador
// const context = new AudioContext()
// const lowFilter = new BiquadFilterNode(context,{type:'lowshelf',frequency:100})
// const midLowFilter = new BiquadFilterNode(context,{type:'peaking',frequency:400,Q:3})
// const midFilter = new BiquadFilterNode(context,{type:'peaking',frequency:400,Q:3})
// const midHighFilter = new BiquadFilterNode(context,{type:'peaking',frequency:800,Q:3})
// const highFilter = new BiquadFilterNode(context,{type:'highshelf',frequency:1600})
// const finalGain = new GainNode(context)

//Cola reproducción que contendrá las canciones que se irán reproduciendo
let playing_queue = []
//Indice de canción que se está reproduciendo
let song_index=0

let last_song_index
//Variable para controlar el aleatorio
let shuffle_state = false


//Listener que activa el aleatorio
shuffle.addEventListener("click", activateShuffle)

//Listener que genera una lista de canciones recomendadas
recommended_list.addEventListener("click", (evt)=>{
    evt.preventDefault()
    loadShufflePlayingList()
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

loadShufflePlayingList()
initialVolume()
playerMainState()

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


function initialVolume(){
    document.addEventListener("DOMContentLoaded", ()=>{
        audio.volume='0.5'
        volume_bar.style.width=`50%`
        volume_dot.style.left=`50%`
    })
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
                                           
                                            <i data-album-id="${id}" class="fa-regular fa-comment add-album-review see-album-reviews"></i>
                                        </div>
                                    </div>`
    const canvas = section_album_head.querySelector("canvas")
    const see_reviews = section_album_head.querySelector(".see-album-reviews")

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


async function seeAlbumReviews(id){
    main_content.innerHTML=''
    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    
    const response = await fetch(`../api_audio/album_reviews_nouser.php?id=${id}`)
    const data = await response.json()
    loader.classList.remove("d-flex")
    loader.classList.add("d-none")

    const album_data = data["album_data"]
    main_content.classList.add("position-absolute", "w-100", "top-0")
    const section_album_head = document.createElement("section")
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
    const enlace_grupo = section_album_head.querySelector("h3")
    enlace_grupo.addEventListener("click", ()=>{
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
                                    <i>Escrita por ${review.auhtor} el ${r_date}</i>
                                </div>`
                                
        // review_cont.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 40%, rgba(${color2.r}, ${color2.g}, ${color2.b}, .5), rgba(${color5.r},${color5.g},${color5.b},.5) 70%)`
        reviews_container.appendChild(review_cont)
    })
    section_reviews.appendChild(reviews_container)
    main_content.appendChild(section_reviews)
    
}

async function loadShufflePlayingList(){
    playing_queue.length = 0
    const response = await fetch('../api_audio/shuffle_nouser.php')
    const data = await response.json()
    const random_list = data["random_list"]
    random_list.forEach(song=>{
        playing_queue.push(song)
    })

    if(audio.paused){
        loadSong()
    }
    
}

function loadSong(){
    audio.src=playing_queue[0].file
    track_info.innerHTML=`<img src='${playing_queue[0].picture}' class='rounded'>
                            <div class='d-flex flex-column'>
                                <span class='track-info-title'>${playing_queue[0].title}</span>
                                <span class='track-info-artist'>${playing_queue[0].author}</span>
                            </div>`
    bar2.style.width='0%'
    dot.style.left='0'
    current_time.innerText='0:00'
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
    div_albums_container.classList.add("d-flex", "gap-3", "d-none", "options-artist", "flex-column", "flex-lg-row", "mb-3", "flex-wrap")
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
