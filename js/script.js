window.onscroll = function() { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";

    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

function closeBar() {
    document.getElementById('bar').style.top = "-100%";
    document.getElementById('bar').style.transition = "0.5s ease";
}

function showBar() {
    document.getElementById('bar').style.transition = "0.5s ease";
    document.getElementById('bar').style.top = "0px";

}

function closeError() {
    document.getElementById('errorbtn1').style.display = "block";
    document.getElementById('errorbtn2').style.display = "none";
    document.getElementById('error').style.transition = "0.5s ease";
    document.getElementById('error').style.transform = "translateX(100%)";


}

function showError() {
    document.getElementById('error').style.transition = "0.5s ease";
    document.getElementById('error').style.transform = "translateX(0px)";
    document.getElementById('errorbtn1').style.display = "none";
    document.getElementById('errorbtn2').style.display = "block";
}
