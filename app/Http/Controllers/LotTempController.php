<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Mail\EmailSendApproval;
use App\Mail\SalesDeactiveMail;
use App\Mail\LotTempMail;
use App\Mail\UserEmail;

class LotTempController extends Controller
{
    public function Mail(Request $request) {
        $formattedNumber = number_format($request->land_area, 2, '.', ',');

        $dataArray = array(
            'user_id'       => $request->user_id,
            'level_no'      => $request->level_no,
            'entity_cd'     => $request->entity_cd,
            'doc_no'        => $request->doc_no,
            'email_addr'    => $request->email_addr,
            'descs'         => $request->descs,
            'user_name'     => $request->user_name,
            'sender_name'   => $request->sender_name,
            'project_no'    => $request->project_no,
            'temp_no'       => $request->temp_no,
            'url_link'      => $request->url_link,
            'land_area'     => $formattedNumber,
            'entity_name'   => $request->entity_name,
            'prospect_no'   => $request->prospect_no,
            'lot_no_dt'     => $request->lot_no_dt,
            'lot_no_hd'     => $request->lot_no_hd,
            'rt_grp_name'   => $request->rt_grp_name,
            'link'          => 'lottemp',
        );

        try {
            $emailAddresses = $request->email_addr;
            // Check if email addresses are provided and not empty
            if(isset($emailAddresses) && !empty($emailAddresses) && filter_var($emailAddresses, FILTER_VALIDATE_EMAIL)) {
                $emails = is_array($emailAddresses) ? $emailAddresses : [$emailAddresses];
                foreach ($emails as $email) {
                    Mail::to($email)->send(new LotTempMail($dataArray));
                }
                
                $sentTo = is_array($emailAddresses) ? implode(', ', $emailAddresses) : $emailAddresses;
                Log::channel('sendmail')->info('Email berhasil dikirim ke: ' . $sentTo);
                return "Email berhasil dikirim ke: " . $sentTo;
            } else {
                Log::channel('sendmail')->warning('Tidak ada alamat email yang diberikan.');
                return "Tidak ada alamat email yang diberikan.";
            }
        } catch (\Exception $e) {
            Log::channel('sendmail')->error('Gagal mengirim email: ' . $e->getMessage());
            return "Gagal mengirim email: " . $e->getMessage();
        }
    }

    public function changestatus($entity_cd='', $project_no='', $doc_no='', $status='', $level_no='', $rt_grp_name='', $user_id='')
    {
        $where2 = array(
            'doc_no'        => $doc_no,
            'status'        => array("A",'R', 'C'),
            'entity_cd'     => $entity_cd,
            'level_no'      => $level_no,
            'type'          => 'G',
            'module'        => 'SA',
        );

        $where3 = array(
            'doc_no'        => $doc_no,
            'status'        => 'P',
            'entity_cd'     => $entity_cd,
            'level_no'      => $level_no,
            'type'          => 'G',
            'module'        => 'SA',
        );
        $query = DB::connection('ITDC')
        ->table('mgr.cb_cash_request_appr')
        ->where($where2)
        ->get();

        $query3 = DB::connection('ITDC')
        ->table('mgr.cb_cash_request_appr')
        ->where($where3)
        ->get();
        if(count($query)>0){
            $msg = 'You Have Already Made a Request to Approval Temporary Lot Approval No. '.$doc_no ;
            $notif = 'Restricted !';
            $st  = 'OK';
            $image = "double_approve.png";
            $msg1 = array(
                "Pesan" => $msg,
                "St" => $st,
                "notif" => $notif,
                "image" => $image
            );
            return view("emails.after", $msg1);
        } else {
            if ($status == 'A') {
                $name   = 'Approval';
                $bgcolor = '#40de1d';
                $valuebt  = 'Approve';
            }else if ($status == 'R') {
                $name   = 'Revision';
                $bgcolor = '#f4bd0e';
                $valuebt  = 'Revise';
            } else if ($status == 'C'){
                $name   = 'Cancelation';
                $bgcolor = '#e85347';
                $valuebt  = 'Cancel';
            }
            $data = array(
                'entity_cd'     => $entity_cd, 
                'project_no'    => $project_no, 
                'doc_no'        => $doc_no, 
                'status'        => $status,
                'level_no'      => $level_no, 
                'rt_grp_name'   => $rt_grp_name, 
                'user_id'       => $user_id,
                'name'          => $name,
                'bgcolor'       => $bgcolor,
                'valuebt'       => $valuebt
            );
        }
        return view('emails/lottemp/action', $data);
    }

