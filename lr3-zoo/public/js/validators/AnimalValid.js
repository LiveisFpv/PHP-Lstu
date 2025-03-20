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
        
        const csvFileInput = document.getElementById("csv-file");
        
        if (csvFileInput.files.length > 0) {
            isValid = isValid || validateCSVFile(csvFileInput.files[0]);
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});
function validateCSVFile(file){
    const reader = new FileReader();
    let isValid = true;

    reader.onload = function (e) {
        const text = e.target.result;
        const lines = text.split("\n");

        lines.forEach((line, index) => {
            const fields = line.split(",");

            if (fields.length !== 4) {
                showError("csv-file", `Ошибка в строке ${index + 1}: неверное количество полей`);
                isValid = false;
                return;
            }

            const [name, gender, age, cage] = fields;

            if (name.trim() === "" || !/^(?!-)(?!.*--)(?!.*-$)[a-zA-Zа-яА-ЯёЁ\s\-]+$/u.test(name.trim())) {
                showError("csv-file", `Ошибка в строке ${index + 1}: неверное название животного`);
                isValid = false;
            }

            if (!/^(м|ж)$/i.test(gender.trim())) {
                showError("csv-file", `Ошибка в строке ${index + 1}: неверный пол животного`);
                isValid = false;
            }

            if (isNaN(age) || age < 1 || age > 100) {
                showError("csv-file", `Ошибка в строке ${index + 1}: неверный возраст животного`);
                isValid = false;
            }

            if (isNaN(cage) || cage < 1 || cage > 1000000000) {
                showError("csv-file", `Ошибка в строке ${index + 1}: неверный номер клетки`);
                isValid = false;
            }
        });
    };
    reader.readAsText(file);
    return isValid;
}