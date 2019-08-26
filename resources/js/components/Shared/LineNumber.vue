<template>
    <span
        class="inline-block px-1 rounded border border-tint-100 bg-tint-100 text-tint-600 medium text-xs"
    >
        :<span class="font-mono">{{ lineNumber }}</span>
    </span>
</template>

<script>
export default {
    props: {
        lineNumber: { required: true },
    },
};
</script>
