<div class="page-heading">
    <div>
        <p class="eyebrow">ACCOUNT SETTINGS</p>
        <h1>Your profile.</h1>
        <p class="subtext">Manage your account and subject targets.</p>
    </div>
</div>

<div class="form-panel">

    <?php if ($message): ?>
        <div class="alert success">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <h3>Personal Information</h3>

    <form method="post" class="form-stack">

        <?= $this->csrfField() ?>

        <input type="hidden" name="action" value="update_profile">

        <label>
            Full name
            <input
                type="text"
                name="full_name"
                value="<?= htmlspecialchars($user['full_name']) ?>"
                required
            >
        </label>

        <label>
            Email address
            <input
                type="email"
                name="email"
                value="<?= htmlspecialchars($user['email']) ?>"
                required
            >
        </label>

        <label>
            New password
            <input
                type="password"
                name="new_password"
                minlength="8"
                placeholder="Leave blank to keep current password"
            >
        </label>

        <button class="btn primary">Save Profile</button>

    </form>

    <div class="divider"></div>

    <h3>My Subject Daily Targets</h3>

    <p class="muted">
        Change the number of hours you want to study each subject per day.
    </p>

    <?php foreach ($subjects as $subject): ?>

        <form method="post" class="form-stack"
              style="margin-top:20px; padding-bottom:20px; border-bottom:1px solid #eee;">

            <?= $this->csrfField() ?>

            <input type="hidden" name="action"
                   value="update_subject_target">

            <input type="hidden" name="subject_id"
                   value="<?= $subject['id'] ?>">

            <label>
                Subject Name

                <input type="text"
                       value="<?= htmlspecialchars($subject['subject_name']) ?>"
                       disabled>
            </label>

            <label>
                Daily Target Hours

                <input
                    type="number"
                    name="target_hours"
                    value="<?= htmlspecialchars($subject['target_hours']) ?>"
                    min="0.25"
                    max="24"
                    step="0.25"
                    required
                >
            </label>

            <button type="submit" class="btn primary">
                Update Target Time
            </button>

        </form>

    <?php endforeach; ?>

</div>
