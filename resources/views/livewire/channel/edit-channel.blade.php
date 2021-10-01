<div>
    @if ($channel->image)
        <img src="{{ asset('images' . '/' . $channel->image) }}" alt="">
    @endif
    <form wire:submit.prevent="update">

        <div class="form-group">
            <label for="name">NAME</label>
            <input type="text" class="form-control" wire:model="channel.name">
        </div>
        @error('channel.name')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" wire:model="channel.slug">
        </div>

        @error('channel.slug')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" cols="30" rows="4"
                wire:model="channel.description"></textarea>
        </div>

        @error('channel.description')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror

        <div class="form-group">
            <input type="file" wire:model="image">
        </div>

        <div class="form-group">
            @if ($image)
                photo preview
                <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" alt="">
            @endif
        </div>

        @error('image')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </form>
</div>
