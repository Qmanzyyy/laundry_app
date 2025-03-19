const eyeicon = document.getElementById("eyeicon");
const password = document.getElementById("password");

function look () {
  if (password.type == "password") {
    password.type = "text";
    eyeicon.src = "./../img/eye-open.png";
  } else {
    password.type = "password";
    eyeicon.src = "./../img/eye-close.png";
  }
};

eyeicon.addEventListener("click", look);
