import { usePage } from '@inertiajs/vue3';

export function useTrans(value) {
    const translations = usePage().props.translations;

    return value.split('.').reduce((acc, key) => {
        if (acc && acc[key] !== undefined) {
            return acc[key];
        }
        return value; // fallback if key path is not found
    }, translations);
}