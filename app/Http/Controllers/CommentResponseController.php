<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateCommentResponseRequest;
use App\User;

class CommentResponseController extends Controller
{
   public function store(CreateCommentResponseRequest $request){		
        $user=Auth::user();
        $comment=\App\Comment::findOrFail($request->get('idComment'));
		$commentResponse = new \App\CommentResponse();
		$commentResponse=[
			'user_id' => $user->id,
			'description' => $request->get('description'),
		];
        $comment->comments_reponse()->create([
			'user_id' => $user->id,
			'description' => $request->get('description'),
		]);
        return json_encode($comment);
	}
	public function destroy($id)
    {        
        $comment_response=\App\CommentResponse::findOrFail($id);
        $comment=\App\Comment::findOrFail($comment_response->comment_id);
        $summernote = $comment->summernote;
        $user = $summernote->user;
        if($user == Auth::user()){
            $this->authorize('equal',$user);
        }
        else{
            $user = \App\User::findOrFail($comment_response->user_id);
            $this->authorize('equal',$user);
        }       
        
        $comment_response->forceDelete();
        return "ok";
    }
    public function update (Request $request, $id)
    {
        $comment_response=\App\CommentResponse::findOrFail($id);
        $user = \App\User::findOrFail($comment_response->user_id);
        $this->authorize('equal',$user);
        $comment_response->description=$request->get('description');
        $comment_response->save();

    }
}
