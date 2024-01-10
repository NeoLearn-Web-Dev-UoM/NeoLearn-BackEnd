import {deleteById, getCourseById} from './js/api/course.js';
import * as InstructorAPI from './js/api/instructor.js';
import * as TeacherActions from './js/utils/dynamicCourseActions.js';

'use strict';

let user = JSON.parse(localStorage.getItem('user'));

// Make sure the user is logged in
if (!user) window.location.href = 'welcome.html';

let userName = user.name;
let userType = localStorage.getItem('userType');
console.log(user)

let nameTop = document.getElementById('navbarDropdown');
nameTop.innerHTML = userName;

// Get the lesson id from the url
let url = new URL(window.location.href);
let lessonId = url.searchParams.get("id");

console.log(url)
console.log(lessonId)

// Get the lesson from the API
let course = await getCourseById(lessonId);
let courseName = course.name;
let courseDescription = course.description;
let urlVideo = course.videoUrl;

// Set the lesson details
let courseNameElement = document.getElementById('lessonText');
courseNameElement.innerHTML = courseName;

// Try to get the course instructor
try {
        let instructor = await InstructorAPI.getInstructorById(course.instructorId);
        userName = instructor.name;

        let courseInstructorElement = document.getElementById('sourceTitle');
        courseInstructorElement.innerHTML = "By: " + userName;
}
catch (e) {
        console.log(e);
}

let courseDescriptionElement = document.getElementById('details-lesson');
courseDescriptionElement.innerHTML = courseDescription;

// Set the iframe source
let videoElement = document.getElementById('video-element');
videoElement.src = urlVideo;

// add teacher actions if the user is a teacher
if (userType === 'Teacher') {
        let container = document.getElementById('course-details-video');
        let element = TeacherActions.createTeacherElement();

        let div = document.createElement('div');
        div.innerHTML = element;
        container.appendChild(div);

        // Also remove teacher-only elements
        let teacherOnlyElements = document.getElementsByClassName('teacher-only');
        let teacherOnlyElementsArray = Array.from(teacherOnlyElements);

        teacherOnlyElementsArray.forEach(element => {
                element.style.display = 'block';
        });
}
else if (userType === 'Student') {
        console.log('student')
        // Also remove teacher-only elements
        let teacherOnlyElements = document.getElementsByClassName('teacher-only');
        let teacherOnlyElementsArray = Array.from(teacherOnlyElements);

        console.log(teacherOnlyElementsArray)

        teacherOnlyElementsArray.forEach(element => {
                element.style.display = 'none';
        });

        let myCourses = document.getElementById('my-courses');
        myCourses.href = 'student.html';
}

// Handle the delete button
let deleteBtn = document.getElementById('deleteLesson');

if (deleteBtn) {
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
                } catch (error) {
                        console.error(error);
                        alert("Προέκυψε σφάλμα κατά τη διαγραφή του μαθήματος");
                }
        });
}

let updateBtn = document.getElementById('editLesson');
if (updateBtn) {
        updateBtn.addEventListener('click', (e) => {
                e.preventDefault();

                window.location.href = 'editLesson.html?id=' + lessonId;
        });
}


// Handle Home button
let homeBtn = document.getElementById('homebtn');
console.log(homeBtn)
homeBtn.addEventListener('click', (e) => {
        e.preventDefault();

        if (userType === 'Student') window.location.href = 'student.html';
        else if (userType === 'Teacher') window.location.href = 'teacher.html';
});