<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Kasus;
use TextAnalysis\Comparisons\HammingDistanceComparison;
use TextAnalysis\Tokenizers\GeneralTokenizer;
use Gate;

class CbrDiSimController extends Controller
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
        return view('cbrdis.index',compact('kasus','kasusBaru'));
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
//        $text1 = "hikinghikingcampingswimminghikinghikingcampingswimminghikinghikingcampingswimming";
//        $text2 = "hikingbikingswimminghikinghikingswimminghikinghikingcampingswimminggasdadd";

//        $tokenizer = new GeneralTokenizer(" ");

//        $text1 = $tokenizer->tokenize("This has some words");
//        $text2 = $tokenizer->tokenize("This has some wordsx");
        $arrResult = [];
        $compare = new HammingDistanceComparison();
        //$result = $compare->distance($text1, $text2);

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

            $arrFact1 = str_replace(" ","",$fact1);
            $arrFact1a = str_replace(" ","",strtolower($val->fact1));

            if(strlen($arrFact1) > strlen($arrFact1a)){
                $arrFact1a = str_pad($arrFact1a,strlen($arrFact1));
            }else if (strlen($arrFact1) < strlen($arrFact1a)){
                $arrFact1 = str_pad($arrFact1,strlen($arrFact1a));
            }
            try {
                $val->result1 = $compare->distance($arrFact1, $arrFact1a) * $val->fact1w;
            }catch (exception $e){
                var_dump($e);
            }

            //fact 2
            $arrFact2 = str_replace(" ","",$fact2);
            $arrFact2a = str_replace(" ","",strtolower($val->fact2));

            if(strlen($arrFact2) > strlen($arrFact2a)){
                $arrFact2a = str_pad($arrFact1a,strlen($arrFact2));
            }else if (strlen($arrFact2) < strlen($arrFact2a)){
                $arrFact2 = str_pad($arrFact2,strlen($arrFact2a));
            }

            $val->result2 = $compare->distance($arrFact2, $arrFact2a) * $val->fact2w;

            //fact 3
            $arrFact3 = str_replace(" ","",$fact3);
            $arrFact3a = str_replace(" ","",strtolower($val->fact3));

            if(strlen($arrFact3) > strlen($arrFact3a)){
                $arrFact3a = str_pad($arrFact3a,strlen($arrFact3));
            }else if (strlen($arrFact3) < strlen($arrFact3a)){
                $arrFact3 = str_pad($arrFact3,strlen($arrFact3a));
            }

            $val->result3 = $compare->distance($arrFact3, $arrFact3a) * $val->fact3w;

            //fact 4
            $arrFact4 = str_replace(" ","",$fact4);
            $arrFact4a = str_replace(" ","",strtolower($val->fact4));

            if(strlen($arrFact4) > strlen($arrFact4a)){
                $arrFact4a = str_pad($arrFact4a,strlen($arrFact4));
            }else if (strlen($arrFact4) < strlen($arrFact4a)){
                $arrFact4 = str_pad($arrFact4,strlen($arrFact4a));
            }

            $val->result4 = $compare->distance($arrFact4, $arrFact4a) * $val->fact4w;

            $val->totalWeight = $val->fact1w + $val->fact2w + $val->fact3w + $val->fact4w;

            $val->result = (1/$val->totalWeight) * ($val->result1+$val->result2+$val->result3+$val->result4);
//            var_dump($val);
            $arrCbrRes[$i] = $val;
            $i++;
        }

        usort($arrCbrRes,function($first,$second){
            return $first->result > $second->result;
        });

        return view('cbrdis.index',compact('kasusBaru','arrCbrRes'));
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
