//Toggler behavior
const el = document.querySelector('.collapse');
const button = document.querySelector('.toggler');
const handleToggle = () => el.classList.toggle('show');
button.onclick = () => handleToggle();


//Move debugging to the bottom of the page
const debug = document.querySelectorAll(".debug");
const footer = document.querySelector("#footer");
[].forEach.call(debug, function(div) {
    footer.before(div);
});