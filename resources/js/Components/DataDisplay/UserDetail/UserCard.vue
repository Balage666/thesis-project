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

const emits = defineEmits(['onPictureButtonClick'])

const sendShowModalEmit = () => {
    emits('onPictureButtonClick');
}

</script>

<template>
    <div class="card border-0 rounded-5 mt-5 py-2">
        <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
                <div class="container-img">
                    <!--FIXME: Image doesn't fit in its container on small resolution-->
                    <img :src="props.user.profile_picture" :alt="props.user.name" class="rounded-circle" style="width: 90%">
                    <button class="btn btn-lg btn-primary" v-if="props.profilePictureEditModeVisible" @click="sendShowModalEmit"><i class="fa-solid fa-pencil"></i> {{ __('Change') }}</button>
                </div>
                <div class="mt-1 mt-lg-0 mt-md-0">
                    <h4>{{ props.user.name }}</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

@import url(*/css/edit-user-mode.css);

</style>
