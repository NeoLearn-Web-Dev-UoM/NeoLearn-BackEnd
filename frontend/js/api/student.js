import {endpoints} from "./endpoints.js";

async function loginStudent(username, password) {
    let response = await fetch(endpoints.students.login, {
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

export {loginStudent};