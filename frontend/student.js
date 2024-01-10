import * as CourseAPI from "./js/api/course.js";
import * as Utils from "./js/utils/utils.js";

// Check if the user is logged in
let userFromStorage = localStorage.getItem('user');

if (!userFromStorage) window.location.href = 'welcome.html';

let user = JSON.parse(userFromStorage);
let userType = localStorage.getItem('userType');
document.addEventListener('DOMContentLoaded', async function () {
    // Display the user name on the top right corner
    // Display the user's name
    const nameElement = document.getElementById('navbarDropdown');
    nameElement.innerHTML = user.name;

    // Fetch courses from the API
    let courses = await CourseAPI.getAllCourses();

    // Display the courses
    createAllCoursesElements(courses);

    // Handle the search functionality
    const searchBtn = document.getElementById('searchbtn');
    searchBtn.addEventListener('click', (event) => {
        searchCourses(event);
    });

    // Display Data on the Student Profile Details
    Utils.updateUserProfileDetailsElement(user.name, user.email, userType);

    // Handle the home button click
    let homeBtn = document.getElementById('home-btn');
    homeBtn.addEventListener('click', () => {
        window.location.href = 'student.html';
    });

    // Handle the logout button click
    let logoutBtn = document.getElementById('logout');
    logoutBtn.addEventListener('click', () => {
        Utils.logout();
    });
});

function makeCourseElement(course) {
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
    const courseFrame = document.getElementById('courses-frame');
    // Handle the data and generate HTML for each course
    let coursesContainer = document.getElementById('courses-container-1');

    if (coursesContainer === null) {
        coursesContainer = document.createElement('div');
        coursesContainer.classList.add('container');
        coursesContainer.setAttribute('id', 'courses-container-1');
        courseFrame.appendChild(coursesContainer);
    }

    courses.forEach(course => {
        const courseElement = document.createElement('div');
        courseElement.innerHTML = makeCourseElement(course);

        coursesContainer.appendChild(courseElement);
    });

    // Handle the click on each course
    courses.forEach(course => {
        const courseElement = document.getElementById(`lesson-${course.id}`);
        courseElement.addEventListener('click', () => {
            window.location.href = `lessonDescriptionTeacher.html?id=${course.id}`;
        });
    });
}

function updateAllCoursesElements(courses) {
    // Handle the data and generate HTML for each course
    const coursesContainer = document.getElementById('courses-container-1');

    const coursesElementsPure = document.getElementsByClassName('lesson-link');
    const coursesElements = Array.from(coursesElementsPure);
    coursesElements.forEach(courseElement => {
        coursesContainer.remove();
    });

    console.log(coursesContainer)

    createAllCoursesElements(courses);
}

async function searchCourses(event) {
    event.preventDefault();

    // Get the input value
    let input = document.getElementById('search-input').value;

    console.log(input)

    // Fetch courses from the API
    try {
        let courses = await CourseAPI.getCoursesByName(input);

        updateAllCoursesElements(courses)

        if (courses.length === 0) {
            const alertElement = document.getElementById('courses-alert');
            alertElement.style.display = 'block';

            // Hide the alert after 3 seconds
            setTimeout(() => {
                alertElement.style.display = 'none';
            }, 4000);
        }
    }
    catch (err) {
        const alertElement = document.getElementById('courses-alert');
        alertElement.style.display = 'block';

        // Hide the alert after 3 seconds
        setTimeout(() => {
            alertElement.style.display = 'none';
        }, 3000);
    }
}