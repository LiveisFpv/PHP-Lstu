document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("forms").addEventListener("submit", function (event) {
        
        isValid = validateInput();

        if (!isValid) {
            event.preventDefault();
        }
    });
});
function validateCSVFile(file){
    const reader = new FileReader();
    let isValid = true;

    if (!file.name.endsWith(".csv") || file.type !== "text/csv") {
        showError("csv-file","Неверный формат файла! Выберите CSV.");
        isValid=false
    }

    const maxSize = 2 * 1024 * 1024;
    if (file.size > maxSize) {
        showError("csv-file","Файл слишком большой! Максимальный размер 2MB.");
        isValid=false
    }
    return isValid;
}
function validateInput(){
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

    const cageInput = document.getElementById("animal-cage");
    if (cageInput.value < 1 || cageInput.value>1000000000 || cageInput.value === "") {
        showError("animal-cage", "Номер клетки должен быть больше 0 и меньше 1000000000");
        isValid = false;
    } else {
        clearError("animal-cage");
    }
    
    try{
        const csvFileInput = document.getElementById("csv-file");
        
        if (csvFileInput.files.length > 0) {
            isValid = isValid || validateCSVFile(csvFileInput.files[0]);
        }
    } catch (e){
    }
    return isValid;
}