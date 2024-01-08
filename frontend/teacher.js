'use strict'
let currentSlide = 1;

// Get the user from local storage
let user = localStorage.getItem('user');
let type = localStorage.getItem('userType');

// ------------ DISPLAY USER NAME ------------

// If the user is not logged in, redirect to the login page
if (!user) {
    window.location.href = 'welcome.html';
}

// Turn the user to an object we can work with
user = JSON.parse(user);

// Get the user's name
const name = user.name;

// Display the user's name
const nameElement = document.getElementById('user-name');
nameElement.innerHTML = name;




// ------------ DISPLAY COURSES ------------
document.addEventListener('DOMContentLoaded', function () {
    // Fetch courses from the API
    fetch("http://localhost/neolearn-backend/index.php/courses/search/instructor/" + user.id)
        .then(response => response.json())
        .then(courses => {
            createCoursesElements(courses);
        })
        .catch(error => console.error('Error fetching courses:', error));
});

// SEARCH COURSES

// Get the search button
const searchBtn = document.getElementById('search-btn');

// Add an event listener to the search button
searchBtn.addEventListener('click', (e) => {
    e.preventDefault();
    console.log("Clicked")
});


function searchCourses() {
        // Fetch courses from the API
        fetch("http://localhost/neolearn-backend/index.php/courses/search/name", {
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "name": document.getElementById('search-course').value,
            })
        } )
            .then(response => console.log(response.json()))
            .then(courses => {
                console.log(courses);
                createCoursesElements(courses);
            })
            .catch(error => console.error('Error fetching courses:', error));
}


function createCoursesElements(courses) {
    // Handle the data and generate HTML for each course
    const coursesContainer1 = document.getElementById('courses-container-1');

    courses.forEach((course, index) => {
        const courseElement = document.createElement('div');
        courseElement.innerHTML = `
                    <a class="lesson-link" onclick="openNewPage('lessonText${index + 1}', 'sourceTitle${index + 1}')">
                        <figure>
                            <blockquote class="blockquote">
                                <p id="lessonText${index + 1}">${course.name}</p>
                            </blockquote>
                            <figcaption class="blockquote-footer">
                                <cite title="Source Title" id="sourceTitle${index + 1}">${course.description}</cite>
                            </figcaption>
                        </figure>
                    </a>
                    <hr>
                `;

        coursesContainer1.appendChild(courseElement);
    });
}

function showSlide(slideNumber) {
    const slides = document.querySelectorAll('.slide');
    slides.forEach(slide => {
        slide.style.display = 'none';
    });

    const currentSlideElement = document.getElementById(`slide${slideNumber}`);
    if (currentSlideElement) {
        currentSlideElement.style.display = 'block';
        currentSlide = slideNumber;
    }
}

function changeSlide(nextSlide) {
    showSlide(nextSlide);
}

// Show the initial slide
showSlide(currentSlide);

function openNewPage(lessonTextId, sourceTitleId) {
    var lessonText = document.getElementById(lessonTextId).textContent;
    var sourceTitle = document.getElementById(sourceTitleId).textContent;

    // Use unique identifiers for each link
    var keyPrefix = 'lessonDescription_';  // Unique prefix
    localStorage.setItem(keyPrefix + 'lessonText', lessonText);
    localStorage.setItem(keyPrefix + 'sourceTitle', sourceTitle);

    // Navigate to the new_page.html
    window.location.href = 'lessonDescriptionTeacher.html';
}

function homeBtn() {
    window.location.href = 'teacher.html';
}

function logOutBtn() {
    var txt;
    if (confirm("Είσαι σίγουρος ότι επιθυμείς να αποσυνδεθείς από το Λογαριασμό σου;")) {
        // Remove the user from local storage
        localStorage.removeItem('user');
        window.location.href = 'welcome.html';
    }
    document.getElementById("demo").innerHTML = txt;
}
