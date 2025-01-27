<?php

use App\Lib\GoogleAuthenticator;
use App\Lib\SendSms;
use App\Models\Airport;
use App\Models\Categories;
use App\Models\CommissionLog;
use App\Models\EmailTemplate;
use App\Models\Extension;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Series;
use App\Models\SmsTemplate;
use App\Models\EmailLog;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Matches;
use App\Models\Player;
use App\Models\PlayerState;
use App\Models\WalletLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;


function sidebarVariation()
{

    $variation['sidebar'] = 'bg_img';
    $variation['selector'] = 'capsule--rounded';
    $variation['overlay'] = 'overlay--indigo';
    $variation['opacity'] = 'overlay--opacity-8';
    return $variation;
}



function dateFormat($date)
{
    return date('M jS, Y', strtotime($date));
}
function dateTimeFormat($date)
{
    return date('M jS, Y H:i', strtotime($date));
}

function gmtTimeFormat($date)
{
    date_default_timezone_set("GMT");
    $dateTime = new DateTime($date);
    $dateTime->setTimezone(new DateTimeZone("Asia/Kolkata"));
    return $dateTime->format('H:i');
}

function getShortName($name)
{
    $nameParts = explode(" ", $name);

    $formattedName = $name;
    if (count($nameParts) == 2) {
        $firstName = ($nameParts[0][0] ?? '');
        $lastName = ucwords(($nameParts[1] ?? ''));
        $formattedName = ($firstName ?? '') . " " . ($lastName ?? '');
    }
    if (count($nameParts) >= 3) {
        $firstName = ($nameParts[0][0] ?? '');
        $secondName = ($nameParts[1][0] ?? '');
        $lastName = ucwords(($nameParts[2] ?? ''));
        $formattedName = ($firstName ?? '') . " " . ($secondName ?? '') . " " . ($lastName ?? '');
    }

    return $formattedName;
}

function getPageCountData($fetchData){
    $pageData = [];
    if(!empty($fetchData)){
    $pageData['total'] = $total = $fetchData->total();
    $currentPage = $fetchData->currentPage();
    $perPage = $fetchData->perPage();
    $pageData['from'] = ($currentPage - 1) * $perPage + 1;
    $pageData['to'] = min($currentPage * $perPage, $total);
    }
    return $pageData;

}


function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}

function shortDescription($string, $length = 120)
{
    return Illuminate\Support\Str::limit($string, $length);
}

function shortCodeReplacer($shortCode, $replace_with, $template_string)
{
    return str_replace($shortCode, $replace_with, $template_string);
}

function verificationCode($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}

function getNumber($length = 8)
{
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


//moveable
function uploadImage($file, $location, $size = null, $old = null, $thumb = null)
{
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');

    if ($old) {
        removeFile($location . '/' . $old);
        removeFile($location . '/thumb_' . $old);
    }
    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
    $image = Image::make($file);
    if ($size) {
        // $size = explode('x', strtolower($size));
        // $image->resize($size[0], $size[1]);
    }
    $image->save($location . '/' . $filename);

    if ($thumb) {
        $thumb = explode('x', $thumb);
        Image::make($file)->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
    }

    return $filename;
}


function uploadFile($file, $location, $size = null, $old = null)
{
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');

    if ($old) {
        removeFile($location . '/' . $old);
    }

    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
    $file->move($location, $filename);
    return $filename;
}

function makeDirectory($path)
{
    if (file_exists($path)) return true;
    return mkdir($path, 0755, true);
}


function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}


function activeTemplate($asset = false)
{
    $general = GeneralSetting::first(['active_template']);
    $template = $general->active_template;
    $sess = session()->get('template');
    if (trim($sess)) {
        $template = $sess;
    }
    if ($asset) return 'assets/templates/' . $template . '/';
    return 'templates.' . $template . '.';
}

function activeTemplateName()
{
    $general = GeneralSetting::first(['active_template']);
    $template = $general->active_template;
    $sess = session()->get('template');
    if (trim($sess)) {
        $template = $sess;
    }
    return $template;
}

