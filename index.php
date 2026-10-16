<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'db.php';

/**
 * Renders a result page in the same style as the registration form.
 * $type: "success" or "error" (only changes the icon colour).
 */
function render_page(string $title, string $content, string $type = "error"): void
{
    $icon = $type === "success" ? "&#10003;" : "!";

    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $title . '</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:wght@600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --deep: #0b3b3c;
            --teal: #0f9b8e;
            --teal-dark: #0b7a70;
            --amber: #ffb547;
            --text: #17302f;
            --muted: #6b7f7e;
            --line: #d5e0de;
            --page: #f1f5f4;
            --white: #ffffff;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            font-family: "DM Sans", "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background: var(--page);
            line-height: 1.55;
            overflow-x: hidden;
        }

        .topbar {
            background: var(--deep);
            color: #fff;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand {
            font-family: "Fraunces", Georgia, serif;
            font-size: 20px;
            font-weight: 700;
        }

        .topbar a {
            color: #cfeeea;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border-bottom: 1px solid rgba(207, 238, 234, 0.4);
        }

        .topbar a:hover { color: #fff; border-color: #fff; }
        a:focus-visible { outline: 3px solid var(--amber); outline-offset: 3px; }

        .page {
            min-height: calc(100vh - 57px);
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 520px;
            padding: 40px 34px 34px;
            text-align: center;
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 22px 44px rgba(11, 59, 60, 0.1);
        }

        .icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            display: grid;
            place-items: center;
            border-radius: 18px;
            font-family: "Fraunces", Georgia, serif;
            font-size: 30px;
            font-weight: 700;
        }

        .icon.success { background: var(--teal); color: #fff; }
        .icon.error { background: var(--amber); color: var(--deep); }

        h2 {
            font-family: "Fraunces", Georgia, serif;
            font-size: clamp(24px, 4vw, 30px);
            line-height: 1.2;
            letter-spacing: -0.4px;
        }

        .container p { margin-top: 10px; color: var(--muted); }

        .container .message {
            margin-top: 0;
            font-size: 17px;
            font-weight: 600;
            color: var(--text);
        }

        .message a {
            display: inline-block;
            margin-top: 14px;
            color: var(--teal-dark);
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1.5px solid currentColor;
        }

        .message a:hover { color: var(--deep); }

        .actions {
            margin-top: 28px;
            display: grid;
            gap: 12px;
        }

        .actions a {
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: background .15s, border-color .15s;
        }

        .actions a:first-child { background: var(--teal); color: #fff; }
        .actions a:first-child:hover { background: var(--teal-dark); }

        .actions a:last-child:not(:first-child) {
            color: var(--teal-dark);
            border: 1.5px solid var(--line);
            background: #fff;
        }

        .actions a:last-child:not(:first-child):hover { border-color: var(--teal); }

        @media (max-width: 600px) {
            .topbar { padding: 14px 16px; }
            .page { padding: 20px 12px; align-items: flex-start; }
            .container { padding: 30px 20px 26px; }
        }

        @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    </style>
</head>
<body>

    <header class="topbar">
        <span class="brand">Student Portal</span>
        <a href="search.html">Search student details</a>
    </header>

    <main class="page">
        <div class="container">
            <div class="icon ' . $type . '" aria-hidden="true">' . $icon . '</div>
            ' . $content . '
        </div>
    </main>

</body>
</html>';
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

$studentname        = trim($_POST["studentname"] ?? "");
$studentid          = trim($_POST["studentid"] ?? "");
$studentclass       = trim($_POST["studentclass"] ?? "");
$studentschoolname  = trim($_POST["studentschoolname"] ?? "");
$studentemail       = trim($_POST["studentemail"] ?? "");
$studentaddress     = trim($_POST["studentaddress"] ?? "");
$studentcountrycode = trim($_POST["studentcountrycode"] ?? "");
$studentphone       = trim($_POST["studentphone"] ?? "");

// Validate all fields
if (
    $studentname === "" ||
    $studentid === "" ||
    $studentclass === "" ||
    $studentschoolname === "" ||
    $studentemail === "" ||
    $studentaddress === "" ||
    $studentcountrycode === "" ||
    $studentphone === ""
) {
    render_page("Student Registration", '<p class="message">All fields are required.</p>');
    exit;
}

if (!filter_var($studentemail, FILTER_VALIDATE_EMAIL)) {
    render_page("Student Registration", '<p class="message">Please enter a valid email address.</p>');
    exit;
}

// Check database connection
if (!isset($conn) || $conn->connect_error) {
    render_page("Student Registration", '<p class="message">Database connection failed. Please check db.php.</p>');
    exit;
}

// Check whether email already exists
$check = $conn->prepare(
    "SELECT email FROM newdata WHERE email = ? LIMIT 1"
);

if (!$check) {
    render_page("Student Registration", '<p class="message">Unable to check email. Please verify the database table.</p>');
    exit;
}

$check->bind_param("s", $studentemail);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $check->close();
    $conn->close();
    render_page(
        "Student Registration",
        '<p class="message">This email is already registered.<br>
        <a href="index.html">Go Back</a></p>'
    );
    exit;
}

$check->close();

// Insert student details
$sql = "INSERT INTO newdata
(name, studentid, class, schoolname, email, address, phonecode, phone)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    render_page("Student Registration", '<p class="message">Unable to prepare registration query. Check your database columns.</p>');
    exit;
}

$stmt->bind_param(
    "ssssssss",
    $studentname,
    $studentid,
    $studentclass,
    $studentschoolname,
    $studentemail,
    $studentaddress,
    $studentcountrycode,
    $studentphone
);

if ($stmt->execute()) {
    render_page(
        "Registration Successful",
        '<h2>Student Registered Successfully!</h2>
            <p>Your details have been saved successfully.</p>
            <div class="actions">
                <a href="index.html">Register Another Student</a>
                <a href="search.html">Search Student Details</a>
            </div>',
        "success"
    );
} else {
    render_page("Student Registration", '<p class="message">Registration failed. Please verify the submitted details.</p>');
}

$stmt->close();
$conn->close();