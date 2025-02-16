Financial Management System Documentation

Overview

The Financial Management System is a comprehensive platform designed to help users track their expenses, set and monitor savings goals . The system provides tools for managing recurring expenses, categorizing spending, and securely processing UPI payments. With interactive visual analytics, users gain better financial insights and control over their money.

Features

Savings Goal Management: Users can set, update, and delete savings goals, ensuring better financial planning.

Expense Tracking: Allows users to view, categorize, and analyze expenses in real-time using AJAX-based updates.

Recurring Expenses: Users can automate and track recurring payments, such as subscriptions and monthly bills.

UPI Payment Processing: Enables users to securely process UPI transactions with OTP verification.

Visual Analytics: Uses Chart.js to provide interactive charts and graphs for financial insights.

User Authentication: Ensures secure login and logout mechanisms for data privacy.

Technologies Used

Backend: PHP (session management, database interactions)

Database: MySQL (structured storage of financial data)

Frontend: HTML, TailwindCSS, JavaScript (for UI/UX design)

Data Visualization: Chart.js (for financial trend analysis)

Security Measures: Prepared statements, password hashing, session handling

Functional Flow

1. Managing Savings Goals

Users enter details such as:

Goal Name

Target Amount

Current Savings

Goal Deadline

System stores this information in the saving table.

Users can add more savings to their goals and track progress.

When a goal is reached, the system notifies the user.

2. Tracking Expenses

Users can categorize expenses based on predefined categories (e.g., food, travel, utilities).

The system dynamically updates expense records and provides real-time filtering.

Expenses are stored in the expense table.

Users can search for expenses by category and view them in a detailed table.

3. Recurring Expenses

Users can set up automated recurring expenses, such as monthly rent or utility bills.

The system fetches available expense categories dynamically from ENUM fields.

Users can filter and view recurring expenses.

Data is stored in the recurring_expense table.

4. UPI Payment Processing

Users enter payment details, including:

Transaction Amount

Mobile Number

Email Address

The system generates a transaction ID and stores it in upi_transaction.

Users confirm payment via OTP authentication.

Successful transactions are logged in the system.

5. Visualizing Financial Data

Users can analyze savings progress and expense patterns using:

Pie Charts (for comparing savings vs. expenses)

Line Charts (for tracking financial trends over time)

Bar Graphs (for category-wise expense breakdowns)

Chart.js dynamically updates graphs based on user-selected filters.

Database Interaction

Tables Used:

saving (Manages savings goals, including target amount and deadline)

expense (Stores individual expense transactions by category)

recurring_expense (Handles automated recurring expenses)

upi_transaction (Logs UPI-based transactions)

SQL Queries

Insert Savings Goal:

INSERT INTO saving (user_id, goal_name, target_amount, current_saving, goal_deadline)
VALUES (?, ?, ?, ?, ?);

Fetch Expenses by Category:

SELECT * FROM expense WHERE user_id=? AND cat_types=?;

Insert UPI Transaction:

INSERT INTO upi_transaction (transaction_id, user_id, amount, date)
VALUES (?, ?, ?, ?);

Retrieve Recurring Expenses:

SELECT * FROM recurring_expense WHERE user_id=?;

Security Considerations

SQL Injection Prevention: Uses prepared statements to prevent malicious database queries.

Session Security: Ensures user authentication before accessing sensitive financial data.

Data Validation:

Ensures numeric values for all financial fields (e.g., amount, savings goal target).

Verifies mobile numbers and email addresses before processing payments.

Password Hashing: User passwords are hashed using password_hash() before being stored in the database.

OTP Verification: Ensures secure UPI transactions by verifying user identity via one-time password authentication.

Future Enhancements

Implement email and SMS alerts to notify users of upcoming expenses and goal achievements.

Introduce budget tracking and expenditure limits to help users manage spending.

Enhance UI with AI-based financial insights and spending recommendations.

Add multi-user collaboration for family budgeting and group financial planning.

Develop export options (CSV, PDF) for users to download their financial reports.

Implement dark mode and customizable themes for better user experience.

Conclusion

The Financial Management System is a user-friendly and secure platform designed to streamline financial tracking and expense management. The system enables users to efficiently set goals, categorize spending, and process payments with real-time insights. With future improvements, it aims to provide an even more comprehensive personal finance management experience.

