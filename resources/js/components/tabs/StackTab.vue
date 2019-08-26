<template>
    <Stack
        :frames="report.stacktrace"
        :selected-frame-number="selectedFrameNumber"
        :file-contents-endpoint="meta.fileContentsEndpoint"
        @frameclick="selectedFrameNumber = $event"
    />
</template>

<script>
import Stack from '../Stack/Stack.vue';
import findKey from 'lodash/findKey';

export default {
    inject: ['report'],

    props: {
        meta: {
            default: {}
        },
        file: { required: false },
        lineNumber: { required: false },
    },

    data() {
        return {
            selectedFrameNumber: this.report.stacktrace.length,
        };
    },

    components: {
        Stack,
    },

    provide() {
        return {
            setSelectedFrameNumber: frameNumber => (this.selectedFrameNumber = frameNumber),
        };
    },

    mounted() {
        window.addEventListener('keydown', e => {
            if (e.key === 'j') {
                this.selectedFrameNumber =
                    this.selectedFrameNumber === 1
                        ? this.report.stacktrace.length
                        : this.selectedFrameNumber - 1;
            }
        });

        window.addEventListener('keydown', e => {
            if (e.key === 'k') {
                this.selectedFrameNumber =
                    this.selectedFrameNumber === this.report.stacktrace.length
                        ? 1
                        : this.selectedFrameNumber + 1;
            }
        });
    },

    created() {
        this.selectFrame();
    },

    computed: {
        selectedFrame() {
            return this.report.stacktrace[this.report.stacktrace.length - this.selectedFrameNumber];
        },
    },

    methods: {
        selectFrame() {
            if (this.file) {
                const frameKey = findKey(this.report.stacktrace, f => f.file === this.file);

                this.selectedFrameNumber =
                    this.report.stacktrace.length - frameKey || this.selectedFrameNumber;
            }
        },
    },
};
</script>
