<template>
    <div :class="['premium-toast-container', { 'show': toaster }]">
        <div class="premium-toast-card shadow-lg" :class="`border-accent-${toastColor}`">
            <div class="toast-content d-flex align-items-center py-3 px-4">
                <div class="icon-box me-3" :class="`text-${toastColor}`">
                    <i :class="getIcon"></i>
                </div>

                <div class="flex-grow-1">
                    <span class="toast-message text-dark fw-700">{{ messageToaster }}</span>
                </div>

                <button type="button" class="btn-close-custom ms-3" @click="ExitToaster" aria-label="Close">
                    <i class="bi bi-x"></i>
                </button>
            </div>

            <div v-if="toaster" class="toast-progress-bar" :class="`bg-${toastColor}`"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ToastComponent",
    data() {
        return {
            toaster: false,
            toastColor: 'success', // success, danger, warning, info
            messageToaster: '',
            timer: null
        };
    },
    computed: {
        getIcon() {
            const icons = {
                success: 'bi bi-check-circle-fill',
                danger: 'bi bi-exclamation-octagon-fill',
                warning: 'bi bi-exclamation-triangle-fill',
                info: 'bi bi-info-circle-fill'
            };
            return icons[this.toastColor] || icons.success;
        }
    },
    methods: {
        showToast(message, color = 'success') {
            // Clear existing timer if any
            if (this.timer) clearTimeout(this.timer);

            this.messageToaster = message;
            this.toastColor = color;
            this.toaster = true;

            this.timer = setTimeout(() => {
                this.ExitToaster();
            }, 3000);
        },
        ExitToaster() {
            this.toaster = false;
        }
    }
};
</script>


<style src="../../css/partials/toast.css"></style>