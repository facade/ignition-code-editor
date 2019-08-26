<template>
    <div>
        <div>
            You can share this link with others:<br />
            <input
                class="text-gray-700"
                id="public_url"
                name="public_url"
                type="text"
                v-model="publicUrl"
            />
        </div>
        <div>
            You can use this link to administer the shared error: <br />
            <input
                class="text-gray-700"
                id="owner_url"
                name="owner_url"
                type="text"
                v-model="ownerUrl"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        publicUrl: { required: true },
        ownerUrl: { required: true },
    },
};
</script>
