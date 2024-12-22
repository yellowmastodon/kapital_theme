export default function loadHeaderSeries(){
    const headerSeries = document.querySelectorAll('.header-series-wrapper > a');
    if (headerSeries.length > 0){
        headerSeries[getRandomInt(0, headerSeries.length - 1)].style.display = "";        
    }

}
function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}