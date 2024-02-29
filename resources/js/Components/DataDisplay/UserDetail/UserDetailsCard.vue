<script setup>

import { useForm, Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    nameEditModeVisible: {
        type: Boolean,
        default: false
    },
    emailEditModeVisible: {
        type: Boolean,
        default: false
    },
    resetPasswordButtonVisible: {
        type: Boolean,
        default: false
    },
    legacyEditorButtonVisible: {
        type: Boolean,
        default: false
    }
});

const emits = defineEmits(['editModeToggled', 'nameModified', 'emailModified']);

const emitToggleData = () => {
    emits('editModeToggled');
}

const editNameForm = useForm({
    name: props.user.name
});

const editEmailForm = useForm({
    email: props.user.email
});

const sendModifiedNameData = () => {
    emits('nameModified', editNameForm);
}

const sendModifiedEmailData = () => {
    emits('emailModified', editEmailForm);
}

</script>
<template>
    <div class="card border-0 rounded-5 mt-5 py-2">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h6 class="my-0 fw-bold text-center text-lg-start text-md-start text-sm-start">Full Name</h6>
                </div>
                <div class="col-sm-6">
                    <h6 class="my-0 text-secondary text-center text-lg-start text-md-start text-sm-start" v-if="!props.nameEditModeVisible">{{ props.user.name }}</h6>
                    <form v-if="props.nameEditModeVisible" @submit.prevent="sendModifiedNameData">
                        <input class="form-control-sm border-0 rounded-end-0" type="text" name="name" id="name" v-model="editNameForm.name" required>
                        <input class="btn btn-sm btn-primary border-0 rounded-start-0 fw-bold" type="submit" value="Modify">
                    </form>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-6">
                    <h6 class="my-0 fw-bold text-center text-lg-start text-md-start text-sm-start">Email</h6>
                </div>
                <div class="col-sm-6">
                    <h6 class="text-secondary text-center text-lg-start text-md-start text-sm-start my-0" v-if="!props.emailEditModeVisible">{{ props.user.email }}</h6>
                    <form v-if="props.emailEditModeVisible" @submit.prevent="sendModifiedEmailData">
                        <input class="form-control-sm border-0 rounded-end-0" type="email" name="email" id="email" v-model="editEmailForm.email" required>
                        <input class="btn btn-sm btn-primary border-0 rounded-start-0 fw-bold" type="submit" value="Modify">
                    </form>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-6">
                    <h6 class="my-0 fw-bold text-center text-lg-start text-md-start text-sm-start">Password</h6>
                </div>
                <div class="col-sm-6 text-center text-lg-start text-md-start text-sm-start">
                    <h6 class="my-0 text-secondary" v-if="!props.resetPasswordButtonVisible">************************</h6>
                    <Link :href="route('user-reset-password', { user: props.user })" method="post" as="button" class="text-secondary my-0 " v-if="props.resetPasswordButtonVisible">{{__('Reset :name\'s password', props.user)}}</Link>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-12 d-grid gap-2 gap-lg-0 d-lg-flex d-md-flex align-items-md-center align-items-lg-center justify-content-md-center justify-content-lg-between">
                    <Link :href="route('user-edit', { user: props.user })" class="btn btn-lg btn-info" as="button" type="button">{{ __("Legacy Editor") }}</Link>
                    <button @click="emitToggleData" class="btn btn-lg btn-info">{{ __("Edit Mode") }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
