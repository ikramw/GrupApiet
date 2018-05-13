//Navigation Toggle
function navToggle() {
    var menu = document.getElementById("content-toggle");
    if (menu.className === "nav-main") {
        menu.className += " responsive";
    } else {
        menu.className = "nav-main";
    }
}
function closeMenu() {
    var menu = document.getElementById("content-toggle");
    if (menu.className === "nav-main responsive") {
        menu.className = "nav-main";
    } else {
        menu.className = "nav-main";
    }
}

//Visar och gömmer element
let entries = document.getElementById("entries-wrapper");
let users = document.getElementById("users");
let comments = document.getElementById("comments");

function showEntries() {
    entries.style.display = "block";
    users.style.display = "none";
    comments.style.display = "none";
}
function showUsers() {
    users.style.display = "block";
    entries.style.display = "none";
    comments.style.display = "none";
}
function showComments() {
    users.style.display = "none";
    entries.style.display = "none";
    comments.style.display = "flex";
}
