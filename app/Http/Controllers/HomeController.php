<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\PatientSick;
use App\Models\Sick;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
    public function index()
    {
        return view('home');
    }

    public function patients()
    {
        $patients = Patient::all();
        return view('pages.patients')
            ->with('patients',$patients)
            ;
    }

    public function patient($id)
    {

        $apps = Appointment::all()->where('pid','=',$id);
        $show = Patient::find($id);
        $patients = Patient::all();
        $drs = Doctor::all();
        $sicks = Sick::all();

        $ps = PatientSick::all();

        return view('pages.patient')
            ->with('patients',$patients)
            ->with('show',$show)
            ->with('apps',$apps)
            ->with('ps',$ps)
            ->with('drs',$drs)
            ->with('sicks',$sicks)
            ;
    }

    public function appointmentStore(Request $request){
        //return $request->cid;
        ///*
        if($request->cid != '' || $request->cid != null){
            foreach ($request->cid as $xs){
                DB::table('patient_sicks')->where('pid',$request->pid)->insert([
                    'pid' => $request->pid,
                    'cid' => $xs,
                ]);
            }

            $string = implode(',', $request->cid);

            $app = new Appointment;
            $app->pid = $request->pid;
            $app->cid = $string;
            $app->toDr = $request->toDr;
            $app->appointmentDate = $request->appointmentDate;
            $app->status = 'Pending';
            $app->note = $request->note;
            $app->save();
        }else{
            DB::table('patient_sicks')->where('pid',$request->pid)->insert([
                'pid' => $request->pid,
                'cid' => '',
            ]);
            $app = new Appointment;
            $app->pid = $request->pid;
            $app->cid = null;
            $app->toDr = $request->toDr;
            $app->appointmentDate = $request->appointmentDate;
            $app->status = 'Pending';
            $app->note = $request->note;
            $app->save();
        }



        return redirect()->back();


    }

}
