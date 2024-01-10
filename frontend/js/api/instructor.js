import { endpoints } from './endpoints.js';

async function loginInstructor(username, password) {
    let response = await fetch(endpoints.instructors.login, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            "email": username,
            "password": password,
        }),
    });

    if (response.status === 401) throw new Error('Invalid credentials');

    if (!response.ok) throw new Error('Failed to login');

    let data = await response.json();

    return data;
}

async function getInstructorById(id) {
    let response = await fetch(endpoints.instructors.getById + id, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    });

    if (!response.ok) throw new Error('Failed to get instructor');

    let data = await response.json();

    return data;
}

export { loginInstructor, getInstructorById };