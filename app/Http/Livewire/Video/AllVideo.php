<?php

namespace App\Http\Livewire\Video;

use Livewire\Component;

class AllVideo extends Component
{

    public function mount()
    {
        $this->videos = auth()->user()->channel->videos;
    }
    public function render()
    {
        return view('livewire.video.all-video')->extends('layouts.app');
    }
}
