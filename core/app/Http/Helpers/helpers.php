<?php

use Carbon\Carbon;
use App\Lib\Captcha;
use App\Models\Plan;
use App\Models\User;
use App\Models\BvLog;
use App\Notify\Notify;
use App\Lib\ClientInfo;
use App\Lib\CurlRequest;
use App\Lib\FileManager;
use App\Models\Frontend;
use App\Constants\Status;
use App\Models\Extension;
use App\Models\UserExtra;
use Illuminate\Support\Str;
use App\Models\GeneralSetting;
use Laramin\Utility\VugiChugi;
use App\Lib\GoogleAuthenticator;
use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use App\Models\Category;



function systemDetails()
{
    $system['name']          = 'binaryecom';
    $system['version']       = '2.0';
    $system['build_version'] = '5.0.9';
    return $system;
}

function slug($string)
{
    return Str::slug($string);
}

function verificationCode($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = (int) ($min - 1) . '9';
    return random_int($min, $max);
}

function getNumber($length = 8)
{
    $characters       = '1234567890';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function activeTemplate($asset = false)
{
    $template = session('template') ?? gs('active_template');
    if ($asset) return 'assets/templates/' . $template . '/';
    return 'templates.' . $template . '.';
}

function activeTemplateName()
{
    $template = session('template') ?? gs('active_template');
    return $template;
}

function siteLogo($type = null)
{
    $name = $type ? "/logo_$type.png" : '/logo.png';
    return getImage(getFilePath('logoIcon') . $name);
}

function siteFavicon()
{
    return getImage(getFilePath('logoIcon') . '/favicon.png');
}

function loadReCaptcha()
{
    return Captcha::reCaptcha();
}

function loadCustomCaptcha($width = '100%', $height = 46, $bgColor = '#003')
{
    return Captcha::customCaptcha($width, $height, $bgColor);
}

function verifyCaptcha()
{
    return Captcha::verify();
}

function loadExtension($key)
{
    $extension = Extension::where('act', $key)->where('status', Status::ENABLE)->first();
    return $extension ? $extension->generateScript(): '';
}

function getTrx($length = 12)
{
    $characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getAmount($amount, $length = 2)
{
    $amount = round($amount ?? 0, $length);
    return $amount + 0;
}

function showAmount($amount, $decimal = 2, $separate = true, $exceptZeros = false, $currencyFormat = true)
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
        } else {
            $printAmount = rtrim($printAmount, '0');
        }
    }
    if ($currencyFormat) {
        if (gs('currency_format') == Status::CUR_BOTH) {
            return gs('cur_sym') . $printAmount . ' ' . __(gs('cur_text'));
        } elseif (gs('currency_format') == Status::CUR_TEXT) {
            return $printAmount . ' ' . __(gs('cur_text'));
        } else {
            return gs('cur_sym') . $printAmount;
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
    return "https://api.qrserver.com/v1/create-qr-code/?data=$wallet&size=300x300&ecc=m";
}

function keyToTitle($text)
{
    return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
}


function titleToKey($text)
{
    return strtolower(str_replace(' ', '_', $text));
}


function strLimit($title = null, $length = 10)
{
    return Str::limit($title, $length);
}


function getIpInfo()
{
    $ipInfo = ClientInfo::ipInfo();
    return $ipInfo;
}


function osBrowser()
{
    $osBrowser = ClientInfo::osBrowser();
    return $osBrowser;
}


function getTemplates()
{
    $param['purchasecode'] = env("PURCHASECODE");
    $param['website']      = @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'] . ' - ' . env("APP_URL");
    $url                   = VugiChugi::gttmp() . systemDetails()['name'];
    $response              = CurlRequest::curlPostContent($url, $param);
    if ($response) {
        return $response;
    } else {
        return null;
    }
}


function getPageSections($arr = false)
{
    $jsonUrl  = resource_path('views/') . str_replace('.', '/', activeTemplate()) . 'sections.json';
    $sections = json_decode(file_get_contents($jsonUrl));
    if ($arr) {
        $sections = json_decode(file_get_contents($jsonUrl), true);
        ksort($sections);
    }
    return $sections;
}


function getImage($image, $size = null, $defaultUser = false)
{
    $clean = '';
    if (file_exists($image) && is_file($image)) {
        return asset($image) . $clean;
    }
    if ($defaultUser) {
        return asset('assets/images/default-user.png');
    }
    if ($size) {
        return route('placeholder.image', $size);
    }
    return asset('assets/images/default.png');
}


function notify($user, $templateName, $shortCodes = null, $sendVia = null, $createLog = true, $pushImage = null)
{
    $globalShortCodes = [
        'site_name'       => gs('site_name'),
        'site_currency'   => gs('cur_text'),
        'currency_symbol' => gs('cur_sym'),
    ];

    if (gettype($user) == 'array') {
        $user = (object) $user;
    }

    $shortCodes = array_merge($shortCodes ?? [], $globalShortCodes);

    $notify               = new Notify($sendVia);
    $notify->templateName = $templateName;
    $notify->shortCodes   = $shortCodes;
    $notify->user         = $user;
    $notify->createLog    = $createLog;
    $notify->pushImage    = $pushImage;
    $notify->userColumn   = isset($user->id) ? $user->getForeignKey() : 'user_id';
    $notify->send();
}

function getPaginate($paginate = null)
{
    if (!$paginate) {
        $paginate = gs('paginate_number');
    }
    return $paginate;
}

function paginateLinks($data)
{
    return $data->appends(request()->all())->links();
}


function menuActive($routeName, $type = null, $param = null)
{
    if     ($type == 3) $class = 'side-menu--open';
    elseif ($type == 2) $class = 'sidebar-submenu__open';
    else   $class              = 'active';

    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) return $class;
        }
    } elseif (request()->routeIs($routeName)) {
        if ($param) {
            $routeParam = array_values(@request()->route()->parameters ?? []);
            if (strtolower(@$routeParam[0]) == strtolower($param)) return $class;
            else return;
        }
        return $class;
    }
}


