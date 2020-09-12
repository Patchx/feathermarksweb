@extends('layouts.app')

@section('head_unique')
    <script async src="https://cse.google.com/cse.js?cx=910818fda3106e175"></script>
@endsection

@section('content')
<div class="ml-30 mr-30">
    <div class="row">
        <div class="col-12">
            <div 
                class="mx-auto"
                style="max-width:550px"
            >
                <label>@{{mainLabelText}}</label>

                <div class="input-group">
                    <input 
                        type="text" 
                        class="form-control" 
                        v-model="main_input_text"
                        v-on:keyup.enter="searchBarEnterPressed"
                        autofocus
                    />

                    <div class="input-group-append">
                        <button 
                            :class="plusBtnClasses" 
                            type="button"
                            v-on:click="activateAddBookmarkMode"
                        >
                            <i 
                                v-if="mode === 'add-bookmark'"
                                v-cloak
                                class="fas fa-arrow-right"
                            ></i>

                            <i 
                                v-else-if="mode === 'feather'"
                                v-cloak
                                class="fas fa-feather-alt"
                            ></i>

                            <i 
                                v-else
                                v-cloak
                                class="fas fa-plus"
                            ></i>
                        </button>
                    
                        <button 
                            :class="searchBtnClasses" 
                            type="button"
                            v-on:click="activateSearchMode"
                        >
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center mt-25">
        <iframe 
            :src="searchIframeSrc"
            v-if="showExternalSearchResults"
            v-cloak
            width="100%"
            height="550px"
            style="
                border: 1px solid rgba(0, 0, 0, 0.125);
                border-radius: 3px;
            "
        ></iframe>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ mix('/wp/js/home-page.js') }}"></script>
@endsection
