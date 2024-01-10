'use strict'

import * as CourseAPI from "./js/api/course.js";


// Make sure dom is loaded before doing anything
document.addEventListener("DOMContentLoaded", async function () {
    // get the id of the course from the url
    let url = new URL(window.location.href);
    let courseId = url.searchParams.get("id");
    // Get the course from the API
    let course = await CourseAPI.getCourseById(courseId);

    // Get the form elements
    let newName = document.getElementById('newName');
    let newDescription = document.getElementById('newdesc');
    let newVideoUrl = document.getElementById('newUrl');

    // Set the form values
    newName.value = course.name;
    newDescription.value = course.description;
    newVideoUrl.value = course.videoUrl;

    let instructorId = course.instructorId;

    // Add event listener to the update button
    let updateBtn = document.getElementById('btnCreate');

    updateBtn.addEventListener('click', () => updateLesson(newName.value, newDescription.value, newVideoUrl.value, instructorId, courseId));

});

function homeBtn() {
    window.location.href = 'teacher.html';
}


function editLessonLink() {
    window.location.href = "editLesson.html";
}

function updateLesson(newName, newDescription, newVideoUrl, instructorId, courseId) {
    // Make sure the values are not empty
    if (newName === '' || newDescription === '' || newVideoUrl === '') {
        alert('Παρακαλώ συμπληρώστε όλα τα πεδία');
        return;
    }

    let confirmUpdateMsg = "Οι πληροφορίες του μαθήματος πρόκειται να ενημερωθούν. Επιθυμείτε να συνεχίσετε;";
    let confirmUpdate = confirm(confirmUpdateMsg);
    if (confirmUpdate) {
        try {
            CourseAPI.updateCourse(courseId, newName, newDescription, newVideoUrl, instructorId);
            alert('Το μάθημα ενημερώθηκε επιτυχώς');
            window.location.href = 'lessonDescriptionTeacher.html?id=' + courseId;
        }
        catch (e) {
            alert('Υπήρξε κάποιο πρόβλημα κατά την ενημέρωση του μαθήματος');
            console.log(e);
        }
    }

}

function tryToUpdateLesson() {

}

function returnToMainPage() {
    window.location.href = "lessonDescriptionTeacher.html";
}

function logOutBtn() {
    var txt;
    if (confirm("Είσαι σίγουρος ότι επιθυμείς να αποσυνδεθείς από το Λογαριασμό σου;")) {
      window.location.href = 'welcome.html';
    }
    document.getElementById("demo").innerHTML = txt;
}