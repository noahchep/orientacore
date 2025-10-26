<?php
// career_assessment_index.php
// Single-file career assessment demo inspired by CareerFitter test page.
// Save this file to a PHP-enabled server (e.g., XAMPP, LAMP) and open in browser.
// It contains inline CSS and JS for simplicity and a tiny JSON-based result store.

session_start();

// Simple question set (pairwise forced-choice). Each question awards 1 point to a category key when option A or B chosen.
$questions = [
    ["q" => "Are you more inspired by", "a" => "envisioning hypothetical ideas", "b" => "facts and data", "akey" => "creative", "bkey" => "analytical"],
    ["q" => "Do you prefer", "a" => "working with people", "b" => "working with machines", "akey" => "social", "bkey" => "technical"],
    ["q" => "Would you rather", "a" => "lead a team", "b" => "follow a plan", "akey" => "leadership", "bkey" => "organized"],
    ["q" => "Do you enjoy", "a" => "designing things", "b" => "solving puzzles", "akey" => "creative", "bkey" => "analytical"],
    ["q" => "Are you drawn to", "a" => "helping others directly", "b" => "research and discovery", "akey" => "social", "bkey" => "analytical"],
    ["q" => "Do you prefer tasks that are", "a" => "hands-on", "b" => "desk-based", "akey" => "technical", "bkey" => "organized"],
    ["q" => "Would you rather", "a" => "pitch an idea", "b" => "refine a process", "akey" => "leadership", "bkey" => "organized"],
    ["q" => "Do you like", "a" => "expressing yourself", "b" => "working with numbers", "akey" => "creative", "bkey" => "analytical"],
    ["q" => "At work do you value", "a" => "collaboration", "b" => "independence", "akey" => "social", "bkey" => "technical"],
    ["q" => "Are you better at", "a" => "big-picture thinking", "b" => "detail-focused tasks", "akey" => "leadership", "bkey" => "organized"],
];

$categories = ["creative"=>0, "analytical"=>0, "social"=>0, "technical"=>0, "leadership"=>0, "organized"=>0];

// Handle submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers_json'])) {
    $answers = json_decode($_POST['answers_json'], true);
    // tally
    foreach ($answers as $qi => $choice) {
        if (!isset($questions[$qi])) continue;
        $q = $questions[$qi];
        if ($choice === 'A') $categories[$q['akey']] += 1;
        if ($choice === 'B') $categories[$q['bkey']] += 1;
    }
    arsort($categories);
    $_SESSION['last_result'] = $categories;

    // save to results.json (append)
    $store = [
        'timestamp'=>date('c'),
        'ip'=>$_SERVER['REMOTE_ADDR'] ?? 'local',
        'scores'=>$categories
    ];
    $file = __DIR__ . '/results.json';
    $all = [];
    if (file_exists($file)) $all = json_decode(file_get_contents($file), true) ?: [];
    $all[] = $store;
    file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT));

    // redirect to results anchor
    header('Location: '.$_SERVER['PHP_SELF'].'#results');
    exit;
}

