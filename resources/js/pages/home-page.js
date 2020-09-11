
(() => {
	// ---------------------
	// - Private Functions -
	// ---------------------

	function createLink(vue_app) {
		axios.post('/links/create', {
			name: 'asdf',
			url: 'google.com',
			category: 'personal',
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
		},

		computed: {
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
				this.mode = 'add-bookmark';

				// Just for testing right now
				// createLink(this);
				// deleteLink(this);
			},
		},
	});
})();