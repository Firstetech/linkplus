<?php

namespace App\Http\Controllers;

use App\Setting;
use Faker\Factory;
use MatthiasMullie\Minify;
use Illuminate\Http\Request;
use Iodev\Whois\Factory as Whois;
use Illuminate\Support\Facades\DB;
use GeoIp2\Database\Reader as GeoIP;
use Illuminate\Support\Facades\Hash;

class WebToolsController extends Controller
{
    // HTML Beautifier
    public function htmlBeautifier()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.html-beautifier', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // HTML Minifier
    public function htmlMinifier()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.html-minifier', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // CSS Beautifier
    public function cssBeautifier()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.css-beautifier', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // CSS Minifier
    public function cssMinifier()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.css-minifier', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // CSS Minifier Result 
    public function resultCssMinifier(Request $request)
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Request parameter
            $css = $request->css;

            // Minifier
            $minifier = new Minify\CSS($request->css);
            $results = $minifier->minify();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.css-minifier', compact('supportPage', 'css', 'results', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Random Password Generator
    public function randomPasswordGenerator()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.random-password-generator', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Bcrypt Password Generator
    public function bcryptPasswordGenerator()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.bcrypt-password-generator', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Bcrypt Password Generator Result 
    public function resultBcryptPasswordGenerator(Request $request)
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Request parameter
            $password = $request->password;

            // Bcrypt Password Generator
            $results = bcrypt($password);

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.bcrypt-password-generator', compact('supportPage', 'password', 'results', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // MD5 Password Generator
    public function md5PasswordGenerator()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.md5-password-generator', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // MD5 Password Generator Result 
    public function resultMd5PasswordGenerator(Request $request)
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Request parameter
            $password = $request->password;

            // MD5 Password Generator
            $results = md5($password);

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.md5-password-generator', compact('supportPage', 'password', 'results', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Random Word Generator
    public function randomWordGenerator()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.random-word-generator', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Random Word Generator Result 
    public function resultRandomWordGenerator(Request $request)
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Request parameter
            $words = $request->words;
            $words_ = [];

            if ($words < 9999) {
                // Random Word Generator
                $faker = Factory::create();
                for ($i = 0; $i < $words; $i++) {
                    $words_[] = $faker->word;
                }

                $count = (int)$words;
                $results = implode(', ', $words_);
            } else {
                $count = (int)$words;
                $results = trans('Maximum limit reached');
            }

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.random-word-generator', compact('supportPage', 'count', 'results', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Text Counter
    public function textCounter()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.text-counter', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Lorem Generator
    public function loremGenerator()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.lorem-generator', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Emojies
    public function emojies()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.emojies', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // JS Beautifier
    public function jsBeautifier()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.js-beautifier', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // JS Minifier
    public function jsMinifier()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.js-minifier', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // JS Minifier Result 
    public function resultjsMinifier(Request $request)
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Request parameter
            $js = $request->js;

            // Minifier
            $minifier = new Minify\JS($request->js);
            $results = $minifier->minify();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.js-minifier', compact('supportPage', 'js', 'results', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // DNS
    public function dnsLookup()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.dns', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // DNS Result 
    public function resultDnsLookup(Request $request)
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Queries
            $domain = str_replace(['http://', 'https://'], '', $request->input('domain'));

            try {
                $results = dns_get_record($domain, DNS_A + DNS_AAAA + DNS_CNAME + DNS_MX + DNS_TXT + DNS_NS);
            } catch (\Exception $e) {
                $results = [];
            }

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.dns', compact('supportPage', 'results', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // IP Address
    public function ipLookup()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.ip', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // IP Result 
    public function resultIpLookup(Request $request)
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Queries
            try {
                $results = (new GeoIP(storage_path('app/geoip/GeoLite2-City.mmdb')))->city($request->input('ip'))->raw;
            } catch (\Exception $e) {
                $results = false;
            }

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.ip', compact('supportPage', 'results', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Whois Address
    public function whoisLookup()
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.whois', compact('supportPage', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    // Whois Result 
    public function resultWhoisLookup(Request $request)
    {
        // Queries
        $config = DB::table('config')->get();

        // Check website
        if ($config[38]->config_value == "yes") {
            $settings = Setting::where('status', 1)->first();
            $supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

            // Input
            $domain = str_replace(['http://', 'https://', 'www.', 'http://www.', 'https://www.'], '', $request->input('domain'));

            $results = false;
            try {
                $results = Whois::get()->createWhois()->loadDomainInfo($domain);
            } catch (\Exception $e) {
                $results = [];
            }

            // Check webtools
            if ($settings->google_adsense_code != 'DISABLE_BOTH') {
                return view('pages.web-tools.whois', compact('supportPage', 'results', 'settings', 'config'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }


    // Random word generator function
    function getRandomWord($len)
    {
        $word = array_merge(range('a', 'z'), range('A', 'Z'));
        shuffle($word);
        return substr(implode($word), 0, $len);
    }
}
