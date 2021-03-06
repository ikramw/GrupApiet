let selectedEntryId = 0;
let selectedEntryUserId = "";

//var loggedInUserId=0;
let loggedInUser = [];

//Sections som ska gömmas eller visas
let frontpageHeader = document.getElementById("frontpage-header");
let entries = document.getElementById("entries");
let singleEntry = document.getElementById("single-entry");
let users = document.getElementById("users");
let singleUser = document.getElementById("single-user");
let usernameHeader = document.getElementById("display-username");
let userProfile = document.getElementById("my-profile");
let createPost = document.getElementById("create-entry-wrapper");
let editPost = document.getElementById("edit-entry-wrapper");

//Login och register form
let loginForm = document.getElementById("login-form");
let registerForm = document.getElementById("register-form");

//Elementen som ska fyllas på med information
let entriesContent = document.getElementById("entries-content");
let singleEntryContent = document.getElementById("single-entry-content");
let usersContent = document.getElementById("users-content");
let entryCommentsContent = document.getElementById("entry-comments-content");
let singleUserContent = document.getElementById("single-user-content");
let userProfileEntries = document.getElementById("user-profile-entries");

//Länkarna i navigationen
let entriesLink = document.getElementById("entries-link");
let usersLink = document.getElementById("users-link");
let profileLink = document.getElementById("profile-link");

//Funktion för att bestämma vilken länk i navigationen som är aktiv
function activeNav(link) {

  if(link == "entries") {
    entriesLink.classList.add("active");
    usersLink.classList.remove("active");
    if (profileLink) {
      profileLink.classList.remove("active");
    }
  }
  else if(link == "users") {
    entriesLink.classList.remove("active");
    usersLink.classList.add("active");
    if (profileLink) {
      profileLink.classList.remove("active");
    }
  }
  else if(link == "profile") {
    entriesLink.classList.remove("active");
    usersLink.classList.remove("active");
    if (profileLink) {
      profileLink.classList.add("active");
    }
  }
}

