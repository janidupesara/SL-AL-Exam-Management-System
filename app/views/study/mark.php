<div class="page-heading"><div><p class="eyebrow">DAILY STUDY LOG</p><h1>Record your effort.</h1><p class="subtext">Enter the time you spent studying a subject. Your chart updates automatically.</p></div></div>
<div class="form-panel">
<?php if($message): ?><div class="alert success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php if(!$subjects): ?><div class="alert warning">You have no subjects. Please register subjects first.</div><?php else: ?>
<form method="post" class="form-stack">
<?= $this->csrfField() ?>
<label>Subject<select name="subject_id" required><?php foreach($subjects as $s): ?><option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['subject_name']) ?> · target <?= number_format($s['target_hours'],2) ?> hrs/day</option><?php endforeach; ?></select></label>
<div class="two-col"><label>Study date<input type="date" name="study_date" max="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" required></label><label>Time studied (hours)<input type="number" name="hours" min="0" max="24" step="0.25" placeholder="e.g. 1.5" required><small>Use 0 if you did not study this subject on that date.</small></label></div>
<label>Notes (optional)<textarea name="notes" rows="3" placeholder="What did you study today?"></textarea></label>
<button class="btn primary">Save study time</button>
</form><?php endif; ?>
</div>
<div class="tip-card"><span class="tip-icon">✦</span><div><strong>Keep your records consistent</strong><p>Enter one record per subject per day. Saving that subject and date again will update the existing record.</p></div></div>
