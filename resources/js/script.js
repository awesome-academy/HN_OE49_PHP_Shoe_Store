document.getElementById('navbarDropdown').addEventListener("click", function() {
    document.getElementById('dd-menu').classList.toggle('show');
})

document.getElementById('logout').addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById('logout-form').submit();
})


