<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //  Pages
    public function index()
    {
        // Static pages
        $pages = DB::table('pages')->where('page_name', 'home')->orWhere('page_name', 'about')->orWhere('page_name', 'contact')
            ->orWhere('page_name', 'faq')->orWhere('page_name', 'pricing')->orWhere('page_name', 'privacy')->orWhere('page_name', 'footer')
            ->orWhere('page_name', 'refund')->orWhere('page_name', 'terms')->get()->groupBy('page_name');
        // Custom pages
        $custom_pages = DB::table('pages')->where('page_name', 'Custom Page')->get();

        // Queries
        $settings = Setting::first();
        $config = DB::table('config')->get();

        // View
        return view('admin.pages.index', compact('pages', 'custom_pages', 'settings', 'config'));
    }

    // Add page
    public function addPage()
    {
        // Queries
        $config = DB::table('config')->get();
        $settings = Setting::first();

        // View
        return view('admin.pages.add', compact('settings', 'config'));
    }

    // Save page
    public function savePage(Request $request)
    {
        // Validation
        $validator = $request->validate([
            'page_name' => 'required',
            'slug' => 'required',
            'body' => 'required',
            'title' => 'required',
            'description' => 'required',
            'keywords' => 'required'
        ]);

        // Update page
        $page = new Page();
        $page->page_name = "Custom Page";
        $page->section_name = ucfirst($request->page_name);
        $page->section_title = $request->slug;
        $page->section_content = Purifier::clean($request->body);
        $page->title = ucfirst($request->title);
        $page->description = ucfirst($request->description);
        $page->keywords = $request->keywords;
        $page->save();

        return redirect()->back()->with('success', trans('Page Saved Successfully!'));
    }

    // Edit custom page
    public function editCustomPage($id)
    {
        // Get page details
        $page = DB::table('pages')->where('id', $id)->first();
        $settings = Setting::first();
        $config = DB::table('config')->get();

        // View
        return view('admin.pages.custom-edit', compact('page', 'settings', 'config'));
    }

    // Edit page
    public function editPage($id)
    {
        // Get page details
        $sections = DB::table('pages')->where('page_name', $id)->get();
        $settings = Setting::first();
        $config = DB::table('config')->get();

        // View
        return view('admin.pages.edit', compact('sections', 'settings', 'config'));
    }

    // Update page
    public function updatePage(Request $request, $id)
    {
        // Update page
        $sections = DB::table('pages')->where('page_name', $id)->get();
        for ($i = 0; $i < count($sections); $i++) {
            $safe_section_content = $request->input('section' . $i);
            DB::table('pages')->where('page_name', $id)->where('id', $sections[$i]->id)->update(['section_content' => $safe_section_content]);
            DB::table('pages')->where('page_name', $id)->where('id', $sections[$i]->id)->update(['description' => $request->description, 'keywords' => $request->keywords]);
        }

        // SEO
        DB::table('pages')->where('page_name', $id)->update(['title' => $request->title]);
        DB::table('pages')->where('page_name', $id)->update(['keywords' => $request->keywords]);
        DB::table('pages')->where('page_name', $id)->update(['description' => $request->description]);

        // Page redirect
        return redirect()->route('admin.pages')->with('success', trans('Website Content Updated Successfully!'));
    }

    // Update custom page
    public function updateCustomPage(Request $request)
    {
        // Validation
        $validator = $request->validate([
            'page_name' => 'required',
            'slug' => 'required',
            'body' => 'required',
            'title' => 'required',
            'description' => 'required',
            'keywords' => 'required'
        ]);

        // Update page
        DB::table('pages')->where('id', $request->page_id)->update(['section_name' => $request->page_name, 'section_title' => $request->slug, 'section_content' => Purifier::clean($request->body), 'title' => $request->title, 'description' => $request->description, 'keywords' => $request->keywords]);

        return redirect()->back()->with('success', trans('Page Updated Successfully!'));
    }

    // Status Page
    public function statusPage(Request $request)
    {
        // Get plan details
        $page_details = DB::table('pages')->where('id', $request->query('id'))->first();

        // Check status
        if ($page_details->status == 'inactive') {
            $status = 'active';
        } else {
            $status = 'inactive';
        }

        // Update status
        DB::table('pages')->where('id', $request->query('id'))->update(['status' => $status]);
        return redirect()->back()->with('success', trans('Page Status Updated Successfully!'));
    }

    // Disable Page
    public function disablePage(Request $request)
    {
        // Get plan details
        $page_details = DB::table('pages')->where('page_name', $request->query('id'))->first();

        // Check status
        if ($page_details->status == 'inactive') {
            $status = 'active';
        } else {
            $status = 'inactive';
        }

        // Update status
        DB::table('pages')->where('page_name', $request->query('id'))->update(['status' => $status]);
        return redirect()->back()->with('success', trans('Page Status Updated Successfully!'));
    }

    // Delete Page
    public function deletePage(Request $request)
    {
        // Update status
        DB::table('pages')->where('id', $request->query('id'))->delete();
        return redirect()->back()->with('success', trans('Page Deleted Successfully!'));
    }
}