//Skapar element för att visa upp ett inlägg från databasen
function createEntryArticle(entryData, displayWrapper) {
  let entryArticle = document.createElement("article");
  entryArticle.setAttribute("class", "single-entry");

  let entryInfo = document.createElement("div");
  entryInfo.setAttribute("class", "single-entry-info");

  let entryTitle = document.createElement("h1");
  let titleLink = document.createElement("a");
  titleLink.href = "#";
  titleLink.addEventListener("click", function(){
    getSingleEntryAndComments(entryData.entryID);
    selectedEntryId=entryData.entryID;
    selectedEntryUserId=entryData.createdBy;
  });
  let titleText = document.createTextNode(entryData.title);
  titleLink.appendChild(titleText);
  entryTitle.appendChild(titleLink);

  let writtenBy = document.createElement("span");
  let writtenByText = document.createTextNode("Written by ");
  writtenBy.appendChild(writtenByText);

  let entryUsername = document.createElement("a");
  entryUsername.href = "#";
  if (entryData.createdBy == sessionStorage.getItem("loggedInUserId")) {
    entryUsername.addEventListener("click", function(){
      getProfile();
    });
  }
  else {
    entryUsername.addEventListener("click", function(){
      getSingleUser(entryData.createdBy)
    });
  }

  let username = " " + entryData.username;
  let usernameTextNode = document.createTextNode(username);
  entryUsername.appendChild(usernameTextNode);

  let entryDisplayTime = document.createElement("p");
  let entryDisplayTimeText = document.createTextNode(entryData.createdAt.slice(0, 16));
  entryDisplayTime.appendChild(entryDisplayTimeText);

  let entryContentText = document.createElement("p");
  let entryContentTextNode = document.createTextNode(entryData.content);
  entryContentText.appendChild(entryContentTextNode);

  entryInfo.appendChild(entryTitle);
  entryInfo.appendChild(writtenBy);
  entryInfo.appendChild(entryUsername);
  entryInfo.appendChild(entryDisplayTime);
  entryArticle.appendChild(entryInfo);
  entryArticle.appendChild(entryContentText);

  if (entryData.createdBy == sessionStorage.getItem("loggedInUserId")) {
    let changeEntryDiv = document.createElement("div");
    changeEntryDiv.setAttribute("class", "change-entry");

    let editEntry = document.createElement("a");
    editEntry.href = "#";
    editEntry.addEventListener("click", function(){
      showEditPost(entryData.title, entryData.content, entryData.entryID)
    });
    let editEntryIcon = document.createElement("i");
    editEntryIcon.setAttribute("class", "fa fa-edit");

    let editEntryText = document.createTextNode(" Edit");
    editEntry.appendChild(editEntryIcon);
    editEntry.appendChild(editEntryText);
    changeEntryDiv.appendChild(editEntry);

    let deleteEntry = document.createElement("a");
    deleteEntry.href = "#";
    deleteEntry.addEventListener("click", function(){
      deleteEntryF(entryData.entryID)
    });
    let deleteEntryIcon = document.createElement("i");
    deleteEntryIcon.setAttribute("class", "fa fa-times");

    let deleteEntryText = document.createTextNode(" Delete");
    deleteEntry.appendChild(deleteEntryIcon);
    deleteEntry.appendChild(deleteEntryText);
    changeEntryDiv.appendChild(deleteEntry);

    entryArticle.appendChild(changeEntryDiv);
  }

  displayWrapper.appendChild(entryArticle);

}
//Skapar element för att visa upp användare från databasen
function createUserDiv(userData) {

  let userDiv = document.createElement("div");
  userDiv.setAttribute("class", "user");

  let userUsername = document.createElement("a");
  userUsername.href = "#";
  /* Lägger till ett event som kallar på funktionen getSingleUser och skickar
     med id för användaren */
  userUsername.addEventListener("click", function(){
    getSingleUser(userData.userID)
  });
  var usernameText = document.createTextNode(userData.username);
  userUsername.appendChild(usernameText);

  let userCreated = document.createElement("p");
  let userCreatedText = document.createTextNode("Joined " + userData.createdAt.slice(0, 10));
  userCreated.appendChild(userCreatedText);

  userDiv.appendChild(userUsername);
  userDiv.appendChild(userCreated);

  usersContent.appendChild(userDiv);
}
//Skapar element för att visa kommentarer kopplat till inlägg
function createEntryComments(commentData) {
  let entryComment = document.createElement("div");
  entryComment.setAttribute("class", "entry-comment");

  let commentText = document.createElement("div");
  commentText.setAttribute("class", "comment-text");

  let commentUsername = document.createElement("a");
  commentUsername.href = "#";
  commentUsername.addEventListener("click", function(){
    getSingleUser(commentData.createdBy)
  });
  //Hämtar användarnamnet
  let username = " " + commentData.username;
  let usernameTextNode = document.createTextNode(username);
  commentUsername.appendChild(usernameTextNode);

  let commentDisplayTime = document.createElement("p");
  commentDisplayTime.setAttribute("class", "display-time");
  let commentDisplayTimeText = document.createTextNode(commentData.createdAt);
  commentDisplayTime.appendChild(commentDisplayTimeText);

  let commentContentText = document.createElement("p");
  let commentContentTextNode = document.createTextNode(commentData.content);
  commentContentText.appendChild(commentContentTextNode);

  commentText.appendChild(commentUsername);
  commentText.appendChild(commentDisplayTime);
  commentText.appendChild(commentContentText);

  if (commentData.createdBy == sessionStorage.getItem("loggedInUserId")) {
    let deleteComment = document.createElement("a");
    deleteComment.href = "#";
    deleteComment.addEventListener("click", function(){
      deleteCommentF(commentData.commentID, commentData.entryID)
    });
    let deleteCommentText = document.createTextNode("Delete");
    deleteComment.appendChild(deleteCommentText);

    commentText.appendChild(deleteComment);
  }

  entryComment.appendChild(commentText);
  entryCommentsContent.appendChild(entryComment);
}
//Gör att allt genererat content töms så att det inte blir dubletter
function emptyContent() {
  entriesContent.innerHTML = "";
  usersContent.innerHTML = "";
  singleEntryContent.innerHTML = "";
  entryCommentsContent.innerHTML = "";
  singleUserContent.innerHTML = "";
  if (userProfileEntries) {
    userProfileEntries.innerHTML = "";
  }
}

//Hämtar alla entries
async function getAllEntries() {
  const response = await fetch('/api/entries');
  const { data } = await response.json();

  entries.style.display = "block";
  users.style.display = "none";
  singleUser.style.display = "none";
  singleEntry.style.display = "none";
  frontpageHeader.style.display = "block";
  usernameHeader.style.display = "none";
  if(createPost) {
    createPost.style.display = "none";
  }
  if(editPost) {
    editPost.style.display = "none";
  }
  if(userProfile) {
    userProfile.style.display = "none";
  }

  emptyContent();
  activeNav("entries");

  let selectValue = document.getElementById("selectEntryAmount").value;

  //Skapar artikel element för antalet entries som är valt i select elementet
  for (let i = 0; i < selectValue && i < data.length; i++) {

    createEntryArticle(data[i], entriesContent);
  }
}
//Kallar på funtionen för att hämta alla entries då de visas på startsidan
getAllEntries();

