@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">About US</div>

                <div class="panel-body">
                    <form>
                        <select class="form-group">
                            <option value="1">one</option>
                            <option value="2">two</option>
                            <option value="3">three</option>
                            <option value="4" selected="selected">four</option>
                        </select>
                    </form>
                    Welcome
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
