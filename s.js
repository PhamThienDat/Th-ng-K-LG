
function goback() {    history.back(-1)
}
window.onscroll = function() {scrollFunction()};
function scrollFunction() {

if (document.body.scrollTop > 0 || document.documentElement.scrollTop > 0) {
document.getElementById("myBtn").style.display = "block";
} else {
document.getElementById("myBtn").style.display = "none";
}
}

document.getElementById('myBtn').addEventListener("click", function(){
document.body.scrollTop = 0;
document.documentElement.scrollTop = 0;
});
var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')



