document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("search");
    const unitsContainer = document.getElementById("units-container");
    const cards = unitsContainer.getElementsByClassName("unit-card");
    const displaySearchContainer = unitsContainer.style.display;
    const displayCards = cards[0].style.display;
    
    searchInput.addEventListener("input", () => {
        const query = searchInput.value.toLowerCase();
        let filteredCardsNb = 0;

        Array.from(cards).forEach((card) => {
            const cardTitle = card.querySelector(".card-title").textContent.toLowerCase();
            const cardCost = card.querySelector(".card-text").textContent.toLowerCase();
            const cardOrigin = (() => {
                let temp = card.querySelectorAll(".card-text")[1].cloneNode(true);
                temp.querySelector('img').remove();
                return temp.textContent.toLowerCase();
            })();

            if (cardTitle.indexOf(query) !== -1 || cardCost.indexOf(query) !== -1 || cardOrigin.indexOf(query) !== -1) {
                card.style.display = displayCards;
                filteredCardsNb += 1;
            } else {
                card.style.display = "none";
            }
        });

        unitsContainer.style.display = filteredCardsNb > 0 ? displaySearchContainer : "none";
    });
});