function fileUploader($file, $location, $size = null, $old = null, $thumb = null, $filename = null)
{
    $fileManager           = new FileManager($file);
    $fileManager->path     = $location;
    $fileManager->size     = $size;
    $fileManager->old      = $old;
    $fileManager->thumb    = $thumb;
    $fileManager->filename = $filename;
    $fileManager->upload();
    return $fileManager->filename;
}

function fileManager()
{
    return new FileManager();
}

function getFilePath($key)
{
    return fileManager()->$key()->path;
}

function getFileSize($key)
{
    return fileManager()->$key()->size;
}

function getThumbSize($key)
{
    return fileManager()->$key()->thumb;
}

function getFileExt($key)
{
    return fileManager()->$key()->extensions;
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->diffForHumans();
}


function showDateTime($date, $format = 'Y-m-d h:i A')
{
    if (!$date) {
        return '-';
    }
    $lang = session()->get('lang');
    Carbon::setlocale($lang ?? 'en');

    return Carbon::parse($date)->translatedFormat($format);
}


function getContent($dataKeys, $singleQuery = false, $limit = null, $orderById = false)
{

    $templateName = activeTemplateName();
    if ($singleQuery) {
        $content = Frontend::where('tempname', $templateName)->where('data_keys', $dataKeys)->orderBy('id', 'desc')->first();
    } else {
        $article = Frontend::where('tempname', $templateName);
        $article->when($limit != null, function ($q) use ($limit) {
            return $q->limit($limit);
        });
        if ($orderById) {
            $content = $article->where('data_keys', $dataKeys)->orderBy('id')->get();
        } else {
            $content = $article->where('data_keys', $dataKeys)->orderBy('id', 'desc')->get();
        }
    }
    return $content;
}

function verifyG2fa($user, $code, $secret = null)
{
    $authenticator = new GoogleAuthenticator();
    if (!$secret) {
        $secret = $user->tsc;
    }
    $oneCode  = $authenticator->getCode($secret);
    $userCode = $code;
    if ($oneCode == $userCode) {
        $user->tv = Status::YES;
        $user->save();
        return true;
    } else {
        return false;
    }
}


