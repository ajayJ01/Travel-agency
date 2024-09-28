<?php

namespace App\Http\Controllers\admin\question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question\Question;

class QuestionController extends Controller
{
    public function Show()
    {
          
        $questions = Question::orderBy('id', 'ASC')->paginate(10);
        return view('admin.question.index')->with('questions', $questions);
    }
   
    
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
           'answer'=> 'required',
           'status'=>'required|in:1,0'
        ]);
      $status = Question::create([
      'question'=> $request->question,
      'answer'=> $request->answer,
      'status'=>$request->status
]);
     if ($status) {
            request()->session()->flash('success', ' successfully added');
        } else {
            request()->session()->flash('error', 'Error occurred while adding Vendor');
        }

        return redirect()->route('question.show');
    }
    public function Update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
           'answer'=> 'required'
        ]);
        $edit = Question:: findorfail($id);
       $status = $edit->update([
      'question'=> $request->question,
      'answer'=> $request->answer
       ]);
       if ($status) {
            $request->session()->flash('success', ' successfully updated');
        } else {
            $request->session()->flash('error', 'Error occurred, Please try again!');
        }

        return redirect()->route('question.show');
    }
    public function delete($id)
    {
        $delete = Question::find($id);
        if ($delete) {
            $status = $delete->delete();
            if ($status) {
                request()->session()->flash('success', ' successfully deleted');
            } else {
                request()->session()->flash('error', 'Error, Please try again');
            }
            return redirect()->route('question.show');
        } else {
            request()->session()->flash('error', 'not found');
            return redirect()->back();
        }
    }

}
