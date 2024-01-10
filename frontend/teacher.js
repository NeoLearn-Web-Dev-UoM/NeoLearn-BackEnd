'use strict'

import {getCoursesByInstructorId} from "./js/api/course.js";
import {logout} from "./js/utils/authUtils.js";

// let currentSlide = 1;

// Get the user from local storage
let user = localStorage.getItem('user');
let type = localStorage.getItem('userType');

// If the user is not logged in, redirect to the login page
if (!user) window.location.href = 'welcome.html';

// Turn the user to an object we can work with
user = JSON.parse(user);
const name = user.name; // Get the user's name

document.addEventListener('DOMContentLoaded', async function () {
    // Display the user name on the top right corner
    // Display the user's name
    const nameElement = document.getElementById('user-name');
    nameElement.innerHTML = name;

    // Fetch courses from the API
    let courses = await getCoursesByInstructorId(user.id);

    // Display the courses
    createAllCoursesElements(courses);
});

// HANDLE LOGOUT
const logoutBtn = document.getElementById('logout');
logoutBtn.addEventListener('click', logout);

function searchCourses() {
        // TODO: Implement search functionality
}

function createCourseElement(course) {
    let element = `
        <a class="lesson-link" id="lesson-${course.id}">
            <figure>
                <blockquote class="blockquote">
                    <p id="lessonText-${course.id}" >${course.name}</p>
                </blockquote>
                <figcaption class="blockquote-footer">
                    <cite title="Source Title" id="sourceTitle-${course.id}">${course.description}</cite>
                </figcaption>
            </figure>
        </a>
        <hr>
    `;

    return element;
}

function createAllCoursesElements(courses) {
    // Handle the data and generate HTML for each course
    const coursesContainer1 = document.getElementById('courses-container-1');

    // Parse the courses list and create a course element for each course
    courses.forEach((course, index) => {
        const courseElement = document.createElement('div');
        courseElement.classList.add('teacher-courses-container');
        courseElement.innerHTML = createCourseElement(course);

        coursesContainer1.appendChild(courseElement);
    });

    // Add event listeners to each course
    const courseElements = document.querySelectorAll('.lesson-link');
    courseElements.forEach(courseElement => {
        courseElement.addEventListener('click', handleCourseClick);
    });
}

function handleCourseClick(e) {
    // Get the clicked course element
    const courseElement = e.target;

    // Get the id of the clicked course
    const courseId = courseElement.id.split('-')[1];

    // Open the lesson page and pass the lesson id
    window.location.href = `lessonDescriptionTeacher.html?id=${courseId}`;
}
