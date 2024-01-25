<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\DB;

class SendController extends Controller
{
    public function Mail(Request $request) {
        $callback = array(
            'data' => null,
            'Error' => false,
            'Pesan' => '',
            'Status' => 200
        );


        $dataArray = array(
            'user_id'       => $request->user_id,
            'level_no'      => $request->level_no,
            'entity_cd'     => $request->entity_cd,
            'doc_no'        => $request->doc_no,
            'email_addr'    => $request->email_addr,
            'descs'         => $request->descs,
            'user_name'     => $request->user_name,
            'project_no'    => $request->project_no,
            'temp_no'       => $request->temp_no,
            'files'         => 'E:\xampp\htdocs\sendmailapi\public\pdf\PR_BTID.pdf',
            'prospect_no'   => $request->prospect_no,
            'lot_no_dt'     => $request->lot_no_dt,
            'lot_no_hd'     => $request->lot_no_hd,
            'rt_grp_name'   => $request->rt_grp_name,
            'link'          => 'lottemp',
            'body'          => 'Please Approve '.$request->descs,
        );

        $sendToEmail = strtolower($request->email_addr);
        if(isset($sendToEmail) && !empty($sendToEmail) && filter_var($sendToEmail, FILTER_VALIDATE_EMAIL))
        {
            Mail::to($sendToEmail)
                ->send(new SendMail($dataArray));
            $callback['Error'] = false;
            $callback['Pesan'] = 'sendToEmail';
            echo json_encode($callback);
        }
    }
}