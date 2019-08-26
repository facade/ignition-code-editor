<template>
    <div class="card card-no-props">
        <div class="card-details">
            <div class="card-details-overflow">
                <OccurrenceDetails />
            </div>
        </div>
    </div>
</template>

<script>
import OccurrenceDetails from './OccurrenceDetails';

export default {
    components: {
        OccurrenceDetails,
    },
};
</script>
