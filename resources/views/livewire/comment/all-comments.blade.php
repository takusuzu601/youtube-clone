<div>
    @include('includes.recursive',['comments'=>$video->comments()->latestFirst()->get()])
    {{-- latestFirstは更新順に並び替え --}}
</div>
