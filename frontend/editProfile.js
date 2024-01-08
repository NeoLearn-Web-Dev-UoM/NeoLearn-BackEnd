'use strict'

let updateStudentAPI = "http://localhost/neolearn-backend/index.php/students";
let updateTeacherAPI = "http://localhost/neolearn-backend/index.php/instructors";
let currentAPI = "";

let userType = localStorage.getItem("userType");

console.log(userType)

if (userType === "Student") currentAPI = updateStudentAPI;
else if (userType === "Teacher") currentAPI = updateTeacherAPI;

// SET USERNAME ON TOP NAVBAR
let user = JSON.parse(localStorage.getItem("user"));

console.log(currentAPI);

let nameTop = document.getElementById("navbarDropdown");
nameTop.innerHTML = user.name;

function callUpdateAPI(id, email, newPass) {
    let data = {
        id: id,
        email: email,
        password: newPass
    };

    fetch(currentAPI, {
        method: 'PUT',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then((response) => {
            if (response.status === 200) {
                alert("Η ενημέρωση ολοκληρώθηκε με επιτυχία! Θα μεταφερθείτε στην σελίδα του Προφίλ σας.");
                window.location.href = "viewProfile.html";
            } else {
                alert("Η ενημέρωση απέτυχε!");
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

function updateProfile() {
    let updateMsg = "Οι πληροφορίες πρόκειται να ανανεωθούν. Είστε σίγουροι ότι θέλετε να συνεχίσετε;";
    let confirmUpdate = confirm(updateMsg);

    let id = user.id;
    let email = document.getElementById("newEmail").value;
    let newPass = document.getElementById("newPass").value;

    let mailIsEmpty = email === "";
    let passIsEmpty = newPass === "";

    // If both email and newPass are empty then alert the user
    if (mailIsEmpty && passIsEmpty) {
        alert("Δεν έχετε κάνει καμία αλλαγή!");
        return;
    }

    // Check if email is empty if it is then set it to the current email
    if (mailIsEmpty) email = user.email;

    // Make sure the mail is in the correct format
    let mailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.match(mailFormat)) {
        alert("Μη έγκυρο email!");
        return;
    }

    // Check if newPass is empty if it is then set it to the current password
    if (newPass === "") newPass = user.password;

    if (confirmUpdate) {
        callUpdateAPI(id, email, newPass);
    }
}

function returnToMainPage() {
    window.location.href = "viewProfile.html";
}

function homeBtn() {
    window.location.href = 'teacher.html';
}

function logOutBtn() {
    logout();
}

function editProfileBtn() {
    window.location.href = 'editProfile.html';
}