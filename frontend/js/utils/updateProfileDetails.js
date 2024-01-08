let user = JSON.parse(localStorage.getItem('user'));
let userType = localStorage.getItem('userType');

let profDetails = document.getElementById('profile-details');

let name = user.name;
let email = user.email;

let element = `
    <p>
        <b>${userType === 'Teacher' ? `Καθηγητής` : 'Μαθητής'}</b> <br>
        <b>Όνομα:</b> ${name} <br>
        <b>Email:</b> ${email} <br>
    </p>
`

profDetails.innerHTML = element;
