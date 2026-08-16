<template>
    <Loader ref="loader" />
    <Toastcomponents ref="toast" />

    <div
        class="container py-5 d-flex justify-content-center animate__animated animate__fadeIn"
    >
        <div
            class="card border-0 shadow-lg overflow-hidden w-100"
            style="max-width: 800px; border-radius: 30px; background: #ffffff"
        >
            <div
                style="
                    height: 8px;
                    background: linear-gradient(90deg, #003c87, #fc7d07);
                "
            ></div>

            <div class="card-body p-4 p-md-5">
                <!-- STEPS -->
                <div class="mb-5">
                    <div
                        class="d-flex justify-content-between position-relative"
                    >
                        <div
                            class="position-absolute top-50 start-0 end-0 translate-middle-y"
                            style="height: 2px; background: #edf2f7; z-index: 0"
                        ></div>

                        <div
                            class="position-absolute top-50 start-0 translate-middle-y transition-all"
                            style="height: 2px; background: #003c87; z-index: 0"
                            :style="{
                                width:
                                    (currentStep / (steps.length - 1)) * 100 +
                                    '%',
                            }"
                        ></div>

                        <div
                            v-for="(step, index) in steps"
                            :key="index"
                            class="position-relative text-center"
                            style="z-index: 1"
                        >
                            <button
                                type="button"
                                class="btn rounded-circle d-flex align-items-center justify-content-center border-2 p-0 mx-auto transition-all step-bubble"
                                :class="
                                    currentStep >= index
                                        ? 'active-step'
                                        : 'inactive-step'
                                "
                                :disabled="index > currentStep"
                                @click="goToStep(index)"
                                style="
                                    width: 40px;
                                    height: 40px;
                                    font-weight: 700;
                                "
                            >
                                <i
                                    v-if="currentStep > index"
                                    class="bi bi-check-lg"
                                ></i>

                                <span v-else>
                                    {{ index + 1 }}
                                </span>
                            </button>

                            <p
                                class="small mt-2 mb-0 d-none d-md-block fw-bold text-uppercase"
                                :style="{
                                    color:
                                        currentStep === index
                                            ? '#003C87'
                                            : '#adb5bd',
                                    fontSize: '10px',
                                    letterSpacing: '1px',
                                }"
                            >
                                {{ step }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FORM -->
                <form @submit.prevent="nextStep">
                    <div class="tab-content">
                        <!-- ================================================= -->
                        <!-- STEP 1 - PERSONAL DETAILS -->
                        <!-- ================================================= -->
                        <div
                            v-if="currentStep === 0"
                            class="animate__animated animate__fadeIn"
                        >
                            <div class="text-center mb-4">
                                <h2 class="fw-bold" style="color: #003c87">
                                    Create
                                    <span style="color: #fc7d07">
                                        Landlord
                                    </span>
                                    Account
                                </h2>

                                <p class="text-muted">
                                    Start by setting up your professional
                                    profile.
                                </p>
                            </div>

                            <!-- PROFILE PICTURE -->
                            <div class="d-flex justify-content-center mb-5">
                                <div class="position-relative">
                                    <div
                                        class="avatar-wrapper rounded-circle border border-4 border-white shadow-sm overflow-hidden"
                                        style="
                                            width: 130px;
                                            height: 130px;
                                            background: #f8fafc;
                                        "
                                    >
                                        <img
                                            class="profile-pic w-100 h-100 object-fit-cover"
                                            :src="previewPic"
                                            alt="Profile Picture"
                                        />
                                    </div>

                                    <button
                                        type="button"
                                        class="btn position-absolute bottom-0 end-0 rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                        @click="triggerProfileInput"
                                        style="
                                            width: 38px;
                                            height: 38px;
                                            background: #003c87;
                                            color: white;
                                            border: 3px solid white;
                                        "
                                    >
                                        <i class="bi bi-camera-fill"></i>
                                    </button>

                                    <input
                                        ref="fileInput"
                                        class="d-none"
                                        name="profile_pic"
                                        id="profile-pic"
                                        type="file"
                                        accept="image/*"
                                        @change="handleImageUpload"
                                    />
                                </div>
                            </div>

                            <div
                                v-if="errors.profilePic"
                                class="alert alert-danger border-0 rounded-3 small py-2 text-center mb-4"
                            >
                                <i
                                    class="bi bi-exclamation-triangle-fill me-2"
                                ></i>

                                {{ errors.profilePic[0] }}
                            </div>

                            <!-- INPUTS -->
                            <div class="row g-3">
                                <!-- FIRST NAME -->
                                <div class="col-md-6">
                                    <label
                                        class="form-label small fw-bold text-muted"
                                    >
                                        FIRST NAME
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control custom-input"
                                        placeholder="John"
                                        v-model="firstname"
                                    />

                                    <span
                                        v-if="errors.firstname"
                                        class="text-danger small mt-1 d-block"
                                    >
                                        {{ errors.firstname[0] }}
                                    </span>
                                </div>

                                <!-- LAST NAME -->
                                <div class="col-md-6">
                                    <label
                                        class="form-label small fw-bold text-muted"
                                    >
                                        LAST NAME
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control custom-input"
                                        placeholder="Doe"
                                        v-model="lastname"
                                    />

                                    <span
                                        v-if="errors.lastname"
                                        class="text-danger small mt-1 d-block"
                                    >
                                        {{ errors.lastname[0] }}
                                    </span>
                                </div>

                                <!-- EMAIL -->
                                <div class="col-12">
                                    <label
                                        class="form-label small fw-bold text-muted"
                                    >
                                        EMAIL ADDRESS
                                    </label>

                                    <input
                                        type="email"
                                        class="form-control custom-input"
                                        placeholder="example@email.com"
                                        v-model="email"
                                    />

                                    <span
                                        v-if="errors.email"
                                        class="text-danger small mt-1 d-block"
                                    >
                                        {{ errors.email[0] }}
                                    </span>
                                </div>

                                <!-- PASSWORD -->
                                <div class="col-md-6">
                                    <label
                                        class="form-label small fw-bold text-muted"
                                    >
                                        PASSWORD
                                    </label>

                                    <input
                                        id="password"
                                        type="password"
                                        class="form-control custom-input"
                                        placeholder="••••••••"
                                        v-model="password"
                                    />

                                    <span
                                        v-if="errors.password"
                                        class="text-danger small mt-1 d-block"
                                    >
                                        {{ errors.password[0] }}
                                    </span>
                                </div>

                                <!-- CONFIRM PASSWORD -->
                                <div class="col-md-6">
                                    <label
                                        class="form-label small fw-bold text-muted"
                                    >
                                        CONFIRM PASSWORD
                                    </label>

                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        class="form-control custom-input"
                                        placeholder="••••••••"
                                        v-model="password_confirmation"
                                    />

                                    <span
                                        v-if="errors.password_confirmation"
                                        class="text-danger small mt-1 d-block"
                                    >
                                        {{ errors.password_confirmation[0] }}
                                    </span>
                                </div>

                                <!-- SHOW PASSWORD -->
                                <div class="col-12">
                                    <div
                                        class="form-check form-switch mb-2 ms-1"
                                    >
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="showpassword"
                                            @change="showpassword"
                                            style="cursor: pointer"
                                        />

                                        <label
                                            class="form-check-label small text-muted"
                                            for="showpassword"
                                        >
                                            Show Passwords
                                        </label>
                                    </div>
                                </div>

                                <!-- PHONE -->
                                <div class="col-md-8">
                                    <label
                                        class="form-label small fw-bold text-muted"
                                    >
                                        PHONE NUMBER
                                    </label>

                                    <input
                                        type="tel"
                                        class="form-control custom-input"
                                        placeholder="09XX XXX XXXX"
                                        v-model="phonenumber"
                                    />

                                    <span
                                        v-if="errors.phonenumber"
                                        class="text-danger small mt-1 d-block"
                                    >
                                        {{ errors.phonenumber[0] }}
                                    </span>
                                </div>

                                <!-- GENDER -->
                                <div class="col-md-4">
                                    <label
                                        class="form-label small fw-bold text-muted"
                                    >
                                        GENDER
                                    </label>

                                    <select
                                        class="form-select custom-input"
                                        v-model="gender"
                                    >
                                        <option value="">Select</option>

                                        <option value="male">Male</option>

                                        <option value="female">Female</option>
                                    </select>

                                    <span
                                        v-if="errors.gender"
                                        class="text-danger small mt-1 d-block"
                                    >
                                        {{ errors.gender[0] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- ================================================= -->
                        <!-- STEP 2 - GOVERNMENT ID -->
                        <!-- ================================================= -->
                        <div
                            v-if="currentStep === 1"
                            class="animate__animated animate__fadeIn text-center py-4"
                        >
                            <h2 class="fw-bold mb-3" style="color: #003c87">
                                Identity Verification
                            </h2>

                            <p class="text-muted mb-5">
                                Please upload a valid government-issued ID.
                            </p>

                            <div
                                class="upload-area p-5 border-2 border-dashed rounded-4 transition-all"
                                @click="triggerGovIdInput"
                                style="
                                    cursor: pointer;
                                    background: #f8fafc;
                                    border-color: #cbd5e0;
                                "
                            >
                                <input
                                    ref="govIdInput"
                                    class="d-none"
                                    type="file"
                                    accept="image/*"
                                    @change="handleGovermentIdUpload"
                                />

                                <div class="mb-3">
                                    <i
                                        class="bi bi-card-heading"
                                        style="
                                            font-size: 3.5rem;
                                            color: #003c87;
                                        "
                                    ></i>
                                </div>

                                <h5 class="fw-bold">Upload Government ID</h5>

                                <p class="text-muted small">
                                    Click to browse or drag and drop
                                </p>
                            </div>

                            <div
                                v-if="govermentIdPicPreview"
                                class="mt-4 animate__animated animate__zoomIn"
                            >
                                <div class="position-relative d-inline-block">
                                    <img
                                        :src="govermentIdPicPreview"
                                        class="img-fluid rounded-3 shadow-sm border"
                                        style="max-height: 200px"
                                    />

                                    <button
                                        type="button"
                                        @click.stop="removeGovermentPermitPic"
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow"
                                    >
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>

                            <div
                                v-if="errors.governmentIdPic"
                                class="text-danger small mt-3"
                            >
                                {{ errors.governmentIdPic[0] }}
                            </div>
                        </div>

                        <!-- ================================================= -->
                        <!-- STEP 3 - BUSINESS PERMIT -->
                        <!-- ================================================= -->
                        <div
                            v-if="currentStep === 2"
                            class="animate__animated animate__fadeIn text-center py-4"
                        >
                            <h2 class="fw-bold mb-3" style="color: #003c87">
                                Business Accreditation
                            </h2>

                            <p class="text-muted mb-5">
                                Upload your valid Business Permit to start
                                listing.
                            </p>

                            <div
                                class="upload-area p-5 border-2 border-dashed rounded-4 transition-all"
                                @click="triggerBusinessPermitInput"
                                style="
                                    cursor: pointer;
                                    background: #f8fafc;
                                    border-color: #cbd5e0;
                                "
                            >
                                <input
                                    ref="businessPermitInput"
                                    class="d-none"
                                    type="file"
                                    accept="image/*"
                                    @change="handleBusinessPermitUpload"
                                />

                                <div class="mb-3">
                                    <i
                                        class="bi bi-file-earmark-check"
                                        style="
                                            font-size: 3.5rem;
                                            color: #003c87;
                                        "
                                    ></i>
                                </div>

                                <h5 class="fw-bold">Upload Business Permit</h5>

                                <p class="text-muted small">
                                    Click to browse or drag and drop
                                </p>
                            </div>

                            <div
                                v-if="businessIdPicPreview"
                                class="mt-4 animate__animated animate__zoomIn"
                            >
                                <div class="position-relative d-inline-block">
                                    <img
                                        :src="businessIdPicPreview"
                                        class="img-fluid rounded-3 shadow-sm border"
                                        style="max-height: 200px"
                                    />

                                    <button
                                        type="button"
                                        @click.stop="removeBusinessPermitPic"
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow"
                                    >
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>

                            <div
                                v-if="errors.businessPermitPic"
                                class="text-danger small mt-3"
                            >
                                {{ errors.businessPermitPic[0] }}
                            </div>
                        </div>

                        <!-- ================================================= -->
                        <!-- STEP 4 - OTP -->
                        <!-- ================================================= -->
                        <div
                            v-if="currentStep === 3"
                            class="animate__animated animate__fadeIn text-center py-5"
                        >
                            <div class="mb-4">
                                <div
                                    class="d-inline-block p-4 rounded-circle mb-3"
                                    style="background: rgba(0, 60, 135, 0.05)"
                                >
                                    <i
                                        class="bi bi-shield-lock-fill"
                                        style="
                                            font-size: 2.5rem;
                                            color: #003c87;
                                        "
                                    ></i>
                                </div>

                                <h2 class="fw-bold" style="color: #003c87">
                                    OTP Verification
                                </h2>

                                <p class="text-muted">
                                    We've sent a 6-digit code to your email.
                                </p>
                            </div>

                            <!-- OTP INPUTS -->
                            <div
                                class="d-flex justify-content-center gap-2 mb-4"
                                @paste="handlePaste"
                            >
                                <input
                                    v-for="(digit, index) in otpdigits"
                                    :key="index"
                                    :ref="'otpInput' + index"
                                    type="text"
                                    inputmode="numeric"
                                    autocomplete="one-time-code"
                                    maxlength="1"
                                    class="form-control text-center fw-bold fs-3 otp-input-box"
                                    v-model="otpdigits[index]"
                                    @input="handleInput(index, $event)"
                                    @keydown.backspace="
                                        handleBackspace(index, $event)
                                    "
                                    @keydown.left="handleArrow(index, -1)"
                                    @keydown.right="handleArrow(index, 1)"
                                />
                            </div>

                            <div v-if="otpError" class="text-danger small mb-3">
                                {{ otpError }}
                            </div>

                            <!-- TIMER -->
                            <div class="mb-5">
                                <div
                                    v-if="otpTimer > 0"
                                    class="badge rounded-pill px-3 py-2 fw-bold"
                                    style="background: #fff4e6; color: #fc7d07"
                                >
                                    <i class="bi bi-clock-history me-2"></i>

                                    Expires in:
                                    {{ formattedTime }}
                                </div>

                                <div v-else class="text-danger small fw-bold">
                                    OTP has expired. Please request a new code.
                                </div>
                            </div>

                            <!-- BUTTONS -->
                            <div
                                class="d-grid gap-3 d-sm-flex justify-content-sm-center"
                            >
                                <button
                                    type="button"
                                    @click="RegisterLandlord"
                                    :disabled="isRegistering || !isOtpComplete"
                                    class="btn px-5 py-3 rounded-pill fw-bold text-white shadow-sm register-submit-btn"
                                    style="background: #003c87; border: none"
                                >
                                    <span
                                        v-if="isRegistering"
                                        class="spinner-border spinner-border-sm me-2"
                                    ></span>

                                    Verify & Register Account
                                </button>

                                <button
                                    type="button"
                                    @click="resendOtp"
                                    class="btn btn-link text-decoration-none fw-bold align-self-center"
                                    :disabled="otpTimer > 0 || isResending"
                                    :style="{
                                        color:
                                            otpTimer > 0 || isResending
                                                ? '#cbd5e0'
                                                : '#003C87',
                                    }"
                                >
                                    <span
                                        v-if="isResending"
                                        class="spinner-border spinner-border-sm me-1"
                                    ></span>

                                    Resend Code
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- NAVIGATION -->
                    <div
                        v-if="currentStep < 3"
                        class="d-flex justify-content-between mt-5 pt-4 border-top"
                    >
                        <button
                            type="button"
                            class="btn btn-light px-4 py-2 rounded-3 fw-bold text-muted border"
                            @click="prevStep"
                            :disabled="currentStep === 0"
                        >
                            <i class="bi bi-chevron-left me-2"></i>
                            Back
                        </button>

                        <button
                            type="button"
                            class="btn px-5 py-2 rounded-3 fw-bold shadow-sm text-white next-step-btn"
                            @click="nextStep"
                            :disabled="isProcessing"
                            style="background: #003c87; border: none"
                        >
                            <span
                                v-if="isProcessing"
                                class="spinner-border spinner-border-sm me-2"
                            ></span>

                            Next Step

                            <i class="bi bi-chevron-right ms-2"></i>
                        </button>
                    </div>
                </form>

                <!-- LOGIN -->
                <div class="text-center mt-4">
                    <p class="text-muted">
                        Do you already have an account?

                        <a :href="LoginLink" class="text-decoration-none">
                            Login here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "@/components/loader.vue";
import axios from "axios";
import Toastcomponents from "@/components/Toastcomponents.vue";

export default {
    name: "LandlordRegister",

    components: {
        Loader,
        Toastcomponents,
    },

    data() {
        return {
            LoginLink: "/landlordLogin",

            // Images
            previewPic: "/images/registertenant/Profile-PNG-Photo.png",
            govermentIdPicPreview: "",
            businessIdPicPreview: "",

            // Errors
            errors: {},
            otpError: "",

            // Steps
            steps: [
                "Personal Details",
                "Identity Verification",
                "Business Documentation",
                "Email Verification",
            ],

            currentStep: 0,

            // Personal information
            firstname: "",
            lastname: "",
            email: "",
            password: "",
            password_confirmation: "",
            phonenumber: "",
            gender: "",

            // Files
            profilePic: null,
            governmentIdFile: null,
            businessPermitFile: null,

            // OTP
            otpTimer: 0,
            otpdigits: Array(6).fill(""),
            otpInterval: null,

            // Loading
            isProcessing: false,
            isRegistering: false,
            isResending: false,
        };
    },

    computed: {
        formattedTime() {
            const minutes = Math.floor(this.otpTimer / 60);
            const seconds = this.otpTimer % 60;

            return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
        },

        isOtpComplete() {
            return (
                this.otpdigits.length === 6 &&
                this.otpdigits.every((digit) => /^\d$/.test(digit))
            );
        },
    },

    methods: {
        // =====================================================
        // TOAST
        // =====================================================

        showToast(message, color = "success") {
            if (this.$refs.toast) {
                this.$refs.toast.showToast(message, color);
            }
        },

        // =====================================================
        // STEP NAVIGATION
        // =====================================================

        async nextStep() {
            if (this.currentStep >= this.steps.length - 1) {
                return;
            }

            this.isProcessing = true;

            try {
                let isValid = false;

                if (this.currentStep === 0) {
                    isValid = await this.PersonalDetails();
                } else if (this.currentStep === 1) {
                    isValid = await this.IdentityVerification();
                } else if (this.currentStep === 2) {
                    isValid = await this.BusinessDocumentation();
                }

                if (isValid) {
                    this.currentStep++;
                }
            } finally {
                this.isProcessing = false;
            }
        },

        prevStep() {
            if (this.currentStep > 0) {
                this.currentStep--;

                this.errors = {};
                this.otpError = "";

                this.$nextTick(() => {
                    this.focusCurrentStep();
                });
            }
        },

        goToStep(index) {
            if (index <= this.currentStep) {
                this.currentStep = index;

                this.$nextTick(() => {
                    this.focusCurrentStep();
                });
            }
        },

        focusCurrentStep() {
            if (this.currentStep === 3) {
                const otpInput = this.$refs.otpInput0;

                if (Array.isArray(otpInput)) {
                    otpInput[0]?.focus();
                } else {
                    otpInput?.focus();
                }
            }
        },

        // =====================================================
        // PROFILE IMAGE
        // =====================================================

        handleImageUpload(event) {
            const file = event.target.files?.[0];

            if (!file) {
                return;
            }

            if (!file.type.startsWith("image/")) {
                this.showToast("Please select a valid image file.", "danger");

                event.target.value = "";
                return;
            }

            this.profilePic = file;

            if (this.previewPic.startsWith("blob:")) {
                URL.revokeObjectURL(this.previewPic);
            }

            this.previewPic = URL.createObjectURL(file);
        },

        triggerProfileInput() {
            this.$refs.fileInput?.click();
        },

        // =====================================================
        // GOVERNMENT ID
        // =====================================================

        handleGovermentIdUpload(event) {
            const file = event.target.files?.[0];

            if (!file) {
                return;
            }

            if (!file.type.startsWith("image/")) {
                this.showToast("Please select a valid image file.", "danger");

                event.target.value = "";
                return;
            }

            if (this.govermentIdPicPreview) {
                URL.revokeObjectURL(this.govermentIdPicPreview);
            }

            this.governmentIdFile = file;

            this.govermentIdPicPreview = URL.createObjectURL(file);

            this.errors.governmentIdPic = null;
        },

        triggerGovIdInput() {
            this.$refs.govIdInput?.click();
        },

        removeGovermentPermitPic() {
            if (this.govermentIdPicPreview) {
                URL.revokeObjectURL(this.govermentIdPicPreview);
            }

            this.govermentIdPicPreview = "";
            this.governmentIdFile = null;

            if (this.$refs.govIdInput) {
                this.$refs.govIdInput.value = "";
            }
        },

        // =====================================================
        // BUSINESS PERMIT
        // =====================================================

        handleBusinessPermitUpload(event) {
            const file = event.target.files?.[0];

            if (!file) {
                return;
            }

            if (!file.type.startsWith("image/")) {
                this.showToast("Please select a valid image file.", "danger");

                event.target.value = "";
                return;
            }

            if (this.businessIdPicPreview) {
                URL.revokeObjectURL(this.businessIdPicPreview);
            }

            this.businessPermitFile = file;

            this.businessIdPicPreview = URL.createObjectURL(file);

            this.errors.businessPermitPic = null;
        },

        triggerBusinessPermitInput() {
            this.$refs.businessPermitInput?.click();
        },

        removeBusinessPermitPic() {
            if (this.businessIdPicPreview) {
                URL.revokeObjectURL(this.businessIdPicPreview);
            }

            this.businessIdPicPreview = "";
            this.businessPermitFile = null;

            if (this.$refs.businessPermitInput) {
                this.$refs.businessPermitInput.value = "";
            }
        },

        // =====================================================
        // STEP 1 - PERSONAL DETAILS
        // =====================================================

        async PersonalDetails() {
            this.setLoader(true);
            this.errors = {};

            const formData = new FormData();

            formData.append("firstname", this.firstname.trim());

            formData.append("lastname", this.lastname.trim());

            formData.append("email", this.email.trim());

            formData.append("phonenumber", this.phonenumber.trim());

            formData.append("password", this.password.trim());

            formData.append(
                "password_confirmation",
                this.password_confirmation.trim(),
            );

            formData.append("gender", this.gender);

            if (this.profilePic) {
                formData.append("profilePic", this.profilePic);
            }

            try {
                const response = await axios.post(
                    "/personalDetails",
                    formData,
                    {
                        headers: {
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute("content"),
                        },
                    },
                );

                if (response.data.status === "success") {
                    this.errors = {};

                    this.showToast(
                        response.data.message || "Personal details verified.",
                        "success",
                    );

                    return true;
                }

                this.showToast(
                    response.data.message ||
                        "Unable to validate personal details.",
                    "danger",
                );

                return false;
            } catch (error) {
                this.handleAxiosError(error);
                return false;
            } finally {
                this.setLoader(false);
            }
        },

        // =====================================================
        // STEP 2 - GOVERNMENT ID
        // =====================================================

        async IdentityVerification() {
            this.setLoader(true);
            this.errors = {};

            if (!this.governmentIdFile) {
                this.errors.governmentIdPic = ["Government ID is required."];

                this.showToast("Please upload your government ID.", "danger");

                this.setLoader(false);

                return false;
            }

            const formData = new FormData();

            formData.append("governmentIdPic", this.governmentIdFile);

            try {
                const response = await axios.post(
                    "/IdentityVerifaction",
                    formData,
                    {
                        headers: {
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute("content"),
                        },
                    },
                );

                if (response.data.status === "success") {
                    this.showToast(
                        response.data.message || "Government ID verified.",
                        "success",
                    );

                    return true;
                }

                this.showToast(
                    response.data.message ||
                        "Government ID verification failed.",
                    "danger",
                );

                return false;
            } catch (error) {
                this.handleAxiosError(error);
                return false;
            } finally {
                this.setLoader(false);
            }
        },

        // =====================================================
        // STEP 3 - BUSINESS DOCUMENTATION
        // =====================================================

        async BusinessDocumentation() {
            this.setLoader(true);
            this.errors = {};

            if (!this.businessPermitFile) {
                this.errors.businessPermitPic = [
                    "Business permit is required.",
                ];

                this.showToast("Please upload your business permit.", "danger");

                this.setLoader(false);

                return false;
            }

            const formData = new FormData();

            formData.append("businessPermitPic", this.businessPermitFile);

            formData.append("email", this.email.trim());

            try {
                const response = await axios.post(
                    "/businessPermitValidation",
                    formData,
                    {
                        headers: {
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute("content"),
                        },
                    },
                );

                if (response.data.status === "success") {
                    this.showToast(
                        response.data.message || "Business permit accepted.",
                        "success",
                    );

                    // Start OTP countdown
                    if (response.data.timer) {
                        this.startOtpTimer(response.data.timer);
                    }

                    // Reset OTP
                    this.otpdigits = Array(6).fill("");

                    this.otpError = "";

                    return true;
                }

                this.showToast(
                    response.data.message ||
                        "Business permit validation failed.",
                    "danger",
                );

                return false;
            } catch (error) {
                this.handleAxiosError(error);
                return false;
            } finally {
                this.setLoader(false);
            }
        },

        // =====================================================
        // FINAL REGISTRATION
        // =====================================================

        async RegisterLandlord() {
            if (!this.isOtpComplete) {
                this.otpError = "Please enter the complete 6-digit OTP.";

                return false;
            }

            if (this.otpTimer <= 0) {
                this.otpError =
                    "Your OTP has expired. Please request a new code.";

                return false;
            }

            this.isRegistering = true;
            this.setLoader(true);

            this.otpError = "";

            const formData = new FormData();

            formData.append("firstname", this.firstname.trim());

            formData.append("lastname", this.lastname.trim());

            formData.append("email", this.email.trim());

            formData.append("password", this.password.trim());

            formData.append(
                "password_confirmation",
                this.password_confirmation.trim(),
            );

            formData.append("phonenumber", this.phonenumber.trim());

            formData.append("gender", this.gender);

            if (this.profilePic) {
                formData.append("profilePic", this.profilePic);
            }

            if (this.governmentIdFile) {
                formData.append("governmentIdPic", this.governmentIdFile);
            }

            if (this.businessPermitFile) {
                formData.append("businessPermitPic", this.businessPermitFile);
            }

            formData.append("codeotp", this.otpdigits.join(""));

            try {
                const response = await axios.post(
                    "/RegisterLandlord",
                    formData,
                    {
                        headers: {
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute("content"),
                        },
                    },
                );

                if (response.data.status === "success") {
                    this.showToast(
                        response.data.message ||
                            "Landlord account created successfully.",
                        "success",
                    );

                    this.stopOtpTimer();

                    this.Emptyfill();

                    this.currentStep = 0;
                    this.errors = {};

                    setTimeout(() => {
                        window.location.href = "/landlordLogin";
                    }, 1000);

                    return true;
                }

                this.showToast(
                    response.data.message || "Registration failed.",
                    "danger",
                );

                return false;
            } catch (error) {
                this.handleAxiosError(error);
                return false;
            } finally {
                this.isRegistering = false;
                this.setLoader(false);
            }
        },

        // =====================================================
        // OTP TIMER
        // =====================================================

        startOtpTimer(timerValue) {
            this.stopOtpTimer();

            let expirationTime;

            /*
             * Handles:
             * 2026-08-16 17:30:00
             * 2026-08-16T17:30:00
             * ISO date strings
             */
            if (typeof timerValue === "string") {
                expirationTime = new Date(timerValue.replace(" ", "T"));
            } else {
                expirationTime = new Date(timerValue);
            }

            if (Number.isNaN(expirationTime.getTime())) {
                console.error("Invalid OTP expiration time:", timerValue);

                this.otpTimer = 0;

                return;
            }

            const updateTimer = () => {
                const now = new Date();

                const remainingSeconds = Math.max(
                    0,
                    Math.floor(
                        (expirationTime.getTime() - now.getTime()) / 1000,
                    ),
                );

                this.otpTimer = remainingSeconds;

                if (remainingSeconds <= 0) {
                    this.stopOtpTimer();
                }
            };

            updateTimer();

            this.otpInterval = setInterval(updateTimer, 1000);
        },

        stopOtpTimer() {
            if (this.otpInterval) {
                clearInterval(this.otpInterval);
                this.otpInterval = null;
            }
        },

        // =====================================================
        // OTP INPUT
        // =====================================================

        handleInput(index, event) {
            let value = event.target.value || "";

            value = value.replace(/\D/g, "");

            if (value.length > 1) {
                value = value.charAt(value.length - 1);
            }

            this.otpdigits[index] = value;

            if (value && index < 5) {
                this.focusOtpInput(index + 1);
            }
        },

        handleBackspace(index, event) {
            if (
                event.key === "Backspace" &&
                !this.otpdigits[index] &&
                index > 0
            ) {
                this.otpdigits[index - 1] = "";

                this.focusOtpInput(index - 1);
            }
        },

        handleArrow(index, direction) {
            const targetIndex = index + direction;

            if (targetIndex >= 0 && targetIndex < this.otpdigits.length) {
                this.focusOtpInput(targetIndex);
            }
        },

        focusOtpInput(index) {
            this.$nextTick(() => {
                let input = this.$refs[`otpInput${index}`];

                if (Array.isArray(input)) {
                    input = input[0];
                }

                input?.focus();
                input?.select();
            });
        },

        handlePaste(event) {
            event.preventDefault();

            const pasted = event.clipboardData
                ?.getData("text")
                ?.replace(/\D/g, "")
                ?.slice(0, 6);

            if (!pasted) {
                return;
            }

            this.otpdigits = Array(6).fill("");

            for (let i = 0; i < pasted.length; i++) {
                this.otpdigits[i] = pasted[i];
            }

            const focusIndex = Math.min(pasted.length, 5);

            this.focusOtpInput(focusIndex);
        },

        // =====================================================
        // RESEND OTP
        // =====================================================

        async resendOtp() {
            if (this.otpTimer > 0) {
                return;
            }

            this.isResending = true;
            this.otpError = "";

            try {
                const response = await axios.post("/resendOtp", {
                    email: this.email.trim(),
                });

                if (response.data.status === "success") {
                    this.otpdigits = Array(6).fill("");

                    this.startOtpTimer(response.data.timer);

                    this.showToast(
                        response.data.message || "A new OTP has been sent.",
                        "success",
                    );

                    this.focusOtpInput(0);

                    return;
                }

                this.showToast(
                    response.data.message || "Unable to resend OTP.",
                    "danger",
                );
            } catch (error) {
                this.handleAxiosError(error);
            } finally {
                this.isResending = false;
            }
        },

        // =====================================================
        // ERROR HANDLING
        // =====================================================

        handleAxiosError(error) {
            console.error("Axios error:", error);

            if (error.response) {
                const status = error.response.status;

                const data = error.response.data || {};

                if (status === 422) {
                    this.errors = data.errors || {};

                    const errors = data.errors || {};

                    const message = Object.values(errors).flat().join("\n");

                    this.showToast(
                        message || data.message || "Please check your input.",
                        "danger",
                    );

                    return;
                }

                this.showToast(
                    data.message || "Something went wrong. Please try again.",
                    "danger",
                );

                return;
            }

            this.showToast(
                "Network error. Please check your connection.",
                "danger",
            );
        },

        // =====================================================
        // LOADER
        // =====================================================

        setLoader(value) {
            if (this.$refs.loader) {
                this.$refs.loader.loading = value;
            }
        },

        // =====================================================
        // RESET
        // =====================================================

        Emptyfill() {
            if (this.previewPic && this.previewPic.startsWith("blob:")) {
                URL.revokeObjectURL(this.previewPic);
            }

            if (this.govermentIdPicPreview) {
                URL.revokeObjectURL(this.govermentIdPicPreview);
            }

            if (this.businessIdPicPreview) {
                URL.revokeObjectURL(this.businessIdPicPreview);
            }

            this.profilePic = null;

            this.previewPic = "/images/registertenant/Profile-PNG-Photo.png";

            this.firstname = "";
            this.lastname = "";
            this.email = "";
            this.password = "";
            this.password_confirmation = "";
            this.phonenumber = "";
            this.gender = "";

            this.govermentIdPicPreview = "";
            this.governmentIdFile = null;

            this.businessIdPicPreview = "";
            this.businessPermitFile = null;

            this.otpTimer = 0;
            this.otpdigits = Array(6).fill("");

            this.errors = {};
            this.otpError = "";

            this.stopOtpTimer();

            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = "";
            }

            if (this.$refs.govIdInput) {
                this.$refs.govIdInput.value = "";
            }

            if (this.$refs.businessPermitInput) {
                this.$refs.businessPermitInput.value = "";
            }
        },

        // =====================================================
        // SHOW PASSWORD
        // =====================================================

        showpassword(event) {
            const passwordField = document.getElementById("password");

            const confirmPasswordField = document.getElementById(
                "password_confirmation",
            );

            const type = event.target.checked ? "text" : "password";

            if (passwordField) {
                passwordField.type = type;
            }

            if (confirmPasswordField) {
                confirmPasswordField.type = type;
            }
        },
    },

    // =====================================================
    // LIFECYCLE
    // =====================================================

    mounted() {
        this.$nextTick(() => {
            this.focusCurrentStep();
        });
    },

    beforeUnmount() {
        this.stopOtpTimer();

        if (this.previewPic && this.previewPic.startsWith("blob:")) {
            URL.revokeObjectURL(this.previewPic);
        }

        if (this.govermentIdPicPreview) {
            URL.revokeObjectURL(this.govermentIdPicPreview);
        }

        if (this.businessIdPicPreview) {
            URL.revokeObjectURL(this.businessIdPicPreview);
        }
    },
};
</script>

<style scoped src="./../../../css/accountprocess/landlordRegister.css"></style>
