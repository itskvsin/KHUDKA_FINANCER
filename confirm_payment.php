<?php
session_start();
include 'conn.php'; // Database connection

$transaction_id = $_SESSION['transaction_id'];
$email = $_SESSION['email'];
$mobile = $_SESSION['mono'];
$amount = $_SESSION['amount']; // Fixed session variable name
$user_id = $_SESSION['userid'];

$_SESSION['otp'] = 1234; // Static OTP for testing; should be dynamically generated in production

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];
    if ($entered_otp == $_SESSION['otp']) {
        $date = date('Y-m-d H:i:s');

        // Insert transaction into the upi_transaction table
        $stmt = $conn->prepare("INSERT INTO upi_transaction (transaction_id, user_id, amount, date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sids", $transaction_id, $user_id, $amount, $date);

        if ($stmt->execute()) {
            // Insert into the expense table
            $expense_stmt = $conn->prepare("INSERT INTO expense (user_id, amount, cat_types, date, description) VALUES (?, ?, ?, ?, ?)");
            $cat_type = "Miscellaneous";
            $description = "UPI";
            $expense_stmt->bind_param("idsss", $user_id, $amount, $cat_type, $date, $description);
            $expense_stmt->execute();
            $expense_stmt->close();

            echo "<script>alert('Payment Successful! Transaction ID: $transaction_id'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Transaction failed! Try again.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Invalid OTP! Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .qr-container {
            margin: 20px auto;
        }
        .countdown {
            font-size: 20px;
            color: red;
            margin-bottom: 10px;
        }
        form {
            display: inline-block;
            text-align: left;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            font-size: 16px;
        }
    </style>
    <script>
        let countdown = 30;
        function startCountdown() {
            let timer = setInterval(function () {
                document.getElementById("countdown").innerText = countdown;
                countdown--;
                if (countdown < 0) {
                    clearInterval(timer);
                    document.getElementById("otp-section").innerHTML = "<p style='color:red;'>Time expired! Please refresh to retry.</p>";
                }
            }, 1000);
        }
        window.onload = startCountdown;
    </script>
</head>
<body>
    <h2>Confirm Payment</h2>
    <p><b>Transaction ID:</b> <?php echo $transaction_id; ?></p>
    <p><b>Amount:</b> ₹<?php echo number_format($amount, 2); ?></p>

    <div class="qr-container">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa=your_upi_id&pn=Your%20Merchant%20Name&mc=1234&tid=<?php echo $transaction_id; ?>&tr=<?php echo $transaction_id; ?>&am=<?php echo $amount; ?>&cu=INR" alt="QR Code">
        <p>Scan & Pay via UPI</p>
    </div>

    <p class="countdown">Time left: <span id="countdown">30</span> seconds</p>

    <form method="POST" id="otp-section">
        <label>Enter OTP:</label>
        <input type="text" name="otp" pattern="[0-9]{4}" required><br>
        <button type="submit" name="verify_otp">Confirm Payment</button>
    </form>
</body>
</html>
