//Sections som ska gömmas eller visas
let entries = document.getElementById("entries");
let users = document.getElementById("users");

//Elementen som ska fyllas på med information
let entriesContent = document.getElementById("entries-content");
let usersContent = document.getElementById("users-content");
let commentsContent = document.getElementById("comments-content");

//Länkarna i navigationen
let entriesLink = document.getElementById("entries-link");
let usersLink = document.getElementById("users-link");
let commentsLink = document.getElementById("comments-link");

//Sparar värdet på vald option i select för entries
function changeEntriesDisplayed() {
  let selectValue = document.getElementById("selectEntryAmount").value;
  return selectValue;
}

//Hämtar alla entries
async function getAllEntries() {
  const response = await fetch('/api/entries');
  const { data } = await response.json();

  entries.style.display = "block";
  users.style.display = "none";

  entriesContent.innerHTML = "";
  usersContent.innerHTML = "";
  commentsContent.innerHTML = "";

  //Ändrar länk som är aktiv i nav
  entriesLink.classList.add("active");
  usersLink.classList.remove("active");
  commentsLink.classList.remove("active");

  //Skapar element för att visa upp entries från databasen
  function createEntryArticle(entryData) {

    let entryArticle = document.createElement("article");
    entryArticle.setAttribute("class", "new-entry");

    let entryContent = document.createElement("div");
    entryContent.setAttribute("class", "entry-content");

    let entryTitle = document.createElement("h1");
    let titleLink = document.createElement("a");
    titleLink.href = "#";
    titleLink.addEventListener("click", getSingleEntry);
    var titleText = document.createTextNode(entryData.title);
    titleLink.appendChild(titleText);
    entryTitle.appendChild(titleLink);

    let entryContentText = document.createElement("p");
    var entryContentTextNode = document.createTextNode(entryData.content);
    entryContentText.appendChild(entryContentTextNode);

    entryContent.appendChild(entryTitle);
    entryContent.appendChild(entryContentText);
    entryArticle.appendChild(entryContent);

    let entryInfo = document.createElement("div");
    entryInfo.setAttribute("class", "entry-info");

    let entryUsername = document.createElement("a");
    entryUsername.href = "#";
    entryUsername.addEventListener("click", getSingleUser);
    var entryUsernameText = document.createTextNode(entryData.createdBy);
    entryUsername.appendChild(entryUsernameText);

    let entryDisplayTime = document.createElement("p");
    entryDisplayTime.setAttribute("class", "display-time");
    var entryDisplayTimeText = document.createTextNode(entryData.createdAt);
    entryDisplayTime.appendChild(entryDisplayTimeText);

    entryInfo.appendChild(entryUsername);
    entryInfo.appendChild(entryDisplayTime);
    entryArticle.appendChild(entryInfo);

    entriesContent.appendChild(entryArticle);
  }

  let selectValue = document.getElementById("selectEntryAmount").value;

  //Skapar artikel element för antalet entries som är valt i select elementet
  for (let i = 0; i < selectValue && i < data.length; i++) {

    createEntryArticle(data[i]);
  }
}

//Kallar på funtionen för att hämta alla entries då de visas på startsidan
getAllEntries();

function getSingleEntry() {
  console.log("test");
}

//Sparar värdet på vald option i select för users
function changeUsersDisplayed() {
  let selectValue = document.getElementById("selectEntryAmount").value;
  return selectValue;
}


async function getAllUsers() {
  const response = await fetch('/api/users');
  const { data } = await response.json();

  entries.style.display = "none";
  users.style.display = "block";

  entriesContent.innerHTML = "";
  usersContent.innerHTML = "";
  commentsContent.innerHTML = "";

  //Ändrar länk som är aktiv i nav
  entriesLink.classList.remove("active");
  usersLink.classList.add("active");
  commentsLink.classList.remove("active");

  function createUserDiv(userData) {

    let userDiv = document.createElement("div");
    userDiv.setAttribute("class", "user");

    let userUsername = document.createElement("a");
    var usernameText = document.createTextNode(userData.username);
    userUsername.appendChild(usernameText);

    let userCreated = document.createElement("p");
    var userCreatedText = document.createTextNode("Joined " + userData.createdAt);
    userCreated.appendChild(userCreatedText);

    userDiv.appendChild(userUsername);
    userDiv.appendChild(userCreated);

    usersContent.appendChild(userDiv);
  }

  let selectValue = document.getElementById("selectUserAmount").value;

  //Skapar artikel element för antalet entries som är valt i select elementet
  for (let i = 0; i < selectValue && i < data.length; i++) {

    createUserDiv(data[i]);
  }
}

function getSingleUser() {

}

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
/*let entries = document.getElementById("entries");
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
}*/

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
