<?php

namespace App\Http\Controllers;
use App\Notifications\CommentSummernote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateCommentRequest;
use App\User;
class CommentsController extends Controller
{
	public function store(CreateCommentRequest $request){		
        $user=Auth::user();
        $summernote=\App\Summernote::findOrFail($request->get('idSummernote'));
        $summernote->comments()->attach($user->id,['description' => $request->get('description')]);
        ///Crear Notificacion de Comentario al libro
        if($summernote->user_id != $user->id){ //crea notificacion si el que comento no es el dueño del libro
            $notificationUser=[
                'user_id'=> $user->id,
                'name_user_id'=> $user->name_user,
                'user_comment_id'=> $summernote->user_id,
                'message'=> $user->name_user.' ha comentado tu libro '.$summernote->name,
                'routePictureUser'=> $user->existPicturePerfil($user->name_user,$user->sex), 
                'link' => '/summernote/'.$summernote->id,
            ];
            $userNotification=\App\User::find($summernote->user_id);
            $userNotification->notify(new CommentSummernote($notificationUser) );
        }
         
        return json_encode($summernote);
	}
    public function destroy($id)
    {
        $comment=\App\Comment::findOrFail($id);
        $summernote = $comment->summernote;
        $user = $summernote->user;
        if($user == Auth::user()){ //igual al dueño del libro
            $this->authorize('equal',$user);
        }
        else{
            $user = \App\User::findOrFail($comment->user_id); //igual al dueño del comentario
            $this->authorize('equal',$user);
        }        
        $comment->forceDelete();
        return "ok";
    }
    public function update (Request $request, $id)
    {
        $comment=\App\Comment::findOrFail($id);
        $user = \App\User::findOrFail($comment->user_id);
        $this->authorize('equal',$user);
        $comment->description=$request->get('description');
        $comment->save();

    }

}
