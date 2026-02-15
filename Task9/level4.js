const heroName = document.getElementById("heroName");
const submitBtn = document.getElementById("submitBtn");
const result = document.getElementById("result");

submitBtn.addEventListener("click", function () {
const name = heroName.value.trim();

if (name === "") {
    result.className = "text-danger fw-semibold";
    result.textContent = "Name is required!";
    } else {
    result.className = "text-success fw-semibold";
    result.textContent = "Welcome, " + name + "!";
    }
});
    