<template>
    <div>
        <h2>{{ adherant.first_name }} {{ adherant.last_name }}</h2>
        <p>CIN: {{ adherant.cin }}</p>
        <p>Tel: {{ adherant.tel }}</p>
        <p>Date of Membership: {{ adherant.date_of_membership }}</p>
    </div>
</template>

<script>
export default {
    props: {
        adherant: {
            type: Object,
            required: true,
        },
    },
};
</script>
