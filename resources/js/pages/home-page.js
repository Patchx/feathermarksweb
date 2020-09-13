
(() => {
	// ---------------------
	// - Private Functions -
	// ---------------------

	function createLink(vue_app) {
		const params = new URLSearchParams(window.location.search);
		var category = params.get('cat');

		axios.post('/links/create', {
			name: vue_app.draft_bookmark.name,
			url: vue_app.draft_bookmark.url,
			search_phrase: vue_app.draft_bookmark.search_phrase,
			category: category,
		}).then((response) => {
			if (response.data.status !== 'success') {
				console.log(response);
				alert("There was an error saving your bookmark. Please refresh the page and try again");
			}

			vue_app.created_bookmark = response.data.link;
			vue_app.activateSearchMode();
		}).catch((error) => {
			alert(error.response.data.message);
		});
	}

	function detectFeatherCommand(vue_app) {
		if (vue_app.main_input_text.trim() === '//a') {
			vue_app.main_input_text = '';
			fetchAllBookmarks(vue_app);
		}

		if (vue_app.main_input_text.trim() === '//b') {
			vue_app.main_input_text = '';
			vue_app.activateAddBookmarkMode();
		}

		if (vue_app.main_input_text.trim() === '//s') {
			vue_app.main_input_text = '';
			vue_app.activateSearchMode();
		}
	}

	function fetchAllBookmarks(vue_app) {
		const params = new URLSearchParams(window.location.search);
		var category = params.get('cat');
		var request_url = '/links/my-links';

		if (category !== null) {
			request_url += '?cat=' + category;
		}

		axios.get(request_url).then((response) => {
			vue_app.visible_bookmarks = response.data.links;
		});
	}

	function getTitleFromUrl(input_url, callback) { 
		var request_url = '/url/title/' + input_url;

		axios.get(request_url).then((response) => {
			if (response.data.status === 'success'
				&& callback !== undefined
			) {
				return callback(response.data.title);
			}
		}).catch((error) => {
			console.log(error);
		});
	};

	function handleAddBookmarkSubmission(vue_app) {
		if (vue_app.draft_bookmark.url === '') {
			vue_app.draft_bookmark.url = vue_app.main_input_text;
			var url = vue_app.main_input_text;
			vue_app.main_input_text = '';
			
			return getTitleFromUrl(url, (title) => {
				if (vue_app.main_input_text.length < 1) {
					return vue_app.main_input_text = title;
				}
			});
		}

		if (vue_app.draft_bookmark.name === '') {
			vue_app.draft_bookmark.name = vue_app.main_input_text;
			return vue_app.main_input_text = '';
		}

		vue_app.draft_bookmark.search_phrase = vue_app.main_input_text;
		vue_app.main_input_text = '';
		createLink(vue_app);
	}

	function searchMyLinks(vue_app) {
		var request_url = '/links/search-my-links?q=' + vue_app.main_input_text;

		axios.get(request_url).then((response) => {
			if (response.data.status === 'success') {
				vue_app.search_result_bookmarks = response.data.links;
			}
		}).catch((error) => {
			console.log(error);
		});
	}

	// ----------------
	// - Vue Instance -
	// ----------------

	var vue_app = new Vue({
		el: '#vue_app',

		data: {
			created_bookmark: null,

			draft_bookmark: {
				url: '',
				name: '',
				search_phrase: '',
			},

			main_input_text: '',
			mode: 'search',

			search_result_bookmarks: [],
			visible_bookmarks: [],
		},

		computed: {
			mainLabelText: function() {
				if (this.mode === 'add-bookmark') {
					if (this.draft_bookmark.url === '') {
						return 'New Bookmark: Enter URL';
					}

					if (this.draft_bookmark.name === '') {
						return 'Name this bookmark';
					}

					return 'Add a search phrase to help find this later';
				}

				return 'Search';
			},

			plusBtnClasses: function() {
				if (this.mode === 'add-bookmark'
					|| this.mode === 'feather'
				) {
					return 'btn btn-primary';
				}

				return 'btn btn-outline-primary';
			},

			searchBtnClasses: function() {
				if (this.mode === 'search') {
					return 'btn btn-primary';
				}

				return 'btn btn-outline-primary';
			},

			searchIframeSrc: function() {
				return "/search-results?q=" + this.main_input_text;
			},

			showExternalSearchResults: function() {
				if (this.mode !== 'search') {
					return false;
				}

				return this.main_input_text !== '';
			},
		},

		watch: {
			main_input_text: function(after, before) {
				if (after.length > 0) {
					this.created_bookmark = null;
				}

				if (after.length > 0
					&& after[0] !== '/'
					&& this.mode === 'feather'
				) {
					this.activateSearchMode();
				}

				if (after.length === 1
					&& after[0] === '/'
				) {
					this.mode = 'feather';
				}

				if (this.mode === 'feather') {
					detectFeatherCommand(this);
				}
			},
		},

		methods: {
			activateSearchMode: function() {
				if (this.mode === 'feather') {
					this.main_input_text = '';
				}

				this.visible_bookmarks = [];
				this.mode = 'search';
			},

			activateAddBookmarkMode: function() {
				if (this.mode === 'add-bookmark') {
					return this.searchBarEnterPressed();
				}

				this.draft_bookmark.url = '';
				this.draft_bookmark.name = '';
				this.draft_bookmark.search_phrase = '';

				this.visible_bookmarks = [];
				this.mode = 'add-bookmark';
			},

			deleteLink: function(link_id) {
				this.created_bookmark = null;
				var request_url = '/links/delete/' + link_id;

				axios.post(request_url).then((response) => {
					if (response.data.status !== 'success') {
						console.log(response);
						alert('There was an error deleting your link. Please refresh the page and try again');
						return null;
					}

					this.search_result_bookmarks = [];
					fetchAllBookmarks(this);
				}).catch((error) => {
					alert(error.response.data.message);
				});
			},

			searchBarEnterPressed: function() {
				if (this.mode === 'add-bookmark') {
					return handleAddBookmarkSubmission(this);
				}

				// For testing, WIP
				if (this.mode === 'search') {
					searchMyLinks(this);
				}
			},
		},
	});
})();