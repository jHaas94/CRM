
let confirmIt = function (e) {
    if (!confirm('Do you really want to delete this client?')) e.preventDefault();
};
document.getElementById('confirmation').addEventListener('click', confirmIt, false);

