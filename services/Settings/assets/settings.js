window.ntdst = window.ntdst || {};

((exports) => {
    "use strict";

    exports.settings = {
        start() {
            this.setupView();

        },

        setupView() {
            const headers = document.querySelectorAll(".setting-group-header");

            headers.forEach(header => {
                const parent = header.closest(".setting-group");

                if (parent) {
                    const headerHeight = header.offsetHeight +25; // Get header height

                    // Set initial styles
                    parent.style.overflow = "hidden";
                    parent.style.transition = "height 0.3s ease-in-out";

                    // Check if the group should start collapsed
                    if (header.classList.contains("collapsed")) {
                        parent.style.height = `${headerHeight}px`; // Start collapsed
                    } else {
                        parent.style.height = `${parent.scrollHeight}px`; // Fully expanded
                    }

                    header.addEventListener("click", () => {
                        if (header.classList.contains("collapsed")) {
                            // Expand
                            parent.style.height = `${parent.scrollHeight}px`;
                        } else {
                            // Collapse to header height
                            parent.style.height = `${headerHeight}px`;
                        }

                        header.classList.toggle("collapsed");
                    });

                    // Ensure correct height on page resize
                    window.addEventListener("resize", () => {
                        if (!header.classList.contains("collapsed")) {
                            parent.style.height = `${parent.scrollHeight}px`;
                        }
                    });
                }
            });
        }
    };

    document.addEventListener("DOMContentLoaded", () => {
        exports.settings.start();
    });

})(window.ntdst);
