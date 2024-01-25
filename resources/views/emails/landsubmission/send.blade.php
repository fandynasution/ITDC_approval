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
        
    </style>
    
</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #ffffff;">
	<div style="width: 100%; background-color: #e6f0eb; text-align: center;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#e6f0eb" style="margin-left: auto;margin-right: auto;" >
            <tr>
                <td style="padding: 40px 0;">
                    <table style="width:100%;max-width:600px;margin:0 auto;">
                        @include('template.header')
                    </table>
                    <table style="margin-left:200px;width:100%;max-width:840px;margin:0 auto;background-color:#ffffff;">
                        <tbody>
                            <tr>
                                <td style="text-align:center;padding: 0px 30px 0px 20px">
                                    <h5 style="margin-bottom: 24px; color: #526484; font-size: 20px; font-weight: 400; line-height: 28px;">Untuk Bapak/Ibu {{ $data['user_name'] }}</h5>
                                    <p style="text-align:left;color: #526484; font-size: 16px;">Tolong berikan persetujuan untuk Pengajuan Pembayaran dengan detail :</p>
                                    <table cellpadding="0" cellspacing="0" style="text-align:left;width:100%;max-width:800px;margin:0 auto;background-color:#ffffff; ">
                                    <tr>
                                        <th style="border: 1px solid #dddddd;text-align: center;padding: 8px;">Nomor Dokumen</th>
                                        <th style="border: 1px solid #dddddd;text-align: center;padding: 8px;">Nama Pemilik</th>
                                        <th style="border: 1px solid #dddddd;text-align: center;padding: 8px;">Rincian Pengajuan</th>
                                        <th style="border: 1px solid #dddddd;text-align: center;padding: 8px;">NOP</th>
                                        <th style="border: 1px solid #dddddd;text-align: center;padding: 8px;">Periode SPH</th>
                                        <th style="border: 1px solid #dddddd;text-align: center;padding: 8px;">Nominal Pengajuan</th>
                                    </tr>
                                    @if(isset($data['type']) && is_array($data['type']) && count($data['type']) > 0)
                                        <!-- Find and display the first merge -->
                                        @if(isset($data['type'][0]))
                                            <tr>
                                                <td style="border: 1px solid #dddddd;padding: 8px;">{{ $data['doc_no'] }}</td>
                                                <td style="border: 1px solid #dddddd;padding: 8px;">{{ $data['owner'][0] }}</td>
                                                <td style="border: 1px solid #dddddd;padding: 8px;">{{ $data['type'][0] }}</td>
                                                <td style="border: 1px solid #dddddd;padding: 8px;">{{ $data['nop_no'][0] }}</td>
                                                <td style="border: 1px solid #dddddd;padding: 8px;">{{ $data['sph_trx_no'][0] }}</td>
                                                <td style="border: 1px solid #dddddd;padding: 8px;text-align: right;">Rp. {{ $data['request_amt'][0] }}</td>
                                            </tr>  
                                        @endif

                                        <!-- Display other merges -->
                                        @for($i = 1; $i < count($data['type']); $i++)
                                            @if(isset($data['owner'][$i]))
                                                <tr>
                                                    <td style="border: 1px solid #dddddd;padding: 8px;">{{ $data['doc_no'] }}</td>
                                                    <td style="border: 1px solid #dddddd;padding: 8px;">{{ $data['owner'][$i] }}</td>
                                                    <td style="border: 1px solid #dddddd;padding: 8px;">{{ $data['type'][$i] }}</td>
                                                    <td style="border: 1px solid #dddddd;padding: 8px;">{{ $data['nop_no'][$i] }}</td>
                                                    <td style="border: 1px solid #dddddd;padding: 8px;">{{ $data['sph_trx_no'][$i] }}</td>
                                                    <td style="border: 1px solid #dddddd;padding: 8px;text-align: right;">Rp. {{ $data['request_amt'][$i] }}</td>
                                                </tr>
                                            @endif
                                        @endfor
                                    @endif
                                    </table>
                                    <br>
                                    <p style="text-align:left;margin-bottom: 15px; color: #000000; font-size: 16px;">
                                        <b>Thank you,</b><br>
                                        {{ $data['sender_name'] }}
                                    </p>
                                    <br>
                                    <a href="{{ url('api') }}/{{ $data['link'] }}/A/{{ $data['entity_cd'] }}/{{ $data['doc_no'] }}/{{ $data['level_no'] }}" style="background-color:#1ee0ac;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0px 40px;margin: 10px">Approve</a>
                                    <a href="{{ url('api') }}/{{ $data['link'] }}/R/{{ $data['entity_cd'] }}/{{ $data['doc_no'] }}/{{ $data['level_no'] }}" style="background-color:#f4bd0e;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0px 40px;margin: 10px">Revise</a>
                                    <a href="{{ url('api') }}/{{ $data['link'] }}/C/{{ $data['entity_cd'] }}/{{ $data['doc_no'] }}/{{ $data['level_no'] }}" style="background-color:#e85347;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0px 40px;margin: 10px">Cancel</a>
                                    <br>
                                    @php
                                        $hasAttachment = false;
                                    @endphp

                                    @foreach($data['url_file'] as $key => $url_file)
                                        @if($url_file !== '' && $data['file_name'][$key] !== '' && $url_file !== 'EMPTY' && $data['file_name'][$key] !== 'EMPTY')
                                            @if(!$hasAttachment)
                                                @php
                                                    $hasAttachment = true;
                                                @endphp
                                                <p style="text-align:left; margin-bottom: 15px; color: #000000; font-size: 16px;">
                                                    <b style="font-style:italic;">To view the attachment, please click the links below:</b><br>
                                            @endif
                                            <a href="{{ $url_file }}" target="_blank">{{ $data['file_name'][$key] }}</a><br>
                                        @endif
                                    @endforeach

                                    @if($hasAttachment)
                                        </p>
                                    @endif
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