    public function update(Request $request)
    {
        $new_doc_no = str_replace("-","/",$request->doc_no);
        $entity_cd = $request->entity_cd;
        $project_no = $request->project_no;
        $doc_no = $new_doc_no;
        $status = $request->status;
        $level_no = $request->level_no;
        $rt_grp_name = $request->rt_grp_name;
        $user_id = $request->user_id;
        $remarks = $request->remarks;
        if($status == 'A') {
            $pdo = DB::connection('ITDC')->getPdo();
            $sth = $pdo->prepare("SET NOCOUNT ON; EXEC mgr.xrl_send_mail_approval_sales_lot_temp ?, ?, ?, ?, ?, ?, ?, ?;");
            $sth->bindParam(1, $entity_cd);
            $sth->bindParam(2, $project_no);
            $sth->bindParam(3, $doc_no);
            $sth->bindParam(4, $status);
            $sth->bindParam(5, $level_no);
            $sth->bindParam(6, $rt_grp_name);
            $sth->bindParam(7, $user_id);
            $sth->bindParam(8, $remarks);
            $sth->execute();
            if ($sth == true) {
                $msg = "You Have Successfully Approved the Temporary Lot Approval No. ".$doc_no;
                $notif = 'Approved !';
                $st = 'OK';
                $image = "approved.png";
            } else {
                $msg = "You Failed to Approve the Temporary Lot Approval No ".$doc_no;
                $notif = 'Fail to Approve !';
                $st = 'OK';
                $image = "reject.png";
            }
        } else if($status == 'R'){
            $pdo = DB::connection('ITDC')->getPdo();
            $sth = $pdo->prepare("SET NOCOUNT ON; EXEC mgr.xrl_send_mail_approval_sales_lot_temp ?, ?, ?, ?, ?, ?, ?, ?;");
            $sth->bindParam(1, $entity_cd);
            $sth->bindParam(2, $project_no);
            $sth->bindParam(3, $doc_no);
            $sth->bindParam(4, $status);
            $sth->bindParam(5, $level_no);
            $sth->bindParam(6, $rt_grp_name);
            $sth->bindParam(7, $user_id);
            $sth->bindParam(8, $remarks);
            $sth->execute();
            if ($sth == true) {
                $msg = "You Have Successfully Made a Revise Request on Temporary Lot Approval No. ".$doc_no;
                $notif = 'Revised !';
                $st = 'OK';
                $image = "revise.png";
            } else {
                $msg = "You Failed to Make a Revise Request on Temporary Lot Approval No. ".$doc_no;
                $notif = 'Fail to Revised !';
                $st = 'OK';
                $image = "reject.png";
            }
        } else {
            $pdo = DB::connection('ITDC')->getPdo();
            $sth = $pdo->prepare("SET NOCOUNT ON; EXEC mgr.xrl_send_mail_approval_sales_lot_temp ?, ?, ?, ?, ?, ?, ?, ?;");
            $sth->bindParam(1, $entity_cd);
            $sth->bindParam(2, $project_no);
            $sth->bindParam(3, $doc_no);
            $sth->bindParam(4, $status);
            $sth->bindParam(5, $level_no);
            $sth->bindParam(6, $rt_grp_name);
            $sth->bindParam(7, $user_id);
            $sth->bindParam(8, $remarks);
            $sth->execute();
            if ($sth == true) {
                $msg = "You Have Successfully Cancelled the Temporary Lot Approval No. ".$doc_no;
                $notif = 'Cancelled !';
                $st = 'OK';
                $image = "reject.png";
            } else {
                $msg = "You Failed to Cancel the Temporary Lot Approval No. ".$doc_no;
                $notif = 'Fail to Cancelled !';
                $st = 'OK';
                $image = "reject.png";
            }
        }
        $msg1 = array(
            "Pesan" => $msg,
            "St" => $st,
            "image" => $image,
            "notif" => $notif
        );
    return view("emails.after", $msg1);
    }
}