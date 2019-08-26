<template>
    <div>
        <p class="ui-url mb-1">{{ report.context.request.url }}</p>

        <FilePath
            class="mb-1"
            :file="firstFrame.file"
            :editable="true"
            :line-number="firstFrame.line_number"
        >
        </FilePath>

        <div class="grid cols-auto gap-2 justify-start items-center">
            <ExceptionClass :name="firstFrame.class" :method="firstFrame.method" />
            <LineNumber :line-number="firstFrame.line_number" />
        </div>

        <h3 class="mt-3 mb-1">
            <ExceptionMessage :name="report.message" />
        </h3>

        <div class="grid cols-auto gap-2 items-center justify-start">
            <ExceptionClass :name="report.exception_class" />
        </div>
    </div>
</template>

<script>
import FilePath from './FilePath';
import LineNumber from './LineNumber';
import ExceptionMessage from './ExceptionMessage';
import ExceptionClass from './ExceptionClass';

export default {
    components: { ExceptionClass, ExceptionMessage, LineNumber, FilePath },
    inject: ['report'],

    computed: {
        firstFrame() {
            return this.report.stacktrace[0];
        },
    },
};
</script>
