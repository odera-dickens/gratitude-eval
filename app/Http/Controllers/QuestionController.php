<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $questions = Question::all();
        $questions = $questions->transform(function ($question){
            $question->category;
            $question->answers;
            return $question;
        });
        return response()->json($questions->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return response()->json(['_token' => csrf_token()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $question = Question::create($request->only(['category_id', 'exam_id', 'question']));
        $question->answers;
        $question->category;
        return response()->json($question);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->category;
        $question->answers;
        return response()->json($question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Question $question)
    {
        return response()->json(['_token' => csrf_token()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Question $question)
    {
        $question = $question->update($request->only(['category_id', 'exam_id', 'question']));
        $question->category;
        $question->answers;
        return response()->json($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json([], 200);
    }
}
