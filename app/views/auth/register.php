<section class="auth-card register-card">
<div class="auth-brand"><span class="brand-mark">A</span><span>SL A/L STUDY TRACKER</span></div>
<p class="eyebrow">GET STARTED</p><h1>Create your<br><span class="gradient-text">study account.</span></h1>
<p class="subtext">Add your subjects and set a daily study target for each one.</p>
<?php if(!empty($error)): ?><div class="alert danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" class="form-stack" id="registerForm">
<?= $this->csrfField() ?>
<div class="two-col">
<label>Full name<input name="full_name" placeholder="Your name" required></label>
<label>Email address<input type="email" name="email" placeholder="you@example.com" required></label>
</div>
<label>Create password<input type="password" name="password" minlength="8" placeholder="At least 8 characters" required></label>
<div class="section-heading"><div><h3>Your A/L subjects</h3><p>Daily target hours for each subject</p></div><button type="button" class="btn light small" id="addSubject">+ Add subject</button></div>
<div id="subjectRows">
<div class="subject-row"><input name="subject_name[]" placeholder="e.g. Combined Mathematics" required><input type="number" name="target_hours[]" min="0.25" max="24" step="0.25" value="2" required aria-label="Daily target hours"><span>hrs/day</span></div>
<div class="subject-row"><input name="subject_name[]" placeholder="e.g. Physics" required><input type="number" name="target_hours[]" min="0.25" max="24" step="0.25" value="2" required aria-label="Daily target hours"><span>hrs/day</span></div>
</div>
<button class="btn primary full">Create account</button>
</form>
<p class="auth-switch">Already registered? <a href="index.php?url=auth/login">Sign in</a></p>
</section>
