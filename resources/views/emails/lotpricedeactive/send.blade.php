<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="application/pdf">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,600" rel="stylesheet" type="text/css">
    <style>
        html, body {
            width: 100%;
        }
        table {
            margin: 50 auto;
        }
    </style>
    
</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #ffffff;">
	<div style="width: 100%; background-color: #e6f0eb; text-align: center;">
        <table width="80%" border="0" cellpadding="0" cellspacing="0" bgcolor="#e6f0eb" style="margin-left: auto;margin-right: auto;" >
            <tr>
                <td style="padding: 40px 0;">
                    <table style="width:100%;max-width:600px;margin:0 auto;">
                        @include('template.header')
                    </table>
                    <table style="margin-left:200px;width:100%;max-width:800px;margin:0 auto;background-color:#ffffff;">
                        <tbody>
                            <tr>
                                <td style="text-align:center;padding: 0px 30px 0px 20px">
                                <h5 style="text-align:left;color: #526484; font-size: 20px; font-weight: 400; line-height: 28px;">Dear Mr./Mrs. {{ $data['user_name'] }}</h5>
                                    <p style="text-align:left;color: #526484; font-size: 16px;">Please Approve Deactive Lot Price with details :</p>
                                    <table cellpadding="0" cellspacing="0" style="text-align:left;width:100%;max-width:800px;margin:0 auto;background-color:#ffffff; ">
                                        <tr>
                                            <td>Deactive No. </td>
                                            <td> : </td>
                                            <td> {{ $data['doc_no'] }} </td>
                                        </tr>
                                        <tr>
                                            <td>Payment</td>
                                            <td> : </td>
                                            <td> {{ $data['ref_no'] }} </td>
                                        </tr>
                                        <tr>
                                            <td>Lot No. </td>
                                            <td> : </td>
                                            <td> {{ $data['lot_no'] }} </td>
                                        </tr>
                                        <tr>
                                            <td>Reason</td>
                                            <td> : </td>
                                            <td> {{ $data['plan_descs'] }} </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <p style="text-align:left;margin-bottom: 15px; color: #000000; font-size: 16px;">
                                        <b>Thank you,</b><br>
                                        {{ $data['sender_name'] }}
                                    </p>
                                    <br>
                                    <a href="{{ url('api') }}/{{ $data['link'] }}/A/{{ $data['entity_cd'] }}/{{ $data['doc_no'] }}/{{ $data['level_no'] }}/{{ $data['payment_code'] }}/{{ $data['lot_no'] }}" style="background-color:#1ee0ac;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0px 40px;margin: 10px">Approve</a>
                                    <a href="{{ url('api') }}/{{ $data['link'] }}/R/{{ $data['entity_cd'] }}/{{ $data['doc_no'] }}/{{ $data['level_no'] }}/{{ $data['payment_code'] }}/{{ $data['lot_no'] }}" style="background-color:#f4bd0e;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0px 40px;margin: 10px">Revise</a>
                                    <a href="{{ url('api') }}/{{ $data['link'] }}/C/{{ $data['entity_cd'] }}/{{ $data['doc_no'] }}/{{ $data['level_no'] }}/{{ $data['payment_code'] }}/{{ $data['lot_no'] }}" style="background-color:#e85347;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0px 40px;margin: 10px">Cancel</a>
                                    <br>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width:100%;max-width:620px;margin:0 auto;">
                        @include('template.footer')
                    </table>
                </td>
            </tr>
        </table>
        </div>
</body>
</html>