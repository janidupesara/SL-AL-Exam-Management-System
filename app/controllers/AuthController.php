<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Subject.php';
class AuthController extends Controller {
    public function login(): void {
        if (!empty($_SESSION['user_id'])) $this->redirect('dashboard/index');
        $error = '';
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $this->verifyCsrf();
            $user=User::findByEmail($_POST['email'] ?? '');
            if ($user && password_verify($_POST['password'] ?? '', $user['password_hash'])) {
                session_regenerate_id(true); $_SESSION['user_id']=$user['id'];
                $_SESSION['user_name']=$user['full_name']; $this->redirect('dashboard/index');
            }
            $error='Incorrect email or password.';
        }
        $this->view('auth/login',['error'=>$error]);
    }
    public function register(): void {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $this->verifyCsrf();
            $name=trim($_POST['full_name'] ?? ''); $email=trim($_POST['email'] ?? '');
            $password=$_POST['password'] ?? ''; $names=$_POST['subject_name'] ?? [];
            $targets=$_POST['target_hours'] ?? [];
            $colors=['#ff3030','#0754b8','#f4c542','#13a58a','#9b59b6','#f07836'];
            if ($name==='' || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($password)<8 || count($names)<1) {
                $error='Enter your name, a valid email, a password of at least 8 characters, and at least one subject.';
                $this->view('auth/register',['error'=>$error]); return;
            }
            if (User::findByEmail($email)) {
                $this->view('auth/register',['error'=>'That email is already registered.']); return;
            }
            try {
                $id=User::create($name,$email,$password);
                foreach ($names as $i=>$subject) {
                    $subject=trim($subject); $target=(float)($targets[$i] ?? 1);
                    if ($subject!=='' && $target>0 && $target<=24) Subject::create($id,$subject,$target,$colors[$i%count($colors)]);
                }
                session_regenerate_id(true); $_SESSION['user_id']=$id; $_SESSION['user_name']=$name;
                $this->redirect('dashboard/index');
            } catch (Throwable $e) {
                $this->view('auth/register',['error'=>'Could not complete registration. Check that each subject name is unique.']);
            }
            return;
        }
        $this->view('auth/register',['error'=>'']);
    }
    public function logout(): void {
        $_SESSION=[]; session_destroy(); header('Location: index.php?url=auth/login'); exit;
    }
}

