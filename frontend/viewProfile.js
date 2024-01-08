'use strict'

// Run only once when the page is loaded
function init() {
    if (localStorage.getItem('user') == null) {
        window.location.href = 'welcome.html';
    }
}

init()

// Get the user from local storage
let user = JSON.parse(localStorage.getItem('user'));

// Display the user's name
let instructorNameElement = document.getElementById('teacherName');
instructorNameElement.innerHTML = user.name;

// Display the user's email
let instructorEmailElement = document.getElementById('teacherEmail');
instructorEmailElement.innerHTML = user.email;

// Set the user Tyoe
let instructorTypeElement = document.getElementById('userType');
let userType = localStorage.getItem('userType');
console.log(userType);
instructorTypeElement.innerHTML = userType;

function edit(){
    window.location.href = "editProfile.html";
}

function homeBtn() {
    window.location.href = 'teacher.html';
}


function profileBtn() {
    window.location.href = 'viewProfile.html';
}

function calendarBtn() {
    window.location.href = 'calendar.html';
}

function logOutBtn() {
    var txt;
    if (confirm("Είσαι σίγουρος ότι επιθυμείς να αποσυνδεθείς από το Λογαριασμό σου;")) {
      window.location.href = 'welcome.html';
    }
    document.getElementById("demo").innerHTML = txt;
}
function newLessonBtn() {
    window.location.href = 'createLesson.html';
}

function editProfileBtn() {
    window.location.href = 'editProfile.html';
}