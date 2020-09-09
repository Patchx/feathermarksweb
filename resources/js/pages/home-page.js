var vue_app = new Vue({
	el: '#vue_app',

	data: {
		search_iframe_query: '',
	},

	computed: {
		searchIframeSrc: function() {
			return "/search-results?q=" + this.search_iframe_query;
		},
	},

	methods: {
	},
});