// If session has results, expose them to JS via PHP var
$session_result = $_SESSION['last_result'] ?? null;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Career Test — Work Personality Assessment</title>
  <style>
    /* Minimal reset */
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:Inter,system-ui,Arial,sans-serif;background:#f1f6fb;color:#10243a}
    .hero{background:linear-gradient(180deg,#05243e 0%, #0f4664 100%);color:#fff;padding:34px 20px 14px}
    .container{max-width:1100px;margin: -40px auto 60px;padding:20px}
    .card{background:#fff;border-radius:12px;padding:28px;box-shadow:0 8px 20px rgba(8,30,50,0.15)}
    .logo{display:flex;align-items:center;gap:12px}
    .logo .mark{width:46px;height:46px;background:#fff;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#0f4664;font-weight:700}
    h1{font-size:28px;margin-bottom:6px}
    .sub{opacity:0.9}

    /* icons strip */
    .icons{display:flex;gap:12px;margin:18px 0;overflow:hidden}
    .icons img{height:68px;border-radius:8px;object-fit:cover}

    /* question area */
    .qwrap{display:flex;flex-direction:column;gap:18px}
    .progress{height:12px;background:#edf3f8;border-radius:100px;overflow:hidden}
    .progress > i{display:block;height:100%;width:0;background:#1d6fa5}
    .question{font-size:20px;font-weight:600}
    .choices{display:flex;gap:16px;flex-wrap:wrap}
    .choice{flex:1;padding:16px;border-radius:10px;border:2px solid #e6eef6;background:#f8fcff;cursor:pointer;text-align:center;font-weight:600}
    .choice:hover{transform:translateY(-2px)}
    .choice.selected{background:#1d6fa5;color:#fff;border-color:#175b87}
    .controls{display:flex;justify-content:space-between;align-items:center;margin-top:12px}
    .small{font-size:13px;color:#5b7385}
    .btn{background:#1d6fa5;color:#fff;padding:10px 18px;border-radius:10px;border:none;cursor:pointer}

    /* results */
    .result-list{display:flex;gap:12px;flex-wrap:wrap;margin-top:14px}
    .result-item{flex:1;min-width:150px;padding:12px;border-radius:8px;background:#f4fbff;text-align:center}

    footer{max-width:1100px;margin:40px auto;color:#5b7286;text-align:center}

    /* responsive */
    @media(min-width:900px){.choices .choice{flex:0 0 48%}}
  </style>
</head>
<body>
  <header class="hero">
    <div class="container" style="max-width:1100px;margin:0 auto;color:#fff">
      <div class="logo">
        <div class="mark">CF</div>
        <div>
          <h1>Career Test <span style="font-size:14px;opacity:.9">Work Personality Assessment</span></h1>
          <div class="sub">Find out what career fits you best — quick, simple pairwise choices</div>
        </div>
      </div>
      <div class="icons" aria-hidden="true" style="margin-top:18px">
        <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=400&auto=format&fit=crop&ixlib=rb-4.0.3&s=1" alt="people">
        <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=400&auto=format&fit=crop&ixlib=rb-4.0.3&s=2" alt="people">
        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=400&auto=format&fit=crop&ixlib=rb-4.0.3&s=3" alt="people">
        <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=400&auto=format&fit=crop&ixlib=rb-4.0.3&s=4" alt="people">
      </div>
    </div>
  </header>

  <main class="container">
    <div class="card">
      <div id="test-area" class="qwrap">
        <div class="progress" aria-hidden="true"><i id="progress-bar"></i></div>
        <div style="display:flex;justify-content:space-between;align-items:center">
          <div class="small">Question <span id="qnum">1</span> of <?php echo count($questions); ?></div>
          <div class="small">Approx <strong>3-7 min</strong> to complete</div>
        </div>

        <div id="question-box">
          <div class="question" id="question-text"></div>
          <div class="choices" id="choices"></div>
        </div>

        <div class="controls">
          <button id="prevBtn" class="btn" style="background:#9fbdd6">Previous</button>
          <div style="display:flex;gap:8px;align-items:center">
            <div class="small">Can't decide?</div>
            <button id="skipBtn" class="btn" style="background:#6aa0c2">Skip</button>
            <button id="nextBtn" class="btn">Next</button>
          </div>
        </div>

        <form id="submitForm" method="POST" style="display:none">
          <input type="hidden" name="answers_json" id="answers_json">
        </form>
      </div>

      <div id="results" style="margin-top:22px">
        <?php if ($session_result): ?>
          <h3>Last result</h3>
          <div class="result-list">
            <?php foreach ($session_result as $cat => $score): ?>
              <div class="result-item"><strong><?php echo htmlspecialchars(ucfirst($cat)); ?></strong><div style="font-size:18px;margin-top:6px"><?php echo $score; ?></div></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </main>

  <footer>
    Built for demo — customize questions and styling. Place this file on a PHP server. Results are appended to <code>results.json</code> in the same folder.
  </footer>

  <script>
    // Questions passed from PHP
    const QUESTIONS = <?php echo json_encode($questions); ?>;
    const total = QUESTIONS.length;
    let index = 0;
    const answers = Array(total).fill(null);

    const qText = document.getElementById('question-text');
    const choices = document.getElementById('choices');
    const progressBar = document.getElementById('progress-bar');
    const qnum = document.getElementById('qnum');

    function render() {
      qnum.textContent = index + 1;
      const q = QUESTIONS[index];
      qText.textContent = q.q;
      choices.innerHTML = '';

      const a = document.createElement('div');
      a.className = 'choice' + (answers[index]==='A' ? ' selected' : '');
      a.innerHTML = q.a;
      a.onclick = () => select('A');

      const b = document.createElement('div');
      b.className = 'choice' + (answers[index]==='B' ? ' selected' : '');
      b.innerHTML = q.b;
      b.onclick = () => select('B');

      choices.appendChild(a);
      choices.appendChild(b);

      const percent = Math.round(((index)/total)*100);
      progressBar.style.width = percent + '%';
    }

    function select(choice) {
      answers[index] = choice;
      render();
    }

    document.getElementById('nextBtn').addEventListener('click', ()=>{
      if (index < total-1) index++;
      else finish();
      render();
    });
    document.getElementById('prevBtn').addEventListener('click', ()=>{
      if (index>0) index--;
      render();
    });
    document.getElementById('skipBtn').addEventListener('click', ()=>{
      answers[index] = null; if (index<total-1) index++; render();
    });

    function finish(){
      // If some answers null, confirm submission
      const confirmSubmit = true; // always submit for demo
      // encode and submit
      document.getElementById('answers_json').value = JSON.stringify(answers.map(x=>x||'SKIP'));
      document.getElementById('submitForm').submit();
    }

    // initial render
    render();

    // If server returned session result, scroll to it
    <?php if ($session_result): ?>
      window.location.hash = '#results';
    <?php endif; ?>
  </script>
</body>
</html>
