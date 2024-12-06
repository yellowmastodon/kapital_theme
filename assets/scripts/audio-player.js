let playIconContainer;
let audioPlayerContainer;
let seekSlider;
let playState;
let audio;
let durationContainer;
let raf;


const initializeAudioPlayer = () =>{
    playIconContainer = document.getElementById('play-button');
    audioPlayerContainer = document.getElementById('audio-player-container');
    seekSlider = document.getElementById('seek-slider');
    playState = 'play';
    audio = document.querySelector('audio');
    durationContainer = document.getElementById('duration');
    raf = null;

    playIconContainer.addEventListener('click', () => {
        if(playState === 'play') {
            audio.play();
            requestAnimationFrame(whilePlaying);
            playState = 'pause';
            playIconContainer.classList.add("playing");
        } else {
            audio.pause();
            cancelAnimationFrame(raf);
            playState = 'play';
            playIconContainer.classList.remove("playing");
        }
    });
    seekSlider.addEventListener('input', (e) => {
        showRangeProgress(e.target);
    });
    if (audio.readyState > 0) {
        displayDuration();
        setSliderMax();
    } else {
        audio.addEventListener('loadedmetadata', () => {
            displayDuration();
            setSliderMax();
        });
    }

    seekSlider.addEventListener('input', () => {
        displayDuration();
        if(!audio.paused) {
            cancelAnimationFrame(raf);
        }
    });
    
    seekSlider.addEventListener('change', () => {
        audio.currentTime = seekSlider.value;
        displayDuration();
        if(!audio.paused) {
            requestAnimationFrame(whilePlaying);
        }
    });
}


const showRangeProgress = (rangeInput) => {
    if(rangeInput === seekSlider) audioPlayerContainer.style.setProperty('--seek-before-width', rangeInput.value / rangeInput.max * 100 + '%');
    else audioPlayerContainer.style.setProperty('--volume-before-width', rangeInput.value / rangeInput.max * 100 + '%');
}

const calculateTime = (secs) => {
    const minutes = Math.floor(secs / 60);
    const seconds = Math.floor(secs % 60);
    const returnedSeconds = seconds < 10 ? `0${seconds}` : `${seconds}`;
    return `${minutes}:${returnedSeconds}`;
}

const displayDuration = () => {
    durationContainer.textContent = calculateTime(audio.duration - seekSlider.value);
}

const setSliderMax = () => {
    seekSlider.max = Math.floor(audio.duration);
}

const whilePlaying = () => {
      displayDuration();
      seekSlider.value = Math.floor(audio.currentTime);
      audioPlayerContainer.style.setProperty('--seek-before-width', `${seekSlider.value / seekSlider.max * 100}%`);
      raf = requestAnimationFrame(whilePlaying);
      if (audio.paused){
          playState = 'play';
          playIconContainer.classList.remove("playing");
      }
}

window.addEventListener('DOMContentLoaded', () => {
    initializeAudioPlayer();
});
