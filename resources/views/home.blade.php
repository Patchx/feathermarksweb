@extends('layouts.app')

@section('head_unique')
    <script async src="https://cse.google.com/cse.js?cx=910818fda3106e175"></script>
@endsection

@section('content')
<div 
    id="homepage_content"
    class="ml-30 mr-30"
>
    <div class="row">
        <div class="col-12">
            <div 
                class="mx-auto"
                style="max-width:550px"
            >
                <label>@{{mainLabelText}}</label>

                <div class="input-group">
                    <input 
                        v-model="main_input_text"
                        v-on:keyup.enter="searchBarEnterPressed"
                        type="text"
                        autofocus
                        class="form-control" 
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

    <div 
        v-if="visible_bookmarks.length > 0"
        v-cloak
        class="row mt-30"
    >
        <div 
            class="mx-auto"
            style="max-width:400px"
        >
            <p>All Bookmarks</p>

            <p v-for="bookmark in visible_bookmarks">
                <i
                    v-on:click="deleteLink(bookmark.custom_id)" 
                    class="fas fa-trash text-muted mr-25"
                    style="font-size:18px"
                ></i>

                <a
                    :href="bookmark.url"
                    target="_blank"
                    style="font-size:24px"
                >@{{bookmark.name}}</a>
            </p>
        </div>
    </div>

    <div
        v-if="created_bookmark !== null && mode === 'search'"
        v-cloak
        class="row mt-30"
    >
        <div 
            class="mx-auto"
            style="max-width:400px"
        >
            <p>New Bookmark</p>

            <i
                v-on:click="deleteLink(created_bookmark.custom_id)" 
                class="fas fa-trash text-muted mr-25"
                style="font-size:18px"
            ></i>

            <a
                :href="created_bookmark.url"
                target="_blank"
                style="font-size:24px"
            >@{{created_bookmark.name}}</a>
        </div>
    </div>

    <div class="row justify-content-center mt-25">
        <div 
            v-if="showExternalSearchResults"
            v-cloak
            class="mb-10"
        >
            <p>My Bookmarks</p>

            <p v-for="bookmark in search_result_bookmarks">
                <i
                    v-on:click="deleteLink(bookmark.custom_id)" 
                    class="fas fa-trash text-muted mr-25"
                    style="font-size:18px"
                ></i>

                <a
                    :href="bookmark.url"
                    target="_blank"
                    style="font-size:24px"
                >@{{bookmark.name}}</a>
            </p>
        </div>

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

        <div
            v-else
            v-cloak
        >
            <p>System Commands:</p>

            <span class="code-style">//a</span> <span>&nbsp;List all bookmarks</span>
            <br>
            <span class="code-style">//b</span> <span>&nbsp; Create a new bookmark</span>
            <br>
            <span class="code-style">//s</span> <span>&nbsp; Switch to search engine</span>
            <br>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ mix('/wp/js/home-page.js') }}"></script>
@endsection
