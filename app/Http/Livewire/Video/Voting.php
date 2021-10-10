<?php

namespace App\Http\Livewire\Video;

use App\Models\Dislike;
use App\Models\Like;
use App\Models\Video;
use Livewire\Component;

class Voting extends Component
{
    public $video;
    public $likes;
    public $dislikes;
    public $likeActive;
    public $dislikeActive;

    //likeもしくはdislikeボタンが押されたらリフレッシュする
    protected $listeners = ['load_values' => '$refresh'];

    public function mount(Video $video)
    {

        $this->video = $video;
        $this->checkIfLiked();
        $this->checkIfDisLiked();
    }

    public function checkIfLiked()
    {
        //auth_idでvideo modelの関数doesUserLikedVideo()にイイネがあればlikeActiveにtrueを入れ 無ければfalseが入る
        $this->video->doesUserLikedVideo() ? $this->likeActive = true : $this->likeActive = false;
    }
    public function checkIfDisLiked()
    {
        $this->video->doesUserDislikeVideo() ? $this->dislikeActive = true : $this->dislikeActive = false;
    }
    public function render()
    {
        $this->likes = $this->video->likes->count();
        $this->dislikes = $this->video->dislikes->count();
        return view('livewire.video.voting')->extends('layouts.app');
    }

    public function like()
    {
        //databaseにlikeがあればlikeを削除し無ければlikeを作成しdislikeを$this->disableDislik()で削除
        if ($this->video->doesUserLikedVideo()) {
            Like::where('user_id', auth()->id())->where('video_id', $this->video->id)->delete();
            $this->likeActive = false;
        } else {
            $this->video->likes()->create([
                'user_id' => auth()->id()
            ]);
            $this->disableDislike();
            $this->likeActive = true;
        }
        //ボタンが押されればリフレッシュ ロードする
        $this->emit('load_values');
    }

    public function dislike()
    {
        //databaseにdislikeがあればdislikeを削除し無ければdislikeを作成しlikeを$this->disableLike()で削除
        if ($this->video->doesUserDislikeVideo()) {
            Dislike::where('user_id', auth()->id())->where('video_id', $this->video->id)->delete();
            $this->dislikeActive = false;
        } else {
            //check if user alredy dislike the video
            $this->video->dislikes()->create([
                'user_id' => auth()->id()
            ]);
            $this->disableLike();
            $this->dislikeActive = true;
        }
        //ボタンが押されればリフレッシュ ロードする
        $this->emit('load_values');
    }

    //イイネが押されたらBADを削除
    public function disableDislike()
    {
        Dislike::where('user_id', auth()->id())->where('video_id', $this->video->id)->delete();
        $this->dislikeActive = false;
    }
    //BADが押されたらイイネを削除
    public function disableLike()
    {
        Like::where('user_id', auth()->id())->where('video_id', $this->video->id)->delete();
        $this->likeActive = false;
    }
}
