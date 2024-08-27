<?php
include '../config/db.php';
include '../templates/header.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$courses = $pdo->query("SELECT * FROM courses")->fetchAll();
$enrolled = $pdo->prepare("SELECT course_id FROM user_courses WHERE user_id = ?");
$enrolled->execute([$user_id]);
$enrolled_courses = $enrolled->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $action = $_POST['action'];

    if ($action == 'enroll') {
        $stmt = $pdo->prepare("INSERT INTO user_courses (user_id, course_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $course_id]);
    } elseif ($action == 'unenroll') {
        $stmt = $pdo->prepare("DELETE FROM user_courses WHERE user_id = ? AND course_id = ?");
        $stmt->execute([$user_id, $course_id]);
    }

    header("Location: dashboard.php");
    exit();
}
?>

<div class="container mt-4">
    <h1>Dashboard</h1>
    <a href="logout.php" class="btn btn-danger">Logout</a>

    <h2>Courses</h2>
    <ul class="list-group">
        <?php foreach ($courses as $course): ?>
            <li class="list-group-item">
                <?php echo htmlspecialchars($course['name']); ?>
                <?php if (in_array($course['id'], $enrolled_courses)): ?>
                    <form method="POST" class="d-inline float-end">
                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                        <input type="hidden" name="action" value="unenroll">
                        <button type="submit" class="btn btn-warning">Unenroll</button>
                    </form>
                <?php else: ?>
                    <form method="POST" class="d-inline float-end">
                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                        <input type="hidden" name="action" value="enroll">
                        <button type="submit" class="btn btn-success">Enroll</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include '../templates/footer.php'; ?>