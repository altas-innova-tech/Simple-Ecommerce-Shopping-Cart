<template>
    <!-- This component only handles the toast logic, no visual content -->
</template>

<script setup>
import {useToast} from "vue-toastification"
import {usePage} from '@inertiajs/vue3'
import {onMounted, watch} from 'vue'

const toast = useToast()
const page  = usePage()

const showToasts = (toastsArray) => {
//    console.log('showToasts called with:', toastsArray) // Debug log

    if (Array.isArray(toastsArray) && toastsArray.length > 0) {
        toastsArray.forEach((toastData, index) => {
            // Add small delay between toasts for better UX
            setTimeout(() => {
                showSingleToast(toastData)
            }, index * 100) // 100ms delay between each toast
        })
    }
}

const showSingleToast = (toastData) => {
//    console.log('showSingleToast called with:', toastData) // Debug log

    if (toastData && typeof toastData === 'object') {
        const {type, message, title} = toastData

        if (!message) {
            console.warn('No message provided for toast') // Debug log
            return
        }

        const options = {}
        if (title) {
            options.title = title
        }

        switch (type) {
            case 'success':
                toast.success(message, options)
                break
            case 'error':
                toast.error(message, options)
                break
            case 'warning':
                toast.warning(message, options)
                break
            case 'info':
                toast.info(message, options)
                break
            default:
                console.warn('Unknown toast type:', type)
                toast(message, options)
        }
    }
}

onMounted(() => {
//    console.log('Toast handler mounted, page.props:', page.props) // Debug log

    if (page.props.toasts) {
        showToasts(page.props.toasts)
    }
})

// Watch for changes in toasts prop (for subsequent page visits)
watch(() => page.props.toasts, (newToasts) => {
//    console.log('Toasts prop changed:', newToasts) // Debug log

    if (newToasts) {
        showToasts(newToasts)
    }
}, {immediate: true})
</script>
