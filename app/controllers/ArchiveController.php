<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/StudyLog.php';
class ArchiveController extends Controller {
    public function index(): void {
        $this->requireLogin();
        $months=[];
        $q=Database::connect()->prepare("SELECT DATE_FORMAT(study_date,'%Y-%m') month_key, COUNT(*) entries FROM study_logs WHERE user_id=? GROUP BY month_key ORDER BY month_key DESC");
        $q->execute([$_SESSION['user_id']]); $months=$q->fetchAll();
        $selected=$_GET['month'] ?? ($months[0]['month_key'] ?? date('Y-m'));
        if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])$/',$selected)) $selected=date('Y-m');
        $subjects=Subject::all((int)$_SESSION['user_id']); $logs=StudyLog::month((int)$_SESSION['user_id'],$selected);
        $days=(int)date('t',strtotime($selected.'-01')); $labels=range(1,$days); $datasets=[];
        foreach($subjects as $s) {
            $values=array_fill(0,$days,0);
            foreach($logs as $log) if((int)$log['subject_id']===(int)$s['id']) $values[(int)date('j',strtotime($log['study_date']))-1]=(float)$log['hours'];
            $datasets[]=['label'=>$s['subject_name'],'data'=>$values,'borderColor'=>$s['chart_color'],'backgroundColor'=>$s['chart_color'],'tension'=>0.25,'pointRadius'=>3,'borderWidth'=>3];
        }
        $this->view('archive/index',['months'=>$months,'selected'=>$selected,'labels'=>$labels,'datasets'=>$datasets]);
    }
}