function urlPath($routeName, $routeParam = null)
{
    if ($routeParam == null) {
        $url = route($routeName);
    } else {
        $url = route($routeName, $routeParam);
    }
    $basePath = route('home');
    $path     = str_replace($basePath, '', $url);
    return $path;
}


function showMobileNumber($number)
{
    $length = strlen($number);
    return substr_replace($number, '***', 2, $length - 4);
}

function showEmailAddress($email)
{
    $endPosition = strpos($email, '@') - 1;
    return substr_replace($email, '***', 1, $endPosition);
}


function getRealIP()
{
    $ip = $_SERVER["REMOTE_ADDR"];
      //Deep detect ip
    if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    }
    if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    if ($ip == '::1') {
        $ip = '127.0.0.1';
    }

    return $ip;
}


function appendQuery($key, $value)
{
    return request()->fullUrlWithQuery([$key => $value]);
}

function dateSort($a, $b)
{
    return strtotime($a) - strtotime($b);
}

function dateSorting($arr)
{
    usort($arr, "dateSort");
    return $arr;
}

function gs($key = null)
{
    $general = Cache::get('GeneralSetting');
    if (!$general) {
        $general = GeneralSetting::first();
        Cache::put('GeneralSetting', $general);
    }
    if ($key) return @$general->$key;
    return $general;
}
function isImage($string)
{
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    $fileExtension     = pathinfo($string, PATHINFO_EXTENSION);
    if (in_array($fileExtension, $allowedExtensions)) {
        return true;
    } else {
        return false;
    }
}

function isHtml($string)
{
    if (preg_match('/<.*?>/', $string)) {
        return true;
    } else {
        return false;
    }
}


function convertToReadableSize($size)
{
    preg_match('/^(\d+)([KMG])$/', $size, $matches);
    $size = (int)$matches[1];
    $unit = $matches[2];

    if ($unit == 'G') {
        return $size . 'GB';
    }

    if ($unit == 'M') {
        return $size . 'MB';
    }

    if ($unit == 'K') {
        return $size . 'KB';
    }

    return $size . $unit;
}


function frontendImage($sectionName, $image, $size = null, $seo = false)
{
    if ($seo) {
        return getImage('assets/images/frontend/' . $sectionName . '/seo/' . $image, $size);
    }
    return getImage('assets/images/frontend/' . $sectionName . '/' . $image, $size);
}


function shortDescription($string, $length = 120)
{
    return Illuminate\Support\Str::limit($string, $length);
}

function updateBV($id, $bv, $details)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posId = getPositionId($id);
            
            if ($posId == "0") {
                break;
            }
            $posUser = User::find($posId);
            
            if ($posUser->plan_id) {
                $position       = getPositionLocation($id);
                $extra          = UserExtra::where('user_id', $posId)->first();
                $bvLog          = new BvLog();
                $bvLog->user_id = $posId;

                if ($position == 1) {
                    $extra->bv_left  += $bv;
                    $bvLog->position  = '1';
                } else {
                    $extra->bv_right += $bv;
                    $bvLog->position  = '2';
                }
                $extra->save();
                $bvLog->amount   = $bv;
                $bvLog->trx_type = '+';
                $bvLog->details  = $details;
                $bvLog->save();
            }
            $id = $posId;
        } else {
            break;
        }
    }
}

function isUserExists($id)
{
    $user = User::find($id);
    if ($user) {
        return true;
    } else {
        return false;
    }
}

function getPositionId($id)
{
    $user = User::find($id);

    if ($user) {
        return $user->pos_id;
    } else {
        return 0;
    }
}

function getPositionLocation($id)
{
    $user = User::find($id);
    if ($user) {
        return $user->position;
    } else {
        return 0;
    }
}

function getPosition($parentid, $position)
{
    $childid = getTreeChildId($parentid, $position);

    if ($childid != "-1") {
        $id = $childid;
    } else {
        $id = $parentid;
    }
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $nextchildid = getTreeChildId($id, $position);
            if ($nextchildid == "-1") {
                break;
            } else {
                $id = $nextchildid;
            }
        } else break;
    }

    $res['pos_id']   = $id;
    $res['position'] = $position;
    return $res;
}

