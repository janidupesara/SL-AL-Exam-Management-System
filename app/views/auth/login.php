<section class="auth-card">
<div class="auth-brand"><span class="brand-mark">A</span><span>SL A/L STUDY TRACKER</span></div>
<p class="eyebrow">WELCOME BACK</p><h1>Sign in to your<br><span class="gradient-text">study space.</span></h1>
<p class="subtext">Track your effort, understand your progress, and stay on target.</p>
<?php if(!empty($error)): ?><div class="alert danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" class="form-stack">
<?= $this->csrfField() ?>
<label>Email address<input type="email" name="email" placeholder="you@example.com" required></label>
<label>Password<input type="password" name="password" placeholder="Enter your password" required></label>
<button class="btn primary full">Sign in</button>
</form>
<p class="auth-switch">New to the tracker? <a href="index.php?url=auth/register">Create an account</a></p>
</section>
