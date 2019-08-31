<template>
    <div class="stack-main">
        <div class="stack-main-header">
            <FilePath
                v-if="selectedFrame.file"
                class="ui-path"
                :line-number="selectedFrame.line_number"
                :file="selectedFrame.file"
                :editable="true"
            ></FilePath>
            <div class="flex justify-start items-baseline | sm:mt-1">
                <ExceptionClass
                    :name="selectedFrame.class || ''"
                    :method="selectedFrame.method || ''"
                />
                <LineNumber class="ml-1" :line-number="selectedFrame.line_number" />
            </div>
        </div>
        <div class="stack-main-content">
                <div class="stack-code h-full">
                    <codemirror
                        v-model="code"
                        @ready="editorReady"
                        :options="codeMirrorOptions"
                    ></codemirror>
                </div>
            </div>
        </div>
</template>

<script>
import 'codemirror/lib/codemirror.css'
import 'codemirror/addon/selection/active-line.js'
import 'codemirror/mode/php/php.js'
import 'codemirror/theme/base16-dark.css'

import { codemirror } from 'vue-codemirror'
import ExceptionClass from '../Shared/ExceptionClass.vue';
import FilePath from '../Shared/FilePath.vue';
import LineNumber from '../Shared/LineNumber.vue';

export default {
    inject: ['config'],

    props: {
        fileContentsEndpoint: { default: undefined},
        selectedFrame: { required: true },
        selectedRange: { default: [null, null] },
    },

    components: {
        ExceptionClass,
        FilePath,
        LineNumber,
        codemirror,
    },

    data() {
        return {
            savedSuccessful: false,
            cm: null,
            codeSnippet: [],
            codeMirrorOptions: {
                styleActiveLine: true,
                lineNumbers: true,
                mode: 'php',
            },
            firstSelectedLineNumber: null,
        };
    },

    watch: {
        fileContentsEndpoint(val, previous) {
            this.loadFullCodeSnippet();
        },

        selectedFrame: {
            immediate: true,
            handler(val, previous) {
                if (previous === undefined || val.relative_file !== previous.relative_file) {
                    this.loadFullCodeSnippet();
                } else {
                    this.$nextTick(() => {
                        this.cm.doc.setCursor(this.selectedFrame.line_number-1);
                    });
                }
            },
        },
    },

    computed: {
        code() {
            let snippet = '';

            Object.entries(this.codeSnippet).map((line) => {
                snippet += line.pop() + "\n";
            });

            return snippet;
        }
    },

    methods: {
        async loadFullCodeSnippet() {
            if (this.fileContentsEndpoint) {
                try {
                    const response = await fetch(
                        `${this.fileContentsEndpoint}?file=${this.selectedFrame.relative_file}`,
                    );
                    if (response.ok) {
                        const responseData = await response.json();

                        this.codeSnippet = responseData.code_snippet;

                        this.$nextTick(() => {
                            this.cm.doc.setCursor(this.selectedFrame.line_number-1);

                            if (this.selectedFrame.relative_file.indexOf("vendor") === 0) {
                                this.cm.setOption('readOnly', 'nocursor');
                            } else {
                                this.cm.setOption('readOnly', false);
                            }
                        });

                        return;
                    }
                } catch (exception) {
                    //
                }
            }

            this.codeSnippet = this.selectedFrame.code_snippet;
        },

        editorReady(cm) {
            this.cm = cm;
            window.cm = cm;

            this.addKeyMaps(cm);
        },

        addKeyMaps(cm) {
            cm.addKeyMap({
                'Cmd-S': (cm) => {
                    this.saveFile(cm);
                },
                'Ctrl-S': (cm) => {
                    this.saveFile(cm);
                }
            });
        },

        async saveFile(cm) {
            try {
                const response = await fetch(this.fileContentsEndpoint, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                    body: JSON.stringify({
                        file: this.selectedFrame.relative_file,
                        value: cm.doc.getValue(),
                    }),
                });

                this.$toasted.success('File saved successfully!', {
                    duration: 1500
                });
            } catch (error) {
                console.error(error);
                this.savedSuccessful = false;

                this.$toasted.error('There was an error saving your file.', {
                    duration: 1500
                });
            }
        }
    },
};
</script>

<style scoped>
.vue-codemirror {
    height: 100%;
}
.vue-codemirror >>> .CodeMirror {
    height: 100%;
    line-height: 2;
}
.vue-codemirror >>> .CodeMirror-lines {
    padding: 0;
}
</style>
