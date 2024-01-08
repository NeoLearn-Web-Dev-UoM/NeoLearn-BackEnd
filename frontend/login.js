"use strict";

async function loginInstructor(username, password) {
  let loginAPI =
    "http://localhost/neolearn-backend/index.php/auth/instructor/login";

  try {
    return fetch(loginAPI, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: username,
        password: password,
      }),
      mode: "cors",
    });
  } catch (error) {
    console.error("An error occurred during the fetch:", error);
  }
}

async function loginStudent(username, password) {
  let loginAPI =
    "http://localhost/neolearn-backend/index.php/auth/student/login";

  try {
    return fetch(loginAPI, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: username,
        password: password,
      }),
      mode: "cors",
    });
  } catch (error) {
    console.error("An error occurred during the fetch:", error);
  }
}

async function submitBtn() {
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  let userType = getCheckboxValue(checkboxes);

  if (userType === null) {
    alert("Please select a user type");
    return;
  }

  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  if (username === "" || password === "") {
    alert("Please fill in all fields");
    return;
  }

  console.log(userType);

  if (userType === "teacher") {
    const response = await loginInstructor(username, password);
    handleLoginResponse(response);
  } else if (userType === "student") {
    const response = await loginStudent(username, password);
    handleLoginResponse(response);
  }
}

function handleLoginResponse(response) {
  // Get the response body
  response
    .json()
    .then((data) => {
      let alertBox = document.getElementById("alert-login");

      if (response.ok) {
        alertBox.classList.add("alert-success");
        alertBox.innerHTML = "Login Successful";
        alertBox.style.display = "block";

        // Add user to local storage
        localStorage.setItem("user", JSON.stringify(data));

        // Redirect to dashboard based on user type
        if (data.user_type === "instructor") {
          window.location.href =
            "http://localhost/NeoLearn-BackEnd/frontend/teacher.html";
        } else if (data.user_type === "student") {
          window.location.href =
            "http://localhost/NeoLearn-BackEnd/frontend/student.html";
        }
      } else if (response.status === 401) {
        alertBox.classList.add("alert-danger");
        alertBox.innerHTML = "Incorrect username or password";
        alertBox.style.display = "block";

        console.log(response.body);
      }
    })
    .catch((error) => {
      console.error("Error parsing response body:", error);
    });
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
  const checkboxes = document.querySelectorAll(".form-check-input");

  checkboxes.forEach(function (checkbox) {
    if (checkbox.id !== clickedCheckboxId) {
      checkbox.checked = false;
    }
  });
}
