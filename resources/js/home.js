document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('div.dictionary-card')
        .forEach(card => card.addEventListener('click', (e) => {
            let target = e.target;
            while (target !== null && !target.hasAttribute('data-route')) {
                target = target.parentElement;
            }
            if (target !== null) {
                console.log(target.dataset.route);
                window.location.href = target.dataset.route;
            }
        }));
});
