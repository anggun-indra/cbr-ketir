<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Kasus;
use TextAnalysis\Comparisons\CosineSimilarityComparison;
use TextAnalysis\Tokenizers\GeneralTokenizer;
use Gate;

class CbrCoSimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Sorry, You can do this actions");
        }
        $kasusBaru = null;
        $kasus = Kasus::all();
        return view('cbrcos.index',compact('kasus','kasusBaru'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $kasus = Kasus::all();

        $kasusBaru = [];
//        $text1 = ["hiking" , "hiking" , "camping", "swimming"];
//        $text2 = ["hiking" , "biking" , "camping", "swimming"];

        $tokenizer = new GeneralTokenizer(" ");

//        $text1 = $tokenizer->tokenize("This has some words");
//        $text2 = $tokenizer->tokenize("This has some wordsx");
        $arrResult = [];
        $compare = new CosineSimilarityComparison();
//        $result = $compare->similarity($text1, $text2);

//        var_dump($text1);
//        var_dump($text2);
//        var_dump($result);
//        var_dump($kasus);
//        print_r($result);

        $arrCbrRes = [];
        $i = 0;
        foreach ($kasus as $val){
            $fact1 = strtolower(trim($request->fact1));
            $fact2 = strtolower(trim($request->fact2));
            $fact3 = strtolower(trim($request->fact3));
            $fact4 = strtolower(trim($request->fact4));

            $kasusBaru['fact1'] = $fact1;
            $kasusBaru['fact2'] = $fact2;
            $kasusBaru['fact3'] = $fact3;
            $kasusBaru['fact4'] = $fact4;

            //fact 1
            $arrFact1 = $tokenizer->tokenize($fact1);
            $arrFact1a = $tokenizer->tokenize(strtolower($val->fact1));
            $val->result1 = $compare->similarity($arrFact1, $arrFact1a) * $val->fact1w;

            //fact 2
            $arrFact2 = $tokenizer->tokenize($fact2);
            $arrFact2a = $tokenizer->tokenize(strtolower($val->fact2));
            $val->result2 = $compare->similarity($arrFact2, $arrFact2a) * $val->fact2w;

            //fact 3
            $arrFact3 = $tokenizer->tokenize($fact3);
            $arrFact3a = $tokenizer->tokenize(strtolower($val->fact3));
            $val->result3 = $compare->similarity($arrFact3, $arrFact3a) * $val->fact3w;

            //fact 4
            $arrFact4 = $tokenizer->tokenize($fact4);
            $arrFact4a = $tokenizer->tokenize(strtolower($val->fact4));
            $val->result4 = $compare->similarity($arrFact4, $arrFact4a) * $val->fact4w;

            $val->totalWeight = $val->fact1w + $val->fact2w + $val->fact3w + $val->fact4w;

            $val->result = (1/$val->totalWeight) * ($val->result1+$val->result2+$val->result3+$val->result4);
//            var_dump($val);
            $arrCbrRes[$i] = $val;
            $i++;
        }

        usort($arrCbrRes,function($first,$second){
            return $first->result < $second->result;
        });

        return view('cbrcos.index',compact('kasusBaru','arrCbrRes'));
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
    public function update(Request $request)
    {

        $kasus = Kasus::findOrFail($request->kas_id);

        $kasus->update($request->all());
       
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $kasus = Kasus::findOrFail($request->kas_id);
        $kasus->delete();

        return back();

    }
}
