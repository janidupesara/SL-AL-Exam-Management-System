<div class="page-heading"><div><p class="eyebrow">YOUR STUDY HISTORY</p><h1>Previous monthly charts.</h1><p class="subtext">Choose a month to revisit your daily study pattern.</p></div></div>
<div class="archive-layout"><aside class="panel month-list"><h3>Months recorded</h3>
<?php if(!$months): ?><p class="muted">No study records yet.</p><?php endif; ?>
<?php foreach($months as $m): ?><a class="<?= $selected===$m['month_key']?'selected':'' ?>" href="index.php?url=archive/index&month=<?= htmlspecialchars($m['month_key']) ?>"><span><?= date('F Y',strtotime($m['month_key'].'-01')) ?></span><small><?= (int)$m['entries'] ?> entries</small></a><?php endforeach; ?>
</aside><section class="panel archive-chart"><div class="panel-top"><div><p class="eyebrow">MONTHLY REPORT</p><h2><?= date('F Y',strtotime($selected.'-01')) ?></h2></div><button class="btn primary" id="downloadChart">↓ Save chart image</button></div>
<?php if(!$months): ?><div class="empty-state">Your saved monthly charts will appear here after you start recording study time.</div><?php else: ?>
<div class="chart-wrap"><canvas id="studyChart"></canvas></div>
<script type="application/json" id="chartData"><?= json_encode(['labels'=>$labels,'datasets'=>$datasets],JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?></script>
<p class="muted small-text">Use “Save chart image” to download a PNG to your computer. You can also print this page using your browser's Print option.</p>
<?php endif; ?></section></div>
