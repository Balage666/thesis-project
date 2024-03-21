<script setup>

import FavoriteItem from '*vue-components/DataDisplay/Favorites/FavoriteItem.vue';

const props = defineProps({
    list: {
        type: Array,
        required: true
    }
})

const emits = defineEmits(['listChanged'])

const sendListChanged = (payload) => {

    emits('listChanged', payload);
}

</script>

<template>
    <div class="container">

        <ul class="list-group" v-if="props.list.length > 0">

            <FavoriteItem
                class="list-group-item"
                v-for="favorite in props.list"
                :item="favorite"
                @onItemDeleteRequest="sendListChanged"
                />

        </ul>

        <h3 v-else class="text-center">{{ __('There are no favorite products!') }}</h3>

    </div>
</template>

