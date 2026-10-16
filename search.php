<?php
require_once 'db.php';

/**
 * Renders a page in the same style as the registration and search pages.
 * $mode: "table" (wide card for results) or "message" (small card with icon).
 */
function render_page(string $content, string $mode = "message"): void
{
    $wide = $mode === "table";
    $icon = $wide ? '' : '<div class="icon" aria-hidden="true">!</div>';

    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>

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
            --tint: #e6f3f1;
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

        .container.wide {
            max-width: 1040px;
            padding: 34px;
            text-align: left;
        }

        .icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            display: grid;
            place-items: center;
            border-radius: 18px;
            background: var(--amber);
            color: var(--deep);
            font-family: "Fraunces", Georgia, serif;
            font-size: 30px;
            font-weight: 700;
        }

        h2 {
            font-family: "Fraunces", Georgia, serif;
            font-size: clamp(24px, 4vw, 30px);
            line-height: 1.2;
            letter-spacing: -0.4px;
        }

        h3 {
            font-size: 17px;
            font-weight: 600;
            color: var(--text);
        }

        /* ===== Results table ===== */
        .table-wrap {
            margin-top: 22px;
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: 12px;
        }

        table { width: 100%; border-collapse: collapse; font-size: 14.5px; }

        th {
            padding: 13px 16px;
            text-align: left;
            white-space: nowrap;
            background: var(--tint);
            color: var(--deep);
            font-size: 13.5px;
            font-weight: 700;
        }

        td {
            padding: 14px 16px;
            border-top: 1px solid var(--line);
            vertical-align: top;
        }

        tbody tr:hover td { background: #f8fbfa; }

        /* ===== Buttons ===== */
        .actions {
            margin-top: 26px;
            display: grid;
            gap: 12px;
        }

        .wide .actions {
            display: flex;
            flex-wrap: wrap;
        }

        .actions a {
            min-height: 48px;
            padding: 0 26px;
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

        .actions a:last-child {
            color: var(--teal-dark);
            border: 1.5px solid var(--line);
            background: #fff;
        }

        .actions a:last-child:hover { border-color: var(--teal); }

        /* ===== Mobile: each row becomes a labelled card ===== */
        @media (max-width: 760px) {
            .topbar { padding: 14px 16px; }
            .page { padding: 20px 12px; align-items: flex-start; }
            .container { padding: 30px 20px 26px; }
            .container.wide { padding: 24px 16px; }

            .table-wrap { border: 0; overflow: visible; }
            table, tbody, tr, td { display: block; width: 100%; }
            thead { display: none; }

            tr {
                border: 1px solid var(--line);
                border-radius: 12px;
                overflow: hidden;
            }

            td {
                display: grid;
                grid-template-columns: 96px 1fr;
                gap: 10px;
                padding: 11px 14px;
                word-break: break-word;
            }

            td:first-child { border-top: 0; }

            td::before {
                content: attr(data-label);
                color: var(--muted);
                font-weight: 600;
                font-size: 13px;
            }

            .wide .actions { display: grid; }
        }

        @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    </style>
</head>
<body>

    <header class="topbar">
        <span class="brand">Student Portal</span>
        <a href="index.html">Register student</a>
    </header>

    <main class="page">
        <div class="container' . ($wide ? ' wide' : '') . '">
            ' . $icon . '
            ' . $content . '
        </div>
    </main>

</body>
</html>';
}

$links = '<div class="actions">
                <a href="search.html">Search Again</a>
                <a href="index.html">Back to Registration</a>
            </div>';

if (isset($_GET['studentid']) && $_GET['studentid'] !== '') {

    $studentid = trim($_GET['studentid']);

    $sql = "SELECT * FROM newdata WHERE studentid = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        render_page('<h3>Search query failed.</h3>');
        exit;
    }

    $stmt->bind_param("i", $studentid);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $content  = "<h2>Student Details</h2>";
        $content .= '<div class="table-wrap">';
        $content .= "<table>";
        $content .= "<thead><tr>
                <th>Name</th>
                <th>Student ID</th>
                <th>Class</th>
                <th>School</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
              </tr></thead><tbody>";

        while ($row = $result->fetch_assoc()) {
            $content .= "<tr>";
            $content .= '<td data-label="Name">' . htmlspecialchars($row['name']) . "</td>";
            $content .= '<td data-label="Student ID">' . htmlspecialchars($row['studentid']) . "</td>";
            $content .= '<td data-label="Class">' . htmlspecialchars($row['class']) . "</td>";
            $content .= '<td data-label="School">' . htmlspecialchars($row['schoolname']) . "</td>";
            $content .= '<td data-label="Email">' . htmlspecialchars($row['email']) . "</td>";
            $content .= '<td data-label="Address">' . htmlspecialchars($row['address']) . "</td>";
            $content .= '<td data-label="Phone">+' . htmlspecialchars($row['phonecode']) . " "
                       . htmlspecialchars($row['phone']) . "</td>";
            $content .= "</tr>";
        }

        $content .= "</tbody></table></div>";

        $stmt->close();
        $conn->close();

        render_page($content . $links, "table");
        exit;

    } else {
        $content = "<h3>No Student Found</h3>";
    }

    $stmt->close();
    $conn->close();

} else {
    $content = "<h3>Please enter a Student ID.</h3>";
}

render_page($content . $links);