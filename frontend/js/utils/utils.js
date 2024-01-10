function updateUserProfileDetailsElement(name, email, userType) {
    const userProfileDetails = document.getElementById('profile-details');
    let newElement = document.createElement('p');
    newElement.innerHTML = `
        <b> Όνομα: </b> ${name} <br>
        <b> Email: </b> ${email} <br>
        <b> Τύπος: </b> ${userType} <br>
    `;

    userProfileDetails.appendChild(newElement);
}

function logout() {
    let logoutMsg = "Είσαι σίγουρος ότι επιθυμείς να αποσυνδεθείς από το Λογαριασμό σου;";
    let logoutConfirmed = confirm(logoutMsg);

    if (logoutConfirmed) {
        localStorage.removeItem('user');
        localStorage.removeItem('userType');

        window.location.href = 'welcome.html';
    }
}


export { updateUserProfileDetailsElement, logout };