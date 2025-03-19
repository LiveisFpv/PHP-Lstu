document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("forms").addEventListener("submit", function (event) {
        let isValid = true;

        const nameInput = document.getElementById("animal-name");
        if (nameInput.value.trim() === "") {
            showError("animal-name", "Введите название животного");
            isValid = false;
        } else if(!/^(?!-)(?!.*--)(?!.*-$)[a-zA-Zа-яА-ЯёЁ\s\-]+$/u.test(nameInput.value.trim())){
            showError("animal-name", "Название животного не могут содержать специальные символы и цифры начинаться или заканчиваться на '-' и не может состоять только из '-'")
            isValid = false;
        } else {
            clearError("animal-name");
        }

        const genderInput = document.getElementById("animal-gender");
        if (!/^(м|ж)$/i.test(genderInput.value.trim())) {
            showError("animal-gender", "Введите 'м', 'ж'");
            isValid = false;
        } else {
            clearError("animal-gender");
        }

        const ageInput = document.getElementById("animal-age");
        if (ageInput.value < 1 || ageInput.value>100 || ageInput.value === "") {
            showError("animal-age", "Возраст должен быть больше 0 и меньше 100");
            isValid = false;
        } else {
            clearError("animal-age");
        }

        const cageInput = document.getElementById("cage");
        if (cageInput.value < 1 || cageInput.value>1000000000 || cageInput.value === "") {
            showError("cage", "Номер клетки должен быть больше 0 и меньше 1000000000");
            isValid = false;
        } else {
            clearError("cage");
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});
