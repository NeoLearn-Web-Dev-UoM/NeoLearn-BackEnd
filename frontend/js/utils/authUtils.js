function logout() {
    let logoutMsg = "Είσαι σίγουρος ότι επιθυμείς να αποσυνδεθείς από το Λογαριασμό σου;";
    let logoutConfirmed = confirm(logoutMsg);

    if (logoutConfirmed) {
        localStorage.removeItem('user');
        window.location.href = 'welcome.html';
    }
}

export { logout };