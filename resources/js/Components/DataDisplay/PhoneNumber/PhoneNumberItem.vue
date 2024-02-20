<script setup>

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
});

</script>

<template>
    <li>
        <div class="row">
            <div class="col-6 text-start my-4 my-md-2">
                <span class="fw-bold">
                    {{ item.formatted_number }}
                </span>
            </div>
            <div class="col-6 text-end">
                <div class="d-grid d-md-flex align-items-md-end justify-content-md-end gap-2">
                    <!--TODO: Implement edit and delete phone number methods and routes-->
                    <button type="button" class="btn btn-primary">Edit</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </li>
</template>

