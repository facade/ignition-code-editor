<template>
    <div>
        <button @click="methodThatWillThrowError">
            Vue Exception
        </button>
    </div>
</template>

<script>
    export default {
        methods: {
            methodThatWillThrowError() {
                const variable = 'value';
                variable = 'cannot reassign';
            },
        },
    }
</script>
