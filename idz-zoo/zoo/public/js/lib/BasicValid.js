function showError(inputId, message) {
    const span = document.getElementById(inputId + "-span");
    span.textContent = message;
    span.style.color = "red";
}

function clearError(inputId) {
    const span = document.getElementById(inputId + "-span");
    span.textContent = "";
}