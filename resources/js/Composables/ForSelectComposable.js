import { computed } from "vue";

export function useForSelect(collectionOfObjects) {

    const selectOptions = computed(() => {
        let list = [];
        collectionOfObjects.forEach(element => {
            list.push({ label: element.name, value: element.id })
        });
        return list;
    })

    return { selectOptions }

}
