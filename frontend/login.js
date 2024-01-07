'use strict'

let loginAPI = 'http://localhost/neolearn-backend/index.php/auth/instructor/login';

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

    try {
        const response = fetch(loginAPI, {
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

        if (response.ok) {
            // Login successful
            const data = await response.json();

            console.log(data);
        }
        else {
            // Login failed
            alert('Login failed');
        }
    }
    catch (error) {
        console.error('An error occurred during the fetch:', error);
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