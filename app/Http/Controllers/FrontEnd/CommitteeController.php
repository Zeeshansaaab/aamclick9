<?php

namespace App\Http\Controllers\FrontEnd;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\CommitteeUser;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::committee()->parent()->whereStatus('active')->get();
        return view('frontend.committee.index', compact('plans'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $plan = auth()->user()->committees()->with('plan')->where('plan_id', $request->plan_id)->first();
            if($plan){
                if(Carbon::parse($plan->plan->starting_date)->lessThanOrEqualTo(Carbon::now())){
                    return view('frontend.committee.committee-number', compact('plan'));
                }
                return response()->json([
                    'status' => JsonResponse::HTTP_OK,
                    'message' => "You have already applied for this committee"
                ]);
            }
            auth()->user()->committees()->create([
                'plan_id' => $request->plan_id
            ]);
            return response()->json([
                'status'  => JsonResponse::HTTP_OK,
                'message' => "10 members poory hone ka intezar kre",
                'data'    => CommitteeUser::where('plan_id', $request->plan_id)->count(),
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $plan = Plan::where('uuid', $uuid)->firstOrFail();
        $plans = $plan->plans()->withCount('members')->get();
        return view('frontend.committee.show', compact('plans'));
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
