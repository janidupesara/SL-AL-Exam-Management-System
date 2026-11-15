
<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/StudyLog.php';
class DashboardController extends Controller {
    public function index(): void {
        $this->requireLogin();
        $month=$_GET['month'] ?? date('Y-m');
        if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])$/',$month)) $month=date('Y-m');
        $subjects=Subject::all((int)$_SESSION['user_id']);
        $logs=StudyLog::month((int)$_SESSION['user_id'],$month);
        $days=(int)date('t',strtotime($month.'-01'));
        $labels=range(1,$days); $datasets=[];
        foreach ($subjects as $s) {
            $values=array_fill(0,$days,0);
            foreach ($logs as $log) if ((int)$log['subject_id']===(int)$s['id']) $values[(int)date('j',strtotime($log['study_date']))-1]=(float)$log['hours'];
            $datasets[]=['label'=>$s['subject_name'],'data'=>$values,'borderColor'=>$s['chart_color'],'backgroundColor'=>$s['chart_color'],'tension'=>0.25,'pointRadius'=>3,'borderWidth'=>3];
        }
        $analysis=[];
        foreach ($subjects as $s) {
            $total=0; foreach ($logs as $log) if ((int)$log['subject_id']===(int)$s['id']) $total+=(float)$log['hours'];
            $target=(float)$s['target_hours']*$days;
            $pct=$target>0?($total/$target*100):0;
            $status=$pct>=100?'success':($pct>=70?'warning':'danger');
            $analysis[]=['name'=>$s['subject_name'],'total'=>$total,'target'=>$target,'percent'=>$pct,'status'=>$status,'color'=>$s['chart_color']];
        }
        $this->view('dashboard/index',['subjects'=>$subjects,'month'=>$month,'labels'=>$labels,'datasets'=>$datasets,'analysis'=>$analysis]);
    }
}
