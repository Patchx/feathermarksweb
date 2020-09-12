
(() => {
	// ---------------------
	// - Private Functions -
	// ---------------------

	function createLink(vue_app) {
		axios.post('/links/create', {
			name: vue_app.draft_bookmark.name,
			url: vue_app.draft_bookmark.url,
			category: 'personal',
		}).then((response) => {
			if (response.data.status !== 'success') {
				console.log(response);
				alert("There was an error saving your bookmark. Please refresh the page and try again");
			}

			alert("Success!");
			vue_app.activateSearchMode();
		}).catch((error) => {
			alert(error.response.data.message);
		});
	}

	function deleteLink(vue_app) {
		axios.post('/links/delete/1s13').catch((error) => {
			alert(error.response.data.message);
		});
	}

	function detectFeatherCommand(vue_app) {
		if (vue_app.main_input_text.trim() === '--a') {
			vue_app.main_input_text = '';

			axios.get('/links/my-links').then((response) => {
				console.log(response.data);
			});
		}

		if (vue_app.main_input_text.trim() === '--b') {
			vue_app.main_input_text = '';
			vue_app.activateAddBookmarkMode();
		}

		if (vue_app.main_input_text.trim() === '--s') {
			vue_app.main_input_text = '';
			vue_app.activateSearchMode();
		}
	}

	// ----------------
	// - Vue Instance -
	// ----------------

	var vue_app = new Vue({
		el: '#vue_app',

		data: {
			main_input_text: '',
			mode: 'search',
			
			draft_bookmark: {
				url: '',
				name: '',
				keywords: '',
			},
		},

		computed: {
			mainLabelText: function() {
				if (this.mode === 'add-bookmark') {
					if (this.draft_bookmark.url === '') {
						return 'Enter URL';
					}

					if (this.draft_bookmark.name === '') {
						return 'Name this bookmark';
					}

					return 'Add some keywords to help find this later';
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
				if (after.length > 0
					&& after[0] !== '-'
				) {
					this.mode = 'search';
				}

				if (after.length === 1
					&& after[0] === '-'
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

				this.mode = 'search';
			},

			activateAddBookmarkMode: function() {
				if (this.mode === 'add-bookmark') {
					return this.searchBarEnterPressed();
				}

				this.draft_bookmark.url = '';
				this.draft_bookmark.name = '';
				this.draft_bookmark.keywords = '';

				this.mode = 'add-bookmark';

				// Just for testing right now
				// createLink(this);
				// deleteLink(this);
			},

			searchBarEnterPressed: function() {
				if (this.mode === 'add-bookmark') {
					if (this.draft_bookmark.url === '') {
						this.draft_bookmark.url = this.main_input_text;
						return this.main_input_text = '';
					}

					if (this.draft_bookmark.name === '') {
						this.draft_bookmark.name = this.main_input_text;
						return this.main_input_text = '';
					}

					this.draft_bookmark.keywords = this.main_input_text;
					this.main_input_text = '';
					createLink(this);
				}
			},
		},
	});
})();