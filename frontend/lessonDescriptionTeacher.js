import {deleteById, getCourseById} from './js/api/course.js';
'use strict';

// Make sure the user is logged in
if (!localStorage.getItem('user')) {
    window.location.href = 'welcome.html';
}

let userName = JSON.parse(localStorage.getItem('user')).name;

let nameTop = document.getElementById('navbarDropdown');
nameTop.innerHTML = userName;

// Get the lesson id from the url
let url = new URL(window.location.href);
let lessonId = url.searchParams.get("lessonId");

// Get the lesson from the API
let course = await getCourseById(lessonId);
let courseName = course.name;
let courseDescription = course.description;

let courseNameElement = document.getElementById('lessonText');
courseNameElement.innerHTML = courseName;

let courseInstructorElement = document.getElementById('sourceTitle');
courseInstructorElement.innerHTML = "By: " + userName;

let courseDescriptionElement = document.getElementById('details-lesson');
courseDescriptionElement.innerHTML = courseDescription;

// Handle the delete button
let deleteBtn = document.getElementById('deleteLesson');
deleteBtn.addEventListener('click', async (e) => {
        e.preventDefault();

        // Ask the user to confirm the deletio
        let msg = "Είσαι σίγουρος ότι επιθυμείς να διαγράψεις το μάθημα; (Αυτή η ενέργεια δεν μπορεί να αναιρεθεί)";
        let deletionCancelled = !confirm(msg);

        if (deletionCancelled) return;

        // Delete the lesson from the API

        try {
                await deleteById(lessonId);
                alert("Το μάθημα διαγράφηκε επιτυχώς");

                window.location.href = 'teacher.html';
        }
        catch (error) {
                console.error(error);
                alert("Προέκυψε σφάλμα κατά τη διαγραφή του μαθήματος");
        }
});

