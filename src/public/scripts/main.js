//Navigation Toggle
function navToggle() {
  var menu = document.getElementById("content-toggle");
  if (menu.className === "nav-main") {
    menu.className += " responsive";
  } else {
    menu.className = "nav-main";
  }
}

//Visar och gömmer element
let entries = document.getElementById("entries-wrapper");
let users = document.getElementById("users");
let comments = document.getElementById("comments");

let entriesLink = document.getElementById("entries-link");
let usersLink = document.getElementById("users-link");
let commentsLink = document.getElementById("comments-link");

function showEntries() {
  entries.style.display = "block";
  users.style.display = "none";
  comments.style.display = "none";

  entriesLink.classList.add("active");
  usersLink.classList.remove("active");
  commentsLink.classList.remove("active");
}
function showUsers() {
  users.style.display = "block";
  entries.style.display = "none";
  comments.style.display = "none";

  usersLink.classList.add("active");
  entriesLink.classList.remove("active");
  commentsLink.classList.remove("active");
}
function showComments() {
  users.style.display = "none";
  entries.style.display = "none";
  comments.style.display = "flex";

  commentsLink.classList.add("active");
  usersLink.classList.remove("active");
  entriesLink.classList.remove("active");
}

function showSignin() {
  let loginForm = document.getElementById("login-form");
  if (loginForm.className === "login-form") {
    loginForm.className += " visible";
  } else {
    loginForm.className = "login-form";
  }
}
