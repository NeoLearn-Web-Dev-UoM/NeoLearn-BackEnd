'use strict'

import { loginInstructor } from './js/api/instructor.js';
import { loginStudent } from './js/api/student.js';

const INVALID_CREDENTIALS = 'Invalid credentials';
const FAILED_TO_LOGIN = 'Failed to login';

// Handle login button click
let loginBtn = document.getElementById('signinBtn');
loginBtn.addEventListener('click', submitBtn);

async function submitBtn() {
    const checkboxesElements = document.getElementsByClassName('user-type-radio-select');
    const checkboxes = Array.from(checkboxesElements);

    let userType = getCheckboxValue(checkboxes);

    if (userType === null) {
        displayAlert('alert-danger', 'Παρακαλώ επιλέξτε τύπο χρήστη');
        return;
    }

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username === '' || password === '') {
        displayAlert('alert-danger', 'Παρακαλώ συμπληρώστε όλα τα πεδία');
        return;
    }

    if (userType === 'teacher') await handleInstructorLogin(username, password);
    if (userType === 'student') await handleStudentLogin(username, password);
}

async function handleInstructorLogin(username, password) {
    try {
        const loginData = await loginInstructor(username, password);
        displayAlert('alert-success', 'Επιτυχής σύνδεση. Ανακατεύθυνση...');

        // Add user to local storage
        localStorage.setItem('user', JSON.stringify(loginData));

        // Set the user type
        localStorage.setItem('userType', 'Teacher');

        // Redirect to instructor dashboard
        window.location.href = 'http://localhost/NeoLearn-BackEnd/frontend/teacher.html';
    }
    catch (error) {
        let errorMessage = error.message;

        if (errorMessage === INVALID_CREDENTIALS) displayAlert('alert-danger', 'Λάθος κωδικός ή email');
        else if (errorMessage === FAILED_TO_LOGIN) displayAlert('alert-danger', 'Αποτυχία σύνδεσης. Παρακαλώ προσπαθήστε ξανά');
    }
}

async function handleStudentLogin(username, password) {
    try {
        const loginData = await loginStudent(username, password);
        displayAlert('alert-success', 'Επιτυχής σύνδεση. Ανακατεύθυνση...');

        // Add user to local storage
        localStorage.setItem('user', JSON.stringify(loginData));

        // Set the user type
        localStorage.setItem('userType', 'Student');

        // Redirect to student dashboard
        window.location.href = 'http://localhost/NeoLearn-BackEnd/frontend/student.html';
    }
    catch (error) {
        let errorMessage = error.message;

        if (errorMessage === INVALID_CREDENTIALS) displayAlert('alert-danger', 'Λάθος κωδικός ή email');
        else if (errorMessage === FAILED_TO_LOGIN) displayAlert('alert-danger', 'Αποτυχία σύνδεσης. Παρακαλώ προσπαθήστε ξανά');
    }
}

function displayAlert(alertType, message) {
    let alertBox = document.getElementById('alert-login');
    alertBox.classList.add(alertType);
    alertBox.innerHTML = message;
    alertBox.style.display = 'block';

    // Hide the alert box after 3 seconds
    setTimeout(function () {
        alertBox.style.display = 'none';
        alertBox.classList.remove(alertType);
    }, 3000);
}

function getCheckboxValue(checkboxes) {
    let userType = null;

    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) userType = checkbox.id;
    });

    return userType;
}

// Add event listener to checkboxes
const checkboxes = document.querySelectorAll('.form-check-input');
checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener('click', function () {
        handleCheckboxClick(checkbox.id);
    });
});

function handleCheckboxClick(clickedCheckboxId) {
    const checkboxes = document.querySelectorAll('.form-check-input');

    checkboxes.forEach(function (checkbox) {
        if (checkbox.id !== clickedCheckboxId) checkbox.checked = false;
    });
}