function getTreeChildId($parentid, $position)
{
    $cou = User::where('pos_id', $parentid)->where('position', $position)->count();
    $cid = User::where('pos_id', $parentid)->where('position', $position)->first();
    if ($cou == 1) {
        return $cid->id;
    } else {
        return -1;
    }
}

function mlmPositions()
{
    return array(
        '1' => 'Left',
        '2' => 'Right',
    );
}

function updateFreeCount($id)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0") {
                break;
            }
            $position = getPositionLocation($id);

            $extra = UserExtra::where('user_id', $posid)->first();

            if ($position == 1) {
                $extra->free_left += 1;
            } else {
                $extra->free_right += 1;
            }
            $extra->save();

            $id = $posid;
        } else {
            break;
        }
    }
}

function showTreePage($id)
{
    $res      = array_fill_keys(array('b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o'), null);
    $res['a'] = User::find($id);

    $res['b'] = getPositionUser($id, 1);
    if ($res['b']) {
        $res['d'] = getPositionUser($res['b']->id, 1);
        $res['e'] = getPositionUser($res['b']->id, 2);
    }
    if ($res['d']) {
        $res['h'] = getPositionUser($res['d']->id, 1);
        $res['i'] = getPositionUser($res['d']->id, 2);
    }
    if ($res['e']) {
        $res['j'] = getPositionUser($res['e']->id, 1);
        $res['k'] = getPositionUser($res['e']->id, 2);
    }
    $res['c'] = getPositionUser($id, 2);
    if ($res['c']) {
        $res['f'] = getPositionUser($res['c']->id, 1);
        $res['g'] = getPositionUser($res['c']->id, 2);
    }
    if ($res['f']) {
        $res['l'] = getPositionUser($res['f']->id, 1);
        $res['m'] = getPositionUser($res['f']->id, 2);
    }
    if ($res['g']) {
        $res['n'] = getPositionUser($res['g']->id, 1);
        $res['o'] = getPositionUser($res['g']->id, 2);
    }
    return $res;
}

function getPositionUser($id, $position)
{
    return User::where('pos_id', $id)->where('position', $position)->first();
}

function showSingleUserinTree($user)
{
    $res = '';
    if ($user) {
        if ($user->plan_id == 0) {
            $userType = "free-user";
            $stShow   = "Member";
            $planName = '';
        } else {
            $userType = "paid-user";
            $stShow   = "Member";
            $planName = $user->plan->name;
        }
        $img   = getImage('assets/images/user/profile/' . $user->image, '120x120', true);
        $refby = $user->refBy->username ?? '';
        if (auth()->guard('admin')->user()) {
            $hisTree = route('admin.users.other.tree', $user->username);
        } else {
            $hisTree = route('user.other.tree', $user->username);
        }
        $gpv = userGroupPoints($user);
        $extraData  = " data-name=\"$user->fullname\"";
        $extraData .= " data-user_id=\"$user->id\"";
        $extraData .= " data-treeurl=\"$hisTree\"";
        $extraData .= " data-status=\"$stShow\"";
        $extraData .= " data-plan=\"$planName\"";
        $extraData .= " data-image=\"$img\"";
        $extraData .= " data-refby=\"$refby\"";
        $extraData .= " data-gpv=\"$gpv\"";
        $extraData .= " data-cpv=\"$user->bv_points\"";
        $extraData .= " data-lpaid=\"" . @$user->userExtra->paid_left . "\"";
        $extraData .= " data-rpaid=\"" . @$user->userExtra->paid_right . "\"";
        $extraData .= " data-lfree=\"" . @$user->userExtra->free_left . "\"";
        $extraData .= " data-rfree=\"" . @$user->userExtra->free_right . "\"";
        $extraData .= " data-guc=\"" . count(fetchAllChildrenUserIds(@$user->id)) . "\"";
        $extraData .= " data-lbv=\"" . getAmount(@$user->userExtra->bv_left) . "\"";
        $extraData .= " data-rbv=\"" . getAmount(@$user->userExtra->bv_right) . "\"";
        $res       .= "<div class=\"user showDetails\" type=\"button\" $extraData>";
        $res       .= "<img src=\"$img\" alt=\"*\"  class=\"$userType\">";
        $res       .= "<p class=\"user-name\">$user->username</p>";
    } else {
        $img = getImage('assets/images/user/profile/', '120x120', true);

        $res .= "<div class=\"user\" type=\"button\">";
        $res .= "<img src=\"$img\" alt=\"*\"  class=\"no-user\">";
        $res .= "<p class=\"user-name\">No user</p>";
    }

    $res .= " </div>";
    // $res .= " <span class=\"line\"></span>";

    return $res;
}

