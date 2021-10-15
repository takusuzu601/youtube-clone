<?php

namespace App\Http\Livewire\Channel;

use App\Models\Channel;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChannelInfo extends Component
{
    public $channel;
    public $userSubscribed = false;

    public function mount(Channel $channel)
    {
        $this->channel = $channel;

        //チャンネル登録をしているかの判別 AUTH確認後
        if (Auth::check()) {
            if (auth()->user()->isSubscribedTo($this->channel)) {
                $this->userSubscribed = true;
            }
        }
    }
    public function render()
    {
        return view('livewire.channel.channel-info')->extends('layouts.app');
    }

    public function toggle()
    {
        //Authチェックしfalseでloginにリダイレクト
        if (!Auth::check()) {
            return redirect('/login');
        }
        //toggleがクリックされauth idで登録があれば登録を削除無ければ登録する
        if (auth()->user()->isSubscribedTo($this->channel)) {
            Subscription::where('user_id', auth()->id())->where('channel_id', $this->channel->id)->delete();
            $this->userSubscribed = false;
        } else {
            Subscription::create([
                'user_id' => auth()->id(),
                'channel_id' => $this->channel->id
            ]);
            $this->userSubscribed = true;
        }
    }
}
