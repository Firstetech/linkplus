<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Setting;
use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function index()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $homePage = DB::table('pages')->where('page_name', 'home')->get();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();
            $plans = Plan::where('status', 1)->where('is_private', '0')->get();
            $settings = Setting::where('status', 1)->first();
            $currency = Currency::where('iso_code', $config['1']->config_value)->first();

            // Seo Tools
            SEOTools::setTitle($homePage[0]->title);
            SEOTools::setDescription($homePage[0]->description);

            SEOMeta::setTitle($homePage[0]->title);
            SEOMeta::setDescription($homePage[0]->description);
            SEOMeta::addMeta('article:section', ucfirst($homePage[0]->page_name) . ' - ' . $homePage[0]->title, 'property');
            SEOMeta::addKeyword([$homePage[0]->keywords]);

            OpenGraph::setTitle($homePage[0]->title);
            OpenGraph::setDescription($homePage[0]->description);
            OpenGraph::setUrl(URL::full());
            OpenGraph::addImage([asset($settings->site_logo), 'size' => 300]);

            JsonLd::setTitle($homePage[0]->title);
            JsonLd::setDescription($homePage[0]->description);
            JsonLd::addImage(asset($settings->site_logo));

            return view('web', compact('homePage', 'supportPage', 'plans', 'settings', 'currency', 'config'));
        } else {
            return redirect('/login');
        }
    }

    public function faq()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            // Pages
            $page = DB::table('pages')->where('page_name', 'faq')->where('status', "active")->get();

            // Check page
            if (!$page->isEmpty()) {
                $faqPage = DB::table('pages')->where('page_name', 'faq')->get();
                $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();
                $settings = Setting::where('status', 1)->first();

                // Seo Tools
                SEOTools::setTitle($faqPage[0]->title);
                SEOTools::setDescription($faqPage[0]->description);

                SEOMeta::setTitle($faqPage[0]->title);
                SEOMeta::setDescription($faqPage[0]->description);
                SEOMeta::addMeta('article:section', ucfirst($faqPage[0]->page_name) . ' - ' . $faqPage[0]->title, 'property');
                SEOMeta::addKeyword([$faqPage[0]->keywords]);

                OpenGraph::setTitle($faqPage[0]->title);
                OpenGraph::setDescription($faqPage[0]->description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($settings->site_logo), 'size' => 300]);

                JsonLd::setTitle($faqPage[0]->title);
                JsonLd::setDescription($faqPage[0]->description);
                JsonLd::addImage(asset($settings->site_logo));

                return view('pages/faq', compact('faqPage', 'supportPage', 'settings', 'config'));
            } else {
                abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    public function privacyPolicy()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            // Pages
            $page = DB::table('pages')->where('page_name', 'privacy')->where('status', "active")->get();

            // Check page
            if (!$page->isEmpty()) {
                $privacyPage = DB::table('pages')->where('page_name', 'privacy')->get();
                $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();
                $settings = Setting::where('status', 1)->first();

                // Seo Tools
                SEOTools::setTitle($privacyPage[0]->title);
                SEOTools::setDescription($privacyPage[0]->description);

                SEOMeta::setTitle($privacyPage[0]->title);
                SEOMeta::setDescription($privacyPage[0]->description);
                SEOMeta::addMeta('article:section', ucfirst($privacyPage[0]->page_name) . ' - ' . $privacyPage[0]->title, 'property');
                SEOMeta::addKeyword([$privacyPage[0]->keywords]);

                OpenGraph::setTitle($privacyPage[0]->title);
                OpenGraph::setDescription($privacyPage[0]->description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($settings->site_logo), 'size' => 300]);

                JsonLd::setTitle($privacyPage[0]->title);
                JsonLd::setDescription($privacyPage[0]->description);
                JsonLd::addImage(asset($settings->site_logo));

                return view('pages/privacy', compact('privacyPage', 'supportPage', 'settings', 'config'));
            } else {
                abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    public function refundPolicy()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            // Pages
            $page = DB::table('pages')->where('page_name', 'refund')->where('status', "active")->get();

            // Check page
            if (!$page->isEmpty()) {
                $refundPage = DB::table('pages')->where('page_name', 'refund')->get();
                $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();
                $settings = Setting::where('status', 1)->first();

                // Seo Tools
                SEOTools::setTitle($refundPage[0]->title);
                SEOTools::setDescription($refundPage[0]->description);

                SEOMeta::setTitle($refundPage[0]->title);
                SEOMeta::setDescription($refundPage[0]->description);
                SEOMeta::addMeta('article:section', ucfirst($refundPage[0]->page_name) . ' - ' . $refundPage[0]->title, 'property');
                SEOMeta::addKeyword([$refundPage[0]->keywords]);

                OpenGraph::setTitle($refundPage[0]->title);
                OpenGraph::setDescription($refundPage[0]->description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($settings->site_logo), 'size' => 300]);

                JsonLd::setTitle($refundPage[0]->title);
                JsonLd::setDescription($refundPage[0]->description);
                JsonLd::addImage(asset($settings->site_logo));

                return view('pages/refund', compact('refundPage', 'supportPage', 'settings', 'config'));
            } else {
                abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    public function termsAndConditions()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            // Pages
            $page = DB::table('pages')->where('page_name', 'terms')->where('status', "active")->get();

            // Check page
            if (!$page->isEmpty()) {
                $termsPage = DB::table('pages')->where('page_name', 'terms')->get();
                $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();
                $settings = Setting::where('status', 1)->first();

                // Seo Tools
                SEOTools::setTitle($termsPage[0]->title);
                SEOTools::setDescription($termsPage[0]->description);

                SEOMeta::setTitle($termsPage[0]->title);
                SEOMeta::setDescription($termsPage[0]->description);
                SEOMeta::addMeta('article:section', ucfirst($termsPage[0]->page_name) . ' - ' . $termsPage[0]->title, 'property');
                SEOMeta::addKeyword([$termsPage[0]->keywords]);

                OpenGraph::setTitle($termsPage[0]->title);
                OpenGraph::setDescription($termsPage[0]->description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($settings->site_logo), 'size' => 300]);

                JsonLd::setTitle($termsPage[0]->title);
                JsonLd::setDescription($termsPage[0]->description);
                JsonLd::addImage(asset($settings->site_logo));

                return view('pages/terms', compact('termsPage', 'supportPage', 'settings', 'config'));
            } else {
                abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    public function about()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            // Pages
            $page = DB::table('pages')->where('page_name', 'about')->where('status', "active")->get();

            // Check page
            if (!$page->isEmpty()) {
                $aboutPage = DB::table('pages')->where('page_name', 'about')->get();
                $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();
                $settings = Setting::where('status', 1)->first();

                // Seo Tools
                SEOTools::setTitle($aboutPage[0]->title);
                SEOTools::setDescription($aboutPage[0]->description);

                SEOMeta::setTitle($aboutPage[0]->title);
                SEOMeta::setDescription($aboutPage[0]->description);
                SEOMeta::addMeta('article:section', ucfirst($aboutPage[0]->page_name) . ' - ' . $aboutPage[0]->title, 'property');
                SEOMeta::addKeyword([$aboutPage[0]->keywords]);

                OpenGraph::setTitle($aboutPage[0]->title);
                OpenGraph::setDescription($aboutPage[0]->description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($settings->site_logo), 'size' => 300]);

                JsonLd::setTitle($aboutPage[0]->title);
                JsonLd::setDescription($aboutPage[0]->description);
                JsonLd::addImage(asset($settings->site_logo));

                return view('pages/about', compact('aboutPage', 'supportPage', 'settings', 'config'));
            } else {
                abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    public function contact()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            // Pages
            $page = DB::table('pages')->where('page_name', 'contact')->where('status', "active")->get();

            // Check page
            if (!$page->isEmpty()) {
                $contactPage = DB::table('pages')->where('page_name', 'contact')->get();
                $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();
                $settings = Setting::where('status', 1)->first();

                // Seo Tools
                SEOTools::setTitle($contactPage[0]->title);
                SEOTools::setDescription($contactPage[0]->description);

                SEOMeta::setTitle($contactPage[0]->title);
                SEOMeta::setDescription($contactPage[0]->description);
                SEOMeta::addMeta('article:section', ucfirst($contactPage[0]->page_name) . ' - ' . $contactPage[0]->title, 'property');
                SEOMeta::addKeyword([$contactPage[0]->keywords]);

                OpenGraph::setTitle($contactPage[0]->title);
                OpenGraph::setDescription($contactPage[0]->description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($settings->site_logo), 'size' => 300]);

                JsonLd::setTitle($contactPage[0]->title);
                JsonLd::setDescription($contactPage[0]->description);
                JsonLd::addImage(asset($settings->site_logo));

                return view('pages/contact', compact('contactPage', 'supportPage', 'settings', 'config'));
            } else {
                abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Custom pages
    public function customPage($id)
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            // Get page details
            $page = DB::table('pages')->where('section_title', $id)->where('status', "active")->first();

            if (!empty($page)) {
                $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();
                $settings = Setting::where('status', 1)->first();

                // Seo Tools
                SEOTools::setTitle($page->title);
                SEOTools::setDescription($page->description);

                SEOMeta::setTitle($page->title);
                SEOMeta::setDescription($page->description);
                SEOMeta::addMeta('article:section', $page->title, 'property');
                SEOMeta::addKeyword([$page->keywords]);

                OpenGraph::setTitle($page->title);
                OpenGraph::setDescription($page->description);
                OpenGraph::setUrl(URL::full());
                OpenGraph::addImage([asset($settings->site_logo), 'size' => 300]);

                JsonLd::setTitle($page->title);
                JsonLd::setDescription($page->description);
                JsonLd::addImage(asset($settings->site_logo));

                // View page
                return view("pages.custom-page", compact('page', 'supportPage', 'config', 'settings'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }
}
