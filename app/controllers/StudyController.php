<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/StudyLog.php';
class StudyController extends Controller {
    public function mark(): void {
        $this->requireLogin(); $uid=(int)$_SESSION['user_id']; $subjects=Subject::all($uid); $message='';
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $this->verifyCsrf();
            $sid=(int)($_POST['subject_id'] ?? 0); $date=$_POST['study_date'] ?? '';
            $hours=(float)($_POST['hours'] ?? -1); $notes=trim($_POST['notes'] ?? '');
            $subject=Subject::findOwned($sid,$uid);
            $validDate=DateTime::createFromFormat('Y-m-d',$date);
            if (!$subject || !$validDate || $validDate->format('Y-m-d')!==$date || $date>date('Y-m-d') || $hours<0 || $hours>24) {
                $message='Please enter a valid subject, date (not in the future), and time between 0 and 24 hours.';
            } else {
                StudyLog::save($uid,$sid,$date,$hours,$notes); $message='Study time saved. Your chart has been updated.';
            }
        }
        $this->view('study/mark',['subjects'=>$subjects,'message'=>$message]);
    }
}

