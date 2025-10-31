document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");
    const menuBtn = document.getElementById("menuBtn");

    if (menuBtn && sidebar && mainContent) {
        menuBtn.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-full");
            mainContent.classList.toggle("ml-64");
            mainContent.classList.toggle("ml-0");
        });
    }

    // ---- Modal Logic ----
    const modal = document.getElementById("rtoModal");
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const closeModalBtn2 = document.getElementById("closeModalBtn2");

    if (openModalBtn && modal) {
        openModalBtn.addEventListener("click", () => modal.classList.remove("hidden"));
    }

    if (closeModalBtn && modal) {
        closeModalBtn.addEventListener("click", () => modal.classList.add("hidden"));
    }

    if (closeModalBtn2 && modal) {
        closeModalBtn2.addEventListener("click", () => modal.classList.add("hidden"));
    }

    if (modal) {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.classList.add("hidden");
            }
        });
    }
});


const openModalBtn = document.getElementById("openModalBtn");
const closeModalBtn = document.getElementById("closeModalBtn");
const closeModalBtn2 = document.getElementById("closeModalBtn2");
const modal = document.getElementById("rtoModal");

openModalBtn.addEventListener("click", () => {
    modal.classList.remove("hidden");
});

closeModalBtn.addEventListener("click", () => {
    modal.classList.add("hidden");
});

closeModalBtn2.addEventListener("click", () => {
    modal.classList.add("hidden");
});

// close modal on clicking outside
modal.addEventListener("click", (e) => {
    if (e.target === modal) {
        modal.classList.add("hidden");
    }
});
