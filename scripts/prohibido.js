const equalizer = document.querySelector('.equalizer');

const getRandomHeight = (min, max) => ~~(Math.random() * (max - min + 1)) + min;

const animateEqualizer = () => {
  const lines = equalizer.querySelectorAll('div');
  setInterval(() => {
    lines.forEach((line, idx) => {
      const height = getRandomHeight(line.clientWidth, equalizer.clientHeight);
      const shadowLine = equalizer.nextSibling.childNodes[idx];
      
      line.style.height = `${height}px`;
      shadowLine.style.height = `${height}px`;
    })
  }, 100);
}

const createEqualizer = (n) => {
  for (let i = 0; i < n; i++) {
    const line = document.createElement('div');
    equalizer.appendChild(line);
  }
  const shadow = equalizer.cloneNode(true);
  equalizer.after(shadow);
  
  animateEqualizer();
}

createEqualizer(50);