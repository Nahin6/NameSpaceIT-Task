<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Throttle;
use Illuminate\Support\Str;
use App\Models\UrlShorten;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class urlController extends Controller
{


    public function urlShorten(Request $request)
    {

        if (Auth::check()) {

            $request->validate([
                'title' => 'required',
                'original_url' => 'required',
            ]);


        //     $ip = $request->ip();
            $key = Str::random(6);


        $url =   urlShorten::create([
                'title' => $request->input('title'),
                'original_url' => $request->input('original_url'),
                'shortened_url' => $key,
                'user_id' => auth()->id(),
            ]);

            $shortenedUrl = url('/') . '/' . $key;

            return view('dashboard', [
                'shortenedUrl' => $shortenedUrl,
                'successMessage' => 'URL shortened successfully!',
            ]);
        }
        else{
            return view("auth/login");
        }
    }
    public function redirectToOriginalUrl($key)
    {

        $url = urlShorten::where('shortened_url', $key)->first();

        if ($url) {
            return redirect($url->original_url);
        } else {

            abort(404);
        }
    }
    // public function urlPage(){
    //     return view('layouts.urlPage');
    // }
    public function loginPageLoader(){
        return view('auth.login');
    }
    public function regPageLoader(){
        return view('auth.register');
    }
    public function showLink(){
        $url = urlShorten::where('user_id', Auth::User()->id)->orderby('id', 'desc')->get();

        return view('layouts.urlPage', compact('url'));
    }
    public function logoutPageLoader(){
        Auth::logout();
        return redirect('/');
    }

    public function displayErrorPage($blockDuration)
    {
        $errorMessage = session('errors.message') ?? 'Default error message';
        return view('errorPage', compact('errorMessage'));

    }
}
