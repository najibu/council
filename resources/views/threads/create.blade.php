@extends('layouts.app')

@section('header')
    {{-- Google Recaptcha --}}
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a New Thread</div>

                <div class="panel-body">
                    <form action="/threads" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                           <label for="channel_id">Choose a channel:</label>
                           <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Choose one...</option>
                                @foreach($channels as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                        {{ $channel->name }}
                                    </option>
                                @endforeach
                           </select>
                        </div>


                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="body">Body:</label>

                            <wysiwyg name="body"></wysiwyg>
                        </div>

                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6LeTt20UAAAAAC2S3BNqGrQIJ5TtZZlDMbcCsRMf"></div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>

                        @if (count($errors))
                            <div class="form-group">
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
