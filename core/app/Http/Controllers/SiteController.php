<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Cookie;


class SiteController extends Controller
{
    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle   = 'Home';
        $sections    = Page::where('tempname', activeTemplate())->where('slug', '/')->first();
        $seoContents = @$sections->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;

        $products =Product::active()
        ->where('is_featured', Status::YES)
        ->get();
        
        return view('Template::home', compact('pageTitle', 'sections', 'products','seoContents', 'seoImage'));
    }

    public function pages($slug)
    {
        $page        = Page::where('tempname', activeTemplate())->where('slug', $slug)->firstOrFail();
        $pageTitle   = $page->name;
        $sections    = $page->secs;
        $seoContents = $page->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::pages', compact('pageTitle', 'sections', 'seoContents', 'seoImage'));
    }


    public function contact()
    {
        $pageTitle   = "Contact Us";
        $user        = auth()->user();
        $sections    = Page::where('tempname', activeTemplate())->where('slug', 'contact')->first();
        $seoContents = $sections->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::contact', compact('pageTitle', 'user', 'sections', 'seoContents', 'seoImage'));
    }


    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        $request->session()->regenerateToken();

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $random = getNumber();

        $ticket           = new SupportTicket();
        $ticket->user_id  = auth()->id() ?? 0;
        $ticket->name     = $request->name;
        $ticket->email    = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;


        $ticket->ticket     = $random;
        $ticket->subject    = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status     = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title     = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message                    = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message           = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug)
    {
        $policy      = Frontend::where('slug', $slug)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle   = $policy->data_values->title;
        $seoContents = $policy->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('policy_pages', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::policy', compact('policy', 'pageTitle', 'seoContents', 'seoImage'));
    }

    public function changeLanguage($lang = null)
    {
        $language          = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blog()
    {
        $pageTitle = 'Blogs';
        $blogs     = Frontend::where('data_keys', 'blog.element')->latest()->paginate(12);
        $sections  = Page::where('tempname', activeTemplate())->where('slug', 'blog')->firstOrFail();
        return view('Template::blog', compact('pageTitle', 'blogs', 'sections'));
    }

    public function blogDetails($slug)
    {
        $pageTitle   = 'Blog Details';
        $blog        = Frontend::where('slug', $slug)->where('data_keys', 'blog.element')->firstOrFail();
        $latestBlogs = Frontend::where('id', '!=', $blog->id)->where('data_keys', 'blog.element')->take(5)->get();
        $seoContents = $blog->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('blog', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::blog_details', compact('blog', 'latestBlogs', 'pageTitle', 'seoContents', 'seoImage'));
    }

    public function faq()
    {
        $pageTitle = 'FAQs';
        $sections  = Page::where('tempname', activeTemplate())->where('slug', 'faq')->firstOrFail();
        return view('Template::faq', compact('pageTitle', 'sections'));
    }


    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public function cookiePolicy()
    {
        $cookieContent = Frontend::where('data_keys', 'cookie.data')->first();
        abort_if($cookieContent->data_values->status != Status::ENABLE, 404);
        $pageTitle = 'Cookie Policy';
        $cookie    = Frontend::where('data_keys', 'cookie.data')->first();
        return view('Template::cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;
        $fontFile  = realpath('assets/font/solaimanLipi_bold.ttf');
        $fontSize  = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgFill);
        $textBox    = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view('Template::maintenance', compact('pageTitle', 'maintenance'));
    }

    public function products($categoryId = null)
    {
        $pageTitle = "Products";
        $products  = Product::query();
        if ($categoryId) {
            $products = $products->where('category_id', $categoryId);
        }
        $products    = $products->active()->with('category')->hasCategory()->paginate(getPaginate(16));
        $categories  = Category::active()->hasActiveProduct()->get()->take(5);
        $sections    = Page::where('tempname', activeTemplate())->where('slug', 'products')->first();
        $seoContents = @$sections->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;

        return view('Template::products', compact('pageTitle', 'products', 'categories', 'categoryId', 'sections', 'seoContents', 'seoImage'));
    }

    public function productDetails($id)
    {
        $pageTitle = "Product Details";
        $product   = Product::active()->hasCategory()->findOrFail($id);
        $relates   = Product::active()->hasCategory()->where('category_id', $product->category_id)->where('id', '!=', $product->id)->latest()->limit(10)->get();

        $seoContents['social_title']       = $product->meta_title;
        $seoContents['keywords']           = $product->meta_keyword;
        $seoContents['description']        = strLimit(strip_tags($product->meta_description), 150);
        $seoContents['social_description'] = strLimit(strip_tags($product->meta_description), 150);
        $seoContents['image_size']         = getFileSize('products');
        $seoImage                          = getImage(getFilePath('products') . '/' . @$product->thumbnail, getFileSize('products'));
        return view('Template::product_detail', compact('pageTitle', 'product', 'relates', 'seoContents', 'seoImage'));
    }

    public function checkUsername(Request $request)
    {
        $id = User::where('username', $request->username)->first();
        if ($id) {
            return response()->json(['success' => true, 'msg' => "<span class='help-block'><strong class='text-success'>Referrer username matched</strong></span>
            <input type='hidden' id='referrer_id' value='$id->id' name='referrer_id'>"]);
        } else {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Referrer username not found</strong></span>"]);
        }
    }

    public function userPosition(Request $request)
    {

        if (!$request->referrer) {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Inter Referral name first</strong></span>"]);
        }
        if (!$request->position) {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Select your position*</strong></span>"]);
        }
        $user       = User::find($request->referrer);
        $pos        = getPosition($user->id, $request->position);
        $join_under = User::find($pos['pos_id']);
        if ($pos['position'] == 1)
            $position = 'Left';
        else {
            $position = 'Right';
        }
        return response()->json(['success' => true, 'msg' => "<span class='help-block'><strong class='text-success'>You are joining under $join_under->username at $position  </strong></span>"]);
    }

    public function shoppingCart()
    {
        $pageTitle   = "Shopping Cart";
        $sections    = Page::where('tempname', activeTemplate())->where('slug', 'shopping-cart')->first();
        $seoContents = @$sections->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::shopping_cart', compact('pageTitle', 'sections', 'seoContents', 'seoImage'));
    }
}
