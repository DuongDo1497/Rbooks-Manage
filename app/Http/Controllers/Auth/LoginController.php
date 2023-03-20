<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        //$role = Auth()->user()->roles()->first()->name;
        //$parameter = Crypt::encrypt(Auth()->user()->id);
        $division = Auth()->user()->employee()->first()->division()->first()->code_division;

            // Check user role
        switch ($division) {
            case 'BIENDICH':
                    return redirect(route('translate_ones-index'));
                break;
            case 'DESIGN':
                    return redirect(route('design_ones-index'));
                break;    
            case 'MARKETING':
                    return redirect(route('marketing_ones-index'));
                break;
            case 'WRITING':
                    return redirect(route('writing_sach_rbooks-index-1'));
                break;
            case 'IT':
                    return redirect(route('it_ones-index'));
                break;
            case 'SALES':
                    return redirect(route('sales_ones-index'));
                break;
            case 'KETOAN':
                    return redirect(route('account_ones-index'));
                break;
            case 'NHANSU':
                    return redirect(route('hr_others-index'));
                break;
            case 'DATA':
                    return redirect(route('data_others-index'));
                break;
            default:
                    return redirect('/');
                break;
        }
    }

    // protected function redirectTo()
    // {
    //     $role = Auth()->user()->roles()->first()->name;
    //     $user_id = Auth()->user()->id;
    //         // Check user role
    //     switch ($role) {
    //         case 'nv':
    //                 return Redirect::route('users-detail', ['id' => $user_id]);
    //             break;
    //         case 'admin':
    //                 return '/';
    //             break;
    //         default:
    //                 return '/login';
    //             break;
    //     }
    // }
}
