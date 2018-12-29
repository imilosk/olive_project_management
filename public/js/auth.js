/* function item1() {
	localStorage.setItem("item", "item1");
}

function item2() {
	localStorage.setItem("item", "item2");
}

function item3() {
	localStorage.setItem("item", "item3");
}

function item4() {
	localStorage.setItem("item", "item4");
}

function item5() {
	localStorage.setItem("item", "item5");
}

window.onload = function(){
	if(window.location.pathname == "/")
		localStorage.setItem("item", "item1");
	
	document.getElementById(localStorage.getItem("item")).classList.add("active");
} */

document.getElementById("form").addEventListener("submit", function() {
	var password1 = document.getElementById("password1").value;
	var password2 = document.getElementById("password2").value;
	
	if(password1 != password2) {
		return false;
	}
	else {
		return true;
	}
})