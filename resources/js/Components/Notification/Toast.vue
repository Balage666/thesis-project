<script setup>



</script>

<template>
    <!-- TODO: Design toast component! -->
    <div class="float-end">
        <div class="position-fixed fixed-top">
            <div class="position-relative">
                <div class="position-absolute top-0 end-0">
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto">Bootstrap</strong>
                                <small class="text-body-secondary">11 mins ago</small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                Hello, world! This is a toast message.
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
