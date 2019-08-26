<template>
    <div class="contents" @click.stop>
        <button class="tab tab-share" @click="toggleMenu">
            Share<i class="ml-2 fas fa-share"></i>️
        </button>
        <ul
            class="dropdown z-10 right-0 bottom-full bg-gray-700 text-white p-4"
            :class="{ hidden: !menuVisible }"
            style="min-width: 18rem; margin-right: -1px"
        >
            <h5
                class="mb-3 text-left text-gray-500 font-semibold uppercase tracking-wider whitespace-no-wrap"
            >
                Share publicly
            </h5>
            <div v-if="sharedErrorUrls">
                <ShareLinks
                    :publicUrl="sharedErrorUrls.public_url"
                    :ownerUrl="sharedErrorUrls.owner_url"
                />
            </div>
            <ShareForm v-else @share="shareError" />
        </ul>
    </div>
</template>

<script>
import ShareForm from './ShareForm';
import ShareLinks from './ShareLinks';

export default {
    components: { ShareLinks, ShareForm },
    inject: ['report', 'shareEndpoint'],

    data() {
        return {
            sharedErrorUrls: null,
            menuVisible: false,
        };
    },

    watch: {
        menuVisible(menuVisible) {
            if (menuVisible) {
                window.addEventListener('click', this.toggleMenu);
            } else {
                window.removeEventListener('click', this.toggleMenu);
            }
        },
    },

    methods: {
        toggleMenu() {
            this.menuVisible = !this.menuVisible;
        },

        async shareError(selectedTabs) {
            try {
                const response = await fetch(this.shareEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                    body: JSON.stringify({
                        report: JSON.stringify(this.report),
                        tabs: selectedTabs,
                        lineSelection: window.location.hash,
                    }),
                });
                const responseData = await response.json();

                if (response.ok) {
                    this.sharedErrorUrls = responseData;
                }
            } catch (error) {
                console.error(error);
                this.executionSuccessful = false;
            }
        },
    },
};
</script>
