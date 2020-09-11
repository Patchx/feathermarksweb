
(() => {
	// ---------------------
	// - Private Functions -
	// ---------------------

	function createLink(vue_app) {
		axios.post('/links/create', {
			name: vue_app.new_bookmark.name,
			url: vue_app.new_bookmark.url,
			category: 'personal',
		}).then((response) => {
			if (response.data.status !== 'success') {
				console.log(response);
				alert("There was an error saving your bookmark. Please refresh the page and try again");
			}

			alert("Success!");
		}).catch((error) => {
			alert(error.response.data.message);
		});
	}

	function deleteLink(vue_app) {
		axios.post('/links/delete/1s13').catch((error) => {
			alert(error.response.data.message);
		});
	}

	// ----------------
	// - Vue Instance -
	// ----------------

	var vue_app = new Vue({
		el: '#vue_app',

		data: {
			main_input_text: '',
			mode: 'search',
			
			new_bookmark: {
				url: '',
				name: '',
				keywords: '',
			},
		},

		computed: {
			mainLabelText: function() {
				if (this.mode === 'add-bookmark') {
					if (this.new_bookmark.url === '') {
						return 'Enter URL';
					}

					if (this.new_bookmark.name === '') {
						return 'Name this bookmark';
					}

					return 'Add some keywords to help find this later';
				}

				return 'Search';
			},

			plusBtnClasses: function() {
				if (this.mode === 'add-bookmark') {
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

		methods: {
			activateSearchMode: function() {
				this.mode = 'search';
			},

			activateAddBookmarkMode: function() {
				if (this.mode === 'add-bookmark') {
					return this.searchBarEnterPressed();
				}

				this.new_bookmark.url = '';
				this.new_bookmark.name = '';
				this.new_bookmark.keywords = '';

				this.mode = 'add-bookmark';

				// Just for testing right now
				// createLink(this);
				// deleteLink(this);
			},

			searchBarEnterPressed: function() {
				if (this.mode === 'add-bookmark') {
					if (this.new_bookmark.url === '') {
						this.new_bookmark.url = this.main_input_text;
						return this.main_input_text = '';
					}

					if (this.new_bookmark.name === '') {
						this.new_bookmark.name = this.main_input_text;
						return this.main_input_text = '';
					}

					this.new_bookmark.keywords = this.main_input_text;
					this.main_input_text = '';
					createLink(this);
				}
			},
		},
	});
})();