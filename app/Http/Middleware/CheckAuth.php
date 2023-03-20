<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use RBooks\Services\APIAdminService;

class CheckAuth {

    /**
     * Instance of Session Store
     * @var session
     */
    protected $session;

    /**
     * Time for user to remain active, set to 900secs( 15minutes )
     * @var timeout
     */
    protected $timeout = 900;

    public function __construct(Store $session){
        $this->session        = $session;
        $this->redirectUrl    = '/login';
        $this->sessionLabel   = 'warning';
        $this->checkRole      = '';
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Kiem tra session time out sau 15 phut khong su dung
        if(! $this->session->has('lastActivityTime'))
        {
            $this->session->put('lastActivityTime', time());
        }
        else if( time() - $this->session->get('lastActivityTime') > $this->getTimeOut()*60)
        {
            $this->session->forget('lastActivityTime');
            Auth::logout();
            return redirect($this->getRedirectUrl())->with([ $this->getSessionLabel() => 'You have been inactive for '. $this->timeout/60 .' minutes ago.']);
        }
        $this->session->put('lastActivityTime',time());

        //Kiem tra user duoc phep truy cap chuc nang ?
        $role = Auth()->user()->role;
        if ($this->getCheckRole() != '' and $role != $this->getCheckRole()){
            return redirect('/apiadmin/access');
        }
        //Kiem tra page duoc phep view khong ?
        $routename = $request->route()->getName();
//         if (app(APIAdminService::class)->hasAnyRole($role, $routename, 'cview') == 0){
// //            return redirect('/apiadmin/access');
//         }

        return $next($request);
    }

    /**
     * Get timeout from laravel default's session lifetime, if it's not set/empty, set timeout to 15 minutes
     * @return int
     */
    private function getTimeOut()
    {
        return  (env('SESSION_LIFETIME')) ?: $this->timeout;
    }

    /**
     * Get redirect url from env file
     * @return string
     */
    private function getRedirectUrl()
    {
        return  (env('SESSION_TIMEOUT_REDIRECTURL')) ?: $this->redirectUrl;
    }

    /**
     * Get Session label from env file
     * @return string
     */
    private function getSessionLabel()
    {
        return  (env('SESSION_LABEL')) ?: $this->sessionLabel;
    }

    /**
     * Get Check role from env file
     * @return string
     */
    private function getCheckRole()
    {
        return  (env('CHECK_ROLE')) ?: $this->checkRole;
    }
}
