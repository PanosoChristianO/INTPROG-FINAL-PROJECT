<?php
$team = [
    "Jyke"      => ["name" => "Jyke Rafael A. Deala",       "role" => "Leader", "course" => "BS Information Technology", "age" => 20, "image" => "deala.jpg"],
    "Pocio"     => ["name" => "Christer Pocio",             "role" => "Member", "course" => "BS Information Technology", "age" => 21, "image" => "pocio.jpg"],
    "James"     => ["name" => "James Gonzalo",              "role" => "Member", "course" => "BS Information Technology", "age" => 21, "image" => "gonzalo.jpg"],
    "Christian" => ["name" => "Christian Pañoso",           "role" => "Member", "course" => "BS Information Technology", "age" => 22, "image" => "panoso.jpg"],
    "Jayrome"   => ["name" => "Jayrome Mondido",            "role" => "Member", "course" => "BS Information Technology", "age" => 21, "image" => "mondido.jpg"],
    "Dianah"    => ["name" => "Dianah Romasanta",           "role" => "Member", "course" => "BS Information Technology", "age" => 20, "image" => "romasanta.jpg"],
];

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

// Exercise 4 (POST) and Exercise 3 (GET): which member should be shown?
$member = "all";
$via = "";
if (isset($_POST['member'])) { $member = $_POST['member']; $via = "POST"; }
elseif (isset($_GET['member'])) { $member = $_GET['member']; $via = "GET"; }
if (!is_string($member)) { $member = "all"; }

if ($member === "all")            { $show = $team; }
elseif (isset($team[$member]))    { $show = [$member => $team[$member]]; }
else                              { $show = []; }

