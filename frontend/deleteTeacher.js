'use strict'

function showAlert() {
    alert("Το μάθημα διαγράφτηκε με επιτυχία!");
    //εδω θυελω οταν παταω οκ στο αλερτ να νμε οηγαινει στην αρχικη σελιδα με τα μαθηματα χωωρις το μαθηα 
    // που μολις διεγραψα 
    window.location.href = 'teacher.html';
}

let userType = localStorage.getItem('userType');

function homeBtn() {
    if (userType === 'Teacher') window.location.href = 'teacher.html';

    else if (userType === 'Student') window.location.href = 'student.html';
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