function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getAmount($amount, $length = 2)
{
    $amount = round($amount, $length);
    return $amount + 0;
}

function showAmount($amount, $decimal = 2, $separate = true, $exceptZeros = false)
{
    $separator = '';
    if ($separate) {
        $separator = ',';
    }
    $printAmount = number_format($amount, $decimal, '.', $separator);
    if ($exceptZeros) {
        $exp = explode('.', $printAmount);
        if ($exp[1] * 1 == 0) {
            $printAmount = $exp[0];
        }
    }
    return $printAmount;
}

function removeElement($array, $value)
{
    return array_diff($array, (is_array($value) ? $value : array($value)));
}

function cryptoQR($wallet)
{

    return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8";
}

//moveable
function curlContent($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

//moveable
function curlPostContent($url, $arr = null)
{

    if ($arr) {
        $params = http_build_query($arr);
    } else {
        $params = '';
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


function inputTitle($text)
{
    return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
}


function titleToKey($text)
{
    return strtolower(str_replace(' ', '_', $text));
}


function str_limit($title = null, $length = 10)
{
    return \Illuminate\Support\Str::limit($title, $length);
}

//moveable
function getIpInfo()
{
    $ip = $_SERVER["REMOTE_ADDR"];

    //Deep detect ip
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }


    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);


    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');


    return $data;
}

//moveable
function osBrowser()
{
    $userAgent = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $osPlatform = "Unknown OS Platform";
    $osArray = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($osArray as $regex => $value) {
        if (preg_match($regex, $userAgent)) {
            $osPlatform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browserArray = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browserArray as $regex => $value) {
        if (preg_match($regex, $userAgent)) {
            $browser = $value;
        }
    }

    $data['os_platform'] = $osPlatform;
    $data['browser'] = $browser;

    return $data;
}

function siteName()
{
    $general = GeneralSetting::first();
    $sitname = str_word_count($general->sitename);
    $sitnameArr = explode(' ', $general->sitename);
    if ($sitname > 1) {
        $title = "<span>$sitnameArr[0] </span> " . str_replace($sitnameArr[0], '', $general->sitename);
    } else {
        $title = "<span>$general->sitename</span>";
    }

    return $title;
}


//moveable
function getTemplates()
{
    $param['purchasecode'] = env("PURCHASECODE");
    $param['website'] = @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'] . ' - ' . env("APP_URL");
    $url = 'https://license.viserlab.com/updates/templates/' . systemDetails()['name'];
    $result = curlPostContent($url, $param);
    if ($result) {
        return $result;
    } else {
        return null;
    }
}

function convertToWords($number)
{
    return $number = (int) $number;
    $ones = array(
        0 => 'Zero',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine'
    );

    $teens = array(
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen'
    );

    $tens = array(
        10 => 'Ten',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety'
    );

    if ($number < 10) {
        return $ones[$number] . ' Rupees';
    } elseif ($number < 20) {
        return $teens[$number] . ' Rupees';
    } elseif ($number < 100) {
        $ten = floor($number / 10) * 10;
        $one = $number % 10;
        return $tens[$ten] . ' ' . $ones[$one] . ' Rupees';
    } else {
        return 'Invalid input';
    }
}

function postpushnotification($device_id, $title, $message, $noti_type = null, $booking_id = null, $urlToken = null)
{
    if (!empty($device_id)) {
        $fields = array(
            'to' => $device_id,
            'data' => array(
                'title' => $title,
                'message' => $message,
                'urlToken' => $urlToken,
                'sound' => 'sound.mp3'
            ),
            'notification' => array(
                'title' => $title,
                'body' => $message,
                'sound' => 'sound.mp3'
            )
        );
        $response = sendPushNotification($fields);
        return $response;
    }
}


function sendPushNotification($fields = array(), $usertype = Null)
{
    //echo '<pre>';print_r($fields); //exit;
    $API_ACCESS_KEY = 'AAAAlmdUfBg:APA91bFRokwpGV_DgAOj_1vrYlZYmE5XlAdqVkyEaoPLS36I3zanb3ydD-9MkOvTXSw0P1zENUJ34cYWLKQeuho2AdRIU5Z5Di84EBHMbJUVBv0QvzXqykeRrfIG6IfTLl9tgVW9X6NR';

    $headers = array(
        'Authorization: key=' . $API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    // Execute post
    $result = curl_exec($ch);
    //print_r($result);//die;
    sleep(5);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    // Close connection
    curl_close($ch);
    return $result;
}


function getImage($image, $size = null)
{
    $clean = '';
    if (file_exists($image) && is_file($image)) {
        return asset($image) . $clean;
    }
    if ($size) {
        return route('placeholder.image', $size);
    }
    return asset('assets/images/default.png');
}

function notify($user, $type, $shortCodes = null)
{
    if($user->email){ sendEmail($user, $type, $shortCodes); }
    sendSms($user, $type, $shortCodes);
}

function sendSms($user, $type, $shortCodes = [])
{
    $general = GeneralSetting::first();
    $smsTemplate = SmsTemplate::where('act', $type)->where('sms_status', 1)->first();
    $gateway = $general->sms_config->name;
    $sendSms = new SendSms;
    if ($general->sn == 1 && $smsTemplate) {
        $template = $smsTemplate->sms_body;
        //pr($shortCodes);
        foreach ($shortCodes as $code => $value) {
            $template = shortCodeReplacer('{#' . $code . '#}', $value, $template);
        }
        //$message = shortCodeReplacer("{{message}}", $template, $general->sms_api);
        //$message = shortCodeReplacer("{{name}}", $user->username, $message);
        // echo $template; die;
        $sendSms->$gateway($user->mobile, $general->sitename, $template, $general->sms_config);
    }
}


function sendEmail($user, $type = null, $shortCodes = [])
{
    $general = GeneralSetting::first();

    $emailTemplate = EmailTemplate::where('act', $type)->where('email_status', 1)->first();
    if ($general->en != 1 || !$emailTemplate) {
        return;
    }

    // if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
    $user_fullname = isset($user->fullname) ? $user->fullname : $user->email;
    $username = isset($user->username) ? $user->username : $user->email;


    $message = shortCodeReplacer("{{fullname}}", $user_fullname, $general->email_template);
    $message = shortCodeReplacer("{{username}}", $username, $message);
    $message = shortCodeReplacer("{{message}}", $emailTemplate->email_body, $message);

    if (empty($message)) {
        $message = $emailTemplate->email_body;
    }

    foreach ($shortCodes as $code => $value) {
        $message = shortCodeReplacer('{{' . $code . '}}', $value, $message);
    }

    $config = $general->mail_config;
    $emailLog = new EmailLog();
    $emailLog->user_id = $user->id;
    $emailLog->mail_sender = $config->name;
    $emailLog->email_from = $general->sitename . ' ' . $general->email_from;
    $emailLog->email_to = $user->email;
    $emailLog->subject = $emailTemplate->subj;
    $emailLog->message = $message;
    $emailLog->save();


    if ($config->name == 'php') {
        sendPhpMail($user->email, $user->username, $emailTemplate->subj, $message, $general);
    } else if ($config->name == 'smtp') {
        sendSmtpMail($config, $user->email, $user->username, $emailTemplate->subj, $message, $general);
    } else if ($config->name == 'sendgrid') {
        sendSendGridMail($config, $user->email, $user->username, $emailTemplate->subj, $message, $general);
    } else if ($config->name == 'mailjet') {
        sendMailjetMail($config, $user->email, $user->username, $emailTemplate->subj, $message, $general);
    }
}


function sendPhpMail($receiver_email, $receiver_name, $subject, $message, $general)
{
    $headers = "From: $general->sitename <$general->email_from> \r\n";
    $headers .= "Reply-To: $general->sitename <$general->email_from> \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    @mail($receiver_email, $subject, $message, $headers);
}


function sendSmtpMail($config, $receiver_email, $receiver_name, $subject, $message, $general)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = $config->host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $config->username;
        $mail->Password   = $config->password;
        if ($config->enc == 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port       = $config->port;
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom($general->email_from, $general->sitename);
        $mail->addAddress($receiver_email, $receiver_name);
        $mail->addReplyTo($general->email_from, $general->sitename);
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();
    } catch (Exception $e) {
        throw new Exception($e);
    }
}


function sendSendGridMail($config, $receiver_email, $receiver_name, $subject, $message, $general)
{
    $sendgridMail = new \SendGrid\Mail\Mail();
    $sendgridMail->setFrom($general->email_from, $general->sitename);
    $sendgridMail->setSubject($subject);
    $sendgridMail->addTo($receiver_email, $receiver_name);
    $sendgridMail->addContent("text/html", $message);
    $sendgrid = new \SendGrid($config->appkey);
    try {
        $response = $sendgrid->send($sendgridMail);
    } catch (Exception $e) {
        throw new Exception($e);
    }
}


function sendMailjetMail($config, $receiver_email, $receiver_name, $subject, $message, $general)
{
    $mj = new \Mailjet\Client($config->public_key, $config->secret_key, true, ['version' => 'v3.1']);
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => $general->email_from,
                    'Name' => $general->sitename,
                ],
                'To' => [
                    [
                        'Email' => $receiver_email,
                        'Name' => $receiver_name,
                    ]
                ],
                'Subject' => $subject,
                'TextPart' => "",
                'HTMLPart' => $message,
            ]
        ]
    ];
    $response = $mj->post(\Mailjet\Resources::$Email, ['body' => $body]);
}