//Hämtar ett inlägg samt visar kommentarer till inlägget
async function getSingleEntry(id) {
  const response = await fetch('/api/entries/' + id);
  const { data } = await response.json();

  createEntryArticle(data, singleEntryContent);
}
async function getEntryComments(id) {
  const response = await fetch('/api/comments/entry/' + id);
  const { data } = await response.json();

  //Skriver ut antalet svar till inlägget
  document.getElementById("comments-amount").innerHTML = data.length;

  //Skapar artikel element för antalet entries som är valt i select elementet
  for (let i = 0; i < data.length; i++) {

    createEntryComments(data[i]);
  }
}
/*Funktion som kallar på single entry och entry kommentarer så att de visas
på samma sida med samma id */
function getSingleEntryAndComments(id) {
  entries.style.display = "none";
  users.style.display = "none";
  singleUser.style.display = "none";
  if(createPost) {
    createPost.style.display = "none";
  }
  if(editPost) {
    editPost.style.display = "none";
  }
  if(userProfile) {
    userProfile.style.display = "none";
  }
  singleEntry.style.display = "block";
  frontpageHeader.style.display = "none";
  usernameHeader.style.display = "none"

  emptyContent();
  activeNav("entries");

  getSingleEntry(id);
  getEntryComments(id);
}

//Hämtar alla användare
async function getAllUsers() {
  const response = await fetch('/api/users');
  const { data } = await response.json();

  entries.style.display = "none";
  users.style.display = "block";
  singleUser.style.display = "none";
  singleEntry.style.display = "none";
  frontpageHeader.style.display = "block";
  usernameHeader.style.display = "none"
  if(createPost) {
    createPost.style.display = "none";
  }
  if(editPost) {
    editPost.style.display = "none";
  }
  if(userProfile) {
    userProfile.style.display = "none";
  }

  emptyContent();
  activeNav("users");

  let selectValue = document.getElementById("selectUserAmount").value;

  //Skapar artikel element för antalet entries som är valt i select elementet
  for (let i = 0; i < selectValue && i < data.length; i++) {

    createUserDiv(data[i]);
  }
}

//Hämtar en användare samt visar alla användarens inlägg
async function getSingleUser(id) {
  const response = await fetch('/api/entries/user/' + id);
  const { data } = await response.json();

  entries.style.display = "none";
  users.style.display = "none";
  if(createPost) {
    createPost.style.display = "none";
  }
  if(editPost) {
    editPost.style.display = "none";
  }
  if(userProfile) {
    userProfile.style.display = "none";
  }
  singleUser.style.display = "block";
  singleEntry.style.display = "none";
  usernameHeader.style.display = "block"
  frontpageHeader.style.display = "none";

  emptyContent();
  activeNav("users");

  if (data.length < 1) {
    document.getElementById("usernames-blog").innerHTML = "This user hasn't posted anything yet";
  }
  else {
    document.getElementById("usernames-blog").innerHTML = data[0].username + "'s blog";
  //Skapar artikel element för antalet entries som är valt i select elementet
    for (let i = 0; i < data.length; i++) {

      createEntryArticle(data[i], singleUserContent);
    }
  }
}

//Sökfunktion för titel
async function searchByTitle(){
  let searchInput= document.getElementById('search').value;

  const postOptions = {
    method: 'GET'
  }
  const response = await fetch('/api/entries?title='+searchInput,postOptions)
  const { data } = await response.json();

  entries.style.display = "block";
  users.style.display = "none";
  singleEntry.style.display = "none";
  frontpageHeader.style.display = "block";
  usernameHeader.style.display = "none"
  if(createPost) {
    createPost.style.display = "none";
  }
  if(editPost) {
    editPost.style.display = "none";
  }
  if(userProfile) {
    userProfile.style.display = "none";
  }

  emptyContent();
  activeNav("entries");

  //Skapar artikel element för antalet entries som är valt i select elementet
  if (data.length >= 1) {
    for (let i = 0; i < data.length; i++) {

      createEntryArticle(data[i], entriesContent);
    }
  }
  else {
    createEntryArticle(data, entriesContent);
  }
}

//Hämtar inloggad användares inlägg
async function getProfile() {
  const response = await fetch('/api/entries/user/' + sessionStorage.getItem("loggedInUserId"));
  const { data } = await response.json();

  userProfile.style.display = "flex";
  createPost.style.display = "none";
  editPost.style.display = "none";
  entries.style.display = "none";
  singleEntry.style.display = "none";
  users.style.display = "none";
  frontpageHeader.style.display = "none";
  singleUser.style.display = "none";

  emptyContent();
  activeNav("profile");

  if (data.length < 1) {
    let gotNoEntries = document.createElement("p");
    let noEntriesText = document.createTextNode("You haven't posted anything yet");
    gotNoEntries.appendChild(noEntriesText);

    userProfileEntries.appendChild(gotNoEntries);
  }
  else {
    //Skapar artikel element för antalet entries som användaren har
    for (let i = 0; i < data.length; i++) {

      createEntryArticle(data[i], userProfileEntries);
    }
  }
}

