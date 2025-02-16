<?php
session_start();
include 'conn.php'; // Ensure this file correctly establishes a database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['process_payment'])) {
    $email = htmlspecialchars($_POST['email']);
    $mobile = htmlspecialchars($_POST['mobile']);
    $amount = htmlspecialchars($_POST['amount']);

    // Validate mobile number (should be 10 digits)
    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
        echo "<script>alert('Invalid mobile number! Please enter a 10-digit number.');</script>";
    } else {
        // Generate a random transaction ID
        $transaction_id = 'TXN' . rand(100000, 999999);

        // Store values in session for the next step
        $_SESSION['transaction_id'] = $transaction_id;
        $_SESSION['amount'] = $amount;

        // Redirect to the confirmation page
        header('Location: confirm_payment.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPI Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
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
</head>
<body>
    <h2>Enter Payment Details</h2>
    <form method="POST"> <!-- ✅ Fixed: No 'action' -->
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Mobile:</label>
        <input type="text" name="mobile" pattern="[0-9]{10}" required title="Enter a valid 10-digit mobile number"><br>

        <label>Amount:</label>
        <input type="number" name="amount" min="1" required><br>

        <button type="submit" name="process_payment">Generate QR</button>
    </form>
</body>
</html>