function renderUserTree($users) {
    echo '<ul>';
    foreach ($users as $user) {
        echo '<li>';
        if($user->username)
            echo showSingleUserinTree($user);

        
        // If the user has children, call the same function recursively
        if ($user->children->isNotEmpty()) {
            renderUserTree($user->children);
        }
        
        echo '</li>';
    }
    echo '</ul>';
}

function getUserById($id)
{
    return User::find($id);
}

function updatePaidCount($id)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0") {
                break;
            }
            $position = getPositionLocation($id);
            $extra    = UserExtra::where('user_id', $posid)->first();

            if ($position == 1) {
                $extra->free_left -= 1;
                $extra->paid_left += 1;
            } else {
                $extra->free_right -= 1;
                $extra->paid_right += 1;
            }
            $extra->save();
            $id = $posid;
        } else {
            break;
        }
    }
}

function treeComission($id, $amount, $details)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0") {
                break;
            }

            $posUser = User::find($posid);
            if ($posUser->plan_id != 0) {

                $posUser->balance          += $amount;
                $posUser->total_binary_com += $amount;
                $posUser->save();

                $transaction               = new Transaction();
                $transaction->amount       = $posUser->id;
                $transaction->user_id      = $amount;
                $transaction->charge       = 0;
                $transaction->trx_type     = '+';
                $transaction->details      = $details;
                $transaction->remark       = 'binary_commission';
                $transaction->trx          = getTrx();
                $transaction->post_balance = $posUser->balance;
                $transaction->save();
            }
            $id = $posid;
        } else {
            break;
        }
    }
}


function referralComission($user_id, $details)
{
    $user  = User::find($user_id);
    $refer = User::find($user->ref_by);

    if ($refer) {
        $plan = Plan::find($refer->plan_id);
       
        if ($plan) {
            $amount                = $plan->ref_com;
            $refer->balance       += $amount;
            $refer->total_ref_com += $amount;
            $refer->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $refer->id;
            $transaction->amount       = $amount;
            $transaction->charge       = 0;
            $transaction->trx_type     = '+';
            $transaction->details      = $details;
            $transaction->remark       = 'referral_commission';
            $transaction->trx          = getTrx();
            $transaction->post_balance = $refer->balance;
            $transaction->save();
             $refer = User::find($user->ref_by);

           
            notify($refer, 'REFERRAL_COMMISSION', [
                'trx'          => $transaction->trx,
                'amount'       => showAmount($amount, currencyFormat: false),
                'username'     => $user->username,
                'post_balance' => showAmount($refer->balance, currencyFormat: false),
            ]);
        }
    }
}

function createBVLog($user_id, $lr, $amount, $details)
{
    $bvlog           = new BvLog();
    $bvlog->user_id  = $user_id;
    $bvlog->position = $lr;
    $bvlog->amount   = $amount;
    $bvlog->trx_type = '+';
    $bvlog->details  = $details;
    $bvlog->save();
}

function determineCommissionRate($bv) {
    $ranges = config('services.persantage-range');
    foreach ($ranges as $range => $percent) {
        $range = explode('-', $range);
        if (count($range) == 1) {
            $range[1] = PHP_INT_MAX;  // More explicit max range
        }
        if ($bv >= $range[0] && $bv <= $range[1]) {
            return $percent;
        }
    }
    return 0;
}

