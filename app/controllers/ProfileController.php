<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Subject.php';

class ProfileController extends Controller {

    public function index(): void {

        $this->requireLogin();

        $uid = (int)$_SESSION['user_id'];

        $message = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifyCsrf();

            // Update subject target hours
            if (($_POST['action'] ?? '') === 'update_subject_target') {

                $subjectId = (int)($_POST['subject_id'] ?? 0);
                $target = (float)($_POST['target_hours'] ?? 0);

                $subject = Subject::findOwned($subjectId, $uid);

                if (!$subject || $target < 0.25 || $target > 24) {
                    $error = 'Invalid subject or target hours.';
                } else {
                    Subject::updateTarget($subjectId, $uid, $target);
                    $message = 'Subject target time updated successfully!';
                }

            } else {

                // Update profile details
                $name = trim($_POST['full_name'] ?? '');
                $email = trim($_POST['email'] ?? '');

                if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = 'Enter a valid name and email.';
                } else {
                    try {
                        User::update($uid, $name, $email);
                        $_SESSION['user_name'] = $name;

                        if (!empty($_POST['new_password'])) {
                            if (strlen($_POST['new_password']) < 8) {
                                $error = 'Password must contain at least 8 characters.';
                            } else {
                                User::updatePassword($uid, $_POST['new_password']);
                            }
                        }

                        if (!$error) {
                            $message = 'Profile updated successfully!';
                        }

                    } catch (Throwable $e) {
                        $error = 'Email address may already be in use.';
                    }
                }
            }
        }

        $user = User::find($uid);
        $subjects = Subject::all($uid);

        $this->view('profile/index', [
            'user' => $user,
            'subjects' => $subjects,
            'message' => $message,
            'error' => $error
        ]);
    }
}