function isOn($key, $via, $member, $method) { return ($via === $method && $member === $key) ? 'on' : ''; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Team Profile | Group 1</title>
<style>
:root{--navy:#2c3e50;--navy2:#34495e;--accent:#1abc9c;--bg:#f4f4f4;--card:#fff;--txt:#333;--line:#d5dbe0}
@media (prefers-color-scheme:dark){:root{--bg:#141b22;--card:#1e2933;--txt:#e8edf2;--line:#34424f}}
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,Helvetica,sans-serif}
body{background:var(--bg);color:var(--txt);min-height:100vh}
header{background:linear-gradient(135deg,var(--navy),#1b2a38);color:#fff;text-align:center;padding:42px 20px 70px}
header h1{font-size:clamp(1.9rem,6vw,2.8rem);margin-bottom:8px}
header p{opacity:.85}
.container{width:92%;max-width:1200px;margin:-44px auto 30px}
.panel{background:var(--card);border-radius:14px;box-shadow:0 4px 14px rgba(0,0,0,.18);padding:22px;display:grid;gap:22px}
.panel h3{font-size:1rem;margin-bottom:10px;color:var(--navy)}
@media (prefers-color-scheme:dark){.panel h3{color:#bfeee2}}
.panel small{display:block;opacity:.65;margin-bottom:8px;font-size:.8rem}
.tools{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:22px}
#searchBox{width:100%;padding:13px 18px;border:1px solid var(--line);border-radius:25px;font-size:1rem;outline:none;background:var(--bg);color:var(--txt)}
#searchBox:focus{border-color:var(--accent)}
.btns{display:flex;flex-wrap:wrap;gap:6px}
.btns a,.btns button{padding:9px 14px;background:var(--navy2);color:#fff;text-decoration:none;border:0;border-radius:6px;cursor:pointer;font-size:.9rem}
.btns a:hover,.btns button:hover{background:#1a252f}
.btns .on{background:var(--accent)}
.status{text-align:center;margin:22px 0 4px;font-weight:bold}
.team{display:flex;flex-wrap:wrap;justify-content:center;gap:25px;margin-top:18px}
.card{width:280px;background:var(--card);border-radius:12px;overflow:hidden;box-shadow:0 4px 8px rgba(0,0,0,.2);transition:.3s}
.card:hover{transform:translateY(-7px);box-shadow:0 8px 16px rgba(0,0,0,.25)}
.card img{width:100%;height:300px;object-fit:cover;display:block}
.info{padding:20px}
.info h2{color:var(--navy);margin-bottom:10px;font-size:1.3rem}
@media (prefers-color-scheme:dark){.info h2,#modalName{color:#bfeee2}}
.info p{margin:7px 0;font-size:.95rem}
.role{display:inline-block;background:var(--navy);color:#fff;padding:5px 10px;border-radius:15px;font-size:.8rem;margin-bottom:10px}
.role.lead{background:var(--accent)}
.view-btn{width:100%;margin-top:14px;padding:10px;border:0;border-radius:6px;background:var(--navy);color:#fff;cursor:pointer;font-size:.9rem}
.view-btn:hover{background:#1a252f}
.msg{text-align:center;width:100%;font-size:1.1rem;opacity:.7;margin-top:20px}
footer{text-align:center;background:var(--navy);color:#fff;padding:18px;margin-top:40px}
.modal{display:none;position:fixed;inset:0;z-index:1000;background:rgba(0,0,0,.65);justify-content:center;align-items:center;padding:20px}
.modal.open{display:flex}
.modal-content{background:var(--card);color:var(--txt);width:100%;max-width:450px;border-radius:12px;padding:30px;text-align:center;position:relative;animation:pop .3s ease}
@keyframes pop{from{transform:scale(.8);opacity:0}to{transform:scale(1);opacity:1}}
.close{position:absolute;right:14px;top:8px;font-size:2rem;cursor:pointer;color:inherit;opacity:.6;background:none;border:0}
.close:hover{opacity:1}
#modalImage{width:150px;height:150px;border-radius:50%;object-fit:cover;margin-bottom:15px}
#modalName{color:var(--navy);margin-bottom:15px}
.modal-content p{margin:8px 0}
@media (max-width:600px){.card{width:100%;max-width:330px}}
</style>
</head>
<body>

<header>
  <h1>Team Profile</h1>
  <p>Group 1 | INTPROG-Integrative Programming &amp; Technologies 1 </p>
</header>

<div class="container">
  <div class="panel">
    <div>
      <h3>Search team member</h3>
      <input type="text" id="searchBox" placeholder="Search team member..." autocomplete="off">
    </div>
    <div class="tools">
      <div>
        <h3>View team member (GET method)</h3>
        <div class="btns">
          <a href="index.php?member=all" class="<?= isOn('all', $via, $member, 'GET') ?>">All Members</a>
          <?php foreach ($team as $key => $p): ?>
            <a href="index.php?member=<?= urlencode($key) ?>" class="<?= isOn($key, $via, $member, 'GET') ?>"><?= e($key) ?></a>
          <?php endforeach; ?>
        </div>
      </div>
      <div>
        <h3>View team member (POST method)</h3>
        <form method="POST" action="index.php" class="btns">
          <button type="submit" name="member" value="all" class="<?= isOn('all', $via, $member, 'POST') ?>">All Members</button>
          <?php foreach ($team as $key => $p): ?>
            <button type="submit" name="member" value="<?= e($key) ?>" class="<?= isOn($key, $via, $member, 'POST') ?>"><?= e($key) ?></button>
          <?php endforeach; ?>
        </form>
      </div>
    </div>
  </div>

  <p class="status">
    <?php if ($via === ""): ?>Showing all members
    <?php elseif (!$show): ?>Member not found
    <?php else: ?>Showing: <?= $member === "all" ? "All members" : e($team[$member]['name']) ?> (<?= $via ?> method)
    <?php endif; ?>
  </p>

  <div class="team" id="teamContainer">
    <?php foreach ($show as $p): ?>
      <div class="card" data-name="<?= e(strtolower($p['name'])) ?>">
        <img src="images/<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>">
        <div class="info">
          <span class="role <?= $p['role'] === 'Leader' ? 'lead' : '' ?>"><?= e($p['role']) ?></span>
          <h2><?= e($p['name']) ?></h2>
          <p><strong>Course:</strong> <?= e($p['course']) ?></p>
          <p><strong>Age:</strong> <?= e($p['age']) ?></p>
          <button class="view-btn" type="button"
                  data-name="<?= e($p['name']) ?>" data-role="<?= e($p['role']) ?>"
                  data-course="<?= e($p['course']) ?>" data-age="<?= e($p['age']) ?>"
                  data-image="images/<?= e($p['image']) ?>">View Profile</button>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if (!$show): ?><h2 class="msg">Member not found.</h2><?php endif; ?>
    <p class="msg" id="noResult" style="display:none">No team member found.</p>
  </div>
</div>

<div class="modal" id="profileModal" role="dialog" aria-modal="true" aria-labelledby="modalName">
  <div class="modal-content">
    <button class="close" type="button" id="closeBtn" aria-label="Close">&times;</button>
    <img id="modalImage" src="" alt="Profile picture">
    <h2 id="modalName"></h2>
    <p><strong>Role:</strong> <span id="modalRole"></span></p>
    <p><strong>Course:</strong> <span id="modalCourse"></span></p>
    <p><strong>Age:</strong> <span id="modalAge"></span></p>
  </div>
</div>

<footer>Group 1 | INTPROG-Integrative Programming &amp; Technologies 1</footer>

<script>
// Exercise 2: live search
const cards = document.querySelectorAll('.card');
document.getElementById('searchBox').addEventListener('input', function () {
  const q = this.value.toLowerCase().trim();
  let found = false;
  cards.forEach(c => {
    const match = c.dataset.name.includes(q);
    c.style.display = match ? '' : 'none';
    if (match) found = true;
  });
  document.getElementById('noResult').style.display = (!found && cards.length) ? 'block' : 'none';
});

// Exercise 2: View Profile pop-up
const modal = document.getElementById('profileModal');
document.querySelectorAll('.view-btn').forEach(b => b.addEventListener('click', () => {
  document.getElementById('modalName').textContent = b.dataset.name;
  document.getElementById('modalRole').textContent = b.dataset.role;
  document.getElementById('modalCourse').textContent = b.dataset.course;
  document.getElementById('modalAge').textContent = b.dataset.age;
  document.getElementById('modalImage').src = b.dataset.image;
  modal.classList.add('open');
  document.getElementById('closeBtn').focus();
}));
const closeModal = () => modal.classList.remove('open');
document.getElementById('closeBtn').addEventListener('click', closeModal);
modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
</script>
</body>
</html>
