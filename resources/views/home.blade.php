@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-lg-8">
            <div class="card">
                <div class="card-header">                    
                    <select 
                        class="form-control float-right"
                        style="width:110px"
                    >
                        <option value="personal">Personal</option>
                        
                        <option 
                            value="work"
                            @if($category === 'work')
                                selected="true"
                            @endif 
                        >Work</option>
                    </select>
                </div>

                <div class="card-body">
                    @if(session('msg_success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('msg_success') }}
                        </div>
                    @endif

                    @if(session('msg_failure'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('msg_failure') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h5 class="mb-10">New Link</h5>

                    <form
                        action="/links/create"
                        method="POST"
                    >
                        @csrf

                        <div class="row">
                            <div class="col-xs-12 col-md-4 mb-10">
                                <input
                                    type="hidden"
                                    name="category"
                                    value="{{$category}}"
                                />

                                <label>Name</label>

                                <input
                                    name="name"
                                    class="form-control"
                                    maxlength="100"
                                    required
                                />
                            </div>

                            <div class="col-xs-12 col-md-6 mb-10">
                                <label>Url</label>

                                <input
                                    name="url"
                                    class="form-control"
                                    required
                                />
                            </div>

                            <div class="col-xs-12 col-md-1">
                                <label class="d-none d-md-block">&nbsp;</label>

                                <button
                                    type="submit"
                                    class="btn btn-outline-dark d-none d-md-block"
                                >Save</button>

                                <button
                                    type="submit"
                                    class="btn btn-outline-dark d-block d-md-none mt-20"
                                    style="width: 100%"
                                >Save</button>
                            </div>
                        </div>
                    </form>

                    <h5 class="mt-30 mb-10">Your Links</h5>

                    @if($links->count() < 1)
                        <p class="text-muted">No links to display</p>
                    @endif

                    <div class="links-list-div">
                        @foreach($links as $link)
                            <div>
                                <form
                                    action="/links/delete/{{$link->custom_id}}"
                                    method="POST"
                                    class="inline-block"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-link"
                                    ><i class="fas fa-times text-danger"></i></button>
                                </form>

                                <a
                                    href="{{$link->url}}"
                                >{{$link->name}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
