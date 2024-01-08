'use strict'

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

// Create a new course
function createCourse(name, desc, url, instructorId) {
    // Make sure the fields are not empty
    let courseName = document.getElementById('courseName').value;
    let courseDescription = document.getElementById('courseDesc').value;
    let courseUrl = document.getElementById('courseUrl').value;

    let valuesAreEmpty = courseName === "" || courseDescription === "" || courseUrl === "";
    if (valuesAreEmpty) {
        displayError("Παρακαλώ συμπληρώστε όλα τα πεδία");
        return; // Stop execution if the values are empty
    }

    // Make sure the url is valid
    let urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;

    if (!urlRegex.test(courseUrl)) {
        displayError("Παρακαλώ εισάγετε ένα έγκυρο URL");
        return; // Stop execution if the URL is not valid
    }

    // Fetch the data from the API
    let apiUrl = 'http://localhost/neolearn-backend/index.php/courses';

    let options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            "name": courseName,
            "videoUrl": courseUrl,
            "description": courseDescription,
            "instructorId": instructorId
        }),
    }

    fetch(apiUrl, options)
        .then(response => {
            if (response.ok) {
                displayError("Το μάθημα αποθηκεύτηκε (Σε λίγο θα επιστρέψετε στην αρχική οθόνη)", "alert-success")

                // Wait 3 seconds and then redirect to the instructor dashboard
                setTimeout(() => {
                    window.location.href = 'http://localhost/NeoLearn-BackEnd/frontend/teacher.html';
                }, 3000);

                return response.json();
            }
            else {
                displayError("Σφαλμα κατα την αποθηκευση του μαθηματος", "alert-danger")
            }
        })
}

let createCourseBtn = document.getElementById('btnCreate');
createCourseBtn.addEventListener('click', (e) => {
    // Get the values from the form
    let courseName = document.getElementById('courseName').value;
    let courseDescription = document.getElementById('courseDesc').value;
    let courseUrl = document.getElementById('courseUrl').value;

    let user = localStorage.getItem('user');

    // Turn the user into a JSON object
    let userObj = JSON.parse(user);

    // Get the instructorId from the user object
    let instructorId = userObj.id;

    createCourse(courseName, courseDescription, courseUrl, instructorId);
});

function cancelCreateCourse() {
    console.log("cancelCreateCourse() called");
    let cancelMsg = "Είσαι σίγουρος ότι επιθυμείς να ακυρώσεις τη δημιουργία του μαθήματος;";
    let cancelConfirmed = confirm(cancelMsg);

    if (cancelConfirmed) {
        makeSureUserIsLoggedIn('welcome.html', 'teacher.html');
    }
}

function homeBtn() {
    makeSureUserIsLoggedIn('welcome.html', 'teacher.html');
}