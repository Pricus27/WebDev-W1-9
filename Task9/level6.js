const winningDoor = 2;
const result = document.getElementById("result");
const doorBtns = document.querySelectorAll(".doorBtn");

doorBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
    const picked = Number(btn.dataset.door);

    if (picked === winningDoor) {
        result.className = "alert alert-success mt-3 mb-0";
        result.innerHTML =
        '<i class="bi bi-trophy-fill me-2"></i> Correct! Quest Complete <i class="bi bi-check-circle-fill"></i>';
        } else {
            result.className = "alert alert-danger mt-3 mb-0";
            result.innerHTML =
              '<i class="bi bi-x-circle-fill me-2"></i> Wrong door. Try again!';
        }
    });
});