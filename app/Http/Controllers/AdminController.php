<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use App\Repositories\AnswerRepository;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /** @var UserRepository  */
    protected $userRepository;
    protected $questionRepository;
    protected $answerRepository;


    public function __construct(UserRepository $userRepository, QuestionRepository $questionRepository, AnswerRepository $answerRepository)
    {
        parent::__construct();

        $this->middleware('admin');
        $this->userRepository = $userRepository;
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;

    }

    public function users()
    {
        $users = $this->userRepository->all();
        return view('admin/users', compact('users'));
    }

    public function userLogin($userId)
    {
        auth()->loginUsingId($userId);
        return redirect('/');
    }
    public function userDelete($userId)
    {
        User::where('id', $userId)->delete();
        return redirect()->back();
    }

    public function deleteQuestion(Request $request)
    {
        $id = $request['questionId'];
        $this->questionRepository->deleteQuestionById($id);
        return redirect()->back();
    }

    public function deleteAnswer(Request $request)
    {
        $id = $request['answerId'];
        $this->answerRepository->deleteAnswerById($id);
        return redirect()->back();
    }

    public function lockQuestion(Request $request)
    {
        $id = $request['questionId'];
        $question = $this->questionRepository->show($id);
        $question->is_locked = 1;
        $question->save();
        return redirect()->back();
    }

    public function editQuestion(Request $request)
    {
        $questionId = $request['questionId'];
        $question = $this->questionRepository->show($questionId);
        return view('question.create', compact('question'));
    }

    public function updateQuestion(Request $request)
    {
            $question = $this->questionRepository->show($request['questionId']);
            $question->title = $request['title'];
            $question->description = $request['description'];
            $question->category = $request['category'];
            $question->save();

            return redirect()
                ->route('questions.show', ['id' => $question->id])
                ->with('flash_message', 'Question updated !');
    }
}
