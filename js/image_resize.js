function resizeImage(elId, i) {
    var containerW = document.getElementById(elId).offsetWidth;
    var containerH = document.getElementById(elId).offsetHeight;
    var ImgW = document.getElementById(elId).getElementsByTagName("img")[i].clientWidth;
    var ImgH = document.getElementById(elId).getElementsByTagName("img")[i].clientHeight;

    if (ImgW/ImgH < containerW/containerH) {
        ImgW = ImgW * containerH / ImgH;
        ImgH = containerH;
        document.getElementById(elId).getElementsByTagName("img")[i].style.marginLeft = (containerW-ImgW)/2;
    } else {
        ImgH = ImgH * containerW / ImgW;
        ImgW = containerW;
        document.getElementById(elId).getElementsByTagName("img")[i].style.marginTop = (containerH-ImgH)/2;
    }
    document.getElementById(elId).getElementsByTagName("img")[i].style.width = ImgW;
    document.getElementById(elId).getElementsByTagName("img")[i].style.height = ImgH;
}
