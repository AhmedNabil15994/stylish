var myVar;

function loaderFunction() {
    if(window.onload)
    {
        showPage();
    }
}

function showPage() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("wrapper").style.display = "block";
}
