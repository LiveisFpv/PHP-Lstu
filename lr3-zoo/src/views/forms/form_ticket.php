<?php
    session_start();

    $ticketCost = 500;

    function generateTimeOptions() {
        $start = strtotime("09:00");
        $end = strtotime("19:00");
        $interval = 15 * 60; 
        $options = "";

        for ($time = $start; $time <= $end; $time += $interval) {
            $formattedTime = date("H:i", $time);
            $options .= "<option value='$formattedTime'>$formattedTime</option>";
        }

        return $options;
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Покупка билета</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/lib/BasicValid.js" defer></script>
    <script src="/js/validators/TicketValid.js" defer></script>
</head>
<body>
    <script>
        window.onload = function() {
            let message = <?php echo json_encode($_SESSION["message"] ?? ""); ?>;
            if (message) {
                alert(message);
            }
            <?php $_SESSION["message"] = ""; ?>
        };
    </script>
    <div class="form-container">
        <h2>Покупка билета</h2>
        <form action="create" method="post" name="ticketForm" id="forms">
            <div class="form-group">
                <label for="ticket_time">Время сеанса:</label>
                <select id="ticket_time" name="ticket_time" required>
                    <?= generateTimeOptions(); ?>
                </select>
                <span id="ticket_time-span"></span>
            </div>

            <div class="form-group">
                <label>Стоимость билета:</label>
                <p><strong><?= $ticketCost; ?> ₽</strong></p>
                <input type="hidden" name="ticket_cost" value="<?= $ticketCost; ?>">
            </div>

            <div class="form-group">
                <label for="user_email">Email:</label>
                <input type="email" id="user_email" name="user_email" placeholder="example@mail.com">
                <span id="user_email-span"></span>
            </div>

            <h3>Реквизиты оплаты</h3>
            <div class="form-group">
                <label for="card_number">Номер карты:</label>
                <input type="text" id="card_number" name="card_number" placeholder="0000 0000 0000 0000">
                <span id="card_number-span"></span>
            </div>
            <div class="form-group">
                <label for="expiry_date">Срок действия:</label>
                <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                <span id="expiry_date-span"></span>
            </div>
            <div class="form-group">
                <label for="cvc">CVC:</label>
                <input type="text" id="cvc" name="cvc" placeholder="123">
                <span id="cvc-span"></span>
            </div>

            <button type="submit">Купить билет</button>
        </form>
    </div>
</body>
</html>