function getPaginate($paginate = 20)
{
    return $paginate;
}

function paginateLinks($data, $design = 'admin.partials.paginate')
{
    return $data->appends(request()->all())->links($design);
}


function menuActive($routeName, $type = null)
{
    if ($type == 3) {
        $class = 'side-menu--open';
    } elseif ($type == 2) {
        $class = 'sidebar-submenu__open';
    } else {
        $class = 'active';
    }
    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return $class;
    }
}

function pr($value)
{
    echo "<pre>";
    print_r($value);
}
function prd($value)
{
    echo "<pre>";
    print_r($value);
    die;
}

function matchData($matchId)
{
    //fetch match data
    $matchData = Matches::leftjoin(env('DB_DATABASE') . '.user_contests', 'cric_scorecards.matchId', 'user_contests.matchId')
        ->leftjoin('cric_teams as teamOne', 'cric_scorecards.team1_id', '=', 'teamOne.teamId')
        ->leftjoin('cric_teams as teamTwo', 'cric_scorecards.team2_id', '=', 'teamTwo.teamId')
        ->MySelect()
        ->addSelect([
            'teamOne.teamName as teamOne_teamName',
            'teamTwo.teamName as teamTwo_teamName',
            'teamOne.teamSName as teamOne_teamSName',
            'teamTwo.teamSName as teamTwo_teamSName',
        ])
        ->where('cric_scorecards.matchId', $matchId)
        ->first();
     return $matchData;
}


