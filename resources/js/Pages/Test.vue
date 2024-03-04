<script setup>

const props = defineProps({
    products: {
        type: Object
    }
})

// import FileUploadDialog from '*vue-components/Input/FileUploadDialog.vue';

// import { ref, onMounted } from 'vue';
// import { Modal } from 'bootstrap';


// const modalExample = ref(null);


// onMounted(() => {

//     modalExample.value = new Modal(document.getElementById('fileUpload'))
// });

// const showDialog = () => {

//     modalExample.value.show();
// }

// const closeDialog = () => {

//     modalExample.value.hide();

// }


</script>


<template>
    <div>
        <h1>New Feature test</h1>

        <pre>{{ props.products }}</pre>

        <div class="alert alert-danger" v-if="$page.props.errors" v-for="error in $page.props.errors">{{ __(error) }}</div>

        <!-- <button type="button" class="btn btn-primary" @click="showDialog">
            Launch static backdrop modal
        </button> -->

        <!-- <FileUploadDialog :id="'fileUpload'" @onModalClose="closeDialog" /> -->

        <!-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <FileUpload
                            name="demo"
                            accept="image/*"
                            :maxFileSize="1000000"
                        >
                            <template #chooseicon>
                                <i class="fa-solid fa-plus"></i>
                            </template>

                            <template #uploadicon>
                                <i class="fa-solid fa-upload"></i>
                            </template>

                            <template #cancelicon>
                                <i class="fa-solid fa-xmark"></i>
                            </template>

                            <template #empty>
                                <p>Drag and drop files to here to upload.</p>
                            </template>
                        </FileUpload>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> -->


    </div>



</template>

<style scoped>
</style>

