<style>
    .edit-link-modal-p {
        margin-bottom: 5px;
    }
</style>

<template>
    <modal 
        name="edit-link-modal"
        v-on:before-open="handleBeforeOpen"
        width="350"
        height="auto"
        :scrollable="true"
    >
        <div style="padding: 20px">
            <h1
                class="text-center"
                style="font-size: 22px"
            >
                <span>Edit Link</span>

                <span 
                    class="float-right text-muted"
                    style="cursor: pointer"
                    v-on:click="closeModal"
                >X</span>
            </h1>

            <div style="font-size: 20px">
                <p class="edit-link-modal-p">Name</p>

                <input
                    :value="link_name"
                    class="form-control mb-15"
                />

                <p class="edit-link-modal-p">URL</p>

                <input
                    :value="link_url"
                    class="form-control mb-15"
                />

                <p class="edit-link-modal-p">Search Phrase</p>

                <input
                    :value="search_phrase"
                    class="form-control mb-15"
                />

                <p class="edit-link-modal-p">Instaopen Command</p>

                <input
                    :value="instaopen_command"
                    class="form-control mb-15"
                />

                <button
                    class="btn btn-primary mt-15"
                    style="width: 100%"
                >Save</button>
            </div>
        </div>
    </modal>
</template>

<script>
module.exports = (function() {
    return {
        name: 'edit-link-modal',

        data: function() {
            return {
                instaopen_command: '',
                link_name: '',
                link_url: '',
                search_phrase: '',
            };
        },

        methods: {
            closeModal: function() {
                this.$modal.hide('edit-link-modal');
            },

            handleBeforeOpen: function(event) {
                const props = event.params.componentProps;
                this.instaopen_command = props.instaopen_command;
                this.link_name = props.name;
                this.link_url = props.url;
                this.search_phrase = props.search_phrase;
            },
        },
    };
})();
</script>