function imagePath()
{
    $data['gateway'] = [
        'path' => 'assets/images/gateway',
        'size' => '800x800',
    ];
    $data['verify'] = [
        'withdraw' => [
            'path' => 'assets/images/verify/withdraw'
        ],
        'deposit' => [
            'path' => 'assets/images/verify/deposit'
        ]
    ];
    $data['image'] = [
        'default' => 'assets/images/default.png',
        'path' => 'assets/images',
    ];
    $data['sliderImage'] = [
        'path' => 'assets/images',
    ];
    $data['withdraw'] = [
        'method' => [
            'path' => 'assets/images/withdraw/method',
            'size' => '800x800',
        ]
    ];
    $data['ticket'] = [
        'path' => 'assets/support',
    ];
    $data['language'] = [
        'path' => 'assets/images/lang',
        'size' => '64x64'
    ];
    $data['logoIcon'] = [
        'path' => 'assets/images/logoIcon',
    ];
    $data['favicon'] = [
        'size' => '128x128',
    ];
    $data['extensions'] = [
        'path' => 'assets/images/extensions',
        'size' => '36x36',
    ];
    $data['seo'] = [
        'path' => 'assets/images/seo',
        'size' => '600x315'
    ];
    $data['banner'] = [
        'path' => 'assets/images/banner',
        'size' => '600x315'
    ];
    $data['app'] = [
        'path' => 'assets/app',
        'size' => '600x315'
    ];
    $data['profile'] = [
        'user' => [
            'path' => 'assets/images/user/profile',
            'size' => '350x300'
        ],
        'admin' => [
            'path' => 'assets/admin/images/profile',
            'size' => '400x400'
        ]
    ];
    $data['kyc'] = [
        'user' => [
            'path' => 'assets/images/user/kyc',
            'size' => '350x300'
        ],
    ];
    $data['testimonial'] = [
        'user' => [
            'path' => 'assets/testimonial',
            'size' => '350x300'
        ],
    ];
    $data['airline'] = [
        'path' => 'uploads/images/airlines',
        'size' => '800x800',
    ];
    return $data;
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->diffForHumans();
}

