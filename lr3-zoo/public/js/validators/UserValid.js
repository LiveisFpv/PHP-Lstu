document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("forms").addEventListener("submit", function (event) {
        isValid = validateInput();

        if (!isValid) {
            event.preventDefault();
        }
    });
});

function validateInput(){
    let isValid = true;

    const userName = document.getElementById("user-name");
    const userEmail = document.getElementById("user-email");
    const userPassword = document.getElementById("user-password");
    const userRole = document.getElementById("user-role");

    if (userName.value.trim()===""){
        showError("user-name", "Имя пользователя не может быть пустым.");
        isValid = false;
    } else if (!/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u.test(userName.value.trim())){
        showError("user-name", "Имя пользователя может содержать только буквы, пробелы и дефисы.")
        isValid = false;
    } else{
        clearError("user-name")
    }

    if (userEmail.value.trim()===""){
        showError("user-email", "Введите почту");
        isValid = false;
    } else if (!/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(userEmail.value.trim())){
        showError("user-email", "Некорректный email адрес.")
        isValid = false;
    } else{
        clearError("user-email")
    }

    if (userPassword.value.trim().length<8){
        showError("user-password", "Пароль должен быть не менее 8 символов");
        isValid = false;
    } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.,])[A-Za-z\d@$!%*?&]{8,}$/u.test(userPassword.value.trim())){
        showError("user-password", "Пароль должен содержать как минимум одну заглавную букву, одну строчную букву, одну цифру и один специальный символ.")
        isValid = false;
    } else{
        clearError("user-password")
    }

    if (userRole.value.trim()===""){
        showError("user-role", "Роль пользователя не может быть пустой.");
        isValid = false;
    } else if (!/^(admin|user)$/i.test(userRole.value.trim())){
        showError("user-role", "Некорректная роль пользователя.")
        isValid = false;
    } else{
        clearError("user-role")
    }

    return isValid
}