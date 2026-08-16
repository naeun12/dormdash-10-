import "bootstrap";
import "bootstrap-icons/font/bootstrap-icons.css";

import Echo from "laravel-echo";
import Pusher from "pusher-js";
import "./bootstrap";
import { createApp } from "vue";
import TenantRegister from "./components/tenants/tenantRegister.vue";
import LandlordRegister from "./components/landlord/landlordregister.vue";
import LandlordLogin from "./components/landlord/landlordlogin.vue";
import LandlordDormManagement from "./components/landlord/auth/dormManagement.vue";
import landlordDashboard from "./components/landlord/auth/dashboard.vue";
import LandlordRoomManagement from "./components/landlord/auth/roomManagement.vue";

import AOS from "aos";
import "aos/dist/aos.css";
AOS.init();

const tenantContainer = document.querySelector("#TenantRegisterContainer");
if (tenantContainer) {
    createApp(TenantRegister).mount("#TenantRegisterContainer");
}
const landlordContainer = document.querySelector("#LandlordRegisterContainer");
if (landlordContainer) {
    createApp(LandlordRegister).mount("#LandlordRegisterContainer");
}
const landlordContainerLogin = document.querySelector(
    "#landlordContainerLogin",
);
if (landlordContainerLogin) {
    createApp(LandlordLogin).mount("#landlordContainerLogin");
}
const dashboardController = document.querySelector("#dashboard");
if (dashboardController) {
    createApp(landlordDashboard).mount("#dashboard");
}
const landlorddormManagementContainer = document.querySelector(
    "#landlorddormManagement",
);
if (landlorddormManagementContainer) {
    createApp(LandlordDormManagement).mount("#landlorddormManagement");
}

const landlordroomManagementContainer = document.querySelector(
    "#landlordroomManagement",
);
if (landlordroomManagementContainer) {
    createApp(LandlordRoomManagement).mount("#landlordroomManagement");
}