//Visar formuläret för att skapa ett inlägg
function showCreatePost() {
  createPost.style.display = "block";
  editPost.style.display = "none";
  entries.style.display = "none";
  users.style.display = "none";
  frontpageHeader.style.display = "none";
  userProfile.style.display = "none";

  activeNav("profile");
}
function showEditPost(title, content, id) {
  createPost.style.display = "none";
  editPost.style.display = "block";
  entries.style.display = "none";
  users.style.display = "none";
  frontpageHeader.style.display = "none";
  userProfile.style.display = "none";

  activeNav("profile");

  document.getElementById("edit-title").value = title;
  document.getElementById("edit-content").value = content;
  document.getElementById("edit-entry-btn").addEventListener("click", function(){
    editEntry(id)
  });
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
function showSignin() {
  if (loginForm.className === "login-form") {
    loginForm.className += " visible";
    registerForm.className = "register-form";
  } else {
    loginForm.className = "login-form";
    document.getElementById("login-error").innerHTML = "";
  }
}
function showRegister() {
  if (registerForm.className === "register-form") {
    registerForm.className += " visible";
    loginForm.className = "login-form";
  } else {
    registerForm.className = "register-form";
    document.getElementById("register-error").innerHTML = "";
  }
}

//Registrera användare
function registerUser() {

  const formData = new FormData();
  const username = document.getElementById('username');
  const password = document.getElementById('password');

  formData.append('username', username.value);
  formData.append('password', password.value);

  const postOptions = {
    method: 'POST',
    body: formData
  }

  if (formData.get('username').length === 0 || formData.get('password').length === 0) {
    document.getElementById("register-error").innerHTML = "Username or password is empty";
  }
  else {
    fetch('register', postOptions)
    .then(res => res.json())

    location.reload();
  }
}
//Logga in
function login() {

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

  if (formData.get('username').length === 0 || formData.get('password').length === 0) {
    document.getElementById("login-error").innerHTML = "Username or password is empty";
  }
  else {
    fetch('login', postOptions)
    .then(response => {
      if (response.ok) {
        return response.json()
      } else {
        return Promise.reject('something went wrong!')
      }
    })
    .then(function(data) {
      loggedInUser = data;
      sessionStorage.setItem("loggedInUserId", loggedInUser.userID);
      location.reload();
    })
    .catch(error => document.getElementById("login-error").innerHTML = "Username or password is incorrect");
  }
}
//Logga ut
function logOut() {

  const postOptions = {
    method: 'GET',
    credentials: 'include'
  }


  fetch('logout',postOptions)
  .then(() => {
    sessionStorage.clear();
    location.reload();
  })
}

if(editPost) {
  const postEntryForm = document.getElementById('postEntryForm');
  postEntryForm.addEventListener('submit', postEntry);
}

//Lägga upp inlägg
function postEntry(event) {
  // prevents the form from submitting via html/php
  event.preventDefault();
  const formData = new FormData();
  const postTitle = document.getElementById('post-title');
  const postContent = document.getElementById('post-content');

  formData.append('title', postTitle.value);
  formData.append('content', postContent.value);
  formData.append('createdBy', sessionStorage.getItem("loggedInUserId"));

  const postOptions = {
    method: 'POST',
    body: formData
  }

  location.reload();

  fetch('/api/entries', postOptions)
  .then(res => res.json())
}
//Ta bort ett inlägg
function deleteEntryF(id) {
  const postOptions = {
    method: 'DELETE',
    //body: formData
  }

  location.reload();

  fetch('/api/entries/'+ id, postOptions)
  .then(res => res.json())
}
//Redigera ett inlägg
function editEntry(id) {
  const formData = new FormData();
  const title = document.getElementById('edit-title').value;
  const content = document.getElementById('edit-content').value;
  //var string =  'title='+title +'&content ='+content;

  fetch('api/entries/'+id,{
    method: 'PATCH',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'title='+title +'&content='+content
 });
 location.reload();

}

//Lägga upp en kommentar
function postComment() {

  const formData = new FormData();
  const comment = document.getElementById('post-comment');

  formData.append('content', comment.value);
  formData.append('createdBy',sessionStorage.getItem("loggedInUserId"));
  formData.append('entryID', selectedEntryId);

  const postOptions = {
    method: 'POST',
    body: formData
  }

  //Kollar om kommentarsfältet är tomt
  if(formData.get('content').length === 0) {
    document.getElementById("comment-error").innerHTML = "You haven't written anything";
  }
  else {
    fetch('/api/comments', postOptions)
    .then(res => res.json())

    location.reload();
  }
}
//Ta bort en kommentar
function deleteCommentF(id) {
  const postOptions = {
    method: 'DELETE'
  }

  location.reload();

  fetch('/api/comments/'+ id, postOptions)
  .then(res => res.json())
}
