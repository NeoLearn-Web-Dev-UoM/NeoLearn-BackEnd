'use strict'

async function loginInstructor(username, password) {
    let loginAPI = 'http://localhost/neolearn-backend/index.php/auth/instructor/login';

    try {
        return fetch(loginAPI, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "email": username,
                "password": password,
            }),
            mode: 'cors'
        });
    }
    catch (error) {
        console.error('An error occurred during the fetch:', error);
    }
}

async function submitBtn() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]')

    let userType = getCheckboxValue(checkboxes);

    if (userType === null) {
        alert('Please select a user type');
        return;
    }

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username === '' || password === '') {
        alert('Please fill in all fields');
        return;
    }

    console.log(userType);

    if (userType === 'teacher') {
        const response = await loginInstructor(username, password);

        // Get the response body
        const data = await response.json();

        if (response.ok) {
            let alertBox = document.getElementById('alert-login');
            alertBox.classList.add('alert-success');
            alertBox.innerHTML = 'Επιτυχής σύνδεση';
            alertBox.style.display = 'block';

            // Add user to local storage
            localStorage.setItem('user', JSON.stringify(data));

            // Redirect to instructor dashboard
            window.location.href = 'http://localhost/NeoLearn-BackEnd/frontend/teacher.html';
        }
        else if (response.status === 401) {
            let alertBox = document.getElementById('alert-login');
            alertBox.classList.add('alert-danger');
            alertBox.innerHTML = 'Λάθος κωδικός ή email';
            alertBox.style.display = 'block';

            console.log(response.body);
        }
    }

}

function getCheckboxValue(checkboxes) {
    let userType = null;

    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            userType = checkbox.id;
        }
    });

    return userType;
}

function handleCheckboxClick(clickedCheckboxId) {
    const checkboxes = document.querySelectorAll('.form-check-input');

    checkboxes.forEach(function (checkbox) {
        if (checkbox.id !== clickedCheckboxId) {
            checkbox.checked = false;
        }
    });
}