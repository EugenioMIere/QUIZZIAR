document.addEventListener("DOMContentLoaded", function() {
    const card = document.querySelector('.card');
    const items = document.querySelectorAll('.list-group-item');

    card.classList.add('loaded');
    items.forEach((item, index) => {
        setTimeout(() => {
            item.classList.add('loaded');
        }, index * 200);
    });
});