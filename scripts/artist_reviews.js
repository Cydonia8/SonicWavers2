"use strict"
const containers_album = document.querySelectorAll(".album-review-group-container")


containers_album.forEach(container=>{
    const canva = container.querySelector("canvas")
    const btn = container.querySelector("button")
    const img = container.querySelector(".album-review-container-img img")
    canva.width='300'
    canva.height='300'
    let ctxt = canva.getContext("2d")
    ctxt.drawImage(img, 0, 0, 280, 280)
    const image_data = ctxt.getImageData(0,0,canva.width, canva.height)
    let rgb_array = buildRGBArray(image_data.data)
    const quantColors = quantization(rgb_array, 0)
    quantColors.sort((a,b) => a-b)
    let color1 = quantColors[quantColors.length-1]
    let color2 = quantColors[quantColors.length-8]
    let color3 = quantColors[quantColors.length-4]
    let color4 = quantColors[quantColors.length-11]
    let color5 = quantColors[quantColors.length-14]
    container.style.background=`linear-gradient(250deg, rgba(${color1.r},${color1.g},${color1.b},.5) 20%, rgba(${color3.r},${color3.g},${color3.b},0.6500175070028011) 50% , rgba(${color2.r}, ${color2.g}, ${color2.b}, .85), rgba(${color5.r},${color5.g},${color5.b},1) 100%)`
    if(btn !== null){
        btn.style=`--clr:rgb(${color1.r},${color1.g}, ${color1.b})`
    }
})

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

