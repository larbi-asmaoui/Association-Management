import Swal from "sweetalert2";

const Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    iconColor: "white",
    customClass: {
        popup: "colored-toast",
    },
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
    // arabic rtl
    direction: "rtl",
});

export default Toast;