function calculateCommissionRateDifference($userone, $usertwo) {
    $userone = User::find($userone);
    $usertwo = User::find($usertwo);

    $percentone = determineCommissionRate($userone->bv_points);
    $percenttwo = determineCommissionRate($usertwo->bv_points);

    return $percentone > $percenttwo ? 0 : abs($percentone - $percenttwo);
}

function calculateCommissionAmount($user_bv, $bv) {
    $percent = determineCommissionRate($user_bv);
    return calculateAmountByCommissionRate($bv, $percent);
}

function calculateAmountByCommissionRate($bv, $percent) {
    static $oneBVtoUSD = null;
    $oneBVtoUSD = $oneBVtoUSD ?? env('ONE_BV_TO_USD', 0.3);
    return 0; 
    //(($bv * $percent) / 100) * $oneBVtoUSD;
}

function fetchAllAncestorUserIds($id) {
    $user = User::find($id);
    $ids = [];
    while ($user->ref_by != 0) {
        $ids[] = $user->ref_by;
        $user = User::find($user->ref_by);
    }
    return $ids;
}

// get all children of a user

function fetchAllChildrenUserIds($id) {
    $user = User::find($id);
    $ids = [];
    $children = $user->children;
    foreach ($children as $child) {
        $ids[] = $child->id;
        $ids = array_merge($ids, fetchAllChildrenUserIds($child->id));
    }
    return $ids;
}

function awardBusinessVolume($id, $bv, $details) {
    distributeSaleCommissionUpward($id, $bv, $details);
    creditBonusAmount($id, $bv, $details);
    $user = User::find($id);
    $user->increment('bv_points', $bv);
    createBVLog($id, '0', $bv, $details);

    $user = User::find($id);
    $bv = $user->bv_points;
    $percent = determineCommissionRate($bv);
    if($percent >= config('services.last_reward')){
        giveUserReward($id);
    }
}

function creditBonusAmount($id, $bv, $details) {
    $user = User::find($id);
    //$amount = calculateCommissionAmount($user->bv_points, $bv);
    
    //$amount = ($user->total_ref_com+ $user->gp_points);

    $amount = 0;

    $user->increment('balance', $amount);
    
    $transaction = new Transaction();
    $transaction->amount = $amount;
    $transaction->user_id = $id;
    $transaction->charge = 0;
    $transaction->trx_type = '+';
    $transaction->details = $details . ' - Bonus Amount';
    $transaction->remark = 'bonus_amount';
    $transaction->trx = getTrx();
    $transaction->post_balance = $user->balance;
    $transaction->save();
}

function distributeSaleCommissionUpward($id, $bv, $details) {
    $userIds = fetchAllAncestorUserIds($id); // Get all ancestor users
    $currentUser = User::find($id);
    $currentUserPer = determineCommissionRate($currentUser->bv_points); // Get current user commission rate
    $givenPer = $currentUserPer; // Start with the current user's commission rate

    foreach ($userIds as $userId) {
        if($givenPer >= config('services.last_reward')) {
            break; // Stop if total commission has reached or exceeded config('services.last_reward')%
        }

        $user = User::find($userId);
        $userPer = determineCommissionRate($user->bv_points); // Get ancestor user's commission rate

        // Skip if the ancestor's commission rate is not higher than the current user's
        if ($userPer <= $currentUserPer) continue;

        // Calculate the difference in commission percentages
        $diff_percent = $userPer - $givenPer;

        // Ensure the total commission does not exceed config('services.last_reward')%
        if($diff_percent + $givenPer > config('services.last_reward')){
            $diff_percent = config('services.last_reward') - $givenPer;
        }

        // If there's no difference in commission to distribute, skip
        if($diff_percent <= 0) continue;

        // Calculate the commission amount based on the percentage difference
        $amount = calculateAmountByCommissionRate($bv, $diff_percent);

        // Increment the user's balance and create a transaction record
        $user->increment('balance', $amount);
       
        
        $transaction = new Transaction();
        $transaction->amount = $amount;
        $transaction->user_id = $userId;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = $details . ' - Sale Commission';
        $transaction->remark = 'sale_commission';
        $transaction->trx = getTrx(); // Generate a unique transaction ID
        $transaction->post_balance = $user->balance;
        $transaction->commission_by = $id;
        $transaction->save();

        // Update the given percentage for the next iteration
        $givenPer += $diff_percent;
    }
}