function showDateTime($date, $format = 'Y-m-d h:i a')
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->translatedFormat($format);
}

function fetchTitle($string)
{
    if (!empty($string)) {
        $parts = explode(",", $string);
        if (count($parts) > 0) {
            $dPart = trim($parts[0]);
            return $dPart;
        } else {
            return $string;
        }
    } else {
        return '';
    }
}

function showBelow($id)
{
    $arr = array();
    $under_ref = User::where('ref_by', $id)->get();

    foreach ($under_ref as $u) {
        array_push($arr, $u->id);
    }

    return $arr;
}

function ordinal($number)
{
    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
    if ((($number % 100) >= 11) && (($number % 100) <= 13))
        return $number . 'th';
    else
        return $number . $ends[$number % 10];
}

function upcoming($match)
{
    if ($match->start_time >= now()) {
        return 1;
    } else {
        return 0;
    }
}
function getContent($data_keys, $singleQuery = false, $limit = null, $orderById = false)
{
    if ($singleQuery) {
        $content = Frontend::where('data_keys', $data_keys)->orderBy('id', 'desc')->first();
    } else {
        $article = Frontend::query();
        $article->when($limit != null, function ($q) use ($limit) {
            return $q->limit($limit);
        });
        if ($orderById) {
            $content = $article->where('data_keys', $data_keys)->orderBy('id')->get();
        } else {
            $content = $article->where('data_keys', $data_keys)->orderBy('id', 'desc')->get();
        }
    }
    return $content;
}

function getCategories(){
    return Categories::orderBy('name','ASC')
            ->with('sub_category')
            ->where('status',1)
            ->orderBy('id','DESC')
            ->where('showHome','Yes')
            ->get();
}

if (!function_exists('include_route_files')) {
    /**
     * Loops through a folder and requires all PHP files
     *
     * @param string $folder
     * @return void
     */
    function include_route_files(string $folder): void
    {
        try {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder)) as $file) {
                if ($file->isFile() && $file->isReadable() && $file->getExtension() === 'php') {
                    require $file->getPathname();
                }
            }
        } catch (Exception $ex) {
            Log::error($ex);
        }
    }
}

if (!function_exists('activeMenu')) {
    function activeMenu($routes)
    {
        foreach ((array) $routes as $route) {
            if (request()->routeIs($route)) {
                return 'active';
            }
        }
        return '';
    }
}

if (!function_exists('getAirportName')) {
    function getAirportName($code)
    {
        $name = Airport::where(['iata_code'=>$code])->select('name')->first();
    }
}
