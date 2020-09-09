@extends('layouts.app')

@section('head_unique')
    <script async src="https://cse.google.com/cse.js?cx=910818fda3106e175"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-lg-10">
            <div class="card">
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

                    <br>

                    <div class="row">
                        <div class="col-12">
                            <label>Search</label>

                            <input
                                class="form-control"
                                v-model="search_iframe_query"
                            />
                        </div>
                    </div>

                    <br>

                    <iframe 
                        :src="searchIframeSrc"
                        width="100%"
                        height="400px"
                        v-if="search_iframe_query !== ''"
                        v-cloak
                    ></iframe>

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
                                    ><i class="fas fa-times text-muted"></i></button>
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

@section('scripts')
    <script src="{{ mix('/js/home-page.js') }}"></script>
@endsection