// show users rewards

function showUserRewards($user, $number = false)
{
    $rewards = config('services.reward-level');
    $users = $user->children;    
    $rewardsCount = 0;
    foreach ($users as $_usr){
        $percent = determineCommissionRate($_usr->bv_points);
        if($percent >= config('services.last_reward')){
            $rewardsCount++;
        }
    }
    
    if($rewardsCount >= 8){
        return ($number ? 8 : $rewards[8]);
    }elseif($rewardsCount >= 4){
        return ($number ? 4 : $rewards[4]);
    }elseif($rewardsCount >= 2){
        return ($number ? 2 : $rewards[2]);
    }else{
        return ($number ? 0 : $rewards[0]);
    }    
}

function userGroupPoints($user)
{
    $usersIds = fetchAllChildrenUserIds($user->id); 
    $totalPoints = 0;
    foreach ($usersIds as $userId) {
        $user = User::find($userId);
        $totalPoints += $user->bv_points;
    }
    
    return $totalPoints + auth()->user()->retail_gvp ?? 0; // Include the user's own BV points
}

function users_sum_numb($column = 'bv_points'){
    return User::sum($column);
}


function createTransaction($user, $amount, $details, $remark) {
    $transaction = new Transaction();
    $transaction->amount = $amount;
    $transaction->user_id = $user->id;
    $transaction->charge = 0;
    $transaction->trx_type = '+';
    $transaction->details = $details;
    $transaction->remark = $remark;
    $transaction->trx = getTrx();
    $transaction->post_balance = $user->balance;
    $transaction->save();
}


function giveUserReward($id) {
    $user = User::find($id);
    if ($user->is_leader_reward == 0) {
        $user->is_leader_reward = 1;
        $user->save();
        
        $user->increment('balance', config('services.leader_reward_amount'));
        createTransaction($user, config('services.leader_reward_amount'), 'Leader Reward', 'leader_reward');
    }
}

function getRewardUsers() {
    $users = User::where('is_group_reward', 0)->get();
    
    foreach ($users as $user) {
        
        $userRewardLevel = getUserRewardLevel($user);
        
    
        if ($userRewardLevel === 0) {
            continue;
        }

        $eligibleForReward = checkEligibilityForGroupReward($user, $userRewardLevel);
        if (!$eligibleForReward) {
            continue;
        }

        $user->is_group_reward = 1;
        $user->save();
        $rewardAmount = config('services.reward-level')[$userRewardLevel]['amount'];
        $user->increment('balance', $rewardAmount);
        createTransaction($user, $rewardAmount, 'Group Reward - ' . config('services.reward-level')[$userRewardLevel]['name'], 'group_reward');
    }
}

function getUserRewardLevel($user) {
    $count = $user->children->filter(function ($child) {
        return determineCommissionRate($child->bv_points) >= config('services.last_reward');
    })->count();

    foreach ([8, 4, 2, 0] as $level) {
        if ($count >= $level) {
            return $level;
        }
    }
    return 0;
}

function checkEligibilityForGroupReward($user, $userRewardLevel) {
    foreach ($user->children as $child) {
        $childRewardLevel = getUserRewardLevel($child);
        if ($userRewardLevel <= $childRewardLevel) {
            return false;
        }
    }
    return true;
}

function getCategories($type = null)
{
    $cacheKey = 'categories_' . ('all');
    return Cache::remember($cacheKey, 60, function () {
        $categories = Category::where('status', Status::YES);
     return $categories->take(8)->orderBy('name')->get();
    });
}

function getRandomProducts($limit = 4)
{
    return Product::where('status', Status::YES)
        ->inRandomOrder()
        ->take($limit)
        ->get();
}