   const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("mainContent");
        const menuBtn = document.getElementById("menuBtn");

        let isOpen = true;

        menuBtn.addEventListener("click", () => {
            isOpen = !isOpen;
            if (isOpen) {
                // open
                sidebar.classList.remove("-translate-x-64");
                mainContent.classList.add("ml-64");
                mainContent.classList.remove("ml-0");
            } else {
                // close
                sidebar.classList.add("-translate-x-64");
                mainContent.classList.remove("ml-64");
                mainContent.classList.add("ml-0");
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

        