<?php $monthLabel=date('F Y',strtotime($month.'-01')); ?>
<div class="page-heading">
<div><p class="eyebrow">YOUR STUDY OVERVIEW</p><h1>Good work, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Student') ?>.</h1><p class="subtext">Every focused hour moves you closer to your A/L goals.</p></div>
<a class="btn primary" href="index.php?url=study/mark">＋ Mark study time</a>
</div>
<div class="toolbar"><div><h2><?= htmlspecialchars($monthLabel) ?></h2><p class="muted">Daily study hours · All subjects</p></div><form method="get" class="month-form"><input type="hidden" name="url" value="dashboard/index"><input type="month" name="month" value="<?= htmlspecialchars($month) ?>"><button class="btn light">View month</button></form></div>
<section class="panel chart-panel"><div class="panel-top"><div><h3>Study hours by day</h3><p class="muted">Each coloured line represents one subject. Missing days are shown as 0 hours.</p></div><span class="live-dot">● LIVE DATA</span></div>
<?php if(!$subjects): ?><p>No subjects yet. Add subjects from your profile.</p><?php else: ?>
<div class="chart-wrap"><canvas id="studyChart"></canvas></div>
<script type="application/json" id="chartData"><?= json_encode(['labels'=>$labels,'datasets'=>$datasets],JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?></script>
<?php endif; ?></section>
<section class="section-block"><div class="section-title"><div><h2>Monthly target analysis</h2><p class="muted">Actual hours compared with your daily target × days in month.</p></div><a href="index.php?url=archive/index" class="text-link">Previous charts →</a></div>
<div class="analysis-grid">
<?php foreach($analysis as $a): ?>
<article class="analysis-card"><div class="analysis-name"><span class="subject-dot" style="background:<?= htmlspecialchars($a['color']) ?>"></span><strong><?= htmlspecialchars($a['name']) ?></strong><span class="status <?= $a['status'] ?>"><?= $a['status']==='success'?'On target':($a['status']==='warning'?'Almost there':'Needs focus') ?></span></div>
<div class="metric"><strong><?= number_format($a['total'],1) ?></strong><span>/ <?= number_format($a['target'],1) ?> hrs</span></div>
<div class="progress"><span class="<?= $a['status'] ?>" style="width:<?= min(100,$a['percent']) ?>%"></span></div>
<p class="muted small-text"><?= number_format($a['percent'],0) ?>% of monthly target</p></article>
<?php endforeach; ?>
<?php if(!$analysis): ?><div class="empty-state">Add your subjects to start tracking your study progress.</div><?php endif; ?>
</div></section>
