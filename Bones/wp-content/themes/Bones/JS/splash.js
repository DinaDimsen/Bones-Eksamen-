let splash = document.querySelector(".splash");

setTimeout(function(){ 
	
	splash.style.transition = "opacity .5s ease-out";
	splash.style.opacity = "0";

	setTimeout(function(){
		splash.style.display = "none";
	},500);

}, 2000);