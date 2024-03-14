<script setup>

const props = defineProps({
    id: {
        type: String,
        required: true
    },
    data: {
        type: Object,
        required: true
    }
});

console.log(props.data);

const emits = defineEmits(['onDecline', 'onAccept']);

const onDecline = () => {

    emits('onDecline');

}

const onAccept = () => {
    emits('onAccept');
}

</script>
<template>

    <div class="modal fade" :id="props.id" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Confirm Procedure!') }}</h5>
                </div>
                <div class="modal-body">
                    <p class="fs-5">{{ __('Are you sure you want to execute the following procedure on :name, this cannot be undone!', props.data) }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="onDecline" class="btn btn-primary">{{ __('No, I changed my mind') }}</button>
                    <button type="button" @click="onAccept" class="btn btn-danger">{{ __('Yes, I\'m certain') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
