<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\User;
use App\VacationDate;

class PagesController extends Controller
{    
    private $errors = [
        'a' => 'user_not_exist',
        'b' => 'acess_denied',
        'c' => 'action_is_undefined'
    ];

    private function error($error = 'a')
    {
        return ['error' => $this->errors[$error]];
    }
    
    public function index()
    {
        if(Auth::check()) return redirect()->route('manage.index');
        $users = User::all();
        return view('home', ['users' => $users]);
    }

    public function manage()
    {
        if(!Auth::check()) return redirect()->route('login');
        $user = Auth::user();
        $format = 'Y-m-d';
        $minDateLeave = Carbon::now()->addDays(7)->format($format);
        $minDateBack = Carbon::now()->addDays(10)->format($format);
        $vacations = VacationDate::where('user_id', '!=',$user->id)->get();
        $isMain = $user->hasRole('Руководитель') ? true : false;

        return view('manage.index', ['user' => $user, 'minDateLeave' => $minDateLeave,  'minDateBack' => $minDateBack,'vacations' => $vacations, 'isMain' => $isMain]);
    }

    public function auth($action, $userId = null)
    {
        $login = $action == 'login' ? true : false;
        $response = ['stat' => 'logged_out'];
        $user = User::find($userId);
        
        if($login && !empty($user)):
            if(!Auth::check()):
                Auth::login($user, false);
                $response['stat'] = 'logged';
            else:
                $response['stat'] = 'already_logged';
            endif;
        else:
            Auth::logout();
        endif;
        
        return response()->json($response);
    }

    public function vacation(Request $request)
    {
        $response = ['stat' => 'requested'];
        $user = Auth::user();
        if(!empty($user)):
            if(!empty($user->vacation) && $user->vacation->accepted):
                $response = ['warning' => 'Отпуск согласован'];
            else:
                $minDateLeave = Carbon::now()->addDays(7);
                $minDateBack = Carbon::now()->addDays(10);
                $requestDateLeave = $request->leave ? Carbon::parse($request->leave) : $minDateLeave;
                $requestDateBack = $request->back ? Carbon::parse($request->back) : $minDateBack;
                $vacationDateLeave = $minDateLeave->gte($requestDateLeave) ? $minDateLeave : $requestDateLeave;
                $vacationDateBack = $minDateBack->gte($requestDateBack) ? $minDateBack : $requestDateBack;
                ($vacationDateLeave->diffInDays($vacationDateBack, false) < 3)&&($vacationDateBack = $vacationDateLeave->copy()->addDays(3));
                $vacation = VacationDate::firstOrCreate(['user_id' => $user->id]);
                $vacation->update(['leave' => $vacationDateLeave, 'back' => $vacationDateBack]);
            endif;
        else:
            $response = $this->error();
        endif;
        
        return response()->json($response);
    }

    public function updateVacation(Request $request)
    {
        $response = $this->error('c');
        if(Auth::check() && Auth::user()->hasRole('Руководитель')):
            $action = $request->action;
            if(in_array($action, ['accept', 'refuse']) && !empty($request->user)):
                $user = User::find($request->user);
                if(!empty($user)):
                    if($user->vacation->accepted):
                        $response = ['stat' => 'already_updated'];
                    else:
                        $update = $action == 'accept' ? [1, 'accepted'] : [2, 'refused'];
                        $user->vacation->update(['accepted' => $update[0]]);
                        $response = ['stat' => $update[1]];
                    endif;
                else:
                    $response = $this->error();
                endif;
            elseif($action == 'clear'):
                VacationDate::truncate();
                $response = ['stat' => 'cleared'];
            endif;
        else:
            $response = $this->error('b');
        endif;

        return response()->json($response);
    }
}