const BASE_URL = "http://localhost/neolearn-backend/index.php/courses";

async function getAllCourses() {
    const response = await fetch(BASE_URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    const courses = await response.json();

    // if the response is not ok, throw an error
    if (!response.ok) throw new Error("Δεν βρέθηκαν μαθήματα");

    return courses;
}

async function deleteById(id) {
    const response = await fetch(BASE_URL + "/delete/" + id, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    const courses = await response.json();

    // if the response is not ok, throw an error
    if (!response.ok) throw new Error("Το μάθημα δεν μπόρεσε να διαγραφεί");

    return courses;
}

async function getCourseById(id) {
    const response = await fetch(BASE_URL + "/search/id/" + id, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    const course = await response.json();

    // if the response is not ok, throw an error
    if (!response.ok) throw new Error("Το μάθημα δεν βρέθηκε");

    return course;
}

async function getCoursesByInstructorId(id) {
    const response = await fetch(BASE_URL + "/search/instructor/" + id, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    const courses = await response.json();

    // if the response is not ok, throw an error
    if (!response.ok) throw new Error("Δεν βρέθηκαν μαθήματα για τον συγκεκριμένο καθηγητή");

    return courses;
}

async function createCourse(name, desc, url, instructorId) {
    const response = await fetch(BASE_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            "name": name,
            "videoUrl": url,
            "description": desc,
            "instructorId": instructorId
        }),
    });
    const course = await response.json();

    // if the response is not ok, throw an error
    if (!response.ok) throw new Error("Το μάθημα δεν μπόρεσε να δημιουργηθεί");

    return course;
}

async function getCoursesByName(name) {
    // Encode the name
    name = encodeURIComponent(name);

    let apiURL = 'http://localhost/neolearn-backend/index.php/courses/search/name/' + name;
    console.log(apiURL)

    const response = await fetch(apiURL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    const course = await response.json();

    // if the response is not ok, throw an error
    if (!response.ok) throw new Error("Το μάθημα δεν βρέθηκε");

    if (course.length === 0) throw new Error("Το μάθημα δεν βρέθηκε");

    return course;
}

export { getAllCourses, deleteById, getCourseById, getCoursesByInstructorId, createCourse, getCoursesByName, };