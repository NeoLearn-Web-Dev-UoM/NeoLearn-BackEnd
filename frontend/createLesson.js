'use strict'

import * as CourseAPI from './js/api/course.js';

function displayError(error, type) {
    let errorBox = document.getElementById('createCourseError');

    errorBox.innerHTML = error;
    errorBox.style.display = "block";
    errorBox.classList.add(type);

    // Hide the error message after 5 seconds
    setTimeout(() => {
        errorBox.style.display = "none";
        errorBox.classList.remove(type);
    }, 5000);
}

function makeSureUserIsLoggedIn(locationIfNotLoggedIn, locationIfLoggedIn) {
    // Make sure the user is logged in
    if (localStorage.getItem('user') == null) {
        window.location.href = locationIfNotLoggedIn;
    }
    else {
        window.location.href = locationIfLoggedIn;
    }
}

// Run only once when the page is loaded
function init() {
    if (localStorage.getItem('user') == null) {
        window.location.href = 'welcome.html';
    }
}

init();

// HANDLE THE CREATE COURSE BUTTON
let createCourseBtn = document.getElementById('btnCreate');
createCourseBtn.addEventListener('click', async (e) => {
    // Get the values from the form
    let courseName = document.getElementById('courseName').value;
    let courseDescription = document.getElementById('courseDesc').value;
    let courseUrl = document.getElementById('courseUrl').value;

    let user = localStorage.getItem('user');

    // Turn the user into a JSON object
    let userObj = JSON.parse(user);

    // Get the instructorId from the user object
    let instructorId = userObj.id;

    // Create the course
    try {
        await CourseAPI.createCourse(courseName, courseDescription, courseUrl, instructorId);

        // Display a success message
        displayError("Το μάθημα δημιουργήθηκε επιτυχώς!", 'alert-success');

        // Redirect to the teacher page after 3 seconds
        setTimeout(() => {
            window.location.href = 'teacher.html';
        }, 3000);
    }
    catch (error) {
        displayError(error.message, 'error');
    }
});

// HANDLE THE CANCEL BUTTON
let cancelBtn = document.getElementById('btnCancel');
cancelBtn.addEventListener('click', (e) => {
    let cancelMsg = "Είσαι σίγουρος ότι επιθυμείς να ακυρώσεις τη δημιουργία του μαθήματος;";
    let cancelConfirmed = confirm(cancelMsg);

    if (cancelConfirmed) {
        makeSureUserIsLoggedIn('welcome.html', 'teacher.html');
    }
});

function homeBtn() {
    makeSureUserIsLoggedIn('welcome.html', 'teacher.html');
}