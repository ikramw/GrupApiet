//Sections som ska gömmas eller visas
let entries = document.getElementById("entries");
let users = document.getElementById("users");
let comments = document.getElementById("comments");

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
  comments.style.display = "none";

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
  let selectValue = document.getElementById("selectUserAmount").value;
  return selectValue;
}

async function getAllUsers() {
  const response = await fetch('/api/users');
  const { data } = await response.json();

  entries.style.display = "none";
  users.style.display = "block";
  comments.style.display = "none";

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
    userUsername.href = "#";
    userUsername.addEventListener("click", getSingleUser);
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

function changeCommentsDisplayed() {
  let selectValue = document.getElementById("selectCommentsAmount").value;
  return selectValue;
}

async function getAllComments() {
  const response = await fetch('/api/comments?limit=' + selectValue);
  const { data } = await response.json();

  entries.style.display = "none";
  users.style.display = "none";
  comments.style.display = "block";

  entriesContent.innerHTML = "";
  usersContent.innerHTML = "";
  commentsContent.innerHTML = "";

  //Ändrar länk som är aktiv i nav
  entriesLink.classList.remove("active");
  usersLink.classList.remove("active");
  commentsLink.classList.add("active");

  function createCommentDiv(userData) {

    let commentDiv = document.createElement("div");
    commentDiv.setAttribute("class", "comment");

    let commentText = document.createElement("p");
    var commentTextNode = document.createTextNode(userData.content);
    commentText.appendChild(commentTextNode);

    let writtenBy = document.createElement("p");
    var writtenByText = document.createTextNode("Written by ");
    writtenBy.appendChild(writtenByText);

    let commentUsername = document.createElement("a");
    commentUsername.href = "#";
    var commentUsernameText = document.createTextNode(userData.createdBy);
    commentUsername.appendChild(commentUsernameText);

    writtenBy.appendChild(commentUsername);

    let commentCreated = document.createElement("p");
    var commentCreatedText = document.createTextNode(userData.createdAt);
    commentCreated.appendChild(commentCreatedText);

    commentDiv.appendChild(commentText);
    commentDiv.appendChild(writtenBy);
    commentDiv.appendChild(commentCreated);

    commentsContent.appendChild(commentDiv);
  }

  let selectValue = document.getElementById("selectCommentsAmount").value;

  //Skapar artikel element för antalet entries som är valt i select elementet
  for (let i = 0; i < selectValue && i < data.length; i++) {

    createCommentDiv(data[i]);
  }
}

//Öppnar och stänger navigationen på mobiler 
function navToggle() {
  var menu = document.getElementById("content-toggle");
  if (menu.className === "nav-main") {
    menu.className += " responsive";
  } else {
    menu.className = "nav-main";
  }
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
let btnRegister=document.getElementById('submit');
btnRegister.addEventListener('click', registerUser);

function registerUser(){
    // x-www-form-urlencoded
  
    const formData = new FormData();
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    let today = new Date();
    let dd = today.getDate();
    let mm = today.getMonth()+1; //January is 0!
    let yyyy = today.getFullYear();

    if(dd<10) {
        dd = '0'+dd
    } 

    if(mm<10) {
        mm = '0'+mm
    } 

    today = yyyy + '-' + mm + '-' + dd;
    
    formData.append('username', username.value);
    formData.append('password', password.value);
    formData.append('createdAt', today);
  
    const postOptions = {
      method: 'POST',
      body: formData
    }
    
  fetch('register', postOptions)
  .then(res => res.json())
  
}
let btnLogin=document.getElementById('login-submit');
btnLogin.addEventListener('click', login);
function login(){
  
  const formData = new FormData();
  const username = document.getElementById('login-username');
  const password = document.getElementById('login-password');
  
  
  formData.append('username', username.value);
  formData.append('password', password.value);
  
  const postOptions = {
    method: 'POST',
    body: formData,
    credentials: 'include'
  }
  
fetch('login', postOptions)
.then(res => res.json())
.then(console.log);
}