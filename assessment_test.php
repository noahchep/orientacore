<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Step 0: Check if the student has already completed any assessment
$stmt = $pdo->prepare("SELECT id FROM career_assessments WHERE user_id = ?");
$stmt->execute([$user_id]);
$existing_assessment = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing_assessment) {
    // Redirect to results page
    header("Location: assessment_results.php?id=" . $existing_assessment['id']);
    exit;
}

// Step 1: Get all categories
$stmt = $pdo->query("SELECT DISTINCT category FROM career_questions WHERE category IS NOT NULL");
$categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Step 2: Handle category selection
$selected_category = $_POST['selected_category'] ?? null;
$questions = [];

if ($selected_category) {
    // Fetch questions for this category
    $stmt = $pdo->prepare("SELECT * FROM career_questions WHERE category = ? ORDER BY id ASC");
    $stmt->execute([$selected_category]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Step 3: Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['responses']) && $questions) {
    $responses = $_POST['responses'];
    $assessment_type = $selected_category;

    $responses_detailed = [];
    foreach ($responses as $qid => $opt) {
        foreach ($questions as $q) {
            if ($q['id'] == $qid) {
                $responses_detailed[$qid] = [
                    "question" => $q['question_text'],
                    "answer" => $opt,
                    "text" => $q["option_" . strtolower($opt)],
                    "category" => $q['category']
                ];
            }
        }
    }

    $responses_json = json_encode($responses_detailed);

    $stmt = $pdo->prepare("INSERT INTO career_assessments 
        (user_id, assessment_type, responses, score, result, created_at) 
        VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$user_id, $assessment_type, $responses_json, 0, 'Pending Analysis']);

    $assessment_id = $pdo->lastInsertId();
    header("Location: assessment_results.php?id=" . $assessment_id);
    exit;
}
?>

<h2>Career Interest Assessment</h2>

<?php if (!$selected_category): ?>
    <!-- Step 1: Select category -->
    <form method="post">
        <label>Select the career category you are interested in:</label><br><br>
        <select name="selected_category" required>
            <option value="">-- Choose Category --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <button type="submit">Start Assessment</button>
    </form>

<?php else: ?>
    <!-- Step 2: Show questions -->
    <form method="post">
        <input type="hidden" name="selected_category" value="<?= htmlspecialchars($selected_category) ?>">
        <?php foreach ($questions as $index => $q): ?>
            <div>
                <p><strong>Q<?= $index + 1 ?>: <?= htmlspecialchars($q['question_text']) ?></strong></p>
                <label>
                    <input type="radio" name="responses[<?= $q['id'] ?>]" value="A" required>
                    <?= htmlspecialchars($q['option_a']) ?>
                </label><br>
                <label>
                    <input type="radio" name="responses[<?= $q['id'] ?>]" value="B">
                    <?= htmlspecialchars($q['option_b']) ?>
                </label><br>
                <label>
                    <input type="radio" name="responses[<?= $q['id'] ?>]" value="C">
                    <?= htmlspecialchars($q['option_c']) ?>
                </label><br>
                <label>
                    <input type="radio" name="responses[<?= $q['id'] ?>]" value="D">
                    <?= htmlspecialchars($q['option_d']) ?>
                </label>
            </div>
            <hr>
        <?php endforeach; ?>
        <button type="submit">Submit Assessment</button>
    </form>
<?php endif; ?>
