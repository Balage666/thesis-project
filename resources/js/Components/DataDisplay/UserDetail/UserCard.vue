<script setup>

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    profilePictureEditModeVisible: {
        type: Boolean,
        required: true
    }
})

</script>

<template>
    <div class="card border-0 rounded-5 mt-5 py-2">
        <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
                <div class="container-img">
                    <img :src="props.user.profile_picture" :alt="props.user.name" class="rounded-circle" width="150px">
                    <button class="btn btn-lg btn-primary" v-if="props.profilePictureEditModeVisible">Change Picture</button>
                </div>
                <div class="mt-1">
                    <h4>{{ props.user.name }}</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

@import url(*/css/edit-user-mode.css);

</style>
