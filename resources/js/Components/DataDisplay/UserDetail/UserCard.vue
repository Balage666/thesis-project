<script setup>

import { usePage } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

import { Link } from '@inertiajs/inertia-vue3';

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

const pageProps = ref(usePage().props.value);

const permissions = ref(pageProps.value.permissions);

const currentUser = ref(pageProps.value.active_session.user);

const emits = defineEmits(['onPictureButtonClick', 'onGrantSellerRoleButtonClick'])

const sendShowModalEmit = () => {
    emits('onPictureButtonClick');
}

const sendRoleEmit = (user) => {

    emits('onGrantSellerRoleButtonClick', user);

}


</script>

<template>
    <div class="card border-0 rounded-5 mt-5 py-2">
        <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
                <div class="container-img">
                    <img :src="props.user.profile_picture" :alt="props.user.name" class="rounded-circle" style="width: 90%">
                    <button data-cy="change-profile-picture" class="btn btn-lg btn-primary" v-if="props.profilePictureEditModeVisible" @click="sendShowModalEmit"><i class="fa-solid fa-pencil"></i> {{ __('Change') }}</button>
                </div>
                <div class="mt-1 mt-lg-0 mt-md-0">
                    <h4>{{ props.user.name }}</h4>
                </div>
                <div class="mt-1 mt-lg-0 mt-md-0" v-if="permissions.has_only_customer_role && currentUser.id == props.user.id">
                    <button @click="sendRoleEmit(props.user)" data-cy="request-seller-role" type="button" class="btn btn-secondary"><i class="fa-solid fa-money-bill-trend-up"></i> {{ __('Request Seller role') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

@import url(*/css/edit-user-mode.css);

</style>
