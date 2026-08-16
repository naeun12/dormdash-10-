<template>
    <div v-if="visible" class="modal-overlay" @click.self="cancel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content premium-confirm-card border-0">


                <div class="modal-body text-center pt-5 pb-4">
                    <div class="icon-wrapper mb-4" :class="iconClass">
                        <i :class="iconName"></i>
                    </div>

                    <h4 class="fw-800 text-dark mb-2">{{ title }}</h4>
                    <p class="text-muted fs-6 px-3">{{ message }}</p>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2 px-4 pb-4">
                    <button type="button" class="btn btn-modern-secondary flex-fill order-2 order-sm-1" @click="cancel">
                        No, Cancel
                    </button>
                    <button type="button" class="btn btn-modern-action flex-fill order-1 order-sm-2"
                        :class="actionBtnClass" @click="confirm">
                        {{ functionName || 'Confirm' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ConfirmModal",
    data() {
        return {
            visible: false,
            title: 'Confirmation',
            message: 'Are you sure you want to proceed?',
            functionName: 'Confirm',
            iconName: 'bi bi-question-circle-fill', // Default icon
            iconClass: 'icon-primary', // Default color
            actionBtnClass: 'btn-primary-action',
            resolve: null,
        };
    },
    methods: {
        /**
         * @param {string} type - 'danger', 'primary', 'warning'
         */
        show({ title = 'Confirmation', message = 'Are you sure?', functionName = 'Confirm', type = 'primary' } = {}) {
            this.title = title;
            this.message = message;
            this.functionName = functionName;

            // UI Logic based on type
            if (type === 'danger') {
                this.iconName = 'bi bi-exclamation-triangle-fill';
                this.iconClass = 'icon-danger';
                this.actionBtnClass = 'btn-danger-action';
            } else {
                this.iconName = 'bi bi-question-circle-fill';
                this.iconClass = 'icon-primary';
                this.actionBtnClass = 'btn-primary-action';
            }

            this.visible = true;
            return new Promise((resolve) => {
                this.resolve = resolve;
            });
        },
        confirm() {
            this.visible = false;
            if (this.resolve) this.resolve(true);
        },
        cancel() {
            this.visible = false;
            if (this.resolve) this.resolve(false);
        }
    }
};
</script>

<style scoped src="../../css/partials/modalconfirmation.css">

</style>