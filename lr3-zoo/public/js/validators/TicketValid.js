document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("card_number").addEventListener("input", function (event) {
        let value = this.value.replace(/\D/g, ""); 
        value = value.replace(/(.{4})/g, "$1 ").trim(); 
        this.value = value;
    });

    document.getElementById("expiry_date").addEventListener("input", function (event) {
        let value = this.value.replace(/\D/g, "");
        if (value.length > 2) {
            value = value.slice(0, 2) + "/" + value.slice(2, 4); 
        }
        this.value = value;
    });
    document.getElementById("forms").addEventListener("submit", function (event) {
        
        let isValid = true;

        const ticketTime = document.getElementById("ticket_time");
        const timePattern = /^([01]?\d|2[0-3]):[0-5]\d$/;
        const [hours, minutes] = ticketTime.value.split(":").map(Number);

        if (ticketTime.value.trim() === "") {
            showError("ticket_time", "Введите время билета");
            isValid = false;
        } else if (!timePattern.test(ticketTime.value.trim())) {
            showError("ticket_time", "Некорректный формат времени (HH:MM)");
            isValid = false;
        } else if (hours < 9 || hours > 19) {
            showError("ticket_time", "Билеты доступны только с 09:00 до 19:00");
            isValid = false;
        } else if (minutes % 15 !== 0) {
            showError("ticket_time", "Время должно быть кратно 15 минутам (например, 09:00, 09:15)");
            isValid = false;
        } else {
            clearError("ticket_time");
        }

        const emailInput = document.getElementById("user_email");
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailInput.value.trim() === "") {
            showError("user_email", "Введите email");
            isValid = false;
        } else if (!emailPattern.test(emailInput.value.trim())) {
            showError("user_email", "Некорректный email");
            isValid = false;
        } else {
            clearError("user_email");
        }

        const cardNumber = document.getElementById("card_number");
        cardNumber = cardNumber.value.replace(/\s/g, "");
        if (!validateCardNumber(cardNumber.value.trim())) {
            showError("card_number", "Некорректный номер карты");
            isValid = false;
        } else {
            clearError("card_number");
        }

        const cvv = document.getElementById("cvc");
        if (!/^\d{3}$/.test(cvv.value.trim())) {
            showError("cvc", "CVV должен состоять из 3 цифр");
            isValid = false;
        } else {
            clearError("cvc");
        }

        const expiryDate = document.getElementById("expiry_date");
        if (!validateExpiryDate(expiryDate.value.trim())) {
            showError("expiry_date", "Некорректная или просроченная дата");
            isValid = false;
        } else {
            clearError("expiry_date");
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});

function validateCardNumber(cardNumber) {
    if (!/^\d{16}$/.test(cardNumber)) return false;
    let sum = 0;
    let alternate = false;
    for (let i = cardNumber.length - 1; i >= 0; i--) {
        let n = parseInt(cardNumber.charAt(i), 10);
        if (alternate) {
            n *= 2;
            if (n > 9) n -= 9;
        }
        sum += n;
        alternate = !alternate;
    }
    return sum % 10 === 0;
}

function validateExpiryDate(date) {
    if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(date)) return false;
    const [month, year] = date.split("/").map(Number);
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear() % 100;
    const currentMonth = currentDate.getMonth() + 1;
    return year > currentYear || (year === currentYear && month >= currentMonth);
}