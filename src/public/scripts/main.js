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
let entries = document.getElementById("entries");
let users = document.getElementById("users");
let comments = document.getElementById("comments");
let singleUser = document.getElementById("single-user");
let singleEntry = document.getElementById("single-entry");
let frontpageHeader = document.getElementById("frontpage-header");
let singleUsername = document.getElementById("display-username");

let entriesLink = document.getElementById("entries-link");
let usersLink = document.getElementById("users-link");
let commentsLink = document.getElementById("comments-link");

function showEntries() {
  entries.style.display = "block";
  users.style.display = "none";
  comments.style.display = "none";
  frontpageHeader.style.display = "block";
  singleUser.style.display = "none";
  singleUsername.style.display = "none";
  singleEntry.style.display = "none";

  entriesLink.classList.add("active");
  usersLink.classList.remove("active");
  commentsLink.classList.remove("active");
}
function showUsers() {
  users.style.display = "block";
  entries.style.display = "none";
  comments.style.display = "none";
  frontpageHeader.style.display = "block";
  singleUser.style.display = "none";
  singleUsername.style.display = "none";
  singleEntry.style.display = "none";

  usersLink.classList.add("active");
  entriesLink.classList.remove("active");
  commentsLink.classList.remove("active");
}
function showComments() {
  users.style.display = "none";
  entries.style.display = "none";
  comments.style.display = "block";
  frontpageHeader.style.display = "block";
  singleUser.style.display = "none";
  singleUsername.style.display = "none";
  singleEntry.style.display = "none";

  commentsLink.classList.add("active");
  usersLink.classList.remove("active");
  entriesLink.classList.remove("active");
}
function showSingleUser() {
  singleUser.style.display = "block";
  singleUsername.style.display = "block";
  users.style.display = "none";
  entries.style.display = "none";
  comments.style.display = "none";
  frontpageHeader.style.display = "none";
  singleEntry.style.display = "none";

  commentsLink.classList.remove("active");
  usersLink.classList.add("active");
  entriesLink.classList.remove("active");
}
function showSingleEntry() {
  singleEntry.style.display = "block";
  singleUser.style.display = "none";
  singleUsername.style.display = "none";
  users.style.display = "none";
  entries.style.display = "none";
  comments.style.display = "none";
  frontpageHeader.style.display = "none";

  commentsLink.classList.remove("active");
  usersLink.classList.add("active");
  entriesLink.classList.remove("active");
}

//Visar login och register form
let loginForm = document.getElementById("login-form");
let registerForm = document.getElementById("register-form");

function showSignin() {
  if (loginForm.className === "login-form") {
    loginForm.className += " visible";
    registerForm.className = "register-form";
  } else {
    loginForm.className = "login-form";
  }
}
function showRegister() {
  if (registerForm.className === "register-form") {
    registerForm.className += " visible";
    loginForm.className = "login-form";
  } else {
    registerForm.className = "register-form";
  }
}
