let coins = 0;
const coinsSpan = document.getElementById("coins");
const plusBtn = document.getElementById("plusBtn");
const minusBtn = document.getElementById("minusBtn");

plusBtn.addEventListener("click", function () {
    coins++;
    coinsSpan.textContent = coins;
});

minusBtn.addEventListener("click", function () {
    if (coins > 0) coins--;
    coinsSpan.textContent = coins;
});