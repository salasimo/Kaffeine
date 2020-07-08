<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Drink;
use App\Dose;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userLogged = Auth::id();
        $doses = Dose::where('user_id', '=', $userLogged)->orderBy('date', 'DESC')->paginate(5);
        // $drinks = Drink::all();
        $todayDoses = Dose::where('user_id', '=', $userLogged)->where('date', Carbon::now('Europe/Rome')->format('d'));
        return view('user.dashboard.index', ['doses' => $doses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drinks = Drink::all();

        return view('user.dashboard.create', compact('drinks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'drink_id' => 'required|exists:drinks,id',
        ]);
        if ($validator->fails()) {
            return redirect()->route('user.dashboard.create')
                ->withErrors($validator)
                ->withInput();
        }
        $data['user_id'] = Auth::id();
        $data['date'] = Carbon::now('Europe/Rome');

        $dose = new Dose;
        $dose->fill($data);

        $saved = $dose->save();
        if (!$saved) {
            return redirect()->back()->withInput();;
        }

        return redirect()->route('user.dashboard.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dose = Dose::findOrFail($id);
        $user_id = Auth::id();
        if ($user_id != $dose->user_id) {
            abort('404');
        }

        $dose->delete();
        $deleted = $dose->delete();

        if (!$deleted) {
            return redirect()->back(); // aggiungere with status
        }
        return redirect()->route('user.dashboard.index');
    }

    public function stats(Request $request)
    {
        $user_id = Auth::id();
        // $doses = Dose::where('user_id', $user_id)->whereBetween('date', [Carbon::now('Europe/Rome')->startOfWeek(), Carbon::now('Europe/Rome')->endOfWeek()])->get();
        $dosesOfWeek = [];
        for ($i = 6; $i >= 0; $i--) {
            $doseOfTheDay = Dose::where('user_id', $user_id)->whereDate('date', Carbon::now('d')->subDays($i))->join('drinks', 'doses.drink_id', '=', 'drinks.id')->sum('amount');
            $dosesOfWeek[] = $doseOfTheDay;
        }

        return response()->json($dosesOfWeek);
    }
}
