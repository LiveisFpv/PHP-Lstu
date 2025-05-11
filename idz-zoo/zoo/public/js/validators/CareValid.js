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

        const careType = document.getElementById("care-type");
        if (careType.value.trim() === ""){
            showError("care-type","Введите тип ухода");
            isValid = false;
        }else if (!/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u.test(careType.value.trim())){
            showError("care-type","Тип ухода может содержать только буквы, пробелы и дефисы");
            isValid = false;
        } else{
            clearError("care-type");
        }
        
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
    return isValid
}