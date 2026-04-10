<?php
$pathStudents = "./students.json";
$pathArrivals = "./arrivals.json";

require_once('arrival.php');
require_once('student.php');

session_start();

// handle login form submission
if (isset($_POST['studentName'])) {
    $_SESSION['studentName'] = $_POST['studentName'];
    if (empty($_SESSION['studentName'])) { closeSession(); }
    if ($_SESSION['studentName'] !== "all") {
        Student::initStudent($pathStudents, $_SESSION['studentName']);
    }
    record();
}

// redirect to login if no active session
if (empty($_SESSION['studentName'])) {
    header("Location: index.php");
    exit();
}

// handle arrival recording
if (isset($_POST['recordArrival'])) {
    record();
    header("Location: profile.php");
    exit();
}

if (isset($_POST['logout'])) { closeSession(); }

function closeSession(): void {
    session_destroy();
    header("Location: index.php");
    exit();
}

/**
 * Records an arrival for the current student and increments their counter.
 * Sets a session warning if the arrival is outside the allowed time window.
 */
function record() {
    global $pathArrivals, $pathStudents;
    if ($_SESSION['studentName'] !== "all") {
        if (Arrival::recordArrival($pathArrivals, $_SESSION['studentName'])) {
            Student::incrArrivalCount($pathStudents, $_SESSION['studentName']);
        }
        else {
            $_SESSION['lateWarning'] = true;
        }
    }
}

/**
 * Outputs the welcome message and arrival info for the current user.
 * If logged in as "all", shows a table of every recorded arrival.
 */
function welcomeUser(): void {
    global $pathArrivals, $pathStudents;

    if ($_SESSION['studentName'] == "all") {
        echo "<b>All recorded arrivals:</b><br>";
        Arrival::showArrivals($pathArrivals);
    }
    else {
        echo "Welcome, " . htmlspecialchars($_SESSION['studentName']) . "!<br>";
        Student::showArrivalCount($pathStudents, $_SESSION['studentName']);
    }
}
?>

<form method="post">
    <button type="submit" name="recordArrival">Record arrival</button>
</form>

<?php if (!empty($_SESSION['lateWarning'])): ?>
    <p>Arrivals after 20:00 are not recorded.</p>
    <?php unset($_SESSION['lateWarning']); ?>
<?php endif; ?>

<form method="post">
    <button type="submit" name="logout">Log out</button>
</form>

<?php
welcomeUser();
?>