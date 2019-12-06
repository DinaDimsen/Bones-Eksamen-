var darklighttoggle = document.querySelector("#darklight");

darklighttoggle.addEventListener("click",function(){
    var darktoggle = document.querySelector("body");
    var box = document.querySelector(".intro_text");
    var text = document.querySelector(".intro_text h1")
    var text_p = document.querySelector(".intro_text p");
    
    box.classList.toggle("intro_text_dark");
    darktoggle.classList.toggle("darkmode");
    text.classList.toggle("dark_text");
    text_p.classList.toggle("dark_text");
